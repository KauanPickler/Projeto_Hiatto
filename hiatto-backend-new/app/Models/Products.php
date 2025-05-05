<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo_pai',
        'marca',
        'lancamento_pai',
        'loja',
        'nome',
        'peso_kg',
        'unidade',
        'derivacao',
        'categoria',
        'codigo_ncm',
        'descricao',
        'codigo_cest',
        'descricao_cest',
        'origem_fiscal',
        'codigo_pis',
        'descricao_pis',
        'codigo_cofins',
        'descricao_cofins',
        'genero',
        'colecoes',
        'combos',
        'codigo_fornecedor',
        'observacao',
    ];
}


