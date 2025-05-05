<?php

use App\Http\Controllers\ProductsController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/create-user', [UserController::class, 'store']);
Route::post('/login-user', [UserController::class, 'login']);


Route::middleware(['auth:sanctum'])->group(function (){
    Route::get('/list-users', [UserController::class, 'index']);
    Route::put('/update-user/{user}', [UserController::class, 'update']);
    Route::post('/grant-permission/{user}', [UserController::class, 'grantPermission']);
    Route::post('/logout-user/{user}', [UserController::class, 'logout']);


    //Product Permission
    Route::middleware('permission:Produtos')->group(function () {
        Route::get('/show-products', [ProductsController::class, 'index']);
        Route::post('/create-products', [ProductsController::class, 'store']);
        Route::put('/edit-products/{product}', [ProductsController::class, 'update']);
        Route::delete('/delete-products/{product}', [ProductsController::class, 'destroy']);
    });

    

    //Movement Permission
    Route::middleware('permission:Movimentacoes')->group(function () {
        Route::get('/show-products', [ProductsController::class, 'index']);
        Route::post('/create-products', [ProductsController::class, 'store']);
        Route::put('/edit-products/{product}', [ProductsController::class, 'update']);
        Route::delete('/delete-products/{product}', [ProductsController::class, 'destroy']);
    });


    
    //Order Permission
    Route::middleware('permission:Pedidos')->group(function () {
        Route::get('/show-products', [ProductsController::class, 'index']);
        Route::post('/create-products', [ProductsController::class, 'store']);
        Route::put('/edit-products/{product}', [ProductsController::class, 'update']);
        Route::delete('/delete-products/{product}', [ProductsController::class, 'destroy']);
    });

   
});
