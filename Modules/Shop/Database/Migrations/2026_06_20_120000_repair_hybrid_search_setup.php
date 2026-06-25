<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Perbaiki instalasi parsial jika migrasi stub sudah pernah dijalankan sebelumnya.
     */
    public function up(): void
    {
        if (Schema::hasTable('search_dictionaries') && ! Schema::hasColumn('search_dictionaries', 'word')) {
            Schema::table('search_dictionaries', function (Blueprint $table) {
                $table->string('word', 100)->unique()->after('id');
            });
        }

        $fulltextIndex = DB::select(
            "SHOW INDEX FROM shop_products WHERE Key_name = 'shop_products_name_excerpt_fulltext'"
        );

        if (empty($fulltextIndex)) {
            Schema::table('shop_products', function (Blueprint $table) {
                $table->fullText(['name', 'excerpt'], 'shop_products_name_excerpt_fulltext');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Tidak di-rollback agar tidak menghapus data kamus yang sudah terisi.
    }
};
