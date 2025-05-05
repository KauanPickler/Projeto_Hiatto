<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_pai');
            $table->string('marca');
            $table->string('lancamento_pai');
            $table->string('loja');
            $table->string('nome');
            $table->decimal('peso_kg', 8, 3);
            $table->string('unidade');
            $table->string('derivacao');
            $table->string('categoria');
            $table->string('codigo_ncm');
            $table->text('descricao')->nullable();
            $table->string('codigo_cest');
            $table->text('descricao_cest')->nullable();
            $table->string('origem_fiscal');
            $table->string('codigo_pis');
            $table->text('descricao_pis')->nullable();
            $table->string('codigo_cofins');
            $table->text('descricao_cofins')->nullable();
            $table->string('genero');
            $table->string('colecoes');
            $table->string('combos');
            $table->string('codigo_fornecedor');
            $table->text('observacao')->nullable();
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_products');
    }
};
