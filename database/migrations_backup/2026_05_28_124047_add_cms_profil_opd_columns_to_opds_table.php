<?php
// database/migrations/xxxx_xx_xx_xxxxxx_add_cms_profil_opd_columns_to_opds_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('opds', function (Blueprint $table) {
            // Tentang OPD
            if (!Schema::hasColumn('opds', 'tentang_content')) {
                $table->longText('tentang_content')->nullable();
            }
            
            // Tugas dan Fungsi
            if (!Schema::hasColumn('opds', 'tusi_content')) {
                $table->longText('tusi_content')->nullable();
            }
            if (!Schema::hasColumn('opds', 'tusi_pdf')) {
                $table->string('tusi_pdf')->nullable();
            }
            
            // Struktur Organisasi
            if (!Schema::hasColumn('opds', 'structure_content')) {
                $table->longText('structure_content')->nullable();
            }
            if (!Schema::hasColumn('opds', 'structure_pdf')) {
                $table->string('structure_pdf')->nullable();
            }
            
            // Dasar Hukum
            if (!Schema::hasColumn('opds', 'dasar_hukum_content')) {
                $table->longText('dasar_hukum_content')->nullable();
            }
            if (!Schema::hasColumn('opds', 'dasar_hukum_pdf')) {
                $table->string('dasar_hukum_pdf')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('opds', function (Blueprint $table) {
            $table->dropColumn([
                'tentang_content',
                'tusi_content',
                'tusi_pdf',
                'structure_content',
                'structure_pdf',
                'dasar_hukum_content',
                'dasar_hukum_pdf',
            ]);
        });
    }
};