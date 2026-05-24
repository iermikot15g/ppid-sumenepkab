<?php
// database/migrations/xxxx_xx_xx_xxxxxx_add_title_and_other_columns_to_hero_slides_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hero_slides', function (Blueprint $table) {
            $table->string('title')->nullable()->after('image_path');
            $table->string('subtitle')->nullable()->after('title');
            $table->string('button_text')->nullable()->after('subtitle');
            $table->string('button_link')->nullable()->after('button_text');
        });
    }

    public function down(): void
    {
        Schema::table('hero_slides', function (Blueprint $table) {
            $table->dropColumn(['title', 'subtitle', 'button_text', 'button_link']);
        });
    }
};