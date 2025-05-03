<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tarjeta extends Model
{
    protected $fileable = [
        'numero_tarjeta',
        'fecha_caducidad',
        'codigo_seguridad',
    ];
}
