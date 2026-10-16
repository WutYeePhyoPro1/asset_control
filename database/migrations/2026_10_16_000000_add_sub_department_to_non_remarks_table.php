<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('non_remarks', function (Blueprint $table) {
            $table->string('sub_department')->nullable()->after('department');
        });
    }

    public function down(): void
    {
        Schema::table('non_remarks', function (Blueprint $table) {
            $table->dropColumn('sub_department');
        });
    }
};
