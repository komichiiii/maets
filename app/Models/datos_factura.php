<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class datos_factura extends Model
{
    protected $fileable = [
        'nombres',
        'apellidos',
        'direccion',
        'localidad',
        'codigo_postal',
        'pais',
        'telefono',
        'user_id'
    ];
}
