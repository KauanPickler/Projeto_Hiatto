<?php

use App\Http\Controllers\CodigoBarrasController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MagazordController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Services\Magazord\MagazordService;
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
        Route::get('/codigo', [CodigoBarrasController::class, 'index']);
    });

    Route::middleware('guest')->group(function (): void {
        Route::post('/login', [LoginController::class, 'login'])->name('login');
    });
});

Route::middleware('auth:sanctum')->group(function (): void {
    Route::resource('products', ProductsController::class)->except([
        'create',
        'edit',
    ])->parameters([
        'products' => 'id',
    ]);
});



Route::prefix('magazord')->group(function () {
    Route::get('/{resources}/{id?}', [MagazordController::class, 'accessApiMagazord'])
        ->where('resources', 'marca|produtos|unidadeMedida|derivacao|loja|categoria|caracteristica|ncm|cest|situacao-tributaria-PIS|situacao-tributaria-COFINS');
});
