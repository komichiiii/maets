@extends('layouts.home')
@section('titulo_pagina', 'Tarjeta')
<script src="{{ asset('js/delete.js') }}"></script>
@section('contenido')
    <section>

        <h1>Lista de Tarjetas</h1>
        @if ($datos->isEmpty())
            <div class="alert alert-warning" role="alert">
                No hay tarjetas registradas
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
        <div class="modal fade" id="tarjetaAgregar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar Datos de la Tarjeta</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('tarjeta.create') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <p for="exampleInputEmail1" class="form-label">Numero Tarjeta</p>
                                <input type="text" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp" name="txtNumero_tarjeta" required>
                            </div>
                            <div class="mb-3">
                                <p for="exampleInputEmail1" class="form-label">Fecha Caducidad</p>
                                <input type="date" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp" name="txtFecha_caducidad" required>
                            </div>
                            <div class="mb-3">
                                <p for="exampleInputEmail1" class="form-label">Codigo de Seguridad</p>
                                <input type="text" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp" name="txtCodigo_seguridad" required>
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
                                <th scope="col">Numero Tarjeta</th>
                                <th scope="col">Fecha Caducidad</th>
                                <th scope="col">Codigo Seguridad</th>
                                <th><button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#tarjetaAgregar">Agregar</button></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($datos as $item)
                                <tr>
                                    <th hidden>{{ $item->tarjeta_id }}</th>
                                    <td>{{ $item->numero_tarjeta }}</td>
                                    <td>{{ $item->fecha_caducidad }}</td>
                                    <td>{{ $item->codigo_seguridad }}</td>
                                    <td><a href="{{route('tarjeta.update')}}" class="btn-warning btn btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#tarjetaModificar{{ $item->tarjeta_id }}"><i class="bi bi-pencil-square"></i></a>
                                    </td>


                                    <!-- Modal de modificar -->
                                    <div class="modal fade" id="tarjetaModificar{{ $item->tarjeta_id }}" tabindex="-1"
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
                                                    <form action="{{ route('tarjeta.update') }}" method="POST">
                                                        @csrf
                                                        <div class="mb-3">
                                                            <p for="exampleInputEmail1" class="form-label"
                                                                hidden>id</p>
                                                            <input type="text" class="form-control"
                                                                id="exampleInputEmail1" aria-describedby="emailHelp"
                                                                name="txtTarjeta_id" value="{{ $item->tarjeta_id }}" hidden>
                                                        </div>
                                                        <div class="mb-3">
                                                            <p for="exampleInputEmail1"
                                                                class="form-label">Numero Tarjeta</p>
                                                            <input type="text" class="form-control"
                                                                id="exampleInputEmail1" aria-describedby="emailHelp"
                                                                name="txtNumero_tarjeta" value="{{ $item->numero_tarjeta }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <p for="exampleInputEmail1"
                                                                class="form-label">Fecha Caducidad</p>
                                                            <input type="date" class="form-control"
                                                                id="exampleInputEmail1" aria-describedby="emailHelp"
                                                                name="txtFecha_caducidad" value="{{ $item->fecha_caducidad }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <p for="exampleInputEmail1"
                                                                class="form-label">Codigo Seguridad</p>
                                                            <input type="text" class="form-control"
                                                                id="exampleInputEmail1" aria-describedby="emailHelp"
                                                                name="txtCodigo_seguridad" value="{{ $item->codigo_seguridad }}" required>
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
