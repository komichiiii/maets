<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class factura extends Model
{
    protected $fileable = [
        'user_id',
        'datos_factura_id',
        'numero_factura',
        'fecha'
    ];
}
