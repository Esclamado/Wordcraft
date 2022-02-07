<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DefectiveItem extends Model
{
    protected $fillable = [
        'id',
        'pup_id',
        'sku',
        'defective_qty'
    ];
}
