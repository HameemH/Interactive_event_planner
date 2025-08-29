<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('event_photography', function (Blueprint $table) {
            $table->string('package_type')->nullable()->after('photography_required');
            $table->boolean('customizable')->default(false)->after('package_type');
            $table->integer('num_photographers')->nullable()->after('customizable');
            $table->integer('num_hours')->nullable()->after('num_photographers');
            $table->boolean('indoor')->default(true)->after('num_hours');
            $table->boolean('outdoor')->default(false)->after('indoor');
            $table->boolean('cinematography')->default(false)->after('outdoor');
            //  drop old columns as they are not needed:
            $table->dropColumn('photographers_count');
            $table->dropColumn('shoot_type');
        });
    }

    public function down(): void
    {
        Schema::table('event_photography', function (Blueprint $table) {
            $table->dropColumn(['package_type', 'customizable', 'num_photographers', 'num_hours', 'indoor', 'outdoor', 'cinematography']);
            $table->integer('photographers_count')->nullable();
            $table->enum('shoot_type', ['basic', 'premium', 'luxury'])->nullable();
        });
    }
};
