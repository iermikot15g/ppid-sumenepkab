<?php
// database/migrations/xxxx_xx_xx_xxxxxx_add_missing_columns_to_opds_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('opds', function (Blueprint $table) {
            // Kolom untuk Struktur Organisasi (textarea + PDF)
            if (!Schema::hasColumn('opds', 'structure_content')) {
                $table->longText('structure_content')->nullable()->after('legal_pdf_path');
            }
            if (!Schema::hasColumn('opds', 'structure_pdf_path')) {
                $table->string('structure_pdf_path')->nullable()->after('structure_content');
            }
        });
    }

    public function down(): void
    {
        Schema::table('opds', function (Blueprint $table) {
            $table->dropColumn(['structure_content', 'structure_pdf_path']);
        });
    }
};