<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_legal_documents_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('legal_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('opd_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('file_path');
            $table->string('file_size')->nullable();
            $table->string('regulation_number')->nullable(); // nomor peraturan
            $table->integer('year')->nullable(); // tahun peraturan
            $table->boolean('is_published')->default(true);
            $table->integer('download_count')->default(0);
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('legal_documents');
    }
};