<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class carritoController extends Controller
{
    // Método para añadir un producto al carrito
    public function agregar(Request $request)
    {
        $productoId = $request->input('producto_id');
        $userId = Auth::id();

        // 1. Verificar si el usuario ya compró este producto
        $yaComprado = DB::table('facturas')
            ->join('detalles_facturas', 'facturas.id', '=', 'detalles_facturas.factura_id')
            ->where('facturas.user_id', $userId)
            ->where('detalles_facturas.producto_id', $productoId)
            ->exists();

        if ($yaComprado) {
            return redirect()->back()->with('incorrecto', 'Ya has comprado este juego anteriormente');
        }
        // Obtener el ID del producto desde la solicitud
        $productoId = $request->input('producto_id');

        // Obtener el carrito actual de la sesión
        $carrito = Session::get('carrito', []);

        // Verificar si el producto ya está en el carrito
        if (isset($carrito[$productoId])) {
            // Si ya está, incrementar la cantidad
        } else {
            // Si no está, añadirlo al carrito
            $carrito[$productoId] = [
                'id' => $productoId,
                'cantidad' => 1,
            ];
        }

        // Guardar el carrito actualizado en la sesión
        Session::put('carrito', $carrito);

        // Redirigir de vuelta con un mensaje de éxito
        return redirect()->back()->with('correcto', 'Producto añadido al carrito');
    }

    // Método para mostrar el carrito
    public function mostrar()
    {
        // Obtener el carrito de la sesión
        $carrito = Session::get('carrito', []);

        // Obtener los detalles de los productos en el carrito
        $productos = [];
        $totalCarrito = 0; // Inicializar el total del carrito

        foreach ($carrito as $productoId => $item) {
            $producto = DB::table('contenido_descargables')->find($productoId);
            if ($producto) {
                $totalProducto = $producto->precio * $item['cantidad'];
                $totalCarrito += $totalProducto; // Sumar al total del carrito

                $productos[] = [
                    'id' => $producto->id,
                    'nombre' => $producto->nombre,
                    'precio' => $producto->precio,
                    'cantidad' => $item['cantidad'],
                    'imagen' => $producto->imagen,
                    'total' => $totalProducto, // Total por producto
                ];
            }
        }

        // Pasar los productos y el total del carrito a la vista
        return view('carrito.carrito', compact('productos', 'totalCarrito'));
    }

    public function eliminar($productoId)
    {
        // Obtener el carrito de la sesión
        $carrito = Session::get('carrito', []);

        // Eliminar el producto del carrito
        if (isset($carrito[$productoId])) {
            unset($carrito[$productoId]);
        }

        // Guardar el carrito actualizado en la sesión
        Session::put('carrito', $carrito);

        // Redirigir de vuelta con un mensaje de éxito
        return redirect()->route('carrito')->with('incorrecto', 'Producto eliminado del carrito');
    }

    public function pagar(Request $request)
    {
        try {
            // Obtener el ID del usuario logueado
            $userId = Auth::id();

            // Obtener los datos de facturación del usuario
            $datosFactura = DB::table('datos_facturas')->where('user_id', $userId)->first();

            if (!$datosFactura) {
                return back()->with("incorrecto", "Debes registrar tus datos de facturación primero");
            }

            // Obtener el método de pago seleccionado (tarjeta o paypal)
            $metodoPago = $request->input('metodo_pago');

            // Validar que se haya seleccionado un método de pago
            if (empty($metodoPago)) {
                return back()->with("incorrecto", "Debes seleccionar un método de pago");
            }

            // Inicializar variables para los IDs de PayPal y tarjeta
            $paypalId = null;
            $tarjetaId = null;

            // Obtener el ID de PayPal o Tarjeta según el método seleccionado
            if ($metodoPago == 'paypal') {
                // Obtener el ID de PayPal
                $paypal = DB::table('usuario_paypals')->where('user_id', $userId)->first();
                if ($paypal) {
                    $paypalId = $paypal->id; // Asignar el ID de PayPal
                } else {
                    return back()->with("incorrecto", "No tienes una cuenta de PayPal registrada");
                }
            } elseif ($metodoPago == 'tarjeta') {
                // Obtener el ID de Tarjeta
                $tarjeta = DB::table('usuario_tarjetas')->where('user_id', $userId)->first();
                if ($tarjeta) {
                    $tarjetaId = $tarjeta->id; // Asignar el ID de tarjeta
                } else {
                    return back()->with("incorrecto", "No tienes una tarjeta registrada");
                }
            }

            // Verificar que al menos uno de los IDs (paypal o tarjeta) esté presente
            if (is_null($paypalId) && is_null($tarjetaId)) {
                return back()->with("incorrecto", "No se pudo encontrar un método de pago válido.");
            }

            // Inserción en la tabla factura
            DB::insert("INSERT INTO facturas (paypal, tarjeta, user_id, datos_factura_id, numero_factura, fecha) VALUES (?, ?, ?, ?, ?, ?)", [
                $paypalId, // Esto puede ser null
                $tarjetaId, // Esto puede ser null
                $userId,
                $datosFactura->id,
                $numeroFactura = ('dea'),
                $fechaCreacion = now()->format('Y/m/d'),
            ]);


            // Obtener el ID de la factura recién creada
            $facturaId = DB::getPdo()->lastInsertId();

            // Obtener el ID de la factura recién creada
            $facturaId = DB::getPdo()->lastInsertId();

            // Obtener el carrito de la sesión
            $carrito = Session::get('carrito', []);

            // Guardar los productos del carrito en la tabla detalles_factura
            foreach ($carrito as $productoId => $item) {
                $producto = DB::table('contenido_descargables')->find($productoId);
                if ($producto) {
                    DB::insert("INSERT INTO detalles_facturas (factura_id, producto_id, cantidad, precio) VALUES (?, ?, ?, ?)", [
                        $facturaId,
                        $productoId,
                        $item['cantidad'],
                        $producto->precio
                    ]);
                }
            }

            // Generar el número de factura basado en la fecha y el ID
            $fecha = now()->format('Ymd'); // Formato: AñoMesDía (20231025)
            $numeroFactura = 'FACT-' . $fecha . '-' . $facturaId;

            // Actualizar la factura con el número generado
            DB::table('facturas')->where('id', $facturaId)->update(['numero_factura' => $numeroFactura]);


            // Limpiar el carrito después de generar la factura
            Session::forget('carrito');

            return redirect()->route('mostrar.factura', $facturaId)->with("correcto", "Factura generada correctamente");
        } catch (\Throwable $th) {
            return back()->with("incorrecto", "Error al generar al pagar: " . $th->getMessage());
        }
    }

    public function mostrarFactura($facturaId)
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

        // Pasar los datos a la vista
        return view('factura.factura', compact('factura', 'usuario', 'datosFactura', 'metodoPago', 'tipoMetodo', 'productosFactura', 'totalFactura'));
    }

    public function facturas()
    {
        // Obtener el ID del usuario logueado
        $userId = Auth::id();

        // Obtener las facturas del usuario
        $facturas = DB::table('facturas')->where('user_id', $userId)->get();

        $userId = Auth::id();

        // Obtener productos comprados con su porcentaje del total
        $productosGrafica = DB::table('facturas')
            ->join('detalles_facturas', 'facturas.id', '=', 'detalles_facturas.factura_id')
            ->join('contenido_descargables', 'detalles_facturas.producto_id', '=', 'contenido_descargables.id')
            ->where('facturas.user_id', $userId)
            ->select(
                'contenido_descargables.nombre',
                'contenido_descargables.precio',
                DB::raw('(contenido_descargables.precio * detalles_facturas.cantidad) as total_producto')
            )
            ->get();

        // Calcular el total general
        $totalGeneral = $productosGrafica->sum('total_producto');

        // Preparar datos para el gráfico con porcentajes
        $datosGrafico = $productosGrafica->map(function ($item) use ($totalGeneral) {
            return [
                'nombre' => $item->nombre,
                'precio' => $item->precio,
                'porcentaje' => round(($item->total_producto / $totalGeneral) * 100, 1)
            ];
        })->sortByDesc('porcentaje'); // Ordenar por porcentaje descendente

        // Pasar las facturas a la vista
        return view('factura.facturas', compact('datosGrafico', 'totalGeneral', 'facturas'));
    }
}
