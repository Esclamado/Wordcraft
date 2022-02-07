<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeCustomerOrder extends Model
{
    protected $table = 'employee_customer_orders';

    protected $fillable = [
        'employee_id',
        'customer_id',
        'order_code',
        'date',
        'number_of_products',
        'order_status',
        'payment_status'
    ];

    public function employee()
    {
        return $this->belongsTo('App\User', 'employee_id');
    }

    public function customer()
    {
        return $this->belongsTo('App\User', 'customer_id');
    }
}
