<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreLocation extends Model
{
    protected $table = 'store_locations';

    protected $fillable = [
        'island_name',
        'name',
        'address',
        'phone_number',
        'google_maps_url',
        'status'
    ];
}
