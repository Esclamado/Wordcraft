<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeEarning extends Model
{
    protected $table = 'employee_earnings';

    protected $fillable = [
        'order_id',
        'employee_id',
        'reseller_id',
        'customer_id',
        'amount',
        'income',
        'paid_at'
    ];

    public function order()
    {
        return $this->belongsTo('App\Order', 'order_id');
    }

    public function employee()
    {
        return $this->belongsTo('App\User', 'employee_id');
    }

    public function reseller()
    {
        return $this->belongsTo('App\User', 'reseller_id');
    }

    public function customer()
    {
        return $this->belongsTo('App\User', 'customer_id');
    }
}
