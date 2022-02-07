<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportDownload extends Model
{
    protected $table = 'report_downloads';

    protected $fillable = [
        'user_id', 'date', 'product_title', 'file_name', 'order_code', 'username', 'ip_address'
    ];

    public function user() {
        return $this->belongsTo('Ap\User');
    }
}
