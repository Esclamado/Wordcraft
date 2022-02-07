<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Auth\Events\PasswordReset;
use App\User;
use Auth;
use Nexmo;
use App\OtpConfiguration;
use Twilio\Rest\Client;
use Hash;

class OTPVerificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function verification(Request $request){
        if (Auth::check() && Auth::user()->email_verified_at == null) {
            return view('otp_systems.frontend.user_verification');
        }
        else {
            flash('You have already verified your number')->warning();
            return redirect()->route('home');
        }
    }


    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function verify_phone(Request $request){
        $user = Auth::user();
        if ($user->verification_code == $request->verification_code) {
            $user->email_verified_at = date('Y-m-d h:m:s');
            $user->save();

            flash('Your phone number has been verified successfully')->success();
            return redirect()->route('home');
        }
        else{
            flash('Invalid Code')->error();
            return back();
        }
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function resend_verificcation_code(Request $request){
        if($request->id){
            $user = User::findOrFail(decrypt($request->id));
            $user->temporary_code = rand(100000,999999);
            $user->save();
            sendSMS($user->phone, env('APP_NAME'), $user->temporary_code. ' is your temporary verification code. Kindly send this to your contact person.');
        }else{
            $user = Auth::user();
            $user->verification_code = rand(100000,999999);
            $user->save();
            sendSMS($user->phone, env("APP_NAME"), $user->verification_code .' is your verification code for '.env('APP_NAME'));
        }        
        flash('OTP Resend Successfuly!')->success();

        return back();
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function reset_password_with_code(Request $request){
        if (($user = User::where('phone', $request->phone)->where('verification_code', $request->code)->first()) != null) {
            if($request->password == $request->password_confirmation){
                $user->password = Hash::make($request->password);
                $user->email_verified_at = date('Y-m-d h:m:s');
                $user->save();
                event(new PasswordReset($user));
                auth()->login($user, true);

                if(auth()->user()->user_type == 'admin' || auth()->user()->user_type == 'staff')
                {
                    return redirect()->route('admin.dashboard');
                }
                return redirect()->route('home');
            }
            else {
                flash("Password and confirm password didn't match")->warning();
                return back();
            }
        }
        else {
            flash("Verification code mismatch")->error();
            return back();
        }
    }

    /**
     * @param  User $user
     * @return void
     */
    public function send_code($user){
        sendSMS($user->phone, env('APP_NAME'), $user->verification_code.' is your verification code for '.env('APP_NAME'));
    }

    public function send_login_code ($user) {
        sendSMS($user->phone, env('APP_NAME'), $user->temporary_code. ' is your temporary verification code. Kindly send this to your contact person.');
    }

    /**
     * @param  Order $order
     * @return void
     */
    public function send_order_code($order){
        if($order->user->phone != null){
            sendSMS($order->user->phone, env('APP_NAME'), 'You order has been placed and Order Code is : '.$order->code);
        }
    }

    /**
     * [send_order_declined_code description]
     * @param  [type] $order [description]
     * @return [type]        [description]
     */
    public function send_order_declined_code($order) {
        if ($order->user->phone != null) {
            sendSMS($order->user->phone, env('APP_NAME'), 'Your order has been declined! Order Code: ' . $order->order_code);
        }
    }

    /**
     * @param  Order $order
     * @return void
     */
    public function send_delivery_status($order){
        if($order->user->phone != null){
            sendSMS($order->user->phone, env('APP_NAME'), 'Your delivery status has been updated to '.ucfirst(str_replace('_', ' ', $order->orderDetails->first()->delivery_status)).' for Order code : '.$order->code);
        }
    }

    /**
     * @param  Order $order
     * @return void
     */
    public function send_payment_status($order){
        if($order->user->phone != null){
            sendSMS($order->user->phone, env('APP_NAME'), 'Your payment status has been updated to '.$order->payment_status.' for Order code : '.$order->code);
        }
    }


    /**
     * [send_payment_failed description]
     * @param  [type] $order [description]
     * @return [type]        [description]
     */
    public function send_payment_failed($order) {
        if ($order->user->phone != null) {
            sendSMS($order->user->phone, env('APP_NAME'), 'Your payment for order '. $order->code . ' has failed. If you have any questions feel free to contact us.');
        }
    }

    public function send_order_expired($order) {
        if ($order->user->phone != null) {
            sendSMS($order->user->phone, env('APP_NAME'), 'Your payment for order ' . $order->code . ' has expired. You can try again by purchasing the same item again.');
        }
    }

    /**
     * [send_refund_request description]
     * @param  [type] $order   [description]
     * @param  [type] $product [description]
     * @return [type]          [description]
     */
    public function send_refund_request ($order, $product) {
        if ($order->user->phone != null) {
            sendSMS($order->user->phone, env('APP_NAME'), "We have received your return request for product $product");
        }
    }

    /**
     * '[successful_refund_request description]'
     * @param  [type] $order   [description]
     * @param  [type] $product [description]
     * @return [type]          [description]
     */
    public function successful_refund_request ($phone) {
        if ($phone != null) {
            sendSMS($phone, env('APP_NAME'), "We have accepted your refund request and credited it on your e-wallet");
        }
    }

    /**
     * [send_cash_in_payment_status description]
     * @param  [type] $wallet [description]
     * @return [type]         [description]
     */
    public function send_cash_in_payment_status ($wallet) {
        if ($wallet->user->phone != null) {
            sendSMS($wallet->user->phone, env('APP_NAME'), "We have received your payment for your cash in of Amount: $wallet->amount. Thank you!");
        }
    }

    /**
     * [send_cash_in_payment_failed description]
     * @param  [type] $wallet [description]
     * @return [type]         [description]
     */
    public function send_cash_in_payment_failed ($wallet) {
        if ($wallet->user->phone != null) {
            sendSMS($wallet->user->phone, env('APP_NAME'), "Sorry! Your cash in request payment has failed with an Amount of: $wallet->amount, and with Transaction ID: $wallet->transaction_id");
        }
    }

    /**
     * [send_cash_in_payment_expired description]
     * @param  [type] $wallet [description]
     * @return [type]         [description]
     */
    public function send_cash_in_payment_expired ($wallet) {
        if ($wallet->user->phone != null) {
            sendSMS($wallet->user->phone, env('APP_NAME'), "Your cash in request payment has expired with an amount of: $wallet->amount and transaction ID: $wallet->transaction_id");
        }
    }

    /**
     * [send_note_to_customer description]
     * @param  [type] $order_note [description]
     * @return [type]             [description]
     */
    public function send_note_to_customer ($order_note) {
        $user = $order_note->order->user;

        if ($user->phone != null) {
            sendSMS($user->phone, env('APP_NAME'), $order_note->message);
        }
    }
}
