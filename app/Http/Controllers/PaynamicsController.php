<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// SMS Notification
use App\Http\Controllers\OTPVerificationController;

// Order
use App\Order;
use App\Http\Controllers\OrderController;

// Paynamics
use App\PaynamicsQueryRequest;
use App\PaynamicsTransactionRequest;

use Str;

// Logging
use Illuminate\Support\Facades\Log;

// Authenticated User
use Auth;

// Wallet
use App\Wallet;

use App\Http\Controllers\WorldcraftApiController;

class PaynamicsController extends Controller
{
    /**
     * [handle_payment description]
     * @param  [type] $payment_method  [description]
     * @param  [type] $payment_channel [description]
     * @return [type]                  [description]
     */
    public function handle_payment($payment_method, $payment_channel, $order)
    {
        $code = \App\Currency::findOrFail(\App\BusinessSetting::where('type', 'system_default_currency')->first()->value)->code;
        $code = mb_strtoupper($code);

        $merchant_id = env('PAYNAMICS_MERCHANT_ID');
        $request_id = $order->unique_code;

        $notification_url = null;

        if (env('PAYNAMICS_SANDBOX') == true) {
            $notification_url = 'https://webhook.site/6f58ab35-c451-4d0f-919f-151fcfcb7488';
        }

        else {
            $notification_url = route('handle_paynamics_webhook');
        }

        $response_url = route('order_confirmed_pending_paynamics');
        $cancel_url = route('paynamics.cancel_url');
        $amount = "$order->grand_total";
        $mkey = env('PAYNAMICS_MERCHANT_KEY');

        $transaction_signature = $merchant_id .
            $request_id .
            $notification_url .
            $response_url .
            $cancel_url .
            $payment_method .
            "url_link " .
            "single_pay" .
            $amount .
            $code .
            "1" .
            "1" .
            $mkey;

        $signatureTrx = hash('sha512', $transaction_signature);

        $fname      = $order->user->first_name ?? 'N/A';
        $mdname     = '';
        $lname      = $order->user->last_name ?? 'N/A';
        $email      = $order->user->email;
        $phone      = '';
        $mobile     = '';
        $dob        = '';

        $customer_signature = $fname . $lname . $mdname . $email . $phone . $mobile . $dob . $mkey;

        $signature = hash('sha512', $customer_signature);

        $transaction = [
            "transaction" => [
                "merchantid" => $merchant_id,
                "request_id" => $request_id,
                "notification_url" => $notification_url,
                "response_url" => $response_url,
                "cancel_url" => $cancel_url,
                "pmethod" => $payment_method,
                "pchannel" => $payment_channel,
                "payment_action" => "url_link ",
                "collection_method" => "single_pay",
                "payment_notification_status" => "1",
                "payment_notification_channel" => "1",
                "amount" => $amount,
                "currency" => $code,
                "signature" => $signatureTrx
            ],
            "customer_info" => [
                "fname" => $fname,
                "lname" => $lname,
                "email" => $email,
                "signature" => $signature
            ],
            "billing_info" => [
                "billing_address1" => 'Somewhere out there 1',
                "billing_city" => "Hulo",
                "billing_country" => "PH",
                "billing_state" => "Abra"
            ]
        ];

        $transaction = json_encode($transaction);

        $request_type_url = 'https://payin.paynamics.net/paygate/transactions/';
        $transaction = $this->credentials($transaction, $request_type_url);

        return $transaction;
    }

    /**
     * [handle_cash_in_payment description]
     * @param  [type] $payment_method  [description]
     * @param  [type] $payment_channel [description]
     * @param  [type] $wallet          [description]
     * @return [type]                  [description]
     */
    public function handle_cash_in_payment($payment_method, $payment_channel, $wallet)
    {
        $code = \App\Currency::findOrFail(\App\BusinessSetting::where('type', 'system_default_currency')->first()->value)->code;
        $code = mb_strtoupper($code);

        $merchant_id = env('PAYNAMICS_MERCHANT_ID');
        $request_id = $wallet->transaction_id;

        if (env('PAYNAMICS_SANDBOX') == true) {
            $notification_url = 'https://webhook.site/6f58ab35-c451-4d0f-919f-151fcfcb7488';
        }

        else {
            $notification_url = route('handle_webhook_response');
        }

        $total_amount = $wallet->amount + $wallet->convenience_fee;

        $response_url = route('wallet.request_cash_in_pending', encrypt($wallet->id));
        $cancel_url = route('paynamics.cancel_url');
        $amount = "$total_amount";
        $mkey = env('PAYNAMICS_MERCHANT_KEY');

        $transaction_signature = $merchant_id .
            $request_id .
            $notification_url .
            $response_url .
            $cancel_url .
            $payment_method .
            "url_link " .
            "single_pay" .
            $amount .
            $code .
            "1" .
            "1" .
            $mkey;

        $signatureTrx = hash('sha512', $transaction_signature);

        $fname      = $wallet->user->first_name ?? 'N/A';
        $mdname     = '';
        $lname      = $wallet->user->last_name ?? 'N/A';
        $email      = $wallet->user->email;
        $phone      = '';
        $mobile     = '';
        $dob        = '';

        $customer_signature = $fname . $lname . $mdname . $email . $phone . $mobile . $dob . $mkey;

        $signature = hash('sha512', $customer_signature);

        $transaction = [
            "transaction" => [
                "merchantid" => $merchant_id,
                "request_id" => $request_id,
                "notification_url" => $notification_url,
                "response_url" => $response_url,
                "cancel_url" => $cancel_url,
                "pmethod" => $payment_method,
                "pchannel" => $payment_channel,
                "payment_action" => "url_link ",
                "collection_method" => "single_pay",
                "payment_notification_status" => "1",
                "payment_notification_channel" => "1",
                "amount" => $amount,
                "currency" => $code,
                "signature" => $signatureTrx
            ],
            "customer_info" => [
                "fname" => $fname,
                "lname" => $lname,
                "email" => $email,
                "signature" => $signature
            ],
            "billing_info" => [
                "billing_address1" => 'Somewhere out there 1',
                "billing_city" => "Hulo",
                "billing_country" => "PH",
                "billing_state" => "Abra"
            ]
        ];

        $transaction = json_encode($transaction);

        $request_type_url = 'https://payin.payserv.net/paygate/transactions/';
        $transaction = $this->credentials($transaction, $request_type_url);

        return $transaction;
    }

    /**
     * [query_payment_processing_check description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function query_payment_processing_check(Request $request)
    {
        $query_id = null;

        if ($request->type == 'order') {
            $order = Order::where('id', $request->order_id)->first();
            $org_trxid2 = $order->unique_code;
            $query_id = $order->id;
        }

        else if ($request->type == 'wallet') {
            $wallet = Wallet::where('id', $request->wallet_id)->first();
            $org_trxid2 = $wallet->transaction_id;
            $query_id = $wallet->id;
        }

        $merchant_id = env('PAYNAMICS_MERCHANT_ID');
        $request_id = 'QUERY-' . mb_strtoupper(Str::random(7));
        $mkey = env('PAYNAMICS_MERCHANT_KEY');
        $signature = hash('sha512', $merchant_id . $request_id . $org_trxid2 . $mkey);

        $parameters = [
            'merchantid'    => $merchant_id,
            'request_id'    => $request_id,
            'org_trxid2'    => $org_trxid2,
            'signature'     => $signature
        ];

        $parameters = json_encode($parameters);

        $request_type_url = 'https://payin.payserv.net/paygate/transactions/query';
        $transaction = $this->credentials($parameters, $request_type_url);

        $paynamics_query_order_check = PaynamicsQueryRequest::where('type', $request->type)
            ->where('order_id', $query_id)
            ->exists();

        if (!$paynamics_query_order_check) {
            $paynamics_query = new PaynamicsQueryRequest;

            $paynamics_query->user_id = Auth::user()->id;
            $paynamics_query->order_id = $query_id;
            $paynamics_query->type = $request->type;
            $paynamics_query->request_id = $request_id;
            $paynamics_query->org_trxid2 = $org_trxid2;
            $paynamics_query->paynamics_response = $transaction;

            $paynamics_query->save();
        }

        else {
            $paynamics_query = PaynamicsQueryRequest::where('type', $request->type)
                ->where('order_id', $query_id)->first();

            $paynamics_query->paynamics_response = $transaction;
            $paynamics_query->save();
        }

        // Update transaction table
        try {
            $paynamics_transaction_requests = PaynamicsTransactionRequest::where('type', $request->type)
                ->where('request_id', $paynamics_query->org_trxid2)
                ->first();

            $transaction = json_decode($transaction);

            $paynamics_transaction_requests->response_code = $transaction->response_code;
            $paynamics_transaction_requests->response_message = $transaction->response_message;
            $paynamics_transaction_requests->response_advise = $transaction->response_advise;

            $paynamics_transaction_requests->save();

            if ($request->type == 'order') {
                if ($transaction->response_code == 'GR001') {
                    $add_request['order_id'] = $order->id;
                    $add_request['status'] = 'paid';

                    $request->request->add($add_request);

                    $update_payment_status = new OrderController;
                    $update_payment_status->update_payment_status($request);
                }

                else if ($transaction->response_code == 'GR152') {
                    // Call webhook response
                    if (\App\Addon::where('unique_identifier', 'otp_system')->first() != null && \App\Addon::where('unique_identifier', 'otp_system')->first()->activated && \App\OtpConfiguration::where('type', 'otp_for_paid_status')->first()->value){
                        try {
                            $otpController = new OTPVerificationController;
                            $otpController->send_order_expired($order);
                        } catch (\Exception $e) {
                            Log::error($e);
                        }
                    }

                    $order_code = $order->code;
                    $response_message = 'Your payment for order ' . $order_code . ' has expired.';

                    $order_expired = new OrderController;
                    $order_expired->destroy($order->id, $response_message);
                }

                else if ($transaction->response_code == 'GR003') {
                    if (\App\Addon::where('unique_identifier', 'otp_system')->first() != null && \App\Addon::where('unique_identifier', 'otp_system')->first()->activated && \App\OtpConfiguration::where('type', 'otp_for_paid_status')->first()->value){
                        try {
                            $otpController = new OTPVerificationController;
                            $otpController->send_payment_failed($order);
                        } catch (\Exception $e) {
                        }
                    }

                    $order_code = $order->code;
                    $response_message = 'Payment failed for order ' . $order_code . '. You can try again by purchasing the same item again.';

                    $order_failed = new OrderController;
                    $order_failed->destroy($order->id, $response_message);
                }
            }

            else if ($request->type == 'wallet') {
                // Successful Transaction
                if ($transaction->response_code == 'GR001') {
                    $wallet->request_status = 'approved';
                    $wallet->save();

                    $user = $wallet->user;

                    $user->balance += $wallet->amount;
                    $user->save();

                    if (\App\Addon::where('unique_identifier', 'otp_system')->first() != null && \App\Addon::where('unique_identifier', 'otp_system')->first()->activated && \App\OtpConfiguration::where('type', 'otp_for_paid_status')->first()->value){
                        try {
                            $otpController = new OTPVerificationController;
                            $otpController->send_cash_in_payment_status($wallet);
                        } catch (\Exception $e) {
                            Log::error($e);
                        }
                    }
                }

                // Failed Transaction
                else if ($transaction->response_code == 'GR003') {
                    if (\App\Addon::where('unique_identifier', 'otp_system')->first() != null && \App\Addon::where('unique_identifier', 'otp_system')->first()->activated && \App\OtpConfiguration::where('type', 'otp_for_paid_status')->first()->value){
                        try {
                            $otpController = new OTPVerificationController;
                            $otpController->send_cash_in_payment_failed($wallet);
                        } catch (\Exception $e) {
                            Log::error($e);
                        }
                    }

                    $wallet->request_status = 'rejected';
                    $wallet->save();
                }

                else if ($transaction->response_code == 'GR152') {
                    if (\App\Addon::where('unique_identifier', 'otp_system')->first() != null && \App\Addon::where('unique_identifier', 'otp_system')->first()->activated && \App\OtpConfiguration::where('type', 'otp_for_paid_status')->first()->value){
                        try {
                            $otpController = new OTPVerificationController;
                            $otpController->send_cash_in_payment_expired($wallet);
                        } catch (\Exception $e) {
                            Log::error($e);
                        }
                    }
                    $wallet->request_status = 'rejected';
                    $wallet->save();
                }
            }
        } catch (\Exception $e) {
            Log::error($e);
        }

        if ($request->type == 'order') {
            $url = route('paynamics.query_view', encrypt($order->id));
        }

        else if ($request->type == 'wallet') {
            $url = route('wallet.query_cash_in', encrypt($wallet->id));
        }

        return [
            'success' => true,
            'url' => $url
        ];
    }

    /**
     * [query_view description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function query_view($id) {
        $order = Order::findOrFail(decrypt($id));
        
        $paynamics_query_request = PaynamicsQueryRequest::where('type', 'order')
            ->where('order_id', $order->id)
            ->first();

        return view('frontend.user.purchase_order_query', compact('order', 'paynamics_query_request'));
    }

    public function query_request_cash_in ($id) {
        $wallet = Wallet::findOrFail(decrypt($id));

        $paynamics_query_request = PaynamicsQueryRequest::where('type', 'wallet')
            ->where('order_id', $wallet->id)
            ->first();

        return view('frontend.user.wallet.query_request', compact('wallet', 'paynamics_query_request'));
    }

    /**
     * [credentials description]
     * @return [type] [description]
     */
    private function credentials($parameters, $request_type_url)  {
        $basic_username = env("PAYNAMICS_BASIC_AUTH_USERNAME");
        $basic_password = env("PAYNAMICS_BASIC_AUTH_PASSWORD");

        $basic_authorization = base64_encode($basic_username . ':' . $basic_password);

        $url = $request_type_url;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Accept: application/json',
            "Authorization: Basic $basic_authorization"
        ));

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

    /**
     * [handle_webhook_response description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function handle_webhook_response(Request $request)
    {
        $type = \App\PaynamicsTransactionRequest::where('request_id', $request->request_id)
            ->first();

        if ($type->type == 'order') {
            $order = Order::where('unique_code', $request->request_id)
                ->first();

            // Successful Transaction
            try {
                if ($request->response_code == 'GR001') {
                    $add_request['order_id']    = $order->id;
                    $add_request['status']      = 'paid';

                    $request->request->add($add_request);

                    $update_payment_status = new OrderController;
                    $update_payment_status->update_payment_status($request);

                    $response = [
                        'successful' => 'Payment successful for order ' . $order->code
                    ];
                }

                else if ($request->response_code = 'GR003') {
                    if (\App\Addon::where('unique_identifier', 'otp_system')->first() != null && \App\Addon::where('unique_identifier', 'otp_system')->first()->activated && \App\OtpConfiguration::where('type', 'otp_for_paid_status')->first()->value){
                        try {
                            $otpController = new OTPVerificationController;
                            $otpController->send_payment_failed($order);
                        } catch (\Exception $e) {
                            Log::error($e);
                        }
                    }

                    $order_code = $order->code;
                    $response_message = 'Payment failed for order ' . $order_code . 'You can try again by purchasing the same item.';
                
                    $order_failed = new OrderController;
                    $order_failed->destroy($order->id, $response_message);

                    $response = [
                        'failed' => $response_message
                    ];
                }

                else if ($request->response_code == 'GR152') {
                    if (\App\Addon::where('unique_identifier', 'otp_system')->first() != null && \App\Addon::where('unique_identifier', 'otp_system')->first()->activated && \App\OtpConfiguration::where('type', 'otp_for_paid_status')->first()->value){
                        try {
                            $otpController = new OTPVerificationController;
                            $otpController->send_order_expired($order);
                        } catch (\Exception $e) {
                            Log::error($e);
                        }
                    }

                    $order_code = $order->code;
                    $response_message = 'Your payment for order ' . $order_code . ' has expired.';

                    $order_expired = new OrderController;
                    $order_expired->destroy($order->id, $response_message);

                    $response = [
                        'expired' => $response_message
                    ];
                }
            } catch (\Exception $e) {
                Log::error($e);

                $response = [
                    'error' => 'Something went wrong!'
                ];
            }

            return response()->json($response);
        }

        else if ($type->type == 'wallet') {
            $wallet = Wallet::where('transaction_id', $request->request_id)
                ->first();

            try {
                // Successful transaction
                if ($request->response_code == 'GR001') {
                    $wallet->request_status = 'approved';
                    $wallet->save();

                    $user = $wallet->user;
                    
                    $user->balance += $wallet->amount;
                    $user->save();

                    if (\App\Addon::where('unique_identifier', 'otp_system')->first() != null && \App\Addon::where('unique_identifier', 'otp_system')->first()->activated && \App\OtpConfiguration::where('type', 'otp_for_paid_status')->first()->value){
                        try {
                            $otpController = new OTPVerificationController;
                            $otpController->send_cash_in_payment_status($wallet);
                        } catch (\Exception $e) {
                            Log::error($e);
                        }
                    }
    
                    $response = [
                        'successful' => 'Payment successful for wallet cash in with transaction ID: ' . $wallet->transaction_id
                    ];
                }

                // Failed Transaction
                else if ($request->response_code == 'GR003') {
                    if (\App\Addon::where('unique_identifier', 'otp_system')->first() != null && \App\Addon::where('unique_identifier', 'otp_system')->first()->activated && \App\OtpConfiguration::where('type', 'otp_for_paid_status')->first()->value){
                        try {
                            $otpController = new OTPVerificationController;
                            $otpController->send_cash_in_payment_failed($wallet);
                        } catch (\Exception $e) {
                            Log::error($e);
                        }
                    }
    
                    $wallet->request_status = 'rejected';
                    $wallet->save();
    
                    $response = [
                        'failed' => "Payment failed for transaction ID: $wallet->transaction_id"
                    ];
                }

                else if ($request->response_code == 'GR152') {
                    if (\App\Addon::where('unique_identifier', 'otp_system')->first() != null && \App\Addon::where('unique_identifier', 'otp_system')->first()->activated && \App\OtpConfiguration::where('type', 'otp_for_paid_status')->first()->value){
                        try {
                            $otpController = new OTPVerificationController;
                            $otpController->send_cash_in_payment_expired($wallet);
                        } catch (\Exception $e) {
                            Log::error($e);
                        }
                    }
    
                    $wallet->request_status = 'rejected';
                    $wallet->save();
    
                    $response = [
                        'expired' => 'Your payment for wallet cash in has expired, transaction ID: ' . $wallet->transaction_id
                    ];
                }
            } catch (\Exception $e) {
                Log::error($e);

                $response = [
                    'error' => 'Something went wrong!'
                ];
            }

            return response()->json($response);
        }
    }

    /**
     * [handle_webhook_response_wallet description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function handle_webhook_response_wallet (Request $request)
    {
        $wallet = Wallet::where('transaction_id', $request->request_id)
            ->first();

        try {
            // Successful Transaction
            if ($request->response_code == 'GR001') {
                $wallet->request_status = 'approved';
                $wallet->save();

                $user = $wallet->user;

                $user->balance += $wallet->amount;
                $user->save();

                if (\App\Addon::where('unique_identifier', 'otp_system')->first() != null && \App\Addon::where('unique_identifier', 'otp_system')->first()->activated && \App\OtpConfiguration::where('type', 'otp_for_paid_status')->first()->value){
                    try {
                        $otpController = new OTPVerificationController;
                        $otpController->send_cash_in_payment_status($wallet);
                    } catch (\Exception $e) {
                        Log::error($e);
                    }
                }

                $response = [
                    'successful' => 'Payment successful for wallet cash in with transaction ID: ' . $wallet->transaction_id
                ];
            }

            // Failed Transaction
            else if ($request->response_code == 'GR003') {
                if (\App\Addon::where('unique_identifier', 'otp_system')->first() != null && \App\Addon::where('unique_identifier', 'otp_system')->first()->activated && \App\OtpConfiguration::where('type', 'otp_for_paid_status')->first()->value){
                    try {
                        $otpController = new OTPVerificationController;
                        $otpController->send_cash_in_payment_failed($wallet);
                    } catch (\Exception $e) {
                        Log::error($e);
                    }
                }

                $wallet->request_status = 'rejected';
                $wallet->save();

                $response = [
                    'failed' => "Payment failed for transaction ID: $wallet->transaction_id"
                ];
            }

            else if ($request->response_code == 'GR152') {
                if (\App\Addon::where('unique_identifier', 'otp_system')->first() != null && \App\Addon::where('unique_identifier', 'otp_system')->first()->activated && \App\OtpConfiguration::where('type', 'otp_for_paid_status')->first()->value){
                    try {
                        $otpController = new OTPVerificationController;
                        $otpController->send_cash_in_payment_expired($wallet);
                    } catch (\Exception $e) {
                        Log::error($e);
                    }
                }

                $wallet->request_status = 'rejected';
                $wallet->save();

                $response = [
                    'expired' => 'Your payment for wallet cash in has expired, transaction ID: ' . $wallet->transaction_id
                ];
            }
        } catch (\Exception $e) {
            Log::error($e);

            $response = [
                'error' => 'Something went wrong!'
            ];
        }

        return response()->json($response);
    }
}
