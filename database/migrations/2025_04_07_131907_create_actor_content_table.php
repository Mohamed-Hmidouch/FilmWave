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
        Schema::create('actor_content', function (Blueprint $table) {
            $table->id();
            $table->foreignId('actor_id')->constrained()->onDelete('cascade');
            $table->foreignId('content_id')->constrained()->onDelete('cascade');
            $table->string('role_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actor_content');
    }
};
