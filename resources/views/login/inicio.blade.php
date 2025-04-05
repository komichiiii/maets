    @extends('layouts.loginPlantilla')
    @section('titulo_pagina', 'Login Usuario')
    


    @section('contenido')
    <section class="wrapper">
        <form action="{{ route('logear') }}" method="post" class="form-login">
            {{-- {{ route('logear') }} esto manda al loginController para iniciar sesion --}}
            @csrf
            @method('POST')
            <h1>Inicio de Sesion</h1>
            <p>Correo Electronico</p>
            <input class="input-email" type="email" name="email" id="email" required>

            <p>Contraseña</p>
            <input class="input-password" type="password" name="password" id="password" required>
            <br/>
            <div class="olvido"> <a href="#">Olvido su contraseña?</a></div>
            <button class="boton">Iniciar</button>
            <div class="registrado">
            <label>No tienes cuenta?<a href="{{ route('registro') }}"> Registrate!</a></label>
            {{-- {{ route('registro') }} redirecciona el registro del usuario --}}
            </div>
            {{-- Nota los names:  email, password  no son aleatorios
                    son nombres reservados de laravel para los logins
            --}}
        </form>

    </section>
@endsection