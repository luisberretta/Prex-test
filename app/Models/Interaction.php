<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'service',
        'request_body',
        'response_code',
        'response_body',
        'ip_address',
    ];
}
