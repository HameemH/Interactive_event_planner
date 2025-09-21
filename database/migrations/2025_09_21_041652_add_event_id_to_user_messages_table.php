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
        // Check if event_id column already exists before adding it
        if (!Schema::hasColumn('user_messages', 'event_id')) {
            Schema::table('user_messages', function (Blueprint $table) {
                // Add event_id column and make it a foreign key
                $table->foreignId('event_id')->nullable()->constrained()->onDelete('cascade');
            });
        }
        
        // In a separate schema modification, handle the unique constraints
        Schema::table('user_messages', function (Blueprint $table) {
            // Check if the old unique constraint exists before trying to drop it
            $indexExists = \DB::select("SHOW INDEX FROM user_messages WHERE Key_name = 'user_messages_user_id_unique'");
            if (!empty($indexExists)) {
                // Drop the unique constraint on user_id since now we can have multiple messages per user (one per event)
                $table->dropUnique(['user_id']);
            }
            
            // Check if the new composite unique constraint already exists before adding it
            $compositeIndexExists = \DB::select("SHOW INDEX FROM user_messages WHERE Key_name = 'user_messages_user_id_event_id_unique'");
            if (empty($compositeIndexExists)) {
                // Add composite unique constraint for user_id and event_id
                $table->unique(['user_id', 'event_id']);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_messages', function (Blueprint $table) {
            // Drop the composite unique constraint
            $table->dropUnique(['user_id', 'event_id']);
            
            // Restore the original unique constraint on user_id
            $table->unique('user_id');
        });
        
        Schema::table('user_messages', function (Blueprint $table) {
            // Drop the event_id foreign key and column
            $table->dropForeign(['event_id']);
            $table->dropColumn('event_id');
        });
    }
};
