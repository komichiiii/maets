<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class metodosPagosController extends Controller
{
    // crud tarjeta
    public function tarjeta()
    {
        // Obtener el ID del usuario logueado
        $userId = Auth::id();

        // Obtener las facturas del usuario
        // Obtener los datos de PayPal con un JOIN
        $datos = DB::table('usuario_tarjetas')
            ->join('tarjetas', 'usuario_tarjetas.tarjeta_id', '=', 'tarjetas.id')
            ->where('usuario_tarjetas.user_id', $userId)
            ->select(
                'usuario_tarjetas.tarjeta_id',
                'tarjetas.numero_tarjeta',
                'tarjetas.fecha_caducidad',
                'tarjetas.codigo_seguridad'
            )
            ->get();

        // Pasar los paypal a la vista
        return view('metodosPagos.tarjeta', compact('datos'));
    }


    public function createTarjeta(Request $request)
    {
        $userId = Auth::id();
        // Verificar si ya tiene un PayPal registrado
        $tieneTarjeta = DB::table('usuario_tarjetas')
            ->where('user_id', $userId)
            ->exists();
        if ($tieneTarjeta) {
            return back()->with('incorrecto', 'Ya tienes una tarjeta registrada. Solo se permite una por usuario.');
        }
        try {
            $sql = DB::insert("INSERT INTO tarjetas (numero_tarjeta, fecha_caducidad, codigo_seguridad) VALUES (?,?,?)", [
                $request->txtNumero_tarjeta,
                $request->txtFecha_caducidad,
                $request->txtCodigo_seguridad
            ]);

            // Obtener el ID del contenido recién creado
            $tarjetaId = DB::getPdo()->lastInsertId();

            // Obtener el ID del usuario logueado
            $userId = Auth::id();

            // Insertar en la tabla contenido_creador_tabla
            DB::insert("INSERT INTO usuario_tarjetas (tarjeta_id, user_id) VALUES (?, ?)", [
                $tarjetaId,
                $userId
            ]);
        } catch (\Throwable $th) {
            $sql = 0;
        }
        if ($sql == true) {
            return back()->with("correcto", "Agregado correctamente");
        } else {
            return back()->with("incorrecto", "Error al agregar");
        }
    }
    public function updateTarjeta(Request $request)
    {

        try {
            $sql = DB::update(" UPDATE tarjetas SET numero_tarjeta=?, fecha_caducidad=?, codigo_seguridad=? where id=? ", [
                $request->txtNumero_tarjeta,
                $request->txtFecha_caducidad,
                $request->txtCodigo_seguridad,
                $request->txtTarjeta_id
            ]);
            if ($sql == 0) {
                $sql = 1;
            }
            // este if es en el caso de que se el usuario no haya modificado ningun campo
            // sin esto da error 
        } catch (\Throwable $th) {
            $sql = 0;
        }
        if ($sql == true) {
            return back()->with("correcto", "Modificacion exitosa");
        } else {
            return back()->with("incorrecto", "Error al modificar");
        }
    }
    public function deleteTarjeta($id)
    {
        try {
            $sql = DB::delete("DELETE FROM tarjetas WHERE id=$id");
        } catch (\Throwable $th) {
            $sql = 0;
        }
        if ($sql == true) {
            return back()->with("correcto", "Producto eliminado correctamente");
        } else {
            return back()->with("incorrecto", "Error al eliminar");
        }
    }










    // crud paypal
    public function paypal()
    {
        // Obtener el ID del usuario logueado
        $userId = Auth::id();

        // Obtener las facturas del usuario
        // Obtener los datos de PayPal con un JOIN
        $datos = DB::table('usuario_paypals')
            ->join('paypals', 'usuario_paypals.paypal_id', '=', 'paypals.id')
            ->where('usuario_paypals.user_id', $userId)
            ->select(
                'usuario_paypals.paypal_id',
                'paypals.correo',
                'paypals.usuario',
                'paypals.contrasenia'
            )
            ->get();

        // Pasar los paypal a la vista
        return view('metodosPagos.paypal', compact('datos'));
    }


    public function createPaypal(Request $request)
    {
        $userId = Auth::id();
        // Verificar si ya tiene un PayPal registrado
        $tienePaypal = DB::table('usuario_paypals')
            ->where('user_id', $userId)
            ->exists();
        if ($tienePaypal) {
            return back()->with('incorrecto', 'Ya tienes una cuenta PayPal registrada. Solo se permite una por usuario.');
        }
        try {
            $sql = DB::insert("INSERT INTO paypals (correo, usuario, contrasenia) VALUES (?,?,?)", [
                $request->txtCorreo,
                $request->txtUsuario,
                $request->txtContrasenia
            ]);

            // Obtener el ID del contenido recién creado
            $paypalId = DB::getPdo()->lastInsertId();

            // Obtener el ID del usuario logueado
            $userId = Auth::id();

            // Insertar en la tabla contenido_creador_tabla
            DB::insert("INSERT INTO usuario_paypals (paypal_id, user_id) VALUES (?, ?)", [
                $paypalId,
                $userId
            ]);
        } catch (\Throwable $th) {
            $sql = 0;
        }
        if ($sql == true) {
            return back()->with("correcto", "Agregado correctamente");
        } else {
            return back()->with("incorrecto", "Error al agregar");
        }
    }
    public function updatePaypal(Request $request)
    {
        try {
            $sql = DB::update(" UPDATE paypals SET correo=?, usuario=?, contrasenia=? where id=? ", [
                $request->txtCorreo,
                $request->txtUsuario,
                $request->txtContrasenia,
                $request->txtPaypal_id
            ]);
            if ($sql == 0) {
                $sql = 1;
            }
            // este if es en el caso de que se el usuario no haya modificado ningun campo
            // sin esto da error 
        } catch (\Throwable $th) {
            $sql = 0;
        }
        if ($sql == true) {
            return back()->with("correcto", "Modificacion exitosa");
        } else {
            return back()->with("incorrecto", "Error al modificar");
        }
    }
    public function deletePaypal($id)
    {
        try {
            $sql = DB::delete("DELETE FROM paypals WHERE id=$id");
        } catch (\Throwable $th) {
            $sql = 0;
        }
        if ($sql == true) {
            return back()->with("correcto", "Producto eliminado correctamente");
        } else {
            return back()->with("incorrecto", "Error al eliminar");
        }
    }
}
