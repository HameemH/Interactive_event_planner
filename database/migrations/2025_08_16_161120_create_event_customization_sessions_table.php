<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventCustomizationSessionsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('event_customization_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events'); // Link to the main event
            $table->json('session_data'); // Store form data as JSON
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_customization_sessions');
    }
}
