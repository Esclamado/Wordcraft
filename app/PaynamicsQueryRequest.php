<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaynamicsQueryRequest extends Model
{
    protected $table = 'paynamics_query_requests';

    protected $fillable = [
        'user_id',
        'order_id',
        'request_id',
        'org_trxid2',
        'paynamics_response'
    ];

    /**
     * [user description]
     * @return [type] [description]
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * [order description]
     * @return [type] [description]
     */
    public function order()
    {
        return $this->belongsTo('App\Order');
    }
}
