<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CouponCategory extends Model
{
    protected $table = 'coupon_categories';

    protected $fillable = [
        'name',
        'status',
        'description'
    ];
}
