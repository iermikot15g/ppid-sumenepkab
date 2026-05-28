<?php
// database/migrations/xxxx_xx_xx_xxxxxx_add_cms_columns_to_opds_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('opds', function (Blueprint $table) {
            // CMS content columns
            $table->longText('about_content')->nullable()->after('about');
            $table->longText('duties_content')->nullable()->after('duties');
            $table->longText('functions_content')->nullable()->after('functions');
            $table->string('structure_image')->nullable()->after('structure_image'); // sudah ada, rename saja
        });
    }

    public function down(): void
    {
        Schema::table('opds', function (Blueprint $table) {
            $table->dropColumn(['about_content', 'duties_content', 'functions_content']);
        });
    }
};