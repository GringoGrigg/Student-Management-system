<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // ============================================
        // STUDENT ACCESS - Redirect to their profile
        // ============================================
        if ($user->isStudent()) {
            if ($user->student) {
                // Redirect to their own profile with a welcome message
                return redirect()->route('students.show', $user->student->id)
                    ->with('info', 'Welcome to your profile!');
            } else {
                // No student profile found
                Auth::logout();
                return redirect()->route('login')
                    ->with('error', 'No student profile found. Please contact admin.');
            }
        }

        // ============================================
        // ADMIN ACCESS - Full Dashboard
        // ============================================
        $totalStudents = Student::count();
        $activeStudents = Student::where('status', 'Active')->count();
        $inactiveStudents = Student::where('status', 'Inactive')->count();
        $graduatedStudents = Student::where('status', 'Graduated')->count();
        $totalCourses = Student::distinct('course')->count('course');
        $latestStudents = Student::latest()->take(5)->get();
        $isAdmin = $user->isAdmin();
        
        return view('dashboard', compact(
            'totalStudents',
            'activeStudents',
            'inactiveStudents',
            'graduatedStudents',
            'totalCourses',
            'latestStudents',
            'isAdmin'
        ));
    }
}