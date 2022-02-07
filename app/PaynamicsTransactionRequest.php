<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class PaynamicsTransactionRequest extends Model
{
    protected $table = 'paynamics_transaction_requests';

    protected $fillable = [
        'user_id', 'notifiable_id', 'type', 'request_id', 'response_id', 'timestamp',
        'expiry_limit', 'pay_reference', 'direct_otc_info', 'signature', 'response_code', 'response_message', 'response_advise'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
