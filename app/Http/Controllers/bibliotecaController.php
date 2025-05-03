<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class bibliotecaController extends Controller
{
    public function biblioteca()
    {
        $userId = Auth::id();

        // Obtener las facturas del usuario
        // Obtener los datos de PayPal con un JOIN
        $datos = DB::table('facturas')
            ->join('detalles_facturas', 'facturas.id', '=', 'detalles_facturas.factura_id')
            ->join('contenido_descargables', 'detalles_facturas.producto_id', '=', 'contenido_descargables.id')
            ->where('facturas.user_id', $userId)
            ->select(
                'contenido_descargables.id',
                'contenido_descargables.nombre',
                'contenido_descargables.descripcion',
                'contenido_descargables.precio',
                'contenido_descargables.imagen',
            )
            ->get();

        // Pasar los paypal a la vista
        return view('biblioteca.biblioteca', compact('datos'));
    }
}
