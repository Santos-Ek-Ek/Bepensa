<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\CFDIController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CobroController;
use App\Http\Controllers\FacturacionController;
use App\Http\Controllers\InventarioRetornableController;
use App\Http\Controllers\InventarioNoRetornableController;
use App\Http\Controllers\InventarioVacioController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProductoRetornableController;
use App\Http\Controllers\ProductoNoRetornableController;
use App\Http\Controllers\ProductoVacioController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\TipoController;
use App\Http\Controllers\UsuarioController;
use App\Models\Usuario;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('productos', function(){
    return view('inventario.productos');
});

Route::get('usuarios', function(){
    return view('usuarios.usuarios');
});

Route::get('proveedores', function(){
    return view('proveedores.proveedores');
});

Route::get('inventario_no_retornable', function(){
    return view('inventario.no_retornable');
});

Route::get('inventario_retornable', function(){
    return view('inventario.retornable');
});

Route::get('inventario_vacios', function(){
    return view('inventario.vacios');
});

Route::get('categorias', function(){
    return view('categorias.categorias');
});

Route::get('/', function () {
    return view('login.login');
});

// Route::get('/cobro', function () {
//     return view('Cobro.cobro');
// });


// Login
Route::post('login', [LoginController::class, 'validar']);

Route::get('salir', [LoginController::class, 'salir']);

Route::resource('apiProductoRetornable', ProductoRetornableController::class);

Route::resource('apiProductoNoRetornable', ProductoNoRetornableController::class);

Route::resource('apiProductoVacio', ProductoVacioController::class);

Route::resource('apiProducto', ProductoController::class);

Route::resource('apiUsuario', UsuarioController::class);

Route::resource('apiProveedor', ProveedorController::class);

Route::resource('apiRetornable', InventarioRetornableController::class);

Route::resource('apiNoRetornable', InventarioNoRetornableController::class);

Route::resource('apiVacio', InventarioVacioController::class);

Route::resource('apiCategoria', CategoriaController::class);

Route::resource('apiTipo', TipoController::class);

// vista de clientes
Route::get('clientes', [ClienteController::class, 'index']);
Route::post('crear-cliente', [ClienteController::class, 'store'])->name('nuevo-cliente');
Route::put('/clientes/{id}', [ClienteController::class, 'update'])->name('actualizar-cliente');
Route::delete('/clientes/{id}', [ClienteController::class, 'destroy'])->name('eliminar-cliente');

// vista de cfdi
Route::get('cfdi', [CFDIController::class, 'index']);
Route::post('crear-cfdi', [CFDIController::class, 'store'])->name('nuevo-cfdi');
Route::put('/cfdi/{id}', [CFDIController::class, 'update'])->name('actualizar-cfdi');
Route::delete('/cfdi/{id}', [CFDIController::class, 'destroy'])->name('eliminar-cfdi');

// vista de cobro
Route::get('cobro', [CobroController::class, 'index'])->name('cobro');

// vista de facturacion
Route::get('nueva-facturacion', [FacturacionController::class, 'index'])->name('nueva-facturacion');
Route::post('crear-facturacion', [FacturacionController::class, 'store'])->name('crear-facturacion');
Route::resource('facturacion', FacturacionController::class);
Route::get('/buscar-productos', [ProductoController::class, 'buscar']);
Route::put('/facturas/{id}', [CobroController::class, 'update']);
Route::delete('/facturas/{id}', [CobroController::class, 'destroy'])->name('facturacion.destroy');