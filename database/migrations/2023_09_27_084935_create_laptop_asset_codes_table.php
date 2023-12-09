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
        Schema::create('laptop_asset_codes', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned()->nullable();
            $table->string('doc_no')->nullable();
            $table->string('type')->nullable();
            $table->string('emp_name')->nullable();
            $table->string('emp_code')->nullable();
            $table->string('branch_code')->nullable();
            $table->string('branch_name')->nullable();
            $table->string('department')->nullable();
            $table->string('asset_type')->nullable();
            $table->string('laptop_asset_code')->nullable();
            $table->text('laptop_asset_name')->nullable();
            $table->string('handset_asset_code')->nullable();
            $table->text('handset_asset_name')->nullable();
            $table->string('sim_name')->nullable();
            $table->string('sim_phone')->nullable();
            $table->string('receipt_date')->nullable();
            $table->string('receipt_type')->nullable();
            $table->text('remark')->nullable();
            $table->string('file')->nullable();
            $table->string('date')->nullable();
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laptop_asset_codes');
    }
};
