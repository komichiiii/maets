@extends('layouts.main')
@section('titulo_pagina', 'Modificar Productos')

@section('contenido')


<section class="wrapper">
    <section>
        <form action="" method="" class="form-login">
            {{-- {{ route('registrar') }} esto manda al loginController para registrar --}}
            @csrf
            @method('POST')
            <h1>Registro de usuario</h1>
            <p>Nombre de usuario</p>
            <input class="input-name" type="text" name="name" id="name">
            <p>Correo Electronico</p>
            <input class="input-email" type="email" name="email" id="email">

            <p>Contraseña</p>
            <input class="input-password" type="password" name="password" id="password">
            <br />
            <p>Confirmar Contraseña</p>
            <input class="input-password" type="password" name="password_confirmation" id="password_confirmation">
            {{-- Nota los names: name, email, password, password_confirmation no son aleatorios
                son nombres reservados de laravel para los logins
             --}}
            <button>Registrar</button>
        </form>
        <div class="terms">
            <input type="checkbox" name="" id="checkbox">
            <label for="checkbox">Acepto los <a href="#">Terminos y Condicones</a></label>
        </div>
            
            
            
            <div class="registrado">
            <label>Ya tienes una cuenta? <a href="{{ route('productos') }}"> Inicia sesion aqui! </a> </label>
            {{-- {{ route('login') }} redirecciona al login del usuario --}}
            
            </div>

        

    </section>

    @endsection