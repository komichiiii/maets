@extends('layouts.home')
@section('titulo_pagina', 'Factura')
@section('contenido')
    <section>
        <div class="fondo-factura">
            <div class="factura">
                <!-- Encabezado de factura en dos columnas -->
                <div class="encabezado-factura">
                    <div class="datos-comprador">
                        <div class="texto-color">
                            <h1>FACTURA</h1>
                            <p>A nombre de:</p>
                            <p>{{ $datosFactura->nombres }} {{ $datosFactura->apellidos }}</p>
                            <p>{{ $datosFactura->direccion }}</p>
                            <p>{{ $datosFactura->localidad }}</p>
                        </div>
                    </div>

                    <div class="datos-factura">
                        <div class="texto-color">
                            <p>N° DE FACTURA {{ $factura->numero_factura }}</p>
                            <p>FECHA {{ \Carbon\Carbon::parse($factura->fecha)->format('d/m/Y') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Tabla de productos -->
                <div class="productos-factura">
                    <table>
                        <thead>
                            <tr>
                                <th>Cantidad</th>
                                <th>Producto</th>
                                <th>Precio</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($productosFactura as $producto)
                                <tr>
                                    <td>{{ $producto->cantidad }}</td>
                                    <td>{{ $producto->nombre }}</td>
                                    <td>{{ number_format($producto->precio, 2) }}$</td>
                                </tr>
                            @endforeach
                            <tr class="total-row">
                                <td></td>
                                <td><strong>Total A pagar</strong></td>
                                <td><strong>{{ number_format($totalFactura, 2) }}$</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Método de pago -->
                <div class="metodo-pago texto-color">
                    <p>Método de Pago: {{ $tipoMetodo }}</p>
                </div>
            </div>
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    Imprimir
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('factura.pdf', $factura->id) }}">PDF</a></li>
                    <li><a class="dropdown-item" href="{{ route('factura.pdf', $factura->id) }}">Excel</a></li>
                </ul>
            </div>
        </div>

    </section>
    <style>
        h1,
        h2,
        h3,
        p {
            color: #333;
        }
    </style>
@endsection
