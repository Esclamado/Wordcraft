<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OtherPaymentMethodBankDetail extends Model
{
    protected $table = 'other_payment_method_bank_details';

    protected $fillable = [
        'other_payment_method_id',
        'pickup_point_location',
        'bank_image',
        'bank_name',
        'bank_acc_name',
        'bank_acc_number',
        'status'
    ];

    public function other_payment_method()
    {
        return $this->belongsTo('App\OtherPaymentMethod', 'other_payment_method_id');
    }

    public function pickup_point () {
        return $this->belongsTo('App\PickupPoint', 'pickup_point_location');
    }
}
