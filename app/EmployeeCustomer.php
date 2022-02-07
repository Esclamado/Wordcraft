<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeCustomer extends Model
{
    protected $table = 'employee_customers';

    protected $fillable = [
        'employee_id',
        'customer_id',
        'total_orders',
        'last_order_date'
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
