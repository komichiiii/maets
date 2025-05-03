@extends('layouts.home')
@section('titulo_pagina', 'Paypal')
<script src="{{ asset('js/delete.js') }}"></script>
@section('contenido')
    <section>

        <h1>Lista de Paypal</h1>
        @if ($datos->isEmpty())
            <div class="alert alert-warning" role="alert">
                No hay datos de Paypal registrados
            </div>
        @endif
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

    
        <!-- Modal de Agregar -->
        <div class="modal fade" id="paypalAgregar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar Datos de Paypal</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('paypal.create') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <p for="exampleInputEmail1" class="form-label">Correo usado en Paypal</p>
                                <input type="email" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp" name="txtCorreo" required>
                            </div>
                            <div class="mb-3">
                                <p for="exampleInputEmail1" class="form-label">Usuario de Paypal</p>
                                <input type="text" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp" name="txtUsuario" required>
                            </div>
                            <div class="mb-3">
                                <p for="exampleInputEmail1" class="form-label">Contraseña de Paypal</p>
                                <input type="password" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp" name="txtContrasenia" required>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary">Agregar</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>

        <table class="table">
            <thead>
            </thead>
            <tbody>
                <div class="contenedor-productos">
                    <table class="table table-striped table-borderless table-hover table-dark tabla tabla">
                        <thead>
                            <tr>
                                <th scope="col">Correo</th>
                                <th scope="col">Usuario</th>
                                <th scope="col">Contraseña</th>
                                <th><button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#paypalAgregar">Agregar</button></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($datos as $item)
                                <tr>
                                    <th hidden>{{ $item->paypal_id }}</th>
                                    <td>{{ $item->correo }}</td>
                                    <td>{{ $item->usuario }}</td>
                                    <td>{{ $item->contrasenia }}</td>
                                    <td><a href="{{ route('paypal.update') }}" class="btn-warning btn btn-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#paypalModificar{{ $item->paypal_id }}"><i class="bi bi-pencil-square"></i></a>
                                    </td>


                                    <!-- Modal de modificar -->
                                    <div class="modal fade" id="paypalModificar{{ $item->paypal_id }}" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modificar
                                                        Datos
                                                    </h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('paypal.update') }}" method="POST">
                                                        @csrf
                                                        <div class="mb-3">
                                                            <p for="exampleInputEmail1" class="form-label" hidden>id</p>
                                                            <input type="text" class="form-control"
                                                                id="exampleInputEmail1" aria-describedby="emailHelp"
                                                                name="txtPaypal_id" value="{{ $item->paypal_id }}" hidden>
                                                        </div>
                                                        <div class="mb-3">
                                                            <p for="exampleInputEmail1" class="form-label">Correo usado en
                                                                Paypal</p>
                                                            <input type="email" class="form-control"
                                                                id="exampleInputEmail1" aria-describedby="emailHelp"
                                                                name="txtCorreo" value="{{ $item->correo }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <p for="exampleInputEmail1" class="form-label">Usuario de
                                                                Paypal</p>
                                                            <input type="text" class="form-control"
                                                                id="exampleInputEmail1" aria-describedby="emailHelp"
                                                                name="txtUsuario" value="{{ $item->usuario }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <p for="exampleInputEmail1" class="form-label">Contraseña de
                                                                Paypal</p>
                                                            <input type="password" class="form-control"
                                                                id="exampleInputEmail1" aria-describedby="emailHelp"
                                                                name="txtContrasenia" value="{{ $item->contrasenia }}" required>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Cerrar</button>
                                                            <button type="submit"
                                                                class="btn btn-primary">Guardar</button>
                                                        </div>
                                                    </form>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </tr>
                            @endforeach
                </div>

            </tbody>
        </table>


    </section>

@endsection
