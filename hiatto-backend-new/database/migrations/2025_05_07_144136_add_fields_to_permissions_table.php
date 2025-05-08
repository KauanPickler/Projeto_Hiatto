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
        Schema::table('permissions', function (Blueprint $table): void {
            $table->after('guard_name', function (Blueprint $table): void {
                $table->string('label')->nullable();
                $table->string('group');
                $table->string('group_label');
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permissions', function (Blueprint $table): void {
            $table->dropColumn(['label', 'group', 'group_label']);
        });
    }
};
