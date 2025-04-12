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
        Schema::table('contents', function (Blueprint $table) {
            // Vérifier si les colonnes existent déjà avant de les ajouter
            if (!Schema::hasColumn('contents', 'description')) {
                $table->text('description')->nullable()->after('title');
            }
            
            if (!Schema::hasColumn('contents', 'release_year')) {
                $table->integer('release_year')->nullable()->after('description');
            }
            
            if (!Schema::hasColumn('contents', 'type')) {
                $table->string('type')->after('duration');
            }
            
            if (!Schema::hasColumn('contents', 'cover_image')) {
                $table->string('cover_image')->nullable()->after('type');
            }
            
            if (!Schema::hasColumn('contents', 'maturity_rating')) {
                $table->string('maturity_rating')->nullable()->after('cover_image');
            }
            
            if (!Schema::hasColumn('contents', 'views_count')) {
                $table->integer('views_count')->default(0)->after('maturity_rating');
            }
            
            // Vérifier si la colonne 'genre' existe et la supprimer car elle sera gérée via une table pivot
            if (Schema::hasColumn('contents', 'genre')) {
                $table->dropColumn('genre');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contents', function (Blueprint $table) {
            $table->dropColumn([
                'description',
                'release_year',
                'type',
                'cover_image',
                'maturity_rating',
                'views_count'
            ]);
            
            // Rétablir la colonne genre si elle a été supprimée
            $table->string('genre');
        });
    }
}; 