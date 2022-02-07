<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeResellerOrder extends Model
{
    protected $table = 'employee_reseller_orders';

    protected $fillable = [
        'employee_id',
        'reseller_id',
        'order_id',
        'order_code', 
        'date',
        'number_of_products',
        'order_status', 
        'payment_status'
    ];

    public function employee () {
        return $this->belongsTo('App\User', 'employee_id');
    }

    public function reseller () {
        return $this->belongsTo('App\User', 'reseller_id');
    }

    public function order () {
        return $this->belongsTo('App\Order', 'order_id');
    }
}
