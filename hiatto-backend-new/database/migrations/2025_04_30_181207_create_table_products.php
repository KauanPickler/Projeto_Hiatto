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
            $table->string('codigo');
            $table->string('name');
            $table->string('brand');
            $table->float('weight');
            $table->string('unitOfMeasurement');
            $table->string('taxOrigin');
            $table->string('derivations');
            $table->string('categories');
            $table->string('ncm');
            $table->string('cest');
            $table->string('TaxSituation');
            $table->string('stores');
            $table->date('releaseDate');
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
