<?php

namespace App\Http\Controllers\MLM\v1;

use App\Http\Controllers\Controller;
use App\Models\OrderDetail;
use App\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class WebhookController extends Controller
{
    public function send_webhook_response_new_user($user, $phrase_to_encrypt)
    {
        $webhook_url = getenv('BVU_WEBHOOK_ENDPOINT_NEW_USER');

        $response = [];

        try {
            if ($webhook_url != null) {

                $cypher_method = "AES-128-CTR";
                $key = base64_encode($user->user_key->public_key);
                $options = 0;
                $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cypher_method));
                $encrypted_data = bin2hex($iv) . openssl_encrypt($phrase_to_encrypt, $cypher_method, $key, $options, $iv);

                $referred_by = [];

                if ($user->referrer != null) {
                    $referred_by = [
                        'id' => $user->referrer->id,
                        'unique_id' => $user->referrer->unique_id,
                        'name' => $user->referrer->name,
                        'email' => $user->referrer->email,
                        'phone' => $user->referrer->phone,
                    ];
                }

                $response = [
                    'data' => [
                        'type' => 'new_user',
                        'attributes' => [
                            'id' => $user->id,
                            'unique_id' => $user->unique_id,
                            'name' => $user->name,
                            'email' => $user->email,
                            'phone' => $user->phone,
                            'password' => $encrypted_data,
                            'referral_code' => $user->referral_code,
                            'created_at' => date('Y-m-d H:i:s', strtotime($user->created_at)),
                            'encryption_key' => $key,
                            'referred_by' => $referred_by,
                        ]
                    ]
                ];
            }
        } catch (\Exception $e) {
            if (getenv('APP_DEBUG') == true) {
                dd($e);
            }

            Log::errors($e);
        }

        $webhook_response = $this->connect_to_url($response, $webhook_url);

        return $webhook_response;
    }

    public function send_webhook_response_new_order($order)
    {
        $webhook_url = getenv('BVU_WEBHOOK_ENDPOINT_NEW_ORDER');

        $response = [];

        try {
            if ($webhook_url != null) {
                $order_details = [];

                foreach ($order->orderDetails as $item) {
                    $items = [];

                    $items['item_id'] = $item->product_id;
                    $items['item_name'] = $item->product->name;
                    $items['unit_price'] = $item->price / $item->quantity;
                    $items['quantity'] = $item->quantity;
                    $items['total_price'] = $item->price;

                    array_push($order_details, $items);
                }

                $response = [
                    'data' => [
                        'type' => 'new_order',
                        'attributes' => [
                            'id' => $order->id,
                            'order_id' => $order->code,
                            'date' => date('Y-m-d H:i:s', $order->date),
                            'customer' => [
                                'id' => $order->user->id,
                                'unique_id' => $order->user->unique_id,
                                'name' => $order->user->name,
                                'email' => $order->user->email,
                                'phone' => $order->user->phone,
                            ],
                            'payment_method' => $order->payment_type,
                            'payment_channel' => $order->payment_channel,
                            'grand_total' => $order->grand_total,
                            'items' => $order_details
                        ]
                    ]
                ];
            }
        } catch (\Exception $e) {
            if (getenv('APP_DEBUG') == true) {
                dd($e);
            }

            Log::errors($e);
        }

        $webhook_response = $this->connect_to_url($response, $webhook_url);

        return $webhook_response;
    }

    public function send_webhook_response_wallet_updates($wallet)
    {
        $webhook_url = getenv('BVU_WEBHOOK_ENDPOINT_WALLET_UPDATE');

        $response = [];

        try {
            if ($webhook_url != null) {
                $wallet_last_update = Wallet::where('user_id', $wallet->user_id)
                    ->latest()
                    ->first();

                if ($wallet_last_update != null) {
                    $last_update = $wallet_last_update->updated_at;
                }

                $response = [
                    'data' => [
                        'attributes' => [
                            'user' => [
                                'id' => $wallet->user->id,
                                'unique_id' => $wallet->user->unique_id,
                                'name' => $wallet->user->name,
                                'email' => $wallet->user->email,
                                'phone' => $wallet->user->phone
                            ],
                            'balance' => $wallet->user->balance,
                            'update_type' => $wallet->type,
                            'amount' => $wallet->amount,
                            'last_updated' => date('Y-m-d H:i:s', strtotime($last_update)),
                        ]
                    ]
                ];
            }
        } catch (\Exception $e) {
            if (getenv('APP_DEBUG') == true) {
                dd($e);
            }

            Log::errors($e);
        }

        $webhook_response = $this->connect_to_url($response, $webhook_url);

        return $webhook_response;
    }

    private function connect_to_url($params, $url)
    {
        $json_array = json_encode($params);
        $curl = curl_init();
        $headers = [
            'Content-Type: application/json',
            'Worldcraft-Signature: ' . getenv('WEBHOOK_SIGNATURE')
        ];

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $json_array);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HEADER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);

        $response = curl_exec($curl);
        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        Log::debug($response);

        if ($http_code >= 200 && $http_code < 300) {
            echo "Webhook sent successfully.";
        } else {
            echo "Webhook failed";
        }
    }
}
