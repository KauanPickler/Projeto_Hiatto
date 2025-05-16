<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Movimentacao extends Model
{
    protected $table = 'movimentacao'; 
    use HasApiTokens, HasFactory, HasRoles;
    public $timestamps = false;

    protected $fillable = [
        'codigo_produto',
        'name',
        'tipo_movimentacao',
        'nota_fiscal',
        'observacao',
        'data_criacao',
        'data_atualizacao',
    ];
}
