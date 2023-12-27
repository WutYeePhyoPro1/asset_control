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
        Schema::create('non_operators', function (Blueprint $table) {
            $table->id();
            $table->string('doc_no')->nullable();
            $table->string('branch')->nullable();
            $table->string('department')->nullable();
            $table->string('operator')->nullable();
            $table->string('phone')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('non_operators');
    }
};
