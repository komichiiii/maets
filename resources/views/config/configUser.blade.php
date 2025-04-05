@extends('layouts.home')
@section('titulo_pagina', 'Configuración de Usuario')
@section('contenido')


    <section>

        <h1>Configuración de Usuario</h1>
        @if (session('correcto'))
                <div class="alert alert-success" role="alert">
                    {{ session('correcto') }}
                </div>
            @endif
            @if (session('incorrecto'))
                <div class="alert alert-danger" role="alert">
                    {{ session('incorrecto') }}
                </div>
            @endif
        <div class="contenedor">
         
        @foreach ($datos as $item)
        <form action="{{ route('configuracion.update') }}" method="POST">
            @csrf
            <div class="mb-3">
                <p for="exampleInputEmail1" class="form-label">Nombre de Usuario</p>
                <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="name" value="{{$item->name}}" required>
            </div>
            <div class="mb-3">
                <p for="exampleInputEmail1" class="form-label">Correo</p>
                <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                    name="email" value="{{$item->email}}" required>
            </div>
            <div class="mb-3">
                <p for="exampleInputEmail1" class="form-label">Contraseña</p>
                <input type="password" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                    name="password" required>
            </div>
            <div class="mb-3">
                <p for="exampleInputEmail1" class="form-label">Repita su contraseña</p>
                <input type="password" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                    name="password_confirmation" required>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Gurdar</button>
            </div>
        </form>
        @endforeach
    </div>
    </section>


@endsection
