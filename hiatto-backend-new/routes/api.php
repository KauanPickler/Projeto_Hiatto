<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function (): void {

    Route::middleware('auth:sanctum')->group(function (): void {
        Route::resource('perfis', RoleController::class)->except([
            'create',
            'edit',
        ])->parameters([
            'perfis' => 'id',
        ]);

        Route::get('/user', [UserController::class, 'index'])->name('user.index');
    });

    Route::middleware('guest')->group(function (): void {
        Route::post('/login', [LoginController::class, 'login'])->name('login');
    });
});
