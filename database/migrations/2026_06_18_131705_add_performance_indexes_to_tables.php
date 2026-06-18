<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Helper untuk mengecek apakah index sudah ada
        $hasIndex = function ($table, $indexName) {
            $result = DB::select("SHOW INDEX FROM {$table} WHERE Key_name = ?", [$indexName]);
            return count($result) > 0;
        };

        // ========== TABEL NEWS ==========
        Schema::table('news', function (Blueprint $table) use ($hasIndex) {
            if (!$hasIndex('news', 'news_type_published_opd')) {
                $table->index(['type', 'is_published', 'opd_id'], 'news_type_published_opd');
            }
            if (!$hasIndex('news', 'news_event_date_index')) {
                $table->index('event_date', 'news_event_date_index');
            }
            if (!$hasIndex('news', 'news_published_at_index')) {
                $table->index('published_at', 'news_published_at_index');
            }
            if (!$hasIndex('news', 'news_created_by_index')) {
                $table->index('created_by', 'news_created_by_index');
            }
        });

        // ========== TABEL DOCUMENTS ==========
        Schema::table('documents', function (Blueprint $table) use ($hasIndex) {
            if (!$hasIndex('documents', 'documents_opd_status_category')) {
                $table->index(['opd_id', 'status', 'category_id'], 'documents_opd_status_category');
            }
            if (!$hasIndex('documents', 'documents_year_index')) {
                $table->index('year', 'documents_year_index');
            }
            if (!$hasIndex('documents', 'documents_published_at_index')) {
                $table->index('published_at', 'documents_published_at_index');
            }
            if (!$hasIndex('documents', 'documents_created_by_index')) {
                $table->index('created_by', 'documents_created_by_index');
            }
            if (!$hasIndex('documents', 'documents_classification_index')) {
                $table->index('classification', 'documents_classification_index');
            }
            if (!$hasIndex('documents', 'documents_deleted_at_index')) {
                $table->index('deleted_at', 'documents_deleted_at_index');
            }
        });

        // ========== TABEL ACTIVITY_LOGS ==========
        Schema::table('activity_logs', function (Blueprint $table) use ($hasIndex) {
            if (!$hasIndex('activity_logs', 'activity_logs_user_created_index')) {
                $table->index(['user_id', 'created_at'], 'activity_logs_user_created_index');
            }
            if (!$hasIndex('activity_logs', 'activity_logs_entity_type_index')) {
                $table->index('entity_type', 'activity_logs_entity_type_index');
            }
            if (!$hasIndex('activity_logs', 'activity_logs_action_index')) {
                $table->index('action', 'activity_logs_action_index');
            }
        });

        // ========== TABEL DOCUMENT_LOGS ==========
        Schema::table('document_logs', function (Blueprint $table) use ($hasIndex) {
            if (!$hasIndex('document_logs', 'document_logs_doc_user_index')) {
                $table->index(['document_id', 'user_id'], 'document_logs_doc_user_index');
            }
            if (!$hasIndex('document_logs', 'document_logs_action_index')) {
                $table->index('action', 'document_logs_action_index');
            }
            if (!$hasIndex('document_logs', 'document_logs_created_at_index')) {
                $table->index('created_at', 'document_logs_created_at_index');
            }
        });

        // ========== TABEL OPDS ==========
        Schema::table('opds', function (Blueprint $table) use ($hasIndex) {
            if (!$hasIndex('opds', 'opds_is_active_index')) {
                $table->index('is_active', 'opds_is_active_index');
            }
            if (!$hasIndex('opds', 'opds_name_index')) {
                $table->index('name', 'opds_name_index');
            }
        });

        // ========== TABEL USERS ==========
        Schema::table('users', function (Blueprint $table) use ($hasIndex) {
            if (!$hasIndex('users', 'users_opd_id_index')) {
                $table->index('opd_id', 'users_opd_id_index');
            }
            if (!$hasIndex('users', 'users_is_active_index')) {
                $table->index('is_active', 'users_is_active_index');
            }
        });

        // ========== TABEL SESSIONS ==========
        Schema::table('sessions', function (Blueprint $table) use ($hasIndex) {
            if (!$hasIndex('sessions', 'sessions_user_id_index')) {
                $table->index('user_id', 'sessions_user_id_index');
            }
            if (!$hasIndex('sessions', 'sessions_last_activity_index')) {
                $table->index('last_activity', 'sessions_last_activity_index');
            }
        });
    }

    public function down()
    {
        Schema::table('news', function (Blueprint $table) {
            $table->dropIndexIfExists('news_type_published_opd');
            $table->dropIndexIfExists('news_event_date_index');
            $table->dropIndexIfExists('news_published_at_index');
            $table->dropIndexIfExists('news_created_by_index');
        });

        Schema::table('documents', function (Blueprint $table) {
            $table->dropIndexIfExists('documents_opd_status_category');
            $table->dropIndexIfExists('documents_year_index');
            $table->dropIndexIfExists('documents_published_at_index');
            $table->dropIndexIfExists('documents_created_by_index');
            $table->dropIndexIfExists('documents_classification_index');
            $table->dropIndexIfExists('documents_deleted_at_index');
        });

        Schema::table('activity_logs', function (Blueprint $table) {
            $table->dropIndexIfExists('activity_logs_user_created_index');
            $table->dropIndexIfExists('activity_logs_entity_type_index');
            $table->dropIndexIfExists('activity_logs_action_index');
        });

        Schema::table('document_logs', function (Blueprint $table) {
            $table->dropIndexIfExists('document_logs_doc_user_index');
            $table->dropIndexIfExists('document_logs_action_index');
            $table->dropIndexIfExists('document_logs_created_at_index');
        });

        Schema::table('opds', function (Blueprint $table) {
            $table->dropIndexIfExists('opds_is_active_index');
            $table->dropIndexIfExists('opds_name_index');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropIndexIfExists('users_opd_id_index');
            $table->dropIndexIfExists('users_is_active_index');
        });

        Schema::table('sessions', function (Blueprint $table) {
            $table->dropIndexIfExists('sessions_user_id_index');
            $table->dropIndexIfExists('sessions_last_activity_index');
        });
    }
};