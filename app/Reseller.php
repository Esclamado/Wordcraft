<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reseller extends Model
{
    protected $fillable = [
        'user_id','employment_status','telephone_number','tin','company_name','company_address','company_contact','business_name','business_address','nature_of_business','office','years_in_business',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function employmentstatusfiles() {
        return $this->hasMany(EmploymentStatusFile::class);
    }

    public function verified_by () {
        return $this->belongsTo(User::class, 'verified_by');
    }
}
