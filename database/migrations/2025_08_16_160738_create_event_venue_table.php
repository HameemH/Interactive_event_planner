<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventVenueTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('event_venue', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events'); // Link to the main event
            $table->string('venue_name'); // Venue name (if predefined)
            $table->text('venue_address')->nullable(); // Address for custom venues
            $table->decimal('venue_size', 10, 2)->nullable(); // Size in square meters for custom venue
            $table->decimal('venue_cost', 10, 2); // Cost of venue
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_venue');
    }
}
