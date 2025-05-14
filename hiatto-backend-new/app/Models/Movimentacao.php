<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movimentacao extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'codigo_produto',
        'name',
        'tipo_movimentacao',
        'nota_fiscal',
        'observacao',
    ];
}
