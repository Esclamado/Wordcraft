<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OtherPaymentMethod extends Model
{
    protected $table = 'other_payment_methods';

    protected $fillable = [
        'unique_id',
        'name',
        'title',
        'description',
        'type',
        'follow_up_instruction'
    ];
}
