<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Carbon\Carbon;
use Dotenv\Validator;
use Illuminate\Http\Request;

class ProductsController extends Controller {

    function index() {
        $products = Products::all();
        return response()->json([
            'message' => 'Lista de Produtos',
            'data' => $products,
        ]);
    }

    function show(Request $request) {
        $search = $request->input('search');
        $product = Products::where('codigo', $search)
                        ->orWhere('name', 'like', '%' . $search . '%')->get();
                        
        if ($product) {
            return response()->json([
                'message' => 'Produto encontrado',
                'data' => $product,
            ]);
        } else {
            return response()->json([
                'message' => 'Produto não encontrado',
            ], 404);
        }
    }   

     public function store(Request $request) {
        
        try{
        $request->validate([
            'codigo' => 'required|string|unique:products,codigo',
            'name' => 'required|string',
            'brand' => 'required|string',
            'weight' => 'required|numeric',
            'unitOfMeasurement' => 'required|string',
            'taxOrigin' => 'required|string',
            'derivations' => 'required|string',
            'categories' => 'required|string',
            'ncm' => 'required|string',
            'cest' => 'required|string',
            'TaxSituation' => 'required|string',
            'stores' => 'required|string',
            'releaseDate' => 'required|date_format:d/m/Y'
        ]);

        $time = Carbon::createFromFormat('d/m/Y', $request->releaseDate)->format('Y-m-d');
        
        $product = Products::create([
            'codigo' => $request->codigo,
            'name' => $request->name,
            'brand' => $request->brand,
            'weight' => $request->weight,
            'unitOfMeasurement' => $request->unitOfMeasurement,
            'taxOrigin' => $request->taxOrigin,
            'derivations' => $request->derivations,
            'categories' => $request->categories,
            'ncm' => $request->ncm,
            'cest' => $request->cest,
            'TaxSituation' => $request->TaxSituation,
            'stores' => $request->stores,
            'releaseDate' => $time
        ]);

        return response()->json([
            'message' => 'Produto Criado com Sucesso',
            'data' => $product,
        ]);
    }catch(\Exception $e){
        
        return response()->json([
            'message' => 'Erro ao criar produto',
            'error' => $e->getMessage(),
            
        ], 500);
        }
    }

    function update(Request $request, $id) {
        
        try{
            $produto = Products::find($id);
            $request->validate([
                'codigo' => 'required|string',
                'name' => 'required|string',
                'brand' => 'required|string',
                'weight' => 'required|numeric',
                'unitOfMeasurement' => 'required|string',
                'taxOrigin' => 'required|string',
                'derivations' => 'required|string',
                'categories' => 'required|string',
                'ncm' => 'required|string',
                'cest' => 'required|string',
                'TaxSituation' => 'required|string',
                'stores' => 'required|string',
                'releaseDate' => 'required|date_format:d/m/Y'
            ]);
    
            $time = Carbon::createFromFormat('d/m/Y', $request->releaseDate)->format('Y-m-d');
            
            $produto->update([
                'codigo' => $request->codigo,
                'name' => $request->name,
                'brand' => $request->brand,
                'weight' => $request->weight,
                'unitOfMeasurement' => $request->unitOfMeasurement,
                'taxOrigin' => $request->taxOrigin,
                'derivations' => $request->derivations,
                'categories' => $request->categories,
                'ncm' => $request->ncm,
                'cest' => $request->cest,
                'TaxSituation' => $request->TaxSituation,
                'stores' => $request->stores,
                'releaseDate' => $time
            ]);
    
            return response()->json([
                'message' => 'Produto Atualizado com Sucesso',
                'data' => $produto,
            ]);
        }catch(\Exception $e){
            
            return response()->json([
                'message' => 'Erro ao criar produto',
                'error' => $e->getMessage(),
                
            ], 500);
            }
    }

    function destroy($id) {
        try{
            $produto = Products::find($id);
            $produto->delete();
            return response()->json([
                'message' => 'Produto Deletado com Sucesso',
            ], 200);
        }catch(\Exception $e){
            
            return response()->json([
                'message' => 'Erro ao deletar produto',
                'error' => $e->getMessage(),
                
            ], 500);
            }
        
    }
}
