<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset("https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css")}}">
    <link rel="stylesheet"
        href="{{ asset('https://cdn.jsdelivr.net/gh/komichiiii/maets-css@main/login.css') }}">
    <link rel="icon" href="{{asset('icons/Steam-Logo.png')}}">
    <title>@yield('titulo_pagina')</title>
</head>
<body>

    @yield('contenido')

    <script src="{{asset("https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js")}}" ></script>
</body>
</html>