<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class usuario_tarjeta extends Model
{
    protected $fillable = [
        'tarjeta_id',
        'user_id',
    ];
}
