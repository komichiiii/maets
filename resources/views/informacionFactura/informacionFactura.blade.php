@extends('layouts.home')
@section('titulo_pagina', 'Informacion Factura')
<script src="{{ asset('js/delete.js') }}"></script>
@section('contenido')
    <section>

        <h1>Lista de Datos de Factura</h1>
        @if ($datos->isEmpty())
            <div class="alert alert-warning" role="alert">
                No hay datos de factura registrados
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
        <div class="modal fade" id="datosAgregar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar Datos de Factura</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body container-fluid">
                        <form action="{{ route('datos.create') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <p for="exampleInputEmail1" class="form-label">Nombres</p>
                                <input type="text" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp" name="txtNombres" required>
                            </div>
                            <div class="mb-3">
                                <p for="exampleInputEmail1" class="form-label">Apellidos</p>
                                <input type="text" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp" name="txtApellidos" required>
                            </div>
                            <div class="mb-3">
                                <p for="exampleInputEmail1" class="form-label">Direccion</p>
                                <input type="text" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp" name="txtDireccion" required>
                            </div>

                            <div class="mb-3">
                                <p for="exampleInputEmail1" class="form-label">Localidad</p>
                                <input type="text" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp" name="txtLocalidad" required>
                            </div>
                            <div class="mb-3">
                                <p for="exampleInputEmail1" class="form-label">Codigo Postal</p>
                                <input type="text" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp" name="txtCodigoPostal" required>
                            </div>
                            <div class="mb-3">
                                <p for="exampleInputEmail1" class="form-label">Pais</p>
                                <input type="text" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp" name="txtPais" required>
                            </div>
                            <div class="mb-3">
                                <p for="exampleInputEmail1" class="form-label">Telefono</p>
                                <input type="text" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp" name="txtTelefono" required>
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
        <table class="table table-striped table-hover">
            <thead>
            </thead>
            <tbody>
                <div class="contenedor-productos">
                    <table class="table table-striped table-borderless table-hover table-dark tabla tabla">
                        <thead>
                            <tr>
                                <th scope="col">Nombres</th>
                                <th scope="col">Apellidos</th>
                                <th scope="col">Direccion</th>
                                <th scope="col">Localidad</th>
                                <th scope="col">Codigo Postal</th>
                                <th scope="col">Pais</th>
                                <th scope="col">Telefono</th>
                                <th><button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#datosAgregar">Agregar</button></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($datos as $item)
                                <tr>
                                    <th hidden>{{ $item->id }}</th>
                                    <td>{{ $item->nombres }}</td>
                                    <td>{{ $item->apellidos }}</td>
                                    <td>{{ $item->direccion }}</td>
                                    <td>{{ $item->localidad }}</td>
                                    <td>{{ $item->codigo_postal }}</td>
                                    <td>{{ $item->pais }}</td>
                                    <td>{{ $item->telefono }}</td>
                                    <td><a href="" class="btn-warning btn btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#datosModificar{{ $item->id }}"><i class="bi bi-pencil-square"></i></a>
                                    </td>


                                    <!-- Modal de modificar -->
                                    <div class="modal fade" id="datosModificar{{ $item->id }}" tabindex="-1"
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
                                                    <form action="{{ route('datos.update') }}" method="POST">
                                                        @csrf
                                                        <div class="mb-3">
                                                            <p for="exampleInputEmail1" class="form-label"
                                                                hidden>id</p>
                                                            <input type="text" class="form-control"
                                                                id="exampleInputEmail1" aria-describedby="emailHelp"
                                                                name="txtId" value="{{ $item->id }}" hidden>
                                                        </div>
                                                        <div class="mb-3">
                                                            <p for="exampleInputEmail1"
                                                                class="form-label">Nombres</p>
                                                            <input type="text" class="form-control"
                                                                id="exampleInputEmail1" aria-describedby="emailHelp"
                                                                name="txtNombres" value="{{ $item->nombres }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <p for="exampleInputEmail1"
                                                                class="form-label">Apellidos</p>
                                                            <input type="text" class="form-control"
                                                                id="exampleInputEmail1" aria-describedby="emailHelp"
                                                                name="txtApellidos" value="{{ $item->apellidos }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <p for="exampleInputEmail1"
                                                                class="form-label">Direccion</p>
                                                            <input type="text" class="form-control"
                                                                id="exampleInputEmail1" aria-describedby="emailHelp"
                                                                name="txtDireccion" value="{{ $item->direccion }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <p for="exampleInputEmail1"
                                                                class="form-label">Localidad</p>
                                                            <input type="text" class="form-control"
                                                                id="exampleInputEmail1" aria-describedby="emailHelp"
                                                                name="txtLocalidad" value="{{ $item->localidad }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <p for="exampleInputEmail1"
                                                                class="form-label">Codigo Postal</p>
                                                            <input type="text" class="form-control"
                                                                id="exampleInputEmail1" aria-describedby="emailHelp"
                                                                name="txtCodigoPostal" value="{{ $item->codigo_postal }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <p for="exampleInputEmail1"
                                                                class="form-label">Pais</p>
                                                            <input type="text" class="form-control"
                                                                id="exampleInputEmail1" aria-describedby="emailHelp"
                                                                name="txtPais" value="{{ $item->pais }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <p for="exampleInputEmail1"
                                                                class="form-label">Telefono</p>
                                                            <input type="text" class="form-control"
                                                                id="exampleInputEmail1" aria-describedby="emailHelp"
                                                                name="txtTelefono" value="{{ $item->telefono }}" required>
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
