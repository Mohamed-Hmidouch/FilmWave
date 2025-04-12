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
        // Check if the old pivot table exists and rename it
        if (Schema::hasTable('actor_t_v_show')) {
            Schema::rename('actor_t_v_show', 'actor_series');
            
            Schema::table('actor_series', function (Blueprint $table) {
                // Find if foreign key exists
                $foreignKeys = Schema::getConnection()
                    ->getDoctrineSchemaManager()
                    ->listTableForeignKeys('actor_series');
                
                foreach ($foreignKeys as $key) {
                    if (in_array('t_v_show_id', $key->getColumns())) {
                        $table->dropForeign($key->getName());
                        break;
                    }
                }
                
                // Rename column
                $table->renameColumn('t_v_show_id', 'series_id');
                
                // Add foreign key constraint
                $table->foreign('series_id')
                      ->references('id')
                      ->on('series')
                      ->onDelete('cascade');
            });
        }
        else if (Schema::hasTable('actor_tv_show')) {
            Schema::rename('actor_tv_show', 'actor_series');
            
            Schema::table('actor_series', function (Blueprint $table) {
                // Find if foreign key exists
                $foreignKeys = Schema::getConnection()
                    ->getDoctrineSchemaManager()
                    ->listTableForeignKeys('actor_series');
                
                foreach ($foreignKeys as $key) {
                    if (in_array('tv_show_id', $key->getColumns())) {
                        $table->dropForeign($key->getName());
                        break;
                    }
                }
                
                // Rename column
                $table->renameColumn('tv_show_id', 'series_id');
                
                // Add foreign key constraint
                $table->foreign('series_id')
                      ->references('id')
                      ->on('series')
                      ->onDelete('cascade');
            });
        }
        // If neither table exists, create the new pivot table
        else if (!Schema::hasTable('actor_series')) {
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
        // Reverse the rename
        if (Schema::hasTable('actor_series')) {
            Schema::rename('actor_series', 'actor_t_v_show');
            
            Schema::table('actor_t_v_show', function (Blueprint $table) {
                // Drop foreign key
                $table->dropForeign(['series_id']);
                
                // Rename column back
                $table->renameColumn('series_id', 't_v_show_id');
                
                // Add the original foreign key back
                $table->foreign('t_v_show_id')
                      ->references('id')
                      ->on('t_v_shows')
                      ->onDelete('cascade');
            });
        }
    }
};
