<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CouponCategoryBundle extends Model
{
    protected $table = 'coupon_category_bundles';

    protected $fillable = [
        'coupon_id',
        'category_id',
        'category_quantity',
        'category_quantity_max'
    ];

    public function coupon () {
        return $this->belongsTo('App\Coupon', 'coupon_id');
    }

    public function category () {
        return $this->belongsTo('App\Category', 'category_id');
    }
}
