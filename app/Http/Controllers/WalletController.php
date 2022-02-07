<?php

namespace App\Http\Controllers;

use App\Utility\PayfastUtility;
use Illuminate\Http\Request;
use App\Http\Controllers\PaypalController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\PublicSslCommerzPaymentController;
use App\Http\Controllers\InstamojoController;
use App\Http\Controllers\PaytmController;
use Auth;
use Session;
use App\Wallet;
use App\Utility\PayhereUtility;

// Wallet withdrawal request
use App\Affiliate;
use App\AffiliateUser;
use App\AffiliateWithdrawRequest;

// Paynamics
use App\Http\Controllers\PaynamicsController;
use App\PaynamicsTransactionRequest;

class WalletController extends Controller
{
    public function index(Request $request)
    {
        $transaction_type = null;

        $wallets = Wallet::where('user_id', Auth::user()->id)
            ->with('withdraw_request')
            ->orderBy('created_at', 'desc')
            ->distinct();

        if ($request->transaction_type != null) {
            $wallets = $wallets->where('type', $request->transaction_type);
            $transaction_type = $request->transaction_type;
        }

        $wallets = $wallets->paginate(10);

        return view('frontend.user.wallet.index', compact('wallets', 'transaction_type'));
    }

    public function recharge(Request $request)
    {
        $data['amount'] = $request->amount;
        $data['payment_method'] = $request->payment_option;

        $request->session()->put('payment_type', 'wallet_payment');
        $request->session()->put('payment_data', $data);

        if ($request->payment_option == 'paypal') {
            $paypal = new PaypalController;
            return $paypal->getCheckout();
        } elseif ($request->payment_option == 'stripe') {
            $stripe = new StripePaymentController;
            return $stripe->stripe();
        } elseif ($request->payment_option == 'sslcommerz') {
            $sslcommerz = new PublicSslCommerzPaymentController;
            return $sslcommerz->index($request);
        } elseif ($request->payment_option == 'instamojo') {
            $instamojo = new InstamojoController;
            return $instamojo->pay($request);
        } elseif ($request->payment_option == 'razorpay') {
            $razorpay = new RazorpayController;
            return $razorpay->payWithRazorpay($request);
        } elseif ($request->payment_option == 'paystack') {
            $paystack = new PaystackController;
            return $paystack->redirectToGateway($request);
        } elseif ($request->payment_option == 'voguepay') {
            $voguepay = new VoguePayController;
            return $voguepay->customer_showForm();
        } elseif ($request->payment_option == 'payhere') {
            $order_id = rand(100000, 999999);
            $user_id = Auth::user()->id;
            $amount = $request->amount;
            $first_name = Auth::user()->name;
            $last_name = 'X';
            $phone = '123456789';
            $email = Auth::user()->email;
            $address = 'dummy address';
            $city = 'Colombo';

            return PayhereUtility::create_wallet_form($user_id, $order_id, $amount, $first_name, $last_name, $phone, $email, $address, $city);
        } elseif ($request->payment_option == 'payfast') {
            $user_id = Auth::user()->id;
            $amount = $request->amount;
            return PayfastUtility::create_wallet_form($user_id, $amount);
        } elseif ($request->payment_option == 'ngenius') {
            $ngenius = new NgeniusController();
            return $ngenius->pay();
        } else if ($request->payment_option == 'iyzico') {
            $iyzico = new IyzicoController();
            return $iyzico->pay();
        }
        else if ($request->payment_option == 'mpesa') {
            $mpesa = new MpesaController();
            return $mpesa->pay();
        } else if ($request->payment_option == 'flutterwave') {
            $flutterwave = new FlutterwaveController();
            return $flutterwave->pay();
        } elseif ($request->payment_option == 'paytm') {
            $paytm = new PaytmController;
            return $paytm->index();
        }
    }

    public function wallet_payment_done($payment_data, $payment_details)
    {
        $user = Auth::user();
        $user->balance = $user->balance + $payment_data['amount'];
        $user->save();

        $wallet = new Wallet;
        $wallet->user_id = $user->id;
        $wallet->amount = $payment_data['amount'];
        $wallet->payment_method = $payment_data['payment_method'];
        $wallet->payment_details = $payment_details;
        $wallet->save();

        Session::forget('payment_data');
        Session::forget('payment_type');

        flash(translate('Payment completed'))->success();
        return redirect()->route('wallet.index');
    }

    public function offline_recharge(Request $request)
    {
        $wallet = new Wallet;
        $wallet->user_id = Auth::user()->id;
        $wallet->amount = $request->amount;
        $wallet->payment_method = $request->payment_option;
        $wallet->payment_details = $request->trx_id;
        $wallet->approval = 0;
        $wallet->offline_payment = 1;
        $wallet->reciept = $request->photo;
        $wallet->save();
        flash(translate('Offline Recharge has been done. Please wait for response.'))->success();
        return redirect()->route('wallet.index');
    }

    public function offline_recharge_request()
    {
        $wallets = Wallet::where('offline_payment', 1)->paginate(10);
        return view('manual_payment_methods.wallet_request', compact('wallets'));
    }

    public function updateApproved(Request $request)
    {
        $wallet = Wallet::findOrFail($request->id);
        $wallet->approval = $request->status;
        if ($request->status == 1) {
            $user = $wallet->user;
            $user->balance = $user->balance + $wallet->amount;
            $user->save();
        } else {
            $user = $wallet->user;
            $user->balance = $user->balance - $wallet->amount;
            $user->save();
        }
        if ($wallet->save()) {
            return 1;
        }
        return 0;
    }

    /**
     * Author: Ron-ron Asistores
     *
     * @var [type]
     */
    public function request_cash_out()
    {
        return view('frontend.user.wallet.cash_out');
    }

    /**
     * [request_cash_in description]
     * @return [type] [description]
     */
    public function request_cash_in()
    {
        return view('frontend.user.wallet.topup');
    }

    /**
     * [request_cash_in_store description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function request_cash_in_store(Request $request)
    {
        $message = [
            'amount.required' => 'Please input the amount you want to cash in',
            'amount.min' => "You can only cash in with the minimum P500 Pesos"
        ];

        $this->validate($request, [
            'amount' => 'required|min:500|numeric'
        ]);

        $payment_channel = \App\PaymentChannel::where('status', 1)
            ->where('value', $request->payment_channel)
            ->first();

        $convenience_fee = 0;

        if ($payment_channel->rate == 'fixed') {
            $convenience_fee = $payment_channel->price;
        }

        else {
            $total_without_convenience_fee = $request->amount;
            $convenience_fee = ($payment_channel->price / 100) * $total_without_convenience_fee;
        }

        $wallet = new Wallet;

        $wallet->user_id = Auth::user()->id;
        $wallet->transaction_id = date('Ymd-His') . rand(10, 99);
        $wallet->affiliate_withdraw_request_id = null;
        $wallet->amount = $request->amount;
        $wallet->convenience_fee = $convenience_fee;
        $wallet->total_amount = $request->amount + $convenience_fee;
        $wallet->payment_method = $request->payment_method;
        $wallet->payment_channel = $request->payment_channel;
        $wallet->payment_details = "Cash in";
        $wallet->type = 'cash_in';
        $wallet->request_status = 'pending';

        if ($wallet->save()) {
            $paynamics = new PaynamicsController;
            $response = $paynamics->handle_cash_in_payment($request->payment_method, $request->payment_channel, $wallet);

            $wallet->payment_reference = json_decode($response)->pay_reference ?? null;
            $wallet->save();

            try {
                $paynamics_transaction = new PaynamicsTransactionRequest;

                $paynamics_transaction->user_id = $wallet->user_id;
                $paynamics_transaction->notifiable_id = $wallet->id;
                $paynamics_transaction->type = 'wallet';
                $paynamics_transaction->request_id = $wallet->transaction_id;
                $paynamics_transaction->response_id = json_decode($response)->response_id ?? null;
                $paynamics_transaction->timestamp = json_decode($response)->timestamp ?? null;
                $paynamics_transaction->expiry_limit = json_decode($response)->expiry_limit ?? null;
                $paynamics_transaction->pay_reference = json_decode($response)->pay_reference ?? null;
                $paynamics_transaction->direct_otc_info = json_encode(json_decode($response)->direct_otc_info) ?? null;
                $paynamics_transaction->signature = json_decode($response)->signature ?? null;
                $paynamics_transaction->response_code = json_decode($response)->response_code ?? null;
                $paynamics_transaction->response_message = json_decode($response)->response_message ?? null;
                $paynamics_transaction->response_advise = json_decode($response)->response_advise ?? null;

                $paynamics_transaction->save();
            } catch (\Exception $e) {
                if(env('APP_DEBUG') == true) {
                    dd($e);
                }

                \Log::error($e);
            }

            flash(translate('Cash in request is successfully posted!'))->success();
            return redirect()->route('wallet.request_cash_in_pending', encrypt($wallet->id));
        }

        else {
            flash(translate('Something went wrong!'))->error();
            return redirect()->back();
        }
    }

    public function request_cash_in_pending ($id)
    {
        $wallet = Wallet::where('user_id', Auth::user()->id)
            ->where('id', decrypt($id))
            ->first();

        $paynamics_transaction = PaynamicsTransactionRequest::where('request_id', $wallet->transaction_id)
            ->where('type', 'wallet')
            ->first();

        return view('frontend.user.wallet.cash_in_pending', compact('wallet', 'paynamics_transaction'));
    }

    /**
     * [request_cash_out_store description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function request_cash_out_store(Request $request)
    {
        $message = [
            'amount.min' => 'The amount should be at least P100',
            'destination.required' => 'Please input the destination of your withdrawal request',
            'bank_acc_number.required' => "Please input your account number",
            'acc_holder_name.required' => "Please input your account holder name"
        ];

        $this->validate($request, [
            'amount' => 'required|integer|min:100',
            'destination' => 'required',
            'bank_acc_number' => 'required',
            'acc_holder_name' => 'required'
        ], $message);

        if (Auth::user()->balance >= $request->amount && Auth::user()->balance != '0.00') {
            $wallet = new Wallet;

            $wallet->user_id            = Auth::user()->id;
            $wallet->amount             = $request->amount;
            $wallet->payment_method     = "Cash Out";
            $wallet->payment_details    = "Cashing out";
            $wallet->type               = 'cash_out';

            $wallet->save();

            $withdraw_request               = new AffiliateWithdrawRequest;

            $withdraw_request->wallet_id    = $wallet->id;
            $withdraw_request->user_id      = Auth::user()->id;
            $withdraw_request->amount       = $request->amount;
            $withdraw_request->status       = 0;
            $withdraw_request->type         = 'withdraw_request';

            // Details
            $details = [
                'body' => array(
                    'destination' => $request->destination,
                    'acc_number' => $request->bank_acc_number,
                    'acc_holder_name' => $request->acc_holder_name
                )
            ];

            $withdraw_request->details      = json_encode($details);

            if ($withdraw_request->save()) {
                $user = Auth::user();
                $user->balance -= $request->amount;
                $user->save();

                $wallet->affiliate_withdraw_request_id = $withdraw_request->id;
                $wallet->save();

                flash(translate('Cash out request is successfully posted.'))->success();
                return redirect()->route('wallet.index');
            }

            else {
                flash(translate('Something went wrong'))->error();
                return redirect()->back();
            }
        }

        else {
            flash(translate("You can't withdraw an amount greater than to your balance."))->error();
            return redirect()->back();
        }
    }
}
