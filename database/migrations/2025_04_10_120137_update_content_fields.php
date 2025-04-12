<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('episodes', function (Blueprint $table) {
            if (Schema::hasColumn('episodes', 'tv_show_id')) {
                $table->dropForeign(['tv_show_id']);
                $table->dropColumn('tv_show_id');
            }
            
            // إضافة المفتاح الأجنبي الجديد
            $table->foreignId('series_id')->after('id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('episodes', function (Blueprint $table) {
            $table->dropForeign(['series_id']);
            $table->dropColumn('series_id');
            $table->foreignId('tv_show_id')->constrained('t_v_shows')->onDelete('cascade');
        });
    }
};
