<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, update any existing 'organizer' roles to 'admin'
        DB::table('users')->where('role', 'organizer')->update(['role' => 'admin']);
        
        // Then modify the enum to replace 'organizer' with 'admin'
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'guest') DEFAULT 'guest'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to the original enum
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('organizer', 'guest') DEFAULT 'guest'");
        
        // Update any 'admin' roles back to 'organizer'
        DB::table('users')->where('role', 'admin')->update(['role' => 'organizer']);
    }
};