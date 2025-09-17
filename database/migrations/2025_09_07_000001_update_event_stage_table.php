<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::table('event_stage', function (Blueprint $table) {
            $table->dropColumn('decoration_type');
            $table->string('decoration_image_link')->nullable();
        });
    }
    public function down() {
        Schema::table('event_stage', function (Blueprint $table) {
            $table->string('decoration_type')->nullable();
            $table->dropColumn('decoration_image_link');
        });
    }
};
