<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function index()
    {
        return view("login.inicio");
    }

    public function registro()
    {
        return view("login.registroUsuario");
    }

    public function registrar(Request $request)
    {
        // validacion de los datos
        $request->validate([
            'name' => 'required|string|max:255',
            // obligatorio, texto, maximo 255 caracteres
            'email' => 'required|string|email|max:255|unique:users',
            // obligatorio, email, maximo 255 caracteres, unico en la tabla users
            'password' => 'required|string|min:8|confirmed',
            // obligatorio, minimo 8 caracteres, confirmacion de la contraseña
        ]);

        // creacion de un nuevo usuario
        $item = new User();
        $item->name = $request->name;
        $item->email = $request->email;
        $item->password = Hash::make($request->password);
        // hash::make encripta la contraseña
        $item->save();
        return to_route('login');
        // devuelve la vista de login
    }

    public function logear(Request $request)
    {
        $credenciales = [
            'email' => $request->email,
            'password' => $request->password,
            // se crean credenciales proporcionadas por el usuario 
        ];

        // se verifican con la base de datos si son validas
        if (Auth::attempt($credenciales)) {
            return to_route('home');
            // si son validas redirigir a la pagina de inicio
        } else {
            return to_route('login');
            // si no son validas redirigir a la pagina de login
        }
    }
    public function logout()
    {
        Session::flush();
        // limpia los datos de la sesion actual
        Auth::logout();
        // cierra la sesion actual
        return to_route('login');
    }



    public function home()
    {
        $datos = DB::select(" SELECT * FROM  contenido_descargables");
        return view("home.home")->with("datos", $datos);
    }
}
