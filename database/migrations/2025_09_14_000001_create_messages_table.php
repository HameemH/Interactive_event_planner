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
        Schema::create('user_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // 6 Message spaces for 6 event planning parts
            $table->text('venue_message')->nullable();
            $table->text('seating_message')->nullable();
            $table->text('stage_message')->nullable();
            $table->text('catering_message')->nullable();
            $table->text('photography_message')->nullable();
            $table->text('extra_options_message')->nullable();
            
            $table->timestamps();
            $table->unique('user_id'); // One row per user
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_messages');
    }
};