@extends('layouts.home')

@section('titulo_pagina', 'Resultados de búsqueda')

@section('contenido')
    <section>
        <h1>Resultados de búsqueda para: "{{ $query }}"</h1>

        @if ($resultados->isEmpty())
            <p>No se encontraron resultados.</p>
        @else
            <div class="contenedor-productos">
                @foreach ($resultados as $juego)
                    <div class="card" style="width: 18rem;">
                        <img src="{{ asset('images/' . $juego->imagen) }}" class="card-img-top" alt="{{ $juego->nombre }}" height="250">
                        <div class="card-body">
                            <h5 class="card-title">{{ $juego->nombre }}</h5>
                            <p class="card-text">{{ $juego->descripcion }}</p>
                            <p class="card-text">Precio: {{ $juego->precio }}$</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </section>
@endsection