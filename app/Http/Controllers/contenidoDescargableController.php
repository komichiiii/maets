<?php

namespace App\Http\Controllers;


use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class contenidoDescargableController extends Controller
{
    public function productos()
    {
        
        // Obtener el ID del usuario logueado
        $userId = Auth::id();

        // Realizar la consulta filtrada
        $datos = DB::table('contenido_descargables')
            ->join('contenido_creador_tablas', 'contenido_descargables.id', '=', 'contenido_creador_tablas.contenido_id')
            ->where('contenido_creador_tablas.creador_id', $userId)
            ->select('contenido_descargables.*')
            ->get();

        // Pasar los datos a la vista
        return view('contenidoDescargable.productos', compact('datos'));
    }



    public function create(Request $request)
    {
        try {
        // Manejar la subida de la imagen
        if ($request->hasFile('txtImagen')) {
            $image = $request->file('txtImagen');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
        } else {
            $imageName = null;
        }

        // Obtener el ID del usuario logueado
        $userId = Auth::id();

        $sql = DB::insert("INSERT INTO contenido_descargables (nombre,desarrolladora,precio,requisitos,descripcion,imagen) VALUES (?,?,?,?,?,?)", [
            $request->txtNombre,
            $request->txtDesarrolladora,
            $request->txtPrecio,
            $request->txtRequisitos,
            $request->txtDescripcion,
            $imageName
        ]);

        // Obtener el ID del contenido recién creado
        $contenidoId = DB::getPdo()->lastInsertId();

        // Insertar en la tabla contenido_creador_tabla
        DB::insert("INSERT INTO contenido_creador_tablas (contenido_id, creador_id) VALUES (?, ?)", [
            $contenidoId,
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
    public function update(Request $request)
    {
        try {
            // Obtener el registro actual
            $producto = DB::table('contenido_descargables')->where('id', $request->txtId)->first();

            // Manejar la subida de la nueva imagen si se proporciona
            if ($request->hasFile('txtImagen')) {
                $image = $request->file('txtImagen');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images'), $imageName);

                // Eliminar la imagen anterior si existe
                if ($producto->imagen && file_exists(public_path('images/' . $producto->imagen))) {
                    unlink(public_path('images/' . $producto->imagen));
                }
            } else {
                // Mantener la imagen existente si no se proporciona una nueva
                $imageName = $producto->imagen;
            }

            $sql = DB::update(" UPDATE contenido_descargables SET nombre=?, desarrolladora=?, precio=?, requisitos=?, descripcion=?, imagen=? where id=? ", [
                $request->txtNombre,
                $request->txtDesarrolladora,
                $request->txtPrecio,
                $request->txtRequisitos,
                $request->txtDescripcion,
                $imageName,
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
            $imagen = DB::table('contenido_descargables')->where('id', $id)->value('imagen');

            $sql = DB::delete("DELETE FROM contenido_descargables WHERE id=$id");

            if ($imagen && file_exists(public_path('images/' . $imagen))) {
                unlink(public_path('images/' . $imagen));
            }
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
