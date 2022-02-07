<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderPayment extends Model
{
    protected $table = 'order_payments';

    protected $fillable = [
        'order_id',
        'user_id',
        'payment_method',
        'proof_of_payment',
        'cr_number',
        'payment_reference',
        'amount',
        'paid_at'
       
    ];

    public function order()
    {
        return $this->belongsTo('App\Order', 'order_id');
    }
}
