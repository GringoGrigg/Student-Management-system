<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // For handling file storage operations

class StudentController extends Controller
{
    /**
     * Display a listing of students with search, filter, and pagination
     */
    public function index(Request $request) // Added $request parameter for search/filter
    {
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
     * Show the form for creating a new student
     */
    public function create()
    {
        // Simply return the create view with the form
        // No database interaction needed here
        return view('students.create');
    }

    /**
     * Store a newly created student in the database with image upload
     */
    public function store(Request $request)
    {
        // ===== VALIDATION RULES =====
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
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // New photo validation
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
     * Display the specified student's details
     */
    public function show(Student $student)
    {
        // ===== ROUTE MODEL BINDING =====
        // Laravel automatically finds the student by {student} ID from the URL
        // If not found, it returns a 404 error automatically
        // Pass the student to the show view
        return view('students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified student
     */
    public function edit(Student $student)
    {
        // Same as show() - uses Route Model Binding
        // Returns the edit form with existing student data pre-filled
        return view('students.edit', compact('student'));
    }

    /**
     * Update the specified student in the database with image upload
     */
    public function update(Request $request, Student $student)
    {
        // ===== VALIDATION RULES =====
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

        // Redirect back to list with success message
        return redirect()->route('students.index')
            ->with('success', 'Student updated successfully!');
    }

    /**
     * Remove the specified student from the database (Soft Delete)
     */
    public function destroy(Student $student)
    {
        // ===== SOFT DELETE =====
        // 'delete()' with SoftDeletes trait will set 'deleted_at' timestamp
        // The record is NOT permanently removed from the database
        // It can be restored later using 'restore()'
        $student->delete();

        return redirect()->route('students.index')
            ->with('success', 'Student deleted successfully!');
    }

    // ===== BONUS: SOFT DELETE RESTORE FEATURE =====
    
    /**
     * Display all soft-deleted (trashed) students
     */
    public function trashed()
    {
        // ===== ONLY TRASHED STUDENTS =====
        // 'onlyTrashed()' retrieves only records where 'deleted_at' is NOT NULL
        // These are students that have been soft-deleted
        $students = Student::onlyTrashed()->paginate(10);
        
        // Return the trashed view with the deleted students
        return view('students.trashed', compact('students'));
    }

    /**
     * Restore a soft-deleted student
     */
    public function restore($id)
    {
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
     * Permanently delete a student (Force Delete)
     * Note: This is optional and not included in the basic flow
     */
    public function forceDelete($id)
    {
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