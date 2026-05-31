<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('opd_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained();
            $table->foreignId('sub_category_id')->nullable()->constrained();
            
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('doc_number')->nullable();
            $table->integer('year');
            $table->string('officer_name')->nullable();
            
            $table->enum('classification', ['open', 'excluded'])->default('open');
            $table->enum('status', ['published', 'unpublished', 'archived'])->default('unpublished');
            
            $table->string('file_path');
            $table->integer('file_size')->nullable();
            $table->string('file_mime')->nullable();
            $table->integer('download_count')->default(0);
            
            $table->timestamp('published_at')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('last_edited_by')->nullable()->constrained('users');
            $table->foreignId('force_unpublished_by')->nullable()->constrained('users');
            $table->text('force_unpublished_reason')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes for search
            $table->index(['status', 'classification']);
            $table->index('year');
            $table->fullText(['title', 'description']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};