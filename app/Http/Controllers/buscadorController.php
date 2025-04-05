<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class buscadorController extends Controller
{
    public function buscar(Request $request)
    {
        // Obtener el término de búsqueda
        $query = $request->input('q');

        // Validar que el término de búsqueda no esté vacío
        if (empty($query)) {
            return redirect()->route('home')->with('incorrecto', 'Debes ingresar un término de búsqueda.');
        }

        // Realizar la búsqueda en la base de datos
        $resultados = DB::table('contenido_descargable')
            ->where('nombre', 'LIKE', "%{$query}%")
            ->orWhere('descripcion', 'LIKE', "%{$query}%")
            ->orWhere('precio', 'LIKE', "%{$query}%")
            ->get();

        // Pasar los resultados a la vista
        return view('buscador.buscador', compact('resultados', 'query'));
    }
}

