<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventStageTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('event_stage', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events'); // Link to the main event
            $table->enum('stage_type', ['basic', 'premium', 'luxury']); // Stage options
            $table->text('stage_image_link')->nullable(); // URL for the selected stage image
            $table->boolean('surrounding_decoration')->default(false); // Whether the user wants surrounding decoration
            $table->enum('decoration_type', ['basic', 'premium', 'luxury'])->nullable(); // Type of surrounding decoration
            $table->decimal('decoration_cost_per_sqm', 10, 2)->nullable(); // Cost per square meter for decoration
            $table->decimal('total_decoration_cost', 10, 2)->nullable(); // Total decoration cost
            $table->decimal('stage_cost', 10, 2); // Cost of stage setup
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_stage');
    }
}
