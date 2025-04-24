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
        if (!Schema::hasTable('content_playlist')) {
            Schema::create('content_playlist', function (Blueprint $table) {
                $table->id();
                $table->foreignId('content_id')->constrained()->onDelete('cascade');
                $table->foreignId('playlist_id')->constrained()->onDelete('cascade');
                $table->timestamps();
                
                // Éviter les doublons
                $table->unique(['content_id', 'playlist_id']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_playlist');
    }
}; 