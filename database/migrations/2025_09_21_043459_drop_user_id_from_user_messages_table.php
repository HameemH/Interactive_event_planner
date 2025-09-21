<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, backup existing data
        $existingMessages = DB::table('user_messages')->get();
        
        // Drop the entire table
        Schema::dropIfExists('user_messages');
        
        // Recreate the table without user_id
        Schema::create('user_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->text('venue_message')->nullable();
            $table->text('seating_message')->nullable();
            $table->text('stage_message')->nullable();
            $table->text('catering_message')->nullable();
            $table->text('photography_message')->nullable();
            $table->text('extra_options_message')->nullable();
            $table->timestamps();
        });
        
        // Restore data (excluding user_id)
        foreach ($existingMessages as $message) {
            DB::table('user_messages')->insert([
                'event_id' => $message->event_id ?? null,
                'venue_message' => $message->venue_message,
                'seating_message' => $message->seating_message,
                'stage_message' => $message->stage_message,
                'catering_message' => $message->catering_message,
                'photography_message' => $message->photography_message,
                'extra_options_message' => $message->extra_options_message,
                'created_at' => $message->created_at,
                'updated_at' => $message->updated_at,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Backup existing data
        $existingMessages = DB::table('user_messages')->get();
        
        // Drop and recreate table with user_id
        Schema::dropIfExists('user_messages');
        
        Schema::create('user_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('event_id')->nullable()->constrained()->onDelete('cascade');
            $table->text('venue_message')->nullable();
            $table->text('seating_message')->nullable();
            $table->text('stage_message')->nullable();
            $table->text('catering_message')->nullable();
            $table->text('photography_message')->nullable();
            $table->text('extra_options_message')->nullable();
            $table->timestamps();
            
            $table->unique(['user_id', 'event_id']);
        });
        
        // Note: We can't restore user_id data since we don't have it anymore
        // This is a destructive migration
    }
};
