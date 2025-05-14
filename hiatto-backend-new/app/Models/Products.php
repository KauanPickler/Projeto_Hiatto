<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Products extends Model
{
    use HasApiTokens, HasFactory, HasRoles, Notifiable;

    public $timestamps = false;

    protected $fillable = [
        'codigo',
        'name',
        'brand',
        'weight',
        'unitOfMeasurement',
        'taxOrigin',
        'derivations',
        'categories',
        'ncm',
        'cest',
        'TaxSituation',
        'stores',
        'releaseDate',
    ];
}
