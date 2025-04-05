<?php

use App\Http\Controllers\bibliotecaController;
use App\Http\Controllers\buscadorController;
use App\Http\Controllers\carritoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\configuracionUserController;
use App\Http\Controllers\contenidoDescargableController;
use App\Http\Controllers\imprimirController;
use App\Http\Controllers\informacionFacturaController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\metodosPagosController;

/* Route::get('/', function () {
    return "helcome to the homa page";
});
 */ 
// Rutos de login
 Route::middleware("guest")->group(function(){
    // url de la pagina de inicio y entra en el login//nota el nombre de esta vista es "login"
    Route::get('/', [loginController::class, 'index'])->name('login');

    // url de la pagina de registro //nota el nombre de esta vista es "registro"
    Route::get('/registro', [loginController::class, 'registro'])->name('registro');
    // controlador de registro para que se cree el usuario
    Route::post('/registrar', [loginController::class, 'registrar'])->name('registrar');
    // controlador de logear para que se logee el usuario
    Route::post('/logear', [loginController::class, 'logear'])->name('logear');

 });


 Route::middleware("auth")->group(function(){

 Route::get('/home', [loginController::class, 'home'])->name('home');
 Route::get('/logout', [loginController::class, 'logout'])->name('logout');
 Route::get('/config', [configuracionUserController::class, 'configuracion'])->name('configuracion');
 Route::post('/config/update', [configuracionUserController::class, 'configuracionUpdate'])->name('configuracion.update');

 // rutas datos factura
 Route::get('/datos-factura', [informacionFacturaController::class, 'datos'])->name('datos');
 Route::post('/datos-agregar', [informacionFacturaController::class, 'create'])->name('datos.create');
 Route::post('/datos-modificar', [informacionFacturaController::class, 'update'])->name('datos.update');
 Route::get('/datos-eliminar-{id}', [informacionFacturaController::class, 'delete'])->name('datos.delete');
 // nota para el futuro usar datos ya que maneja es la informacion de la factura
 // ala hora de crear la forma en la se creara la factura hacerlo algo como factura.create

 // rutas tarjeta
 Route::get('/tarjeta-datos', [metodosPagosController::class, 'tarjeta'])->name('tarjeta');
 Route::post('/tarjeta-agregar', [metodosPagosController::class, 'createTarjeta'])->name('tarjeta.create');
 Route::post('/tarjeta-modificar', [metodosPagosController::class, 'updateTarjeta'])->name('tarjeta.update');
 Route::get('/tarjeta-eliminar-{id}', [metodosPagosController::class, 'deleteTarjeta'])->name('tarjeta.delete');

// rutas paypal
 Route::get('/paypal-datos', [metodosPagosController::class, 'paypal'])->name('paypal');
 Route::post('/paypal-agregar', [metodosPagosController::class, 'createPaypal'])->name('paypal.create');
 Route::post('/paypal-modificar', [metodosPagosController::class, 'updatePaypal'])->name('paypal.update');
 Route::get('/paypal-eliminar-{id}', [metodosPagosController::class, 'deletePaypal'])->name('paypal.delete');

// carrito/facturas
Route::post('/carrito/agregar', [carritoController::class, 'agregar'])->name('carrito.agregar');
Route::get('/pagos', [carritoController::class, 'mostrar'])->name('carrito');
Route::delete('/carrito/eliminar/{id}', [CarritoController::class, 'eliminar'])->name('carrito.eliminar');
Route::post('/carrito/pagar', [carritoController::class, 'pagar'])->name('carrito.pagar');
Route::get('/factura/{facturaId}', [carritoController::class, 'mostrarFactura'])->name('mostrar.factura');
Route::get('/facturas', [carritoController::class, 'facturas'])->name('facturas.usuario');

// rutas para imprimir
Route::get('/factura/{facturaId}/pdf', [imprimirController::class, 'facturaPdf'])->name('factura.pdf');
Route::get('/factura/{facturaId}/excel', [imprimirController::class, 'facturaExcel'])->name('factura.excel');

// ruta buscador
Route::get('/buscar', [buscadorController::class, 'buscar'])->name('buscar');
 });

 // rutas biblioteca/productos comprados
Route::get('/biblioteca', [bibliotecaController::class, 'biblioteca'])->name('biblioteca');

 Route::group(['middleware' => ['role:admin']], function () {
// rutas crud de productos/ContenidoDescagable
 Route::get('/productos', [contenidoDescargableController::class, 'productos'])->name('productos');
 Route::post('/productos-agregar', [contenidoDescargableController::class, 'create'])->name('productos.create');
 Route::post('/productos-modificar', [contenidoDescargableController::class, 'update'])->name('productos.update');
 Route::get('/productos-eliminar-{id}', [contenidoDescargableController::class, 'delete'])->name('productos.delete');
 // nota cuando se envia una variable id por una url es necesario que la ruta sea de tipo get

 });
