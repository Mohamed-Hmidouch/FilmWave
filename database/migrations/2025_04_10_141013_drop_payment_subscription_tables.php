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
        // First drop the pivot/relationship tables
        Schema::dropIfExists('content_playlist'); // This must be dropped first
        
        // Then drop other tables with foreign keys
        Schema::dropIfExists('user_subscription');
        Schema::dropIfExists('payments');
        
        // Finally drop the main tables
        Schema::dropIfExists('playlists');
        Schema::dropIfExists('subscriptions');
        Schema::dropIfExists('cards');
        Schema::dropIfExists('u_p_i_s');
    }

    public function down(): void
    {
        // Cannot restore tables with this migration
    }
};
