<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CouponBundle extends Model
{
    protected $table = 'coupon_bundles';

    protected $fillable = [
        'coupon_id',
        'product_id',
        'product_quantity',
        'product_quantity_max'
    ];

    public function coupon()
    {
        return $this->belongsTo('App\Coupon');
    }

    public function product()
    {
        return $this->belongsTo('App\Product');
    }
}
