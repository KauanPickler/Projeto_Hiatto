<?php

namespace App\Http\Controllers;

use App\Services\Magazord\MagazordService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class MagazordController extends Controller
{
    public function accessApiMagazordGet(MagazordService $magazord, string $resources, ?int $id = null): JsonResponse
    {
        $map = [
            'marca' => 'getBrands',
            'produtos' => 'getProdutos',
            'unidadeMedida' => 'getUnitsOfMeasurement',
            'derivacao' => 'getDerivation',
            'loja' => 'getStores',
            'categoria' => 'getCategories',
            'caracteristica' => 'getCharacteristics',
            'ncm' => 'getNCM',
            'cest' => 'getCEST',
            'situacao-tributaria-PIS' => 'getPIS',
            'situacao-tributaria-COFINS' => 'getCOFINS',
            'produto' => 'getOneProduct',
        ];

        if (!isset($map[$resources])) {
            return response()->json(['message' => 'Rota Inválida'], 404);
        }

        $method = $map[$resources];
        $data = $id ? $magazord->$method($id) : $magazord->$method();

        return response()->json([
            'message' => 'Rota Acessada com Sucesso',
            'data' => $data,
        ]);
    }

    public function accessApiMagazordPost(MagazordService $magazord, string $resources, Request $request): JsonResponse
    {
        $map = [
            'caracteristica-adicionar' => 'addCharacteristics',
            'produto-caracteristicas' => 'getProductCharacteristics',
            'produto-precos' => 'getProductPrices',
            'produto-derivacao-criar' => 'createProductDerivation',
            'produtos-derivacoes-listar' => 'findAllProductsXDerivations',
            'produto-derivacoes-listar' => 'findAllProductDerivations',
            'produto-derivacao-obter' => 'findOneProductDerivation',
            'produto-derivacao-atualizar' => 'updateProductDerivation',
            'produto-derivacao-remover' => 'removeProductDerivation',
            'precos-adicionar' => 'addPrices',
            'depositos-listar' => 'getDeposits',
            'estoque-movimentar' => 'moveStock',
            'estoque-produto-derivacao' => 'getProductDerivationStock',
            'estoque-movimentacao-listar' => 'getStockMovement',
            'produto-criar' => 'createProduct',
        ];

        if (!isset($map[$resources])) {
            return response()->json(['message' => 'Rota Inválida'], 404);
        }

        $method = $map[$resources];
        $data = $magazord->$method($request);

        return response()->json([
            'message' => 'Rota Acessada com Sucesso',
            'data' => $data,
        ]);
    }
}
