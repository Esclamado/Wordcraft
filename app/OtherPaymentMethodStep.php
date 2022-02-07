<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OtherPaymentMethodStep extends Model
{
    protected $table = 'other_payment_method_steps';

    protected $fillable = [
        'other_payment_method_id',
        'step'
    ];

    public function other_payment_method()
    {
        return $this->belongsTo('App\OtherPaymentMethod', 'other_payment_method_id');
    }
}
