<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class contenido_descargable extends Model
{
    protected $fillable = [
        'nombre',
        'desarrolladora',
        'precio',
        'requisitos',
        'descripcion',
        'imagen'
    ];
}
