<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class informacionFacturaController extends Controller
{
    public function datos()
    {
        // Obtener el ID del usuario logueado
        $userId = Auth::id();

        // Obtener las facturas del usuario
        $datos = DB::table('datos_facturas')->where('user_id', $userId)->get();

        // Pasar las facturas a la vista
        return view('informacionFactura.InformacionFactura', compact('datos'));
    }


    public function create(Request $request)
    {
        $userId = Auth::id();
        // Verificar si ya tiene un PayPal registrado
        $tieneDatos = DB::table('datos_facturas')
            ->where('user_id', $userId)
            ->exists();
        if ($tieneDatos) {
            return back()->with('incorrecto', 'Ya tienes datos de factura registrados. Solo se permite uno por usuario.');
        }
        try {
            // Obtener el ID del usuario logueado
            $userId = Auth::id();
            $sql = DB::insert("INSERT INTO datos_facturas (nombres, apellidos, direccion, localidad, codigo_postal, pais, telefono,user_id) VALUES (?,?,?,?,?,?,?,?)", [
                $request->txtNombres,
                $request->txtApellidos,
                $request->txtDireccion,
                $request->txtLocalidad,
                $request->txtCodigoPostal,
                $request->txtPais,
                $request->txtTelefono,
                $userId // Relacionar con el usuario logueado
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
    public function update(Request $request)
    {
        try {
            $sql = DB::update(" UPDATE datos_facturas SET nombres=?, apellidos=?, direccion=?, localidad=?, codigo_postal=?, pais=?, telefono=? where id=? ", [
                $request->txtNombres,
                $request->txtApellidos,
                $request->txtDireccion,
                $request->txtLocalidad,
                $request->txtCodigoPostal,
                $request->txtPais,
                $request->txtTelefono,
                $request->txtId
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
    public function delete($id)
    {
        try {
            $sql = DB::delete("DELETE FROM datos_facturas WHERE id=$id");
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
