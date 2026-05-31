<?php
// database/migrations/xxxx_xx_xx_xxxxxx_add_title_and_other_columns_to_hero_slides_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('hero_slides', function (Blueprint $table) {
            // Cek apakah kolom belum ada sebelum menambahkan
            if (!Schema::hasColumn('hero_slides', 'title')) {
                $table->string('title')->nullable()->after('image_path');
            }
            
            // Untuk kolom lainnya, lakukan hal yang sama
            if (!Schema::hasColumn('hero_slides', 'other_column')) {
                $table->text('other_column')->nullable();
            }
        });
    }
};