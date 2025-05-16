<?php

use App\Http\Controllers\CodigoBarrasController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MagazordController;
use App\Http\Controllers\MovimentacaoController;
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

        Route::get('/codigo', [CodigoBarrasController::class, 'index']);
    });

    Route::middleware('guest')->group(function (): void {
        Route::post('/login', [LoginController::class, 'login'])->name('login');
    });
});


Route::get('/user', [UserController::class, 'index'])->name('user.index');


Route::middleware('auth:sanctum')->group(function (): void {
    Route::resource('products', ProductsController::class)->except([
        'create',
        'edit',
    ])->parameters([
        'products' => 'id',
    ]);
});

Route::middleware('auth:sanctum')->group(function (): void {
    Route::resource('movimentations', MovimentacaoController::class)->except([
        'create',
        'edit',
    ])->parameters([
        'movimentations' => 'id',
    ]);
});




Route::prefix('magazord')->middleware('auth:sanctum')->group(function () {

    Route::get('/{resources}/{id?}', [MagazordController::class, 'accessApiMagazordGet'])
        ->where('resources', 'marca|produtos|unidadeMedida|derivacao|loja|categoria|caracteristica|ncm|cest|situacao-tributaria-PIS|situacao-tributaria-COFINS|produto');


    Route::post('/{resources}', [MagazordController::class, 'accessApiMagazordPost'])
        ->where('resources', 'caracteristica-adicionar|produto-caracteristicas|produto-precos|produto-derivacao-criar|produtos-derivacoes-listar|produto-derivacoes-listar|produto-derivacao-obter|produto-derivacao-atualizar|produto-derivacao-remover|precos-adicionar|depositos-listar|estoque-movimentar|estoque-produto-derivacao|estoque-movimentacao-listar|produto-criar');
});
