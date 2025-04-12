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
        if (Schema::hasTable('actor_t_v_show')) {
            Schema::rename('actor_t_v_show', 'actor_series');
            
            Schema::table('actor_series', function (Blueprint $table) {
                $table->dropForeign(['t_v_show_id']);
                $table->renameColumn('t_v_show_id', 'series_id');
                $table->foreign('series_id')->references('id')->on('series')->onDelete('cascade');
            });
        } else {
            Schema::create('actor_series', function (Blueprint $table) {
                $table->id();
                $table->foreignId('actor_id')->constrained()->onDelete('cascade');
                $table->foreignId('series_id')->constrained()->onDelete('cascade');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('actor_series')) {
            Schema::table('actor_series', function (Blueprint $table) {
                $table->dropForeign(['series_id']);
                $table->renameColumn('series_id', 't_v_show_id');
                $table->foreign('t_v_show_id')->references('id')->on('t_v_shows')->onDelete('cascade');
            });
            
            Schema::rename('actor_series', 'actor_t_v_show');
        }
    }
};
