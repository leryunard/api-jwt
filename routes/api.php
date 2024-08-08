<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;

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
    
    Route::prefix('categories')->group(function () { 
        // Rutas de Categorías
        Route::get('/', [CategoryController::class, 'index'])->middleware(['permission:categories_index']);
        Route::post('/', [CategoryController::class, 'store'])->middleware(['permission:categories_store']);
        Route::get('/{id}', [CategoryController::class, 'show'])->middleware(['permission:categories_show']);
        Route::put('/{id}', [CategoryController::class, 'update'])->middleware(['permission:categories_update']);
        Route::delete('/{id}', [CategoryController::class, 'destroy'])->middleware(['permission:categories_destroy']);
    });

    Route::prefix('products')->group(function () { 
        // Rutas de Productos
        Route::get('/', [ProductController::class, 'index'])->middleware(['permission:products_index']);
        Route::post('/', [ProductController::class, 'store'])->middleware(['permission:products_store']);
        Route::get('/{id}', [ProductController::class, 'show'])->middleware(['permission:products_show']);
        Route::put('/{id}', [ProductController::class, 'update'])->middleware(['permission:products_update']);
        Route::delete('/{id}', [ProductController::class, 'destroy'])->middleware(['permission:products_destroy']);
    });

    Route::prefix('permission')->group(function () {  
        // Rutas de Productos
        Route::get('/', [ProductController::class, 'index'])->middleware(['permission:products_index']);
        Route::post('/', [ProductController::class, 'store'])->middleware(['permission:products_store']);
        Route::get('/{id}', [ProductController::class, 'show'])->middleware(['permission:products_show']);
        Route::put('/{id}', [ProductController::class, 'update'])->middleware(['permission:products_update']);
        Route::delete('/{id}', [ProductController::class, 'destroy'])->middleware(['permission:products_destroy']);
    });
});