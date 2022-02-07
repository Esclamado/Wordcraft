<?php

namespace App\Http\Controllers;

use App\OrderDeclinedDetail;
use Illuminate\Http\Request;

class OrderDeclinedDetailController extends Controller
{
    /**
     * [store description]
     * @param  [type] $order_details [description]
     * @return [type]                [description]
     */
    public function store($order_details, $parent_id)
    {
        if ($order_details != null) {
            foreach ($order_details as $key => $value) {
                $declined_order_detail = new OrderDeclinedDetail;

                $declined_order_detail->order_declined_id       = $parent_id;
                $declined_order_detail->order_id                = $value->order_id;
                $declined_order_detail->product_id              = $value->product_id;
                $declined_order_detail->variation               = $value->variation;
                $declined_order_detail->price                   = $value->price;
                $declined_order_detail->tax                     = $value->tax;
                $declined_order_detail->shipping_cost           = $value->shipping_cost;
                $declined_order_detail->quantity                = $value->quantity;
                $declined_order_detail->payment_status          = $value->payment_status;
                $declined_order_detail->delivery_status         = $value->delivery_status;
                $declined_order_detail->shipping_type           = $value->shipping_type;
                $declined_order_detail->pickup_point_id         = $value->pickup_point_id;
                $declined_order_detail->order_type              = $value->order_type;
                $declined_order_detail->product_referral_code   = $value->product_referral_code;

                $declined_order_detail->save();
            }
        }
    }
}
