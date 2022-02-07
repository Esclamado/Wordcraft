<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmploymentStatusFile extends Model
{
    public function reseller() {
        return $this->belongstTo(Reseller::class);
    }
}
