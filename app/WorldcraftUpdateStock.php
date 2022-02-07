<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorldcraftUpdateStock extends Model
{
    protected $table = 'worldcraft_update_stocks';

    protected $fillable = [
        'pup_location_id',
        'sku_id',
        'quantity',
        'change_type',
        'type',
        'remarks'
    ];

    /**
     * Get referenced Pickup point location
     */
    public function pickup_point ()
    {
        return $this->belongsTo('App\PickupPoint', 'pup_location_id');
    }
}
