<?php

// ============================================
// CONTROLLER: StudentController
// ============================================
// Purpose: Handles all student-related operations
// Includes CRUD, search, filter, pagination, soft delete
// Now with role-based access control:
// - Admin: Full access to all students
// - Student: Only their own profile (view and edit)
// ============================================

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // 👈 ADDED: For role checking
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    /**
     * Display a listing of students with search, filter, and pagination.
     * 
     * ADMIN: Shows all students with search/filter/pagination
     * STUDENT: Redirects to their own profile
     * 
     * URL: GET /students
     * Access: Requires authentication
     */
    public function index(Request $request)
    {
        // ============================================
        // ROLE-BASED ACCESS CONTROL
        // ============================================
        // Get the currently authenticated user
        // ============================================
        $user = Auth::user();

        // ============================================
        // CHECK: If user is a student
        // ============================================
        // Students cannot view the student list
        // They can only see their own profile
        // ============================================
        if ($user->isStudent()) {
            // Check if student has a linked student record
            if ($user->student) {
                // Redirect student to their own profile
                return redirect()->route('students.show', $user->student->id)
                    ->with('info', 'You can only view your own profile.');
            } else {
                // No student profile found - logout and redirect to login
                Auth::logout();
                return redirect()->route('login')
                    ->with('error', 'No student profile found. Please contact admin.');
            }
        }

        // ============================================
        // ADMIN ACCESS: Full student list
        // ============================================
        // Only admins can view all students
        // ============================================

        // Start building the database query
        $query = Student::query();
        
        // ===== SEARCH FUNCTIONALITY =====
        // Check if user entered a search term
        if ($request->filled('search')) {
            $search = $request->search;
            
            // Search in first_name, last_name, and email fields
            // Using 'LIKE' with % wildcards for partial matching
            // Using a closure with 'orWhere' to search multiple columns
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'LIKE', "%{$search}%")
                  ->orWhere('last_name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }
        
        // ===== COURSE FILTER =====
        // Check if user selected a specific course
        if ($request->filled('course')) {
            // Filter students by the selected course
            $query->where('course', $request->course);
        }
        
        // ===== STATUS FILTER =====
        // Check if user selected a specific status
        if ($request->filled('status')) {
            // Filter students by the selected status
            $query->where('status', $request->status);
        }
        
        // ===== ORDERING & PAGINATION =====
        // 'latest()' orders by created_at descending (newest first)
        // 'paginate(10)' shows 10 students per page with pagination links
        $students = $query->latest()->paginate(10);
        
        // ===== GET DISTINCT COURSES FOR FILTER DROPDOWN =====
        // 'distinct()' gets unique values
        // 'pluck('course')' extracts just the course column
        // This automatically populates the course filter dropdown
        $courses = Student::distinct()->pluck('course');
        
        // Return the view with both students and courses data
        // 'compact()' creates an array: ['students' => $students, 'courses' => $courses]
        return view('students.index', compact('students', 'courses'));
    }

    /**
     * Show the form for creating a new student.
     * 
     * ADMIN ONLY: Students cannot create new student records
     * 
     * URL: GET /students/create
     * Access: Requires authentication (admin only)
     */
    public function create()
    {
        // ============================================
        // ROLE-BASED ACCESS CONTROL
        // ============================================
        // Only admins can create new students
        // ============================================
        $user = Auth::user();
        
        if ($user->isStudent()) {
            return redirect()->route('dashboard')
                ->with('error', 'Students cannot create new student records.');
        }

        // Admin can access the create form
        return view('students.create');
    }

    /**
     * Store a newly created student in the database.
     * 
     * ADMIN ONLY: Students cannot create new student records
     * 
     * URL: POST /students
     * Access: Requires authentication (admin only)
     */
    public function store(Request $request)
    {
        // ============================================
        // ROLE-BASED ACCESS CONTROL
        // ============================================
        // Only admins can store new students
        // ============================================
        $user = Auth::user();
        
        if ($user->isStudent()) {
            return redirect()->route('dashboard')
                ->with('error', 'Students cannot create new student records.');
        }

        // ============================================
        // VALIDATION RULES
        // ============================================
        // 'required' - field must be present
        // 'string' - must be text
        // 'max:100' - maximum 100 characters
        // 'email' - must be valid email format
        // 'unique:students,email' - email must not exist in students table
        // 'nullable' - field is optional
        // 'in:Male,Female,Other' - must be one of these values
        // 'image' - uploaded file must be an image
        // 'mimes:jpeg,png,jpg,gif' - allowed image formats
        // 'max:2048' - maximum file size 2MB (in kilobytes)
        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|unique:students,email',
            'phone' => 'nullable|string|max:20',
            'gender' => 'required|in:Male,Female,Other',
            'date_of_birth' => 'required|date',
            'course' => 'required|string|max:150',
            'status' => 'required|in:Active,Inactive,Graduated',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Get all validated data
        $data = $request->all();

        // ===== IMAGE UPLOAD HANDLING =====
        // Check if user uploaded a file
        if ($request->hasFile('photo')) {
            // Get the uploaded file
            $file = $request->file('photo');
            
            // Create unique filename using timestamp + original name
            // Example: 1234567890_profile.jpg
            $filename = time() . '_' . $file->getClientOriginalName();
            
            // Store the file in storage/app/public/student_photos directory
            // 'public' disk means files will be accessible from the web
            $file->storeAs('public/student_photos', $filename);
            
            // Add the filename to the data array for database storage
            $data['photo'] = $filename;
        }

        // ===== CREATE STUDENT =====
        // 'Student::create()' inserts a new record into the database
        // Only fields in $fillable are allowed (mass assignment protection)
        Student::create($data);

        // ===== REDIRECT WITH SUCCESS MESSAGE =====
        // Redirect to the student list page
        // '->with()' stores a flash message in the session (only available for one request)
        return redirect()->route('students.index')
            ->with('success', 'Student created successfully!');
    }

    /**
     * Display the specified student's details.
     * 
     * ADMIN: Can view any student
     * STUDENT: Can only view their own profile
     * 
     * URL: GET /students/{id}
     * Access: Requires authentication
     */
    public function show(Student $student)
    {
        // ============================================
        // ROLE-BASED ACCESS CONTROL
        // ============================================
        // Get the current user
        // ============================================
        $user = Auth::user();

        // ============================================
        // CHECK: If user is a student
        // ============================================
        // Students can only view their own profile
        // Check if the student being viewed belongs to the current user
        // ============================================
        if ($user->isStudent()) {
            // Check if the student record belongs to this user
            if ($user->student && $user->student->id === $student->id) {
                // Student is viewing their own profile - allowed
                return view('students.show', compact('student'));
            } else {
                // Student is trying to view another student's profile - denied
                return redirect()->route('dashboard')
                    ->with('error', 'You can only view your own profile.');
            }
        }

        // ============================================
        // ADMIN ACCESS: Can view any student
        // ============================================
        return view('students.show', compact('student'));
    }

    /**
     * Show the form for editing a student.
     * 
     * ADMIN: Can edit any student
     * STUDENT: Can only edit their own profile
     * 
     * URL: GET /students/{id}/edit
     * Access: Requires authentication
     */
    public function edit(Student $student)
    {
        // ============================================
        // ROLE-BASED ACCESS CONTROL
        // ============================================
        // Get the current user
        // ============================================
        $user = Auth::user();

        // ============================================
        // CHECK: If user is a student
        // ============================================
        // Students can only edit their own profile
        // ============================================
        if ($user->isStudent()) {
            // Check if the student record belongs to this user
            if (!$user->student || $user->student->id !== $student->id) {
                // Student is trying to edit another student's profile - denied
                return redirect()->route('dashboard')
                    ->with('error', 'You can only edit your own profile.');
            }
            // Student can edit their own profile
            return view('students.edit', compact('student'));
        }

        // ============================================
        // ADMIN ACCESS: Can edit any student
        // ============================================
        return view('students.edit', compact('student'));
    }

    /**
     * Update the specified student in the database.
     * 
     * ADMIN: Can update any student
     * STUDENT: Can only update their own profile
     * 
     * URL: PUT/PATCH /students/{id}
     * Access: Requires authentication
     */
    public function update(Request $request, Student $student)
    {
        // ============================================
        // ROLE-BASED ACCESS CONTROL
        // ============================================
        // Get the current user
        // ============================================
        $user = Auth::user();

        // ============================================
        // CHECK: If user is a student
        // ============================================
        // Students can only update their own profile
        // ============================================
        if ($user->isStudent()) {
            // Check if the student record belongs to this user
            if (!$user->student || $user->student->id !== $student->id) {
                // Student is trying to update another student's profile - denied
                return redirect()->route('dashboard')
                    ->with('error', 'You can only update your own profile.');
            }
        }

        // ============================================
        // VALIDATION RULES
        // ============================================
        // Special email rule: 'unique:students,email,' . $student->id
        // This means: "email must be unique, but ignore this student's own email"
        // This allows students to keep their existing email
        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|unique:students,email,' . $student->id,
            'phone' => 'nullable|string|max:20',
            'gender' => 'required|in:Male,Female,Other',
            'date_of_birth' => 'required|date',
            'course' => 'required|string|max:150',
            'status' => 'required|in:Active,Inactive,Graduated',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Get validated data
        $data = $request->all();

        // ===== IMAGE UPDATE HANDLING =====
        // Check if user uploaded a new photo
        if ($request->hasFile('photo')) {
            // ===== DELETE OLD PHOTO =====
            // Check if student has an existing photo
            if ($student->photo) {
                // Build the full path to the old photo
                $oldPhotoPath = storage_path('app/public/student_photos/' . $student->photo);
                
                // Check if the file exists and delete it
                // This prevents unused files from filling up storage
                if (file_exists($oldPhotoPath)) {
                    unlink($oldPhotoPath); // PHP function to delete file
                }
            }
            
            // ===== UPLOAD NEW PHOTO =====
            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/student_photos', $filename);
            $data['photo'] = $filename;
        }

        // ===== UPDATE STUDENT =====
        // 'update()' executes: UPDATE students SET ... WHERE id = ?
        // Only updates fields in $fillable
        $student->update($data);

        // ============================================
        // ROLE-BASED REDIRECTION
        // ============================================
        // Redirect based on user role
        // ============================================
        if ($user->isStudent()) {
            // Student: Redirect back to their own profile with success message
            return redirect()->route('students.show', $student->id)
                ->with('success', 'Your profile has been updated successfully!');
        }

        // Admin: Redirect to student list with success message
        return redirect()->route('students.index')
            ->with('success', 'Student updated successfully!');
    }

    /**
     * Remove the specified student from the database (Soft Delete).
     * 
     * ADMIN ONLY: Students cannot delete student records
     * 
     * URL: DELETE /students/{id}
     * Access: Requires authentication (admin only)
     */
    public function destroy(Student $student)
    {
        // ============================================
        // ROLE-BASED ACCESS CONTROL
        // ============================================
        // Only admins can delete students
        // ============================================
        $user = Auth::user();
        
        if ($user->isStudent()) {
            return redirect()->route('dashboard')
                ->with('error', 'Students cannot delete student records.');
        }

        // ===== SOFT DELETE =====
        // 'delete()' with SoftDeletes trait will set 'deleted_at' timestamp
        // The record is NOT permanently removed from the database
        // It can be restored later using 'restore()'
        $student->delete();

        return redirect()->route('students.index')
            ->with('success', 'Student deleted successfully!');
    }

    // ============================================
    // BONUS: SOFT DELETE RESTORE FEATURES
    // ============================================
    // These are admin-only features
    // ============================================
    
    /**
     * Display all soft-deleted (trashed) students.
     * 
     * ADMIN ONLY: Students cannot access trash
     * 
     * URL: GET /students/trashed
     * Access: Requires authentication (admin only)
     */
    public function trashed()
    {
        // ============================================
        // ROLE-BASED ACCESS CONTROL
        // ============================================
        // Only admins can view trashed students
        // ============================================
        $user = Auth::user();
        
        if ($user->isStudent()) {
            return redirect()->route('dashboard')
                ->with('error', 'Students cannot access trash.');
        }

        // ===== ONLY TRASHED STUDENTS =====
        // 'onlyTrashed()' retrieves only records where 'deleted_at' is NOT NULL
        // These are students that have been soft-deleted
        $students = Student::onlyTrashed()->paginate(10);
        
        // Return the trashed view with the deleted students
        return view('students.trashed', compact('students'));
    }

    /**
     * Restore a soft-deleted student.
     * 
     * ADMIN ONLY: Students cannot restore students
     * 
     * URL: PATCH /students/{id}/restore
     * Access: Requires authentication (admin only)
     */
    public function restore($id)
    {
        // ============================================
        // ROLE-BASED ACCESS CONTROL
        // ============================================
        // Only admins can restore students
        // ============================================
        $user = Auth::user();
        
        if ($user->isStudent()) {
            return redirect()->route('dashboard')
                ->with('error', 'Students cannot restore student records.');
        }

        // ===== FIND AND RESTORE =====
        // 'onlyTrashed()' finds the record even though it's soft-deleted
        // 'findOrFail()' throws 404 if student not found
        $student = Student::onlyTrashed()->findOrFail($id);
        
        // 'restore()' sets 'deleted_at' back to NULL
        // The student becomes visible again in normal queries
        $student->restore();
        
        // Redirect to student list with success message
        return redirect()->route('students.index')
            ->with('success', 'Student restored successfully!');
    }

    /**
     * Permanently delete a student (Force Delete).
     * 
     * ADMIN ONLY: Students cannot permanently delete students
     * 
     * URL: DELETE /students/{id}/force-delete
     * Access: Requires authentication (admin only)
     */
    public function forceDelete($id)
    {
        // ============================================
        // ROLE-BASED ACCESS CONTROL
        // ============================================
        // Only admins can force delete students
        // ============================================
        $user = Auth::user();
        
        if ($user->isStudent()) {
            return redirect()->route('dashboard')
                ->with('error', 'Students cannot permanently delete student records.');
        }

        // Find the trashed student
        $student = Student::onlyTrashed()->findOrFail($id);
        
        // ===== DELETE PHOTO =====
        // Delete the student's photo from storage if it exists
        if ($student->photo) {
            $photoPath = storage_path('app/public/student_photos/' . $student->photo);
            if (file_exists($photoPath)) {
                unlink($photoPath);
            }
        }
        
        // 'forceDelete()' permanently removes the record from the database
        // This cannot be undone!
        $student->forceDelete();
        
        return redirect()->route('students.trashed')
            ->with('success', 'Student permanently deleted!');
    }
}