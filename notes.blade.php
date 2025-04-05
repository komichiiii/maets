<?php
// comando terminar: php artisan make:controller NombreController
// si es necesario traerse el valor de una variable utilizar
// return view('login.inicio', compact('datos'));


// tener cuidado laravel lee de arriba a bajo puede causar problemas con las rutas variables
Route::get('/post/{post}/{category?}', function ($post, $category = null) {

    if ($category) {
        return "usuario config {$post} de la categoria {$category} ";
    }

    return "usuario config {$post}";
});



// {en Route} significa contenido varible para no especificar cada ruta
// en $category? se usa pra decir si es opcional

/* Route::get('/post/{post}/{category}', function ($post, $category) {
    return "usuario config {$post} de la categoria {$category} ";
}); */