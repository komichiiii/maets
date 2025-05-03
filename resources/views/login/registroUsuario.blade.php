@extends('layouts.loginPlantilla')
@section('tiitulo_pagina', 'Registro Usuario')

@section('contenido')

    <section class="wrapper">
        <section>
            <form action="{{ route('registrar') }}" method="post" class="form-login">
                {{-- {{ route('registrar') }} esto manda al loginController para registrar --}}
                @csrf
                @method('POST')
                <h1>Registro de usuario</h1>
                <p>Nombre de usuario</p>
                <input class="input-name" type="text" name="name" id="name" required>
                <p>Correo Electronico</p>
                <input class="input-email" type="email" name="email" id="email" required>

                <p>Contraseña</p>
                <input class="input-password" type="password" name="password" id="password" required>
                <br />
                <p>Confirmar Contraseña</p>
                <input class="input-password" type="password" name="password_confirmation" id="password_confirmation" required>
                {{-- Nota los names: name, email, password, password_confirmation no son aleatorios
                    son nombres reservados de laravel para los logins
                 --}}
                <button class="boton">Registrar</button>
            </form>
            <div class="terms">
                <input type="checkbox" name="" id="checkbox">
                <label for="checkbox">Acepto los <a href="#">Terminos y Condicones</a></label>
            </div>
                
                
                
                <div class="registrado">
                <label>Ya tienes una cuenta? <a href="{{ route('login') }}"> Inicia sesion aqui! </a> </label>
                {{-- {{ route('login') }} redirecciona al login del usuario --}}
                
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

            

        </section>

    @endsection
