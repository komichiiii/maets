<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class paypal extends Model
{
    protected $fillable = [
        'correo',
        'usuario',
        'contrasenia'
    ];

    protected $hidden = [
        'contrasenia'
    ];
}
