<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class detalles_factura extends Model
{
    protected $fillable = [
        'factura_id',
        'producto_id',
        'cantidad',
        'precio'
    ];
}
