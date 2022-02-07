<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorldcraftStock extends Model
{
    protected $table = 'worldcraft_stocks';

    protected $fillable = [
        'sku',
        'pickup_location_id',
        'stocks',
        'quantity'
    ];

    public function pickup_location () {
        return $this->belongsTo('App\PickupPoint', 'pup_location_id');
    }
}
