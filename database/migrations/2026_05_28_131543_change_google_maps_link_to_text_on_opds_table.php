<?php
// database/migrations/xxxx_xx_xx_xxxxxx_change_google_maps_link_to_text_on_opds_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('opds', function (Blueprint $table) {
            if (Schema::hasColumn('opds', 'google_maps_link')) {
                $table->text('google_maps_link')->nullable()->change();
            }
        });
    }

    public function down(): void
    {
        Schema::table('opds', function (Blueprint $table) {
            if (Schema::hasColumn('opds', 'google_maps_link')) {
                $table->string('google_maps_link', 255)->nullable()->change();
            }
        });
    }
};