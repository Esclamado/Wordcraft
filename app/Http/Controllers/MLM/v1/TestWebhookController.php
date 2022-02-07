<?php

namespace App\Http\Controllers\MLM\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\MLM\v1\WebhookController;
use App\Http\Controllers\OrderController;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Reseller;
use App\User;
use App\UserKey;
use App\Wallet;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TestWebhookController extends Controller
{
    public function test_new_user()
    {
        $faker = Factory::create();

        $user = User::create([
            'unique_id' => unique_code(9),
            'referred_by' => 805,
            'user_type' => 'reseller',
            'name' => $faker->name(),
            'username' => $faker->userName,
            'first_name' => $faker->firstName(),
            'last_name' => $faker->lastName,
            'email' => $faker->email,
            'email_verified_at' => date('Y-m-d H:i:s'),
            'password' => Hash::make('password')
        ]);

        $phrase_to_encrypt = 'password';

        $token = Str::random(60);

        // Create API Keys
        UserKey::create([
            'user_id' => $user->id,
            'public_key' => hash('sha256', $token),
            'private_key' => hash('sha256', $token)
        ]);

        $user->referral_code = substr($user->id . Str::random(), 0, 10);
        $user->save();

        Reseller::create([
            'user_id' => $user->id,
            'is_verified' => random_int(0, 1),
            'employment' => 'Freelancer'
        ]);

        $new_user = new WebhookController();
        $new_user->send_webhook_response_new_user($user, $phrase_to_encrypt);
    }

    public function test_new_order()
    {
        $latest_user = User::latest()->first();

        $shipping_address = [
            'name' => $latest_user->name,
            'email' => $latest_user->email,
            'island' => "nort_luzon",
            'address' => 'Makati',
            'country' => 'Philippines',
            'city' => 'City',
            'postal_code' => '1000',
            'phone' => $latest_user->phone,
            'checkout_type' => 'logged'
        ];

        $random_int = rand(0, 1);

        $order = Order::create([
            'user_id' => $latest_user->id,
            'shipping_address' => json_encode($shipping_address),
            'pickup_point_location' => 'baesa_warehouse',
            'payment_option' => 'other-payment-method',
            'payment_type' => 'cash_on_pickup',
            'payment_status' => $random_int == 1 ? 'paid' : 'unpaid',
            'grand_total' => 8239.00,
            'date' => strtotime('now'),
        ]);

        $now = Carbon::now();
        $order->code = $now->year . $now->month . '-' . $order->id;
        $order->unique_code = $order->id . '-' . unique_order_code();

        $order_details = OrderDetail::create([
            'order_id' => $order->id,
            'seller_id' => 1,
            'product_id' => 60,
            'variation' => 'White-Single',
            'price' => 7490.00,
            'quantity' => 10,
            'payment_status' => $random_int == 1 ? 'paid' : 'unpaid',
            'delivery_status' => 'pending',
            'order_type' => 'same_day_pickup',
        ]);

        $order_details = OrderDetail::create([
            'order_id' => $order->id,
            'seller_id' => 1,
            'product_id' => 60,
            'variation' => 'White-double',
            'price' => 749.00,
            'quantity' => 1,
            'payment_status' => $random_int == 1 ? 'paid' : 'unpaid',
            'delivery_status' => 'pending',
            'order_type' => 'same_day_pickup',
        ]);

        $new_order = new WebhookController();
        $new_order->send_webhook_response_new_order($order);
    }

    public function test_new_wallet_update()
    {
        $type = ['cash_in', 'earnings_convert', 'cash_out'];
        $status = ['pending', 'approved', 'rejected'];

        $wallet = Wallet::create([
            'user_id' => 1042,
            'transaction_id' => date('Ymd-His') . rand(10, 99),
            'amount' => rand(100, 5000),
            'type' => array_rand($type, 1),
            'request_status' => array_rand($status, 1)
        ]);

        $new_wallet_update = new WebhookController();
        $new_wallet_update->send_webhook_response_wallet_updates($wallet);
    }
}
