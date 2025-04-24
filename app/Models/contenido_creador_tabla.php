<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class contenido_creador_tabla extends Model
{
    protected $fillable = [
        'contenido_id',
        'creador_id',
    ];
}
