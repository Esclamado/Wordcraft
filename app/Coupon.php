<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    public function category()
    {
        return $this->belongsTo('App\CouponCategory', 'category_id');
    }
}
