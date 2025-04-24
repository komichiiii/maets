<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class usuario_paypal extends Model
{
    protected $fillable = [
        'paypal_id',
        'user_id',
    ];
}
