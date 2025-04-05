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
         $datos = DB::table('factura')
             ->join('detalles_factura', 'factura.id', '=', 'detalles_factura.factura_id')
             ->join('contenido_descargable', 'detalles_factura.producto_id', '=', 'contenido_descargable.id')
             ->where('factura.user_id', $userId)
             ->select(
                 'contenido_descargable.id',
                 'contenido_descargable.nombre',
                 'contenido_descargable.descripcion',
                 'contenido_descargable.precio',
                 'contenido_descargable.imagen',
             )
             ->get();
 
         // Pasar los paypal a la vista
         return view('biblioteca.biblioteca', compact('datos'));
    }
}
