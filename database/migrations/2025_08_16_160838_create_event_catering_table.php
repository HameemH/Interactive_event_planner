<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventCateringTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('event_catering', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events'); // Link to the main event
            $table->boolean('catering_required')->default(false); // Whether catering is selected
            $table->decimal('per_person_cost', 10, 2); // Cost per person for catering
            $table->integer('total_guests'); // Number of guests for catering
            $table->decimal('total_catering_cost', 10, 2); // Total cost for catering
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_catering');
    }
}
