<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResellerCustomer extends Model
{
    protected $table = 'reseller_customers';

    protected $fillable = [
        'reseller_id', 'customer_id', 'total_orders', 'last_order_date'
    ];

    public function reseller()
    {
        return $this->belongsTo(User::class, 'reseller_id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
}
