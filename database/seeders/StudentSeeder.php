<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        // Sample students with realistic data
        $students = [
            [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'john.doe@example.com',
                'phone' => '0712345678',
                'gender' => 'Male',
                'date_of_birth' => '2000-01-15',
                'course' => 'Computer Science',
                'status' => 'Active',
            ],
            [
                'first_name' => 'Jane',
                'last_name' => 'Smith',
                'email' => 'jane.smith@example.com',
                'phone' => '0723456789',
                'gender' => 'Female',
                'date_of_birth' => '2001-03-20',
                'course' => 'Software Engineering',
                'status' => 'Active',
            ],
            [
                'first_name' => 'Michael',
                'last_name' => 'Johnson',
                'email' => 'michael.j@example.com',
                'phone' => '0734567890',
                'gender' => 'Male',
                'date_of_birth' => '1999-07-10',
                'course' => 'Data Science',
                'status' => 'Graduated',
            ],
            [
                'first_name' => 'Emily',
                'last_name' => 'Williams',
                'email' => 'emily.w@example.com',
                'phone' => '0745678901',
                'gender' => 'Female',
                'date_of_birth' => '2002-11-05',
                'course' => 'Computer Science',
                'status' => 'Active',
            ],
            [
                'first_name' => 'David',
                'last_name' => 'Brown',
                'email' => 'david.b@example.com',
                'phone' => '0756789012',
                'gender' => 'Male',
                'date_of_birth' => '2000-05-25',
                'course' => 'Information Technology',
                'status' => 'Inactive',
            ],
            [
                'first_name' => 'Sarah',
                'last_name' => 'Davis',
                'email' => 'sarah.d@example.com',
                'phone' => '0767890123',
                'gender' => 'Female',
                'date_of_birth' => '2001-09-12',
                'course' => 'Cybersecurity',
                'status' => 'Active',
            ],
            [
                'first_name' => 'James',
                'last_name' => 'Miller',
                'email' => 'james.m@example.com',
                'phone' => '0778901234',
                'gender' => 'Male',
                'date_of_birth' => '1998-12-08',
                'course' => 'Software Engineering',
                'status' => 'Graduated',
            ],
            [
                'first_name' => 'Lisa',
                'last_name' => 'Taylor',
                'email' => 'lisa.t@example.com',
                'phone' => '0789012345',
                'gender' => 'Female',
                'date_of_birth' => '2002-04-18',
                'course' => 'Computer Science',
                'status' => 'Active',
            ],
            [
                'first_name' => 'Robert',
                'last_name' => 'Anderson',
                'email' => 'robert.a@example.com',
                'phone' => '0790123456',
                'gender' => 'Male',
                'date_of_birth' => '2000-08-30',
                'course' => 'Data Science',
                'status' => 'Active',
            ],
            [
                'first_name' => 'Maria',
                'last_name' => 'Martinez',
                'email' => 'maria.m@example.com',
                'phone' => '0701234567',
                'gender' => 'Female',
                'date_of_birth' => '2001-06-14',
                'course' => 'Artificial Intelligence',
                'status' => 'Inactive',
            ],
            [
                'first_name' => 'Alex',
                'last_name' => 'Chen',
                'email' => 'alex.chen@example.com',
                'phone' => '0712345690',
                'gender' => 'Male',
                'date_of_birth' => '1999-11-22',
                'course' => 'Computer Science',
                'status' => 'Active',
            ],
            [
                'first_name' => 'Amanda',
                'last_name' => 'Garcia',
                'email' => 'amanda.g@example.com',
                'phone' => '0723456801',
                'gender' => 'Female',
                'date_of_birth' => '2000-07-19',
                'course' => 'Software Engineering',
                'status' => 'Active',
            ],
            [
                'first_name' => 'Chris',
                'last_name' => 'Wilson',
                'email' => 'chris.w@example.com',
                'phone' => '0734567912',
                'gender' => 'Male',
                'date_of_birth' => '2001-12-03',
                'course' => 'Cybersecurity',
                'status' => 'Graduated',
            ],
            [
                'first_name' => 'Jessica',
                'last_name' => 'Lee',
                'email' => 'jessica.lee@example.com',
                'phone' => '0745678023',
                'gender' => 'Female',
                'date_of_birth' => '2002-05-28',
                'course' => 'Data Science',
                'status' => 'Active',
            ],
            [
                'first_name' => 'Daniel',
                'last_name' => 'Kim',
                'email' => 'daniel.kim@example.com',
                'phone' => '0756789134',
                'gender' => 'Male',
                'date_of_birth' => '2000-09-17',
                'course' => 'Information Technology',
                'status' => 'Inactive',
            ],
        ];

        // Create each student
        foreach ($students as $student) {
            Student::create($student);
        }

        // Add more random students for pagination testing
        $firstNames = ['Emma', 'Oliver', 'Sophia', 'Liam', 'Mia', 'Noah', 'Charlotte', 'James', 'Amelia', 'Ethan', 'Harper', 'Logan', 'Ella', 'Jackson', 'Aria', 'Aiden', 'Scarlett', 'Carter', 'Luna', 'Grayson'];
        $lastNames = ['Park', 'Chang', 'Wang', 'Li', 'Singh', 'Patel', 'Shah', 'Nguyen', 'Tran', 'Khan', 'Ali', 'Hassan', 'Kim', 'Park', 'Zhang', 'Liu', 'Chen', 'Yang', 'Wu', 'Choi'];
        $courses = ['Computer Science', 'Software Engineering', 'Data Science', 'Cybersecurity', 'Information Technology', 'Artificial Intelligence', 'Cloud Computing', 'Web Development', 'Mobile Development', 'Game Development'];
        $statuses = ['Active', 'Inactive', 'Graduated'];
        $genders = ['Male', 'Female', 'Other'];

        // Generate 20 additional random students
        for ($i = 0; $i < 20; $i++) {
            $firstName = $firstNames[array_rand($firstNames)];
            $lastName = $lastNames[array_rand($lastNames)];
            Student::create([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => strtolower($firstName . '.' . $lastName . $i . '@example.com'),
                'phone' => '07' . rand(10000000, 99999999),
                'gender' => $genders[array_rand($genders)],
                'date_of_birth' => now()->subYears(rand(18, 30))->subDays(rand(0, 365))->format('Y-m-d'),
                'course' => $courses[array_rand($courses)],
                'status' => $statuses[array_rand($statuses)],
            ]);
        }
    }
}