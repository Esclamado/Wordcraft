<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResellerEarning extends Model
{
    protected $table = 'reseller_earnings';

    protected $fillable = [
        'order_id', 'reseller_id', 'customer_id', 'amount', 'income', 'paid_at'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function reseller()
    {
        return $this->belongsTo(User::class, 'reseller_id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
}
