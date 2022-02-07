<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResellerCustomerOrder extends Model
{
    protected $table = 'reseller_customer_orders';

    protected $fillable = [
        'reseller_id', 'customer_id', 'order_code', 'number_of_products', 'order_status', 'payment_status'
    ];

    public function reseller()
    {
        return $this->belongsTo(User::class, 'reseller_id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
