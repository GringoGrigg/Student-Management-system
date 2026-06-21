<?php

// ============================================
// CONTROLLER: StudentController
// ============================================
// Purpose: Handles all student-related operations
// Includes CRUD, search, filter, pagination, soft delete
// Role-based access control:
// - Admin: Full access to all students
// - Student: Only their own profile (view and edit)
// IMAGE UPLOAD WITH RESIZE - Makes images visible and optimized
// ============================================

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver; // 👈 ADDED: For image resizing

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
        $user = Auth::user();

        // Students cannot view the student list
        if ($user->isStudent()) {
            if ($user->student) {
                return redirect()->route('students.show', $user->student->id)
                    ->with('info', 'You can only view your own profile.');
            }
            Auth::logout();
            return redirect()->route('login')
                ->with('error', 'No student profile found. Please contact admin.');
        }

        // ============================================
        // ADMIN ACCESS: Full student list
        // ============================================
        $query = Student::query();
        
        // SEARCH FUNCTIONALITY
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'LIKE', "%{$search}%")
                  ->orWhere('last_name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }
        
        // COURSE FILTER
        if ($request->filled('course')) {
            $query->where('course', $request->course);
        }
        
        // STATUS FILTER
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // ORDERING & PAGINATION (10 per page)
        $students = $query->latest()->paginate(10);
        $courses = Student::distinct()->pluck('course');
        
        return view('students.index', compact('students', 'courses'));
    }

    /**
     * Show the form for creating a new student.
     * ADMIN ONLY
     * 
     * URL: GET /students/create
     */
    public function create()
    {
        if (Auth::user()->isStudent()) {
            return redirect()->route('dashboard')
                ->with('error', 'Students cannot create new student records.');
        }
        return view('students.create');
    }

    /**
     * Store a newly created student with image resize.
     * ADMIN ONLY
     * 
     * URL: POST /students
     * 
     * NOTE: Images are automatically resized to 400x400px
     * This ensures they display properly in profile views
     */
    public function store(Request $request)
    {
        // ============================================
        // ROLE-BASED ACCESS CONTROL
        // ============================================
        if (Auth::user()->isStudent()) {
            return redirect()->route('dashboard')
                ->with('error', 'Students cannot create new student records.');
        }

        // ============================================
        // VALIDATION
        // ============================================
        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|unique:students,email',
            'phone' => 'nullable|string|max:20',
            'gender' => 'required|in:Male,Female,Other',
            'date_of_birth' => 'required|date',
            'course' => 'required|string|max:150',
            'status' => 'required|in:Active,Inactive,Graduated',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // 👈 Increased to 5MB
        ]);

        $data = $request->all();

        // ============================================
        // IMAGE UPLOAD WITH RESIZE
        // ============================================
        // This resizes images to 400x400px (square)
        // Perfect for profile photos and thumbnails
        // Improves loading speed and display quality
        // ============================================
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9.]/', '_', $file->getClientOriginalName());
            
            try {
                // Create image manager with GD driver
                $manager = new ImageManager(new Driver());
                
                // Read the uploaded image
                $image = $manager->read($file->getPathname());
                
                // ============================================
                // RESIZE TO 400x400 (Square Crop)
                // ============================================
                // cover() crops the image to exactly 400x400
                // Centers the image and maintains aspect ratio
                // Perfect for profile photos
                // ============================================
                $image->cover(400, 400);
                
                // Save the resized image with 85% quality
                $imagePath = storage_path('app/public/student_photos/' . $filename);
                $image->save($imagePath, 85, 'jpg');
                
                $data['photo'] = $filename;
                
            } catch (\Exception $e) {
                // ============================================
                // FALLBACK: Save original if resize fails
                // ============================================
                // This ensures the upload still works
                $file->storeAs('public/student_photos', $filename);
                $data['photo'] = $filename;
                \Log::error('Image resize failed: ' . $e->getMessage());
            }
        }

        // ===== CREATE STUDENT =====
        Student::create($data);

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
     */
    public function show(Student $student)
    {
        $user = Auth::user();
        
        if ($user->isStudent()) {
            if (!$user->student || $user->student->id !== $student->id) {
                return redirect()->route('dashboard')
                    ->with('error', 'You can only view your own profile.');
            }
        }

        return view('students.show', compact('student'));
    }

    /**
     * Show the form for editing a student.
     * 
     * ADMIN: Can edit any student
     * STUDENT: Can only edit their own profile
     * 
     * URL: GET /students/{id}/edit
     */
    public function edit(Student $student)
    {
        $user = Auth::user();
        
        if ($user->isStudent()) {
            if (!$user->student || $user->student->id !== $student->id) {
                return redirect()->route('dashboard')
                    ->with('error', 'You can only edit your own profile.');
            }
        }

        return view('students.edit', compact('student'));
    }

    /**
     * Update the specified student with image resize.
     * 
     * ADMIN: Can update any student
     * STUDENT: Can only update their own profile
     * 
     * URL: PUT/PATCH /students/{id}
     */
    public function update(Request $request, Student $student)
    {
        $user = Auth::user();
        
        if ($user->isStudent()) {
            if (!$user->student || $user->student->id !== $student->id) {
                return redirect()->route('dashboard')
                    ->with('error', 'You can only update your own profile.');
            }
        }

        // ============================================
        // VALIDATION
        // ============================================
        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|unique:students,email,' . $student->id,
            'phone' => 'nullable|string|max:20',
            'gender' => 'required|in:Male,Female,Other',
            'date_of_birth' => 'required|date',
            'course' => 'required|string|max:150',
            'status' => 'required|in:Active,Inactive,Graduated',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // 👈 Increased to 5MB
        ]);

        $data = $request->all();

        // ============================================
        // IMAGE UPDATE WITH RESIZE
        // ============================================
        if ($request->hasFile('photo')) {
            // ===== DELETE OLD PHOTO =====
            if ($student->photo) {
                $oldPath = 'public/student_photos/' . $student->photo;
                if (Storage::exists($oldPath)) {
                    Storage::delete($oldPath);
                }
            }
            
            // ===== UPLOAD AND RESIZE NEW PHOTO =====
            $file = $request->file('photo');
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9.]/', '_', $file->getClientOriginalName());
            
            try {
                // Create image manager with GD driver
                $manager = new ImageManager(new Driver());
                
                // Read the uploaded image
                $image = $manager->read($file->getPathname());
                
                // Resize to 400x400 (Square Crop)
                $image->cover(400, 400);
                
                // Save the resized image
                $imagePath = storage_path('app/public/student_photos/' . $filename);
                $image->save($imagePath, 85, 'jpg');
                
                $data['photo'] = $filename;
                
            } catch (\Exception $e) {
                // FALLBACK: Save original if resize fails
                $file->storeAs('public/student_photos', $filename);
                $data['photo'] = $filename;
                \Log::error('Image resize failed: ' . $e->getMessage());
            }
        }

        // ===== UPDATE STUDENT =====
        $student->update($data);

        // ============================================
        // ROLE-BASED REDIRECTION
        // ============================================
        if ($user->isStudent()) {
            return redirect()->route('students.show', $student->id)
                ->with('success', 'Your profile has been updated successfully!');
        }

        return redirect()->route('students.index')
            ->with('success', 'Student updated successfully!');
    }

    /**
     * Remove the specified student (Soft Delete).
     * Also deletes the student's photo file.
     * ADMIN ONLY
     * 
     * URL: DELETE /students/{id}
     */
    public function destroy(Student $student)
    {
        if (Auth::user()->isStudent()) {
            return redirect()->route('dashboard')
                ->with('error', 'Students cannot delete student records.');
        }

        // Delete photo
        if ($student->photo) {
            $path = 'public/student_photos/' . $student->photo;
            if (Storage::exists($path)) {
                Storage::delete($path);
            }
        }

        $student->delete();

        return redirect()->route('students.index')
            ->with('success', 'Student deleted successfully!');
    }

    /**
     * Delete the student's photo only (keep the student record).
     * 
     * ADMIN: Can delete any student's photo
     * STUDENT: Can delete their own photo
     * 
     * URL: DELETE /students/{student}/photo
     */
    public function deletePhoto(Student $student)
    {
        $user = Auth::user();
        
        if ($user->isStudent()) {
            if (!$user->student || $user->student->id !== $student->id) {
                return redirect()->back()
                    ->with('error', 'You cannot delete this photo.');
            }
        }

        if ($student->photo) {
            $path = 'public/student_photos/' . $student->photo;
            if (Storage::exists($path)) {
                Storage::delete($path);
            }
            $student->update(['photo' => null]);
            
            return redirect()->back()
                ->with('success', 'Photo deleted successfully!');
        }

        return redirect()->back()
            ->with('error', 'No photo to delete.');
    }

    // ============================================
    // BONUS: SOFT DELETE RESTORE FEATURES
    // ============================================
    // These are admin-only features
    // ============================================
    
    /**
     * Display all soft-deleted (trashed) students.
     * ADMIN ONLY
     * 
     * URL: GET /students/trashed
     */
    public function trashed()
    {
        if (Auth::user()->isStudent()) {
            return redirect()->route('dashboard')
                ->with('error', 'Students cannot access trash.');
        }

        $students = Student::onlyTrashed()->paginate(10);
        return view('students.trashed', compact('students'));
    }

    /**
     * Restore a soft-deleted student.
     * ADMIN ONLY
     * 
     * URL: PATCH /students/{id}/restore
     */
    public function restore($id)
    {
        if (Auth::user()->isStudent()) {
            return redirect()->route('dashboard')
                ->with('error', 'Students cannot restore student records.');
        }

        $student = Student::onlyTrashed()->findOrFail($id);
        $student->restore();
        
        return redirect()->route('students.index')
            ->with('success', 'Student restored successfully!');
    }

    /**
     * Permanently delete a student (Force Delete).
     * Also deletes the student's photo file.
     * ADMIN ONLY
     * 
     * URL: DELETE /students/{id}/force-delete
     */
    public function forceDelete($id)
    {
        if (Auth::user()->isStudent()) {
            return redirect()->route('dashboard')
                ->with('error', 'Students cannot permanently delete student records.');
        }

        $student = Student::onlyTrashed()->findOrFail($id);
        
        if ($student->photo) {
            $path = 'public/student_photos/' . $student->photo;
            if (Storage::exists($path)) {
                Storage::delete($path);
            }
        }
        
        $student->forceDelete();
        
        return redirect()->route('students.trashed')
            ->with('success', 'Student permanently deleted!');
    }
}