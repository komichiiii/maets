@extends('layouts.home')
@section('titulo_pagina', 'Home')
@section('contenido')


    <section>
        <h1>Productos Disponibles</h1>
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
                                    <button type="submit" class="btn btn-success">{{ $item->precio }}$
                                        Comprar</button>
                                </form>


                            </div>
                        </div>
                    @endforeach
                </div>

            </tbody>
        </table>
    </section>

@endsection
