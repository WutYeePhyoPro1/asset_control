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
        Schema::create('asset_types', function (Blueprint $table) {
            $table->id();
            $table->string('doc_id')->nullable();
            $table->string('department')->nullable();
            $table->string('branch')->nullable();
            $table->string('assettype')->nullable();
            $table->string('assetcode')->nullable();
            $table->string('assetname')->nullable();
            $table->string('operator')->nullable();
            $table->string('ph')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_types');
    }
};
