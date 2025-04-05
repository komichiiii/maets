@extends('layouts.home')
@section('titulo_pagina', 'Facturas')
@section('contenido')
    <section>
        <h1>Mis Facturas</h1>
        <table class="table">
            <thead>
            </thead>
            <tbody>
                <div class="contenedor-productos">
                    <table class="table table-striped table-borderless table-hover table-dark tabla tabla">
                        <thead>
                            <tr>
                                <th scope="col">id</th>
                                <th scope="col">Numero de Factura</th>
                                <th scope="col">Fecha</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($facturas as $item)
                                <tr>
                                    <th>{{ $item->id }}</th>
                                    <td>{{ $item->numero_factura }}</td>
                                    <td>{{ $item->fecha }}</td>
                                    <td><a href="{{ route('mostrar.factura', $item->id) }}" class="btn-success btn btn-sm">Ver
                                            mas</a>
                                    </td>
                                </tr>
                            @endforeach
                </div>

            </tbody>
        </table>
        <div class="grafica">
            <h2>Grafica Total Gastado en Maets.com</h2>
            <div id="chart-productos" style="max-width: 600px; margin: 0 auto;"></div>
            <div class="text-center mt-3">
                <small class="text-muted">Total gastado: {{ number_format($totalGeneral, 2) }} €</small>
            </div>
        </div>
        <script src="{{asset('\apexcharts.js-main\dist\apexcharts.min.js')}}"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var options = {
                    chart: {
                        type: 'donut',
                        height: 400
                    },
                    series: {!! json_encode($datosGrafico->pluck('porcentaje')) !!},
                    labels: {!! json_encode($datosGrafico->pluck('nombre')) !!},
                    colors: ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#ec4899'],
                    plotOptions: {
                        pie: {
                            donut: {
                                size: '65%',
                                labels: {
                                    show: true,
                                    total: {
                                        show: true,
                                        label: 'Total',
                                        formatter: function(w) {
                                            return '100%';
                                        }
                                    }
                                }
                            }
                        }
                    },
                    dataLabels: {
                        enabled: true,
                        formatter: function(val, {
                            seriesIndex,
                            w
                        }) {
                            return w.config.labels[seriesIndex] + ': ' + val + '%';
                        },
                        dropShadow: {
                            enabled: false
                        },
                        style: {
                            fontSize: '12px',
                            fontWeight: 'bold'
                        }
                    },
                    legend: {
                        position: 'right',
                        horizontalAlign: 'center',
                        fontSize: '14px',
                        markers: {
                            width: 12,
                            height: 12,
                            radius: 12
                        },
                        itemMargin: {
                            horizontal: 10,
                            vertical: 5
                        }
                    },
                    tooltip: {
                        y: {
                            formatter: function(value, {
                                series,
                                seriesIndex,
                                dataPointIndex,
                                w
                            }) {
                                const precio = {!! json_encode($datosGrafico->pluck('precio')) !!}[seriesIndex];
                                return value + '% (' + precio + ' $)';
                            }
                        }
                    },
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            chart: {
                                width: 300
                            },
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }]
                };

                var chart = new ApexCharts(document.querySelector("#chart-productos"), options);
                chart.render();
            });
        </script>
    </section>
@endsection
