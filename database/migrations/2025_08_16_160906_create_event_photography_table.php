<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventPhotographyTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('event_photography', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events'); // Link to the main event
            $table->boolean('photography_required')->default(false); // Whether photography is selected
            $table->integer('photographers_count'); // Number of photographers
            $table->enum('shoot_type', ['basic', 'premium', 'luxury']); // Type of shoot
            $table->decimal('photography_cost', 10, 2); // Cost of photography service
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_photography');
    }
}
