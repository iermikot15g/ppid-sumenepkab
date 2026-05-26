<?php
// database/migrations/xxxx_xx_xx_xxxxxx_add_profile_columns_to_opds_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('opds', function (Blueprint $table) {
            // Visi Misi
            $table->text('vision')->nullable()->after('duties');
            $table->text('mission')->nullable()->after('vision');
            
            // Tentang OPD
            $table->text('about')->nullable()->after('mission');
            $table->string('google_maps_link')->nullable()->after('about');
            
            // Tugas dan Fungsi (sudah ada duties, kita rename/tambah)
            // duties sudah ada, kita akan gunakan
            $table->text('functions')->nullable()->after('duties');
        });
    }

    public function down(): void
    {
        Schema::table('opds', function (Blueprint $table) {
            $table->dropColumn(['vision', 'mission', 'about', 'google_maps_link', 'functions']);
        });
    }
};