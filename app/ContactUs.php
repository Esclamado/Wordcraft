<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    protected $table = 'contact_us';

    protected $fillable = [
        'full_name', 'contact_number',
        'email_address', 'message', 'ip_address', 'answered'
    ];
}
