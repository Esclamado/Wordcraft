<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use Auth;
use App\OrderPayment;

use Illuminate\Support\Facades\Validator;


class OrderPaymentController extends Controller
{
    /**
     * [store description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'proof_of_payment' => 'required'
        ], [
            'proof_of_payment.required' => 'Please upload your proof of payment before submitting'
        ]);

        if ($validate->fails()) {
            $errors = null;
            $errors = $validate->errors()->messages();

            foreach ($errors as $key => $item) {
                foreach ($item as $error) {
                    flash(translate($error));
                    return redirect()->back();
                }
            }
        }

        $order = Order::findOrFail($request->order_id);

        $order_payment = new OrderPayment;

        $order_payment->order_id = $request->order_id;
        $order_payment->user_id = Auth::user()->id;
        $order_payment->payment_method = $order->payment_type;
        $order_payment->proof_of_payment = $request->proof_of_payment;
        $order_payment->paid_at = \Carbon\Carbon::now();
        
        $order_payment->save();

        flash(translate('Proof of payment is successfully uploaded!'))->success();
        return redirect()->route('purchase_history.show', encrypt($order->id));
    }

    public function store_admin (Request $request) {
        $validate = Validator::make($request->all(), [
            'proof_of_payment' => 'required'
        ], [
            'proof_of_payment.required' => 'Please upload your proof of payment before submitting'
        ]);

        if ($validate->fails()) {
            $errors = null;
            $errors = $validate->errors()->messages();

            foreach ($errors as $key => $item) {
                foreach ($item as $error) {
                    flash(translate($error));
                    return redirect()->back();
                }
            }
        }

        $order = Order::findOrFail($request->order_id);

        $order_payment = new OrderPayment;

        $order_payment->order_id = $request->order_id;
        $order_payment->user_id = Auth::user()->id;
        $order_payment->payment_method = $order->payment_type;
        $order_payment->proof_of_payment = $request->proof_of_payment;
        $order_payment->paid_at = \Carbon\Carbon::now();

        $order_payment->save();

        flash(translate('Proof of payment is successfully uploaded!'))->success();
        return redirect()->back();
    }
}
