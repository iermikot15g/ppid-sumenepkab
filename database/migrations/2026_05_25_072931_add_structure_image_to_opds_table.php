<?php
// database/migrations/xxxx_xx_xx_xxxxxx_add_structure_image_to_opds_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('opds', function (Blueprint $table) {
            $table->string('structure_image')->nullable()->after('logo');
        });
    }

    public function down(): void
    {
        Schema::table('opds', function (Blueprint $table) {
            $table->dropColumn('structure_image');
        });
    }
};