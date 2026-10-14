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
        Schema::table('remarks', function (Blueprint $table) {
            $table->string('branch_name')->nullable()->after('emp_name');
            $table->string('department')->nullable()->after('branch_name');
            $table->string('sub_department')->nullable()->after('department');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('remarks', function (Blueprint $table) {
            $table->dropColumn('sub_department');
        });
    }
};
