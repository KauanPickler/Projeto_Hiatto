<?php

namespace App\Http\Controllers;

use App\Services\Magazord\MagazordService;
use Illuminate\Http\JsonResponse;

class MagazordController extends Controller
{
    public function accessApiMagazord(MagazordService $magazord, string $resources, ?int $id = null): JsonResponse
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
}
