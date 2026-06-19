<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;

class LinkStudentUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * This links existing students to user accounts
     * Ensures proper role-based access control
     */
    public function run(): void
    {
        // ============================================
        // LINK ADMIN USER TO FIRST STUDENT
        // ============================================
        $admin = User::where('email', 'admin@example.com')->first();
        if ($admin) {
            // Get first student
            $student = Student::first();
            if ($student) {
                $student->user_id = $admin->id;
                $student->save();
                $this->command->info("Linked student '{$student->full_name}' to admin user '{$admin->name}'");
            } else {
                $this->command->warn('No students found to link to admin.');
            }
        }

        // ============================================
        // LINK STUDENT USER TO SECOND STUDENT
        // ============================================
        $studentUser = User::where('email', 'student@example.com')->first();
        if ($studentUser) {
            // Get second student
            $student = Student::skip(1)->first();
            if ($student) {
                $student->user_id = $studentUser->id;
                $student->save();
                $this->command->info("Linked student '{$student->full_name}' to student user '{$studentUser->name}'");
            } else {
                $this->command->warn('No second student found to link to student user.');
            }
        }
    }
}