<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('catering_selections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_catering_id')->constrained('event_catering')->onDelete('cascade');
            $table->string('set_menu');
            $table->json('extra_items')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('catering_selections');
    }
};
