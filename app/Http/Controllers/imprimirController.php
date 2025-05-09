<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\carritoController;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class imprimirController extends Controller
{
    public function facturaPdf($facturaId)
    {
        // Obtener los datos de la factura
        $factura = DB::table('facturas')->where('id', $facturaId)->first();

        if (!$factura) {
            return redirect()->route('home')->with("incorrecto", "Factura no encontrada");
        }

        // Obtener los datos del usuario
        $usuario = DB::table('users')->where('id', $factura->user_id)->first();

        // Obtener los datos de facturación
        $datosFactura = DB::table('datos_facturas')->where('id', $factura->datos_factura_id)->first();

        // Obtener los datos de PayPal o Tarjeta según la factura
        if ($factura->paypal) {
            // Obtener el correo de PayPal desde la tabla paypal
            $paypal = DB::table('usuario_paypals')
                ->join('paypals', 'usuario_paypals.paypal_id', '=', 'paypals.id')
                ->where('usuario_paypals.id', $factura->paypal)
                ->select('paypals.correo')
                ->first();

            $metodoPago = $paypal; // Asignar el objeto paypal
            $tipoMetodo = 'PayPal';
        } else {
            // Obtener los datos de la tarjeta
            $tarjeta = DB::table('usuario_tarjetas')->where('id', $factura->tarjeta)->first();
            if ($tarjeta) {
                $metodoPago = DB::table('tarjetas')->where('id', $tarjeta->tarjeta_id)->first();
            } else {
                $metodoPago = null;
            }
            $tipoMetodo = 'Tarjeta';
        }

        // Obtener los productos de la factura
        $productosFactura = DB::table('detalles_facturas')
            ->join('contenido_descargables', 'detalles_facturas.producto_id', '=', 'contenido_descargables.id')
            ->where('detalles_facturas.factura_id', $facturaId)
            ->select('contenido_descargables.nombre', 'detalles_facturas.cantidad', 'detalles_facturas.precio')
            ->get();

        // Calcular el total de la factura
        $totalFactura = $productosFactura->sum(function ($producto) {
            return $producto->cantidad * $producto->precio;
        });

        $pdf = PDF::loadView('imprimir.pdf', compact('factura', 'usuario', 'datosFactura', 'metodoPago', 'tipoMetodo', 'productosFactura', 'totalFactura'))
            ->setPaper('a4', 'portrait')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isRemoteEnabled', true);

        return $pdf->stream('factura-' . $factura->numero_factura . '.pdf');
        
    }
}
