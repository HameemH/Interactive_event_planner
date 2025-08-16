<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventSeatingTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('event_seating', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events'); // Link to the main event
            $table->integer('attendees'); // Number of attendees
            $table->enum('chair_type', ['basic', 'premium', 'luxury']); // Chair options
            $table->enum('table_type', ['circular', 'square']); // Table options
            $table->boolean('seat_cover')->default(false); // Whether the chairs will have covers
            $table->decimal('seating_cost', 10, 2); // Cost for seating arrangements
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_seating');
    }
}
