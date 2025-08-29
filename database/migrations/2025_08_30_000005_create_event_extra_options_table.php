<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('event_extra_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events');
            $table->boolean('photo_booth')->default(false);
            $table->boolean('coffee_booth')->default(false);
            $table->boolean('mehendi_booth')->default(false);
            $table->boolean('paan_booth')->default(false);
            $table->boolean('fuchka_stall')->default(false);
            $table->boolean('sketch_booth')->default(false);
            $table->decimal('extra_options_cost', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_extra_options');
    }
};
