<?php

// ============================================
// SEEDER: Admin User Seeder
// ============================================
// Purpose: Creates default admin and student users
// Useful for testing and development
// ============================================

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * This method creates two default users:
     * 1. Admin user - has full access
     * 2. Student user - has limited access
     * 
     * Usage: php artisan db:seed --class=AdminUserSeeder
     */
    public function run(): void
    {
        // ============================================
        // CREATE ADMIN USER
        // ============================================
        // Admin has full access to all features
        // Can manage students, view trash, etc.
        // ============================================
        User::create([
            'name' => 'Admin User',              // Display name
            'email' => 'admin@example.com',      // Login email
            'password' => Hash::make('password'), // Password (hashed)
            'role' => 'admin',                   // Role: admin
        ]);

        // ============================================
        // CREATE STUDENT USER
        // ============================================
        // Student has limited access
        // Can view students but not manage them (if restricted)
        // ============================================
        User::create([
            'name' => 'Student User',            // Display name
            'email' => 'student@example.com',    // Login email
            'password' => Hash::make('password'), // Password (hashed)
            'role' => 'student',                 // Role: student
        ]);

        // ============================================
        // TEST CREDENTIALS
        // ============================================
        // Admin: admin@example.com / password
        // Student: student@example.com / password
        // ============================================
    }
}