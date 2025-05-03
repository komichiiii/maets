<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class configuracionUserController extends Controller
{
    public function configuracion(){
        $userId = Auth::id();
        $datos = DB::table('users')->where('id', $userId)->get();
        return view("config.configUser", compact('datos'));
    }

    public function configuracionUpdate(Request $request){
        try {
        $userId = Auth::id();
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$userId,
            'password' => 'required|string|min:8|confirmed',
        ]);

        $item = User::find($userId);
        $item->name = $request->name;
        $item->email = $request->email;
        $item->password = Hash::make($request->password);
        $item->save();
        return redirect()->route('configuracion');
        }catch (\Throwable $th) {
            $sql = 0;
        }
        if ($sql == true) {
            return back()->with("correcto", "Se actualizo los datos correctamente");
        } else {
            return back()->with("incorrecto", "Error al actualizar los datos");
        }
    }
}
