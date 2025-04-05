@extends('layouts.home')
@section('titulo_pagina', 'Biblioteca')
@section('contenido')


    <section>
        <h1>Tus juegos</h1>
        @if ($datos->isEmpty())
            <div class="alert alert-warning" role="alert">
                No hay productos en la biblioteca
            </div>
        @endif
        <table class="table">
            <thead>
            </thead>
            <tbody>
                <div class="contenedor-productos">
                    @foreach ($datos as $item)
                        <div class="card" style="width: 18rem;">
                            <img src="{{ asset('images/' . $item->imagen) }}" class="card-img-top" alt="..." height="250">
                            <div class="card-body">
                                <h5 class="card-title">{{ $item->nombre }}</h5>
                                <p class="card-text">{{ $item->descripcion }}</p>
                                <form action="{{ route('carrito.agregar') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="producto_id" value="{{ $item->id }}">
                                    <button type="#" class="btn btn-primary">Descargar</button>
                                </form>


                            </div>
                        </div>
                    @endforeach
                </div>

            </tbody>
        </table>
    </section>

@endsection
