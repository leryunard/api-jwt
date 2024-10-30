<?php

use App\Http\Controllers\Api\AlmacenController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CarritoController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ClientesController;
use App\Http\Controllers\Api\ComprasController;
use App\Http\Controllers\Api\ProveedoresController;
use App\Http\Controllers\Api\RolesController;
use App\Http\Controllers\Api\VentasController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Public accessible API
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Authenticated only API
// We use auth api here as a middleware so only authenticated user who can access the endpoint
// We use group so we can apply middleware auth api to all the routes within the group
Route::middleware('auth:api')->group(function () {
  
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::group(['middleware' => ['role:admin']], function () {
        Route::get('admin', [AuthController::class, 'admin']);
    });

    Route::prefix('categoria')->group(function () {
        // Rutas de Categorías
        Route::get('/', [CategoryController::class, 'index'])->middleware(['permission:categoria_index']);
        Route::post('/', [CategoryController::class, 'store'])->middleware(['permission:categoria_store']);
        Route::get('/{id}', [CategoryController::class, 'show'])->middleware(['permission:categoria_show']);
        Route::put('/{id}', [CategoryController::class, 'update'])->middleware(['permission:categoria_update']);
        Route::delete('/{id}', [CategoryController::class, 'destroy'])->middleware(['permission:categoria_destroy']);
    });

    Route::prefix('almacen')->group(function () {
        // Rutas de Almacen
        Route::get('/', [AlmacenController::class, 'index'])->middleware(['permission:almacen_index']);
        Route::post('/', [AlmacenController::class, 'store'])->middleware(['permission:almacen_store']);
        Route::get('/{id}', [AlmacenController::class, 'show'])->middleware(['permission:almacen_show']);
        Route::post('/{id}', [AlmacenController::class, 'update'])->middleware(['permission:almacen_update']);
        Route::delete('/{id}', [AlmacenController::class, 'destroy'])->middleware(['permission:almacen_destroy']);
        Route::get('/cat_product/contar', [AlmacenController::class, 'producto_categoria']);
        Route::get('/imagenes/{filename}', [AlmacenController::class, 'mostrarImagen']);
    });

    Route::prefix('clientes')->group(function () {
        // Rutas de Clientes
        Route::get('/', [ClientesController::class, 'index'])->middleware(['permission:clientes_index']);
        Route::post('/', [ClientesController::class, 'store'])->middleware(['permission:clientes_store']);
        Route::get('/{id}', [ClientesController::class, 'show'])->middleware(['permission:clientes_show']);
        Route::put('/{id}', [ClientesController::class, 'update'])->middleware(['permission:clientes_update']);
        Route::delete('/{id}', [ClientesController::class, 'destroy'])->middleware(['permission:clientes_destroy']);
    });

    Route::prefix('proveedores')->group(function () {
        // Rutas de Proveedores
        Route::get('/', [ProveedoresController::class, 'index'])->middleware(['permission:proveedores_index']);
        Route::post('/', [ProveedoresController::class, 'store'])->middleware(['permission:proveedores_store']);
        Route::get('/{id}', [ProveedoresController::class, 'show'])->middleware(['permission:proveedores_show']);
        Route::put('/{id}', [ProveedoresController::class, 'update'])->middleware(['permission:proveedores_update']);
        Route::delete('/{id}', [ProveedoresController::class, 'destroy'])->middleware(['permission:proveedores_destroy']);
    });

    Route::prefix('compras')->group(function () {
        // Rutas de Compras
        Route::get('/', [ComprasController::class, 'index'])->middleware(['permission:compras_index']);
        Route::post('/', [ComprasController::class, 'store'])->middleware(['permission:compras_store']);
        Route::get('/{id}', [ComprasController::class, 'show'])->middleware(['permission:compras_show']);
        Route::put('/{id}', [ComprasController::class, 'update'])->middleware(['permission:compras_update']);
        Route::delete('/{id}', [ComprasController::class, 'destroy'])->middleware(['permission:compras_destroy']);
    });

    Route::prefix('roles')->group(function () {
        // Rutas de Roles
        Route::get('/', [RolesController::class, 'index'])->middleware(['permission:roles_index']);
        Route::post('/', [RolesController::class, 'store'])->middleware(['permission:roles_store']);
        Route::get('/{id}', [RolesController::class, 'show'])->middleware(['permission:roles_show']);
        Route::put('/{id}', [RolesController::class, 'update'])->middleware(['permission:roles_update']);
        Route::delete('/{id}', [RolesController::class, 'destroy'])->middleware(['permission:roles_destroy']);
    });

    Route::prefix('usuarios')->group(function () {
        // Rutas de Usuarios
        Route::get('/', [UserController::class, 'index']);
        Route::get('/{id}', [UserController::class, 'show']);
        Route::put('/{id}', [UserController::class, 'update']);
        Route::delete('/{id}', [UserController::class, 'destroy']);
    });

    Route::prefix('ventas')->group(function () {
        // Rutas de Ventas
        Route::get('/', [VentasController::class, 'index'])->middleware(['permission:ventas_index']);
        Route::post('/', [VentasController::class, 'store'])->middleware(['permission:ventas_store']);
        Route::get('/{id}', [VentasController::class, 'show'])->middleware(['permission:ventas_show']);
        Route::put('/{id}', [VentasController::class, 'update'])->middleware(['permission:ventas_update']);
        Route::delete('/{id}', [VentasController::class, 'destroy'])->middleware(['permission:ventas_destroy']);
    });

    Route::prefix('carrito')->group(function () {
        // Rutas de Carrito
        Route::get('/', [CarritoController::class, 'index'])->middleware(['permission:compras_index']);
        Route::post('/', [CarritoController::class, 'store'])->middleware(['permission:compras_store']);
        Route::get('/{id}', [CarritoController::class, 'show'])->middleware(['permission:compras_show']);
        Route::put('/{id}', [CarritoController::class, 'update'])->middleware(['permission:compras_update']);
        Route::delete('/{id}', [CarritoController::class, 'destroy'])->middleware(['permission:compras_destroy']);
    });
});
