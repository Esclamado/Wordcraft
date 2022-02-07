<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CouponUsage extends Model
{
    protected $table = 'coupon_usages';

    protected $fillable = [
        'user_id', 
        'coupon_id',
        'usages'
    ];

    public function coupon()
    {
        return $this->belongsTo('App\Coupon');
    }
}
