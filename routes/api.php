<?php

use App\Http\Controllers\Api\AlmacenController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;

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
Route::middleware('auth:api')->group(function() {
    Route::get('/me', [UserController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
    
    Route::get('profile', [AuthController::class, 'profile']);

    Route::group(['middleware' => ['role:admin']], function() {
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
        Route::get('/cat_product/contar', [AlmacenController::class, 'producto_categoria'])->middleware('auth:api');
        Route::get('/imagenes/{filename}', [AlmacenController::class, 'mostrarImagen'])->middleware('auth:api');
    });

});