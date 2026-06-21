<?php

// ============================================
// CONTROLLER: DashboardController
// ============================================
// Purpose: Displays dashboard with statistics and charts
// ADMIN: Full dashboard with stats, pie chart, bar chart
// STUDENT: Redirects to their own profile
// ============================================

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use LaravelDaily\LaravelCharts\Classes\LaravelChart; // 👈 ADD THIS - For chart generation

class DashboardController extends Controller
{
    /**
     * Display the dashboard page with statistics and charts.
     * 
     * ADMIN: Shows:
     * - Statistics cards (Total, Active, Inactive, Graduated, Courses)
     * - Pie Chart: Student Status Distribution
     * - Bar Chart: Students by Course
     * - Latest 5 Students table
     * - Admin Panel with quick actions
     * 
     * STUDENT: Redirects to their own profile page
     * 
     * URL: GET /dashboard
     * Access: Requires authentication
     * 
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        // ============================================
        // GET CURRENT USER
        // ============================================
        // Retrieve the authenticated user
        // This gives us access to their role and data
        // ============================================
        $user = Auth::user();

        // ============================================
        // STUDENT ACCESS CONTROL
        // ============================================
        // Students should NOT see the dashboard
        // They should only see their own profile
        // ============================================
        if ($user->isStudent()) {
            // Check if the student has a linked student record
            if ($user->student) {
                // Redirect to their own profile page
                // This is the only page students should see
                return redirect()->route('students.show', $user->student->id)
                    ->with('info', 'Welcome to your profile! You can only view your own information.');
            } else {
                // Student has no linked student record
                // This shouldn't happen normally, but handle it gracefully
                Auth::logout();
                return redirect()->route('login')
                    ->with('error', 'No student profile found. Please contact the administrator.');
            }
        }

        // ============================================
        // ADMIN ACCESS: Full Dashboard
        // ============================================
        // Only admins can access the full dashboard
        // All statistics are calculated below
        // ============================================

        // ============================================
        // STATISTIC 1: Total Students
        // ============================================
        // Count all students in the system
        // Includes Active, Inactive, and Graduated
        // Soft-deleted students are excluded (deleted_at is null)
        // ============================================
        $totalStudents = Student::count();
        // SQL: SELECT COUNT(*) FROM students WHERE deleted_at IS NULL

        // ============================================
        // STATISTIC 2: Active Students
        // ============================================
        // Count students with status = 'Active'
        // These are currently enrolled/studying
        // ============================================
        $activeStudents = Student::where('status', 'Active')->count();
        // SQL: SELECT COUNT(*) FROM students WHERE status = 'Active' AND deleted_at IS NULL

        // ============================================
        // STATISTIC 3: Inactive Students
        // ============================================
        // Count students with status = 'Inactive'
        // These are currently not active in the system
        // ============================================
        $inactiveStudents = Student::where('status', 'Inactive')->count();
        // SQL: SELECT COUNT(*) FROM students WHERE status = 'Inactive' AND deleted_at IS NULL

        // ============================================
        // STATISTIC 4: Graduated Students
        // ============================================
        // Count students with status = 'Graduated'
        // These have completed their studies
        // ============================================
        $graduatedStudents = Student::where('status', 'Graduated')->count();
        // SQL: SELECT COUNT(*) FROM students WHERE status = 'Graduated' AND deleted_at IS NULL

        // ============================================
        // STATISTIC 5: Total Courses
        // ============================================
        // Count distinct/unique courses in the system
        // This tells us how many different courses are offered
        // ============================================
        $totalCourses = Student::distinct('course')->count('course');
        // SQL: SELECT COUNT(DISTINCT course) FROM students WHERE deleted_at IS NULL

        // ============================================
        // STATISTIC 6: Latest 5 Registered Students
        // ============================================
        // Get the 5 most recently added students
        // Ordered by created_at descending (newest first)
        // ============================================
        $latestStudents = Student::latest()->take(5)->get();
        // SQL: SELECT * FROM students WHERE deleted_at IS NULL ORDER BY created_at DESC LIMIT 5

        // ============================================
        // ADMIN FLAG FOR VIEW
        // ============================================
        // Pass this to the view so it can show/hide admin features
        // ============================================
        $isAdmin = $user->isAdmin();

        // ============================================
        // PIE CHART - Student Status Distribution
        // ============================================
        // This creates a pie chart showing the distribution of students
        // by their status (Active, Inactive, Graduated)
        // 
        // Chart Options:
        // - chart_title: Title displayed above the chart
        // - report_type: group_by_string - groups by text field
        // - model: The model to query
        // - group_by_field: The field to group by (status)
        // - chart_type: pie - creates a pie chart
        // - chart_color: RGB values for each slice (Active, Inactive, Graduated)
        // ============================================
        $pieChartOptions = [
            'chart_title' => 'Student Status Distribution',
            'report_type' => 'group_by_string',
            'model' => 'App\Models\Student',
            'group_by_field' => 'status',
            'chart_type' => 'pie',
            'chart_color' => '54, 162, 235, 44, 160, 44, 255, 159, 64', // Blue, Green, Orange
        ];
        $pieChart = new LaravelChart($pieChartOptions);

        // ============================================
        // BAR CHART - Students by Course
        // ============================================
        // This creates a bar chart showing the number of students
        // enrolled in each course
        // 
        // Chart Options:
        // - chart_title: Title displayed above the chart
        // - report_type: group_by_string - groups by text field
        // - model: The model to query
        // - group_by_field: The field to group by (course)
        // - chart_type: bar - creates a bar chart
        // - chart_color: RGB color for the bars (Blue)
        // - chart_height: Height of the chart
        // ============================================
        $barChartOptions = [
            'chart_title' => 'Students by Course',
            'report_type' => 'group_by_string',
            'model' => 'App\Models\Student',
            'group_by_field' => 'course',
            'chart_type' => 'bar',
            'chart_color' => '52, 152, 219', // Blue
            'chart_height' => '300px',
        ];
        $barChart = new LaravelChart($barChartOptions);

        // ============================================
        // RETURN VIEW WITH ALL DATA
        // ============================================
        // Pass all statistics and charts to the dashboard view
        // Each variable is accessible in the Blade template
        // ============================================
        return view('dashboard', compact(
            'totalStudents',        // Total number of students
            'activeStudents',       // Number of active students
            'inactiveStudents',     // Number of inactive students
            'graduatedStudents',    // Number of graduated students
            'totalCourses',         // Number of unique courses
            'latestStudents',       // 5 most recent students
            'isAdmin',              // Whether user is admin
            'pieChart',             // 👈 ADD THIS - Pie chart object
            'barChart'              // 👈 ADD THIS - Bar chart object
        ));
        
        // WHAT THIS DOES:
        // 1. Checks user role
        // 2. If student: redirects to profile
        // 3. If admin: calculates all statistics
        // 4. Creates pie chart for status distribution
        // 5. Creates bar chart for course distribution
        // 6. Passes data to dashboard view
        // 7. Admin sees full dashboard with charts and stats
        // 8. Student never sees dashboard (redirected)
    }
}