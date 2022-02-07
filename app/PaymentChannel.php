<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentChannel extends Model
{
    protected $table = 'payment_channels';

    protected $fillable = [
        'payment_method_id',
        'name',
        'image',
        'value',
        'price',
        'rate',
        'description',
        'status'
    ];

    public function payment_method()
    {
        return $this->belongsTo('App\PaymentMethodList', 'payment_method_id');
    }
}
