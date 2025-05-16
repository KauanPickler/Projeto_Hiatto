<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CodigoBarrasController extends Controller
{
    
    public function index(Request $request)
    {
        
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
}
