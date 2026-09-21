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
        Schema::create('fix_assets', function (Blueprint $table) {
            $table->id();
            $table->string('asset_code')->nullable();
            $table->string('branch_code')->nullable();
            $table->string('branch_name')->nullable();
            $table->string('department')->nullable();
            $table->string('asset_type_name')->nullable();
            $table->string('asset_name')->nullable();
            $table->date('purchase_date')->nullable();
            $table->date('stop_cal_date')->nullable();
            $table->string('status')->nullable();
            $table->json('employee_data')->nullable();
            $table->unique('asset_code');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fix_assets');
    }
};
