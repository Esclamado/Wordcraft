<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $guarded;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function withdraw_request()
    {
        return $this->hasMany(AffiliateWithdrawRequest::class, 'wallet_id');
    }
}
