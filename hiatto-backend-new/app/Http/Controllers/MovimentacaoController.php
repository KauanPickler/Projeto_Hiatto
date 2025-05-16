<?php

namespace App\Http\Controllers;

use App\Models\Movimentacao;
use Illuminate\Http\Request;

class MovimentacaoController extends Controller
{
    public function index(Request $request)
    {
        $query = Movimentacao::query();

    
    if ($request->filled('codigo_produto')) {
        $query->where('codigo_produto', $request->codigo_produto);
    }

    
    if ($request->filled('name')) {
        $query->where('name', 'like', '%' . $request->name . '%');
    }

    
    if ($request->filled('tipo_movimentacao')) {
        $query->where('tipo_movimentacao', $request->tipo_movimentacao);
    }


    if ($request->filled('codigo_romaneio')) {
        $query->where('codigo_romaneio', $request->codigo_romaneio);
    }

    
    if ($request->filled('data_inicio') && $request->filled('data_fim')) {
        $query->whereBetween('data_criacao', [$request->data_inicio, $request->data_fim]);
    }

    $resultados = $query->get();

    if ($resultados->isNotEmpty()) {
        return response()->json([
            'message' => 'Movimentações encontradas',
            'data' => $resultados,
        ]);
    }

    return response()->json([
        'message' => 'Nenhuma movimentação encontrada',
    ], 404);
    }


    public function store(Request $request)
    {
        try {
            Movimentacao::create([
                'codigo_produto' => $request->codigo_produto,
                'name' => $request->name,
                'tipo_movimentacao' => $request->tipo_movimentacao,
                'nota_fiscal' => $request->nota_fiscal,
                'observacao' => $request->observacao,
                'data_criacao' => now(),
                'data_atualizacao' => now(),
            ]);
            return response()->json([
                'message' => 'Movimentação criada com sucesso',
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao criar movimentação: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $movimentacao = Movimentacao::find($id);

        if(!$movimentacao){
            return response()->json([
                'message' => 'Movimentação não encontrada',
            ], 404);
        }else{
            try {
                $movimentacao->update([
                    'codigo_produto' => $request->codigo_produto,
                    'name' => $request->name,
                    'tipo_movimentacao' => $request->tipo_movimentacao,
                    'nota_fiscal' => $request->nota_fiscal,
                    'observacao' => $request->observacao,
                ]);
                return response()->json([
                    'message' => 'Movimentação atualizada com sucesso',
                ], 201);
            } catch (\Exception $e) {
                return response()->json([
                    'message' => 'Erro ao atualizar movimentação: ' . $e->getMessage(),
                ], 500);
            }
        }
        
    }

    public function destroy($id)
    {
        $movimentacao = Movimentacao::find($id);

        if(!$movimentacao){
            return response()->json([
                'message' => 'Movimentação não encontrada',
            ], 404);
        }else{
            try {
                $movimentacao->delete();
                return response()->json([
                    'message' => 'Movimentação deletada com sucesso',
                ], 200);
            } catch (\Exception $e) {
                return response()->json([
                    'message' => 'Erro ao deletar movimentação: ' . $e->getMessage(),
                ], 500);
            }
        }
        
    }
    

}
