<?php

namespace App\Http\Controllers;

use App\OrderDeclined;
use App\OrderDetail;
use App\Http\Controllers\OrderDeclinedDetailController;

// Email
use Mail;
use App\Mail\InvoiceEmailManager;

use Illuminate\Http\Request;
use DB;

use App\User;

// Employee & Reseler
use App\EmployeeCustomerOrder;
use App\ResellerCustomerOrder;

class OrderDeclinedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $date = $request->date;
        $col_name = null;
        $query = null;
        $sort_search = null;
        $order_code = null;

        $orders = OrderDeclined::orderBy('created_at', 'desc');

        if ($request->has('search')) {
            $sort_search = $request->search;
            $orders = $orders->where('order_code', 'like', '%' . $sort_search . '%');
        }

        if ($date != null) {
            if(date('Y-m-d', strtotime(explode(" to ", $date)[0])) == date('Y-m-d', strtotime(explode(" to ", $date)[1]))){
               $orders = $orders->where('created_at', '>=', date('Y-m-d', strtotime(explode(" to ", $date)[0])));
            }
            else{
               $orders = $orders->where('created_at', '>=', date('Y-m-d', strtotime(explode(" to ", $date)[0])))->where('created_at', '<=', date('Y-m-d', strtotime(explode(" to ", $date)[1])));
            }
        }

        if ($request->type != null) {
            $var = explode(",", $request->type);
            $col_name = $var[0];
            $order_code = $var[1];

            if ($col_name == 'orderDetails') {
                $orders = $orders->withCount('orderDetails');
                $orders = $orders->orderBy('order_details_count', $order_code);
            }

            else {
                $orders = $orders->orderBy($col_name, $order_code);
            }
        }

        $orders = $orders->paginate(15);

        return view('backend.sales.declined_orders.index', compact('orders', 'sort_search', 'date', 'col_name', 'order_code'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * [store description]
     * @param  [type] $order [description]
     * @return [type]        [description]
     */
    public function store($order, $reason)
    {
        $declined_order = new OrderDeclined;

        $declined_order->order_id               = $order->id;
        $declined_order->user_id                = $order->user_id;
        $declined_order->order_code             = $order->code;
        $declined_order->pickup_point_location  = $order->pickup_point_location;
        $declined_order->payment_type           = $order->payment_type;
        $declined_order->payment_details        = $order->payment_details;
        $declined_order->grand_total            = $order->grand_total;
        $declined_order->coupon_discount        = $order->coupon_discount;
        $declined_order->date_order_placed      = $order->date;
        $declined_order->viewed                 = $order->viewed;
        $declined_order->delivery_viewed        = $order->delivery_viewed;
        $declined_order->payment_status_viewed  = $order->payment_status_viewed;
        $declined_order->commission_calculated  = $order->commission_calculated;
        $declined_order->date_declined          = \Carbon\Carbon::now();
        $declined_order->payment_reference      = $order->payment_reference ?? null;
        $declined_order->payment_channel        = $order->payment_channel ?? null;
        $declined_order->reason                 = $reason;

        if ($declined_order->save()) {
            // Delete Employee Customer Orders / Reseller Customer Orders
            $employee_customer_order = EmployeeCustomerOrder::where('order_id', $declined_order->order_id)->exists();

            if ($employee_customer_order) {
                $employee_customer_order = EmployeeCustomerOrder::where('order_id', $declined_order->order_id)->first();
                $employee_customer_order->order_status = 'declined';
                $employee_customer_order->save();
            }

            $reseller_customer_order = ResellerCustomerOrder::where('order_id', $declined_order->order_id)->exists();

            if ($reseller_customer_order) {
                $reseller_customer_order = ResellerCustomerOrder::where('order_id', $declined_order->order_id)->first();
                $reseller_customer_order->order_status = 'declined';
                $reseller_customer_order->save();
            }

            $order_details = OrderDetail::where('order_id', $order->id)->get();

            $declined_order_details = new OrderDeclinedDetailController;
            $declined_order_details->store($order_details, $declined_order->id);

            $array['view']      = 'emails.declined_invoice';
            $array['subject']   = translate('Your order has been declined') . ' - ' . $declined_order->order_code;
            $array['from']      = env('MAIL_USERNAME');
            $array['order']     = $declined_order;

            if (\App\Addon::where('unique_identifier', 'otp_system')->first() != null && \App\Addon::where('unique_identifier', 'otp_system')->first()->activated && \App\OtpConfiguration::where('type', 'otp_for_order')->first()->value){
                try {
                    $otpController = new OTPVerificationController;
                    $otpController->send_order_declined_code($declined_order);
                } catch (\Exception $e) {

                }
            }

            if (env('MAIL_USERNAME') != null) {
                try {
                    Mail::to($order->user->email)->queue(new InvoiceEmailManager($array));
                    Mail::to(User::where('user_type', 'admin')->first()->email)->queue(new InvoiceEmailManager ($array));
                } catch (\Exception $e) {

                }
            }
            return 1;
        }

        return 0;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\OrderDeclined  $orderDeclined
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = OrderDeclined::findOrFail(decrypt($id));

        return view('backend.sales.declined_orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\OrderDeclined  $orderDeclined
     * @return \Illuminate\Http\Response
     */
    public function edit(OrderDeclined $orderDeclined)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\OrderDeclined  $orderDeclined
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OrderDeclined $orderDeclined)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\OrderDeclined  $orderDeclined
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrderDeclined $orderDeclined)
    {
        //
    }
}
