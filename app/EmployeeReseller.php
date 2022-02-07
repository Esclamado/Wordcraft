<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeReseller extends Model
{
    protected $table = 'employee_resellers';

    protected $fillable = [
        'employee_id',
        'reseller_id',
        'total_successful_orders',
        'total_earnings',
        'remaining_purchase_to_be_verified',
        'is_verified',
        'date_of_sign_up',
        'date_joined'
    ];

    public function employee()
    {
        return $this->belongsTo('App\User', 'employee_id');
    }

    public function reseller()
    {
        return $this->belongsTo('App\User', 'reseller_id');
    }
}
