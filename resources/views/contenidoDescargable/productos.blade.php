@extends('layouts.home')
@section('titulo_pagina', 'Productos')
<script src="{{ asset('js/delete.js') }}"></script>
@section('contenido')
    @role('admin')
    
    <section>

        <h1>Mis productos en venta.</h1>
        @if ($datos->isEmpty())
            <div class="alert alert-warning" role="alert">
                No hay productos a la venta.
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
        <div class="modal fade" id="productoAgregar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar Producto</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('productos.create') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <p for="exampleInputEmail1" class="form-label">Nombre</p>
                                <input type="text" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp" name="txtNombre" required>
                            </div>
                            <div class="mb-3">
                                <p for="exampleInputEmail1" class="form-label">Desarrolladora</p>
                                <input type="text" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp" name="txtDesarrolladora" required>
                            </div>
                            <div class="mb-3">
                                <p for="exampleInputEmail1" class="form-label">Precio</p>
                                <input type="number" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp" name="txtPrecio" required>
                            </div>

                            <div class="mb-3">
                                <p for="exampleInputEmail1" class="form-label">Requisitos</p>
                                <input type="text" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp" name="txtRequisitos" required>
                            </div>
                            <div class="mb-3">
                                <p for="exampleInputEmail1" class="form-label">Descripcion</p>
                                <input type="text" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp" name="txtDescripcion" required>
                            </div>

                            <div class="mb-3">
                                <p for="exampleInputEmail1" class="form-label">Imagen</p>
                                <input type="file" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp" name="txtImagen" required>
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
                    @foreach ($datos as $item)
                        <div class="card" style="width: 18rem;">
                            @if ($item->imagen)
                                <img class="card-img-top" src="{{ asset('images/' . $item->imagen) }}"
                                    alt="{{ $item->nombre }}">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $item->nombre }}</h5>
                                <p class="card-text">{{ $item->descripcion }}</p>
                                <p></p>
                                <div class="dropdown">
                                    <button type="button" class="btn btn-success">{{ $item->precio }}$ Comprar</button>
                                    <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                        aria-expanded="false">

                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a href="" class="dropdown-item" data-bs-toggle="modal"
                                                data-bs-target="#productoModificar{{ $item->id }}">Modificar</a></li>
                                        <li><a href="{{ route('productos.delete', $item->id) }}" onclick="return res()"
                                                class="dropdown-item">Eliminar</a></li>
                                    </ul>
                                </div>


                            </div>
                        </div>
                        <!-- Modal de modificar -->
                        <div class="modal fade" id="productoModificar{{ $item->id }}" tabindex="-1"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Modificar Datos</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('productos.update') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="mb-3">
                                                <p for="exampleInputEmail1" class="form-label" hidden>id</p>
                                                <input type="text" class="form-control" id="exampleInputEmail1"
                                                    aria-describedby="emailHelp" name="txtId"
                                                    value="{{ $item->id }}" hidden>
                                            </div>
                                            <div class="mb-3">
                                                <p for="exampleInputEmail1" class="form-label">Nombre</p>
                                                <input type="text" class="form-control" id="exampleInputEmail1"
                                                    aria-describedby="emailHelp" name="txtNombre"
                                                    value="{{ $item->nombre }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <p for="exampleInputEmail1" class="form-label">Desarrolladora</p>
                                                <input type="text" class="form-control" id="exampleInputEmail1"
                                                    aria-describedby="emailHelp" name="txtDesarrolladora"
                                                    value="{{ $item->desarrolladora }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <p for="exampleInputEmail1" class="form-label">Precio</p>
                                                <input type="number" class="form-control" id="exampleInputEmail1"
                                                    aria-describedby="emailHelp" name="txtPrecio"
                                                    value="{{ $item->precio }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <p for="exampleInputEmail1" class="form-label">Requisitos</p>
                                                <input type="text" class="form-control" id="exampleInputEmail1"
                                                    aria-describedby="emailHelp" name="txtRequisitos"
                                                    value="{{ $item->requisitos }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <p for="exampleInputEmail1" class="form-label">Descripcion</p>
                                                <input type="text" class="form-control" id="exampleInputEmail1"
                                                    aria-describedby="emailHelp" name="txtDescripcion"
                                                    value="{{ $item->descripcion }}" required>
                                            </div>

                                            <div class="mb-3">
                                                <p for="exampleInputEmail1" class="form-label">Imagen</p>
                                                @if ($item->imagen)
                                                    <img class="card-img-top"
                                                        src="{{ asset('images/' . $item->imagen) }}"
                                                        alt="{{ $item->nombre }}">
                                                @endif
                                                <input type="file" class="form-control" id="exampleInputEmail1"
                                                    aria-describedby="emailHelp" name="txtImagen" value="{{ $item->descripcion }}">
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cerrar</button>
                                                <button type="submit" class="btn btn-primary">Guardar</button>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </tbody>
        </table>


    </section>
        @endrole
@endsection


