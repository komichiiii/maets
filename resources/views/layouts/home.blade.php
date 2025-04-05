<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset("bootstrap-5.3.3-dist/css/bootstrap.min.css")}}">
    <link rel="stylesheet" href="{{asset("bootstrap-icons-1.11.3/font/bootstrap-icons.min.css")}}">
    <link rel="stylesheet" href="{{asset('sidebar.css')}}">
    <link rel="stylesheet" href="{{asset("home.css")}}">
    <link rel="icon" href="{{asset('icons/Steam-Logo.png')}}">
    <title>@yield('titulo_pagina')</title>
</head>
<body>
    
    <section>
        <nav class="navbar navbar-expand-lg navbar-custom" data-bs-theme="dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{route('home')}}"><img class="d-inline-block align-text-top" alt="Logo" width="35" height="35" src="{{asset('icons/Steam-Logo.png')}}" alt=""> Maets</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <form class="d-flex mx-auto search-custom" role="search" action="{{ route('buscar') }}" method="GET">
                        <input class="form-control me-2" type="search" name="q" placeholder="Nombre, Precio." aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Buscar</button>
                    </form>
        
                    <ul class="navbar-nav mb-2 mb-lg-0">
                        <a class="nav-link" href="{{ route('carrito') }}" role="button" data-bs-toggle="" aria-expanded="false">
                            <img class="d-inline-block align-text-top" alt="Logo" width="45" height="45" src="{{asset('icons/carrito.png')}}" alt="">
                        </a>
                        
                        <li class="nav-item dropdown btn" width="35" height="35">
                            <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="{{asset('icons/3puntos.png')}}" width="20" alt="20">
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{route('configuracion')}}"><i class="bi bi-person-fill-gear"></i> Datos del usuario</a></li>
                                <li><a class="dropdown-item" href="{{route('paypal')}}"><i class="bi bi-paypal"></i> Paypal</a></li>
                                <li><a class="dropdown-item" href="{{route('tarjeta')}}"><i class="bi bi-credit-card"></i> Tarjeta</a></li>
                                <li><a class="dropdown-item" href="{{route('datos')}}"><i class="bi bi-file-earmark-person-fill"></i> Informacion de Factura</a></li>
                                <li><a class="dropdown-item" href="{{route('facturas.usuario')}}"><i class="bi bi-receipt-cutoff"></i> Facturas</a></li>
                                <li><a  class="dropdown-item" href="{{ route('logout') }}"><i class="bi bi-box-arrow-left"></i> Cerrar Sesion</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <body>
            <div class="wrapper">
                <aside id="sidebar" class="expand">
                    <div class="d-flex">
                        <button class="toggle-btn" type="button">
                            <i class="lni lni-grid-alt"></i>
                        </button>
                        <div class="sidebar-logo">
                            <a class="navbar-brand" href="{{route('home')}}"><img class="d-inline-block align-text-top" alt="Logo" width="25" height="25" src="{{asset('icons/inicio.png')}}" alt=""> Inicio</a>
                        </div>
                    </div>
                    <ul class="sidebar-nav">
                        <li class="sidebar-item">
                            <a href="{{route('biblioteca')}}" class="sidebar-link">
                                <i class="bi bi-collection-fill"></i>
                                <span>Biblioteca</span>
                            </a>
                        </li>
                        @role('admin')
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                                data-bs-target="#auth" aria-expanded="false" aria-controls="auth">
                                <i class="bi bi-piggy-bank-fill"></i>
                                <span>Mis Productos</span>
                            </a>
                            <ul id="auth" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                            
                                <li class="sidebar-item">
                                    <a href="{{route('productos')}}" class="sidebar-link"><i class="bi bi-card-list"></i>Lista de productos</a>
                                </li>
                                <li class="sidebar-item">
                                    <a id data-bs-toggle="modal" data-bs-target="#productoAgregar" href="#" class="sidebar-link">Agregar</a>
                                </li>
                            </ul>
                        </li>
                        @endrole
                        <li class="sidebar-item">
                            <a href="{{route('configuracion')}}" class="sidebar-link">
                                <i class="bi bi-person-fill-gear"></i>
                                <span>Datos del usuario</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{route('datos')}}" class="sidebar-link">
                                <i class="bi bi-file-earmark-person-fill"></i>
                                <span>Informacion de Factura</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                                data-bs-target="#multi" aria-expanded="false" aria-controls="multi">
                                <i class="bi bi-bank2"></i>
                                <span>Metodos de pago</span>
                            </a>
                            <ul id="multi" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                                <li class="sidebar-item">
                                    <a href="#" class="sidebar-link collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#multi-two" aria-expanded="false" aria-controls="multi-two">
                                        <i class="bi bi-cash-coin"></i>Tipo
                                    </a>
                                    <ul id="multi-two" class="sidebar-dropdown list-unstyled collapse">
                                        <li class="sidebar-item">
                                            <a href="{{route('tarjeta')}}" class="sidebar-link"><i class="bi bi-credit-card"></i>Tarjeta</a>
                                        </li>
                                        <li class="sidebar-item">
                                            <a href="{{route('paypal')}}" class="sidebar-link"><i class="bi bi-paypal"></i>Paypal</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        {{-- <li class="sidebar-item">
                            <a href="#" class="sidebar-link">
                                <i class="lni lni-popup"></i>
                                <span>Notification</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link">
                                <i class="lni lni-cog"></i>
                                <span>Setting</span>
                            </a>
                        </li> --}}
                    </ul>
                </aside>
                <div class="main p-3">
                    <div class="text-center">
                       @yield('contenido')
                    </div>
                </div>
            </div>

       
 

    </section>

    
    <script src="{{asset("bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js")}}" ></script>
    {{-- <script src="{{ asset('js/sidebar.js') }}"></script> --}}
</body>
</html>