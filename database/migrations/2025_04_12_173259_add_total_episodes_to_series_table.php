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
        Schema::table('series', function (Blueprint $table) {
            if (!Schema::hasColumn('series', 'total_episodes')) {
                $table->integer('total_episodes')->default(0)->after('seasons');
            }
            
            if (!Schema::hasColumn('series', 'status')) {
                $table->string('status')->default('ongoing')->after('total_episodes');
            }
            
            if (!Schema::hasColumn('series', 'average_episode_length')) {
                $table->integer('average_episode_length')->nullable()->after('status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('series', function (Blueprint $table) {
            $table->dropColumn(['total_episodes', 'status', 'average_episode_length']);
        });
    }
};
