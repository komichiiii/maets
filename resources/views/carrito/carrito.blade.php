@extends('layouts.home')
@section('titulo_pagina', 'Carrito de Compras')
@section('contenido')
    <section>

        <h1>Carrito de Compras</h1>
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

        @if (count($productos) > 0)
            <div class="box">
                <div class="carrito-productos">
                    @foreach ($productos as $producto)
                        <div class="card" style="width: 18rem;">
                            <img src="{{ asset('images/' . $producto['imagen']) }}" class="card-img-top"
                                alt="{{ $producto['nombre'] }}" height="250">
                            <div class="card-body">
                                <h5 class="card-title">{{ $producto['nombre'] }}</h5>
                                <p class="card-text">Precio c/u: {{ $producto['precio'] }}$</p>
                                <p class="card-text">Cantidad: {{ $producto['cantidad'] }}</p>
                                <p class="card-text">Total: {{ $producto['precio'] * $producto['cantidad'] }}$</p>
                                <form action="{{ route('carrito.eliminar', $producto['id']) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="metodo-precio">
                    <div class="contenedor">
                        <div class="total-carrito">
                            <h3>Total del carrito: {{ $totalCarrito }}$</h3>
                        </div>
                        <div class="mb-3">
                            <form action="{{ route('carrito.pagar') }}" method="POST">
                                @csrf
                                <label for="metodo_pago" class="form-label">Método de Pago</label>
                                <select class="form-select" aria-label="Seleccionar método" name="metodo_pago" required>
                                    <option value="">Seleccionar método</option>
                                    <option value="tarjeta">Tarjeta</option>
                                    <option value="paypal">Paypal</option>
                                </select>
                                <p>¿No tienes un método de pago?</p>
                                <p>¡Regístralo!</p>
                                <a href="{{ route('tarjeta') }}">Tarjeta</a>
                                <a href="{{ route('paypal') }}">Paypal</a>
                                <p></p>
                                <button type="submit" class="btn btn-primary">Pagar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <p>No hay productos en el carrito.</p>
        @endif
    </section>
@endsection
