<?php

// ============================================
// MIGRATION: Add Role Column to Users Table
// ============================================
// Purpose: Add a 'role' column to the users table
// This allows us to differentiate between admin and student users
// ============================================

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * This method is called when running: php artisan migrate
     * It adds the 'role' column to the existing 'users' table
     */
    public function up(): void
    {
        // ============================================
        // TABLE: users
        // ============================================
        // We're modifying the existing 'users' table
        // The 'role' column will be added after the 'email' column
        // Default value is 'student' - new users are students by default
        // ============================================
        Schema::table('users', function (Blueprint $table) {
            // Add 'role' column with enum type
            // 'enum' restricts values to only 'admin' or 'student'
            // ->after('email') places it right after the email column for better readability
            // ->default('student') means new users are automatically assigned 'student' role
            // ->nullable(false) means this column cannot be empty (always has a value)
            $table->enum('role', ['admin', 'student'])
                  ->after('email')
                  ->default('student')
                  ->nullable(false);
                  
            // WHAT THIS DOES:
            // 1. Creates a column 'role' in the 'users' table
            // 2. Only allows two values: 'admin' or 'student'
            // 3. Sets default to 'student' for new users
            // 4. Makes sure the column is never empty
            // 5. Places it after the email column in the table structure
        });
    }

    /**
     * Reverse the migrations.
     * 
     * This method is called when running: php artisan migrate:rollback
     * It removes the 'role' column from the 'users' table
     */
    public function down(): void
    {
        // ============================================
        // ROLLBACK: Remove Role Column
        // ============================================
        // This is the cleanup method - it removes the column we added
        // This is why we can rollback migrations safely
        // ============================================
        Schema::table('users', function (Blueprint $table) {
            // Drop the 'role' column we added
            // This is the reverse of what we did in up()
            $table->dropColumn('role');
            
            // WHAT THIS DOES:
            // 1. Removes the 'role' column from the 'users' table
            // 2. Reverts the table back to its original structure
            // 3. Used when rolling back migrations
        });
    }
};