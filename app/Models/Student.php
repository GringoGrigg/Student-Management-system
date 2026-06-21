<?php

// ============================================
// MODEL: Student
// ============================================
// Purpose: Represents a student in the system
// Handles student data, relationships, and business logic
// Now linked to User model for role-based access
// Includes improved image handling with thumbnails and cleanup
// ============================================

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage; // For file operations

class Student extends Model
{
    // ===== TRAITS =====
    // HasFactory: Allows using factories for testing/database seeding
    // SoftDeletes: Adds soft delete capability (deleted_at column)
    use HasFactory, SoftDeletes;

    // ===== MASS ASSIGNMENT PROTECTION =====
    // These fields can be filled using create() or update() methods
    // Any field NOT in this array cannot be mass-assigned (security feature)
    protected $fillable = [
        'first_name',      // Student's first name
        'last_name',       // Student's last name
        'email',           // Unique email address
        'phone',           // Phone number (optional - nullable in database)
        'gender',          // Male, Female, or Other
        'date_of_birth',   // Date of birth
        'course',          // Course name
        'status',          // Active, Inactive, or Graduated
        'photo',           // Profile photo filename
        'user_id',         // Links student to User account for role-based access
    ];

    // ===== DATE CASTING =====
    // These fields should be treated as Carbon/DateTime objects
    // Allows using methods like ->format(), ->diffForHumans(), etc.
    protected $casts = [
        'date_of_birth' => 'date',      // Converts to Carbon date object
        'created_at' => 'datetime',     // Converts to Carbon datetime object
        'updated_at' => 'datetime',     // Converts to Carbon datetime object
        'deleted_at' => 'datetime',     // Converts to Carbon datetime object for soft delete
    ];

    // ============================================
    // RELATIONSHIPS
    // ============================================
    // These define how the Student model relates to other models
    // ============================================

    /**
     * Get the user that owns the student record.
     * 
     * Relationship: Student belongs to User (Inverse One-to-One)
     * 
     * This is used for role-based access control:
     * - Each student record belongs to a user account
     * - Students can only access their own record
     * - Admins can access all records
     * 
     * Usage: $student->user (returns the User model)
     */
    public function user()
    {
        // belongsTo() means this model has a foreign key 'user_id'
        // that references the 'id' column in the 'users' table
        return $this->belongsTo(User::class);
    }

    // ============================================
    // ACCESSORS (GETTERS)
    // ============================================
    // These create virtual properties that can be accessed like attributes
    // ============================================

    /**
     * Get the full name of the student.
     * 
     * Accessor: $student->full_name
     * 
     * Example: If first_name = "John" and last_name = "Doe"
     * Then $student->full_name returns "John Doe"
     * 
     * Usage: {{ $student->full_name }}
     */
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Get the photo URL for the student with improved handling.
     * 
     * Accessor: $student->photo_url
     * 
     * Returns:
     * - Uploaded photo URL if exists and file is present
     * - Default avatar with name initials if no photo
     * - Handles missing files gracefully
     * 
     * Usage: {{ $student->photo_url }}
     */
    public function getPhotoUrlAttribute()
    {
        // Check if student has a photo filename stored
        if ($this->photo) {
            // Check if the file actually exists in storage
            // This prevents broken image links
            $path = 'public/student_photos/' . $this->photo;
            if (Storage::exists($path)) {
                // Return the full URL using Laravel's asset() helper
                // asset() generates: http://yourdomain.com/storage/student_photos/filename.jpg
                return asset('storage/student_photos/' . $this->photo);
            }
        }
        
        // Return default avatar if no photo exists or file is missing
        // Using a free avatar service (ui-avatars.com)
        // Generates: https://ui-avatars.com/api/?name=John+Doe&size=200&background=3498db&color=ffffff
        // - size=200: Creates a 200x200 pixel avatar
        // - background=3498db: Blue background
        // - color=ffffff: White text
        // - bold=true: Bold text for better readability
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->full_name) . 
               '&size=200&background=3498db&color=ffffff&bold=true';
    }

    /**
     * Get the thumbnail photo URL (smaller version).
     * 
     * Accessor: $student->thumbnail_url
     * 
     * Useful for list views where you want smaller images
     * This improves page load speed in tables
     * 
     * Usage: {{ $student->thumbnail_url }}
     */
    public function getThumbnailUrlAttribute()
    {
        // Check if student has a photo
        if ($this->photo) {
            // Check if file exists
            $path = 'public/student_photos/' . $this->photo;
            if (Storage::exists($path)) {
                // Return the full URL
                return asset('storage/student_photos/' . $this->photo);
            }
        }
        
        // Return smaller avatar for thumbnails
        // size=50 creates a 50x50 pixel avatar
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->full_name) . 
               '&size=50&background=3498db&color=ffffff&bold=true';
    }

    /**
     * Get the age of the student.
     * 
     * Accessor: $student->age
     * 
     * Calculates age based on date_of_birth
     * 
     * Usage: {{ $student->age }} years old
     */
    public function getAgeAttribute()
    {
        // Carbon's diffInYears() calculates the difference in years from now
        return $this->date_of_birth->age; // Carbon automatically handles this
    }

    /**
     * Get the formatted date of birth.
     * 
     * Accessor: $student->formatted_dob
     * 
     * Formats the date as "January 15, 2000"
     * 
     * Usage: {{ $student->formatted_dob }}
     */
    public function getFormattedDobAttribute()
    {
        // Format the date as "January 15, 2000"
        return $this->date_of_birth->format('F d, Y');
    }

    /**
     * Check if the student has a photo.
     * 
     * Accessor: $student->has_photo
     * 
     * Returns true if student has a valid photo file
     * 
     * Usage: @if($student->has_photo) ... @endif
     */
    public function getHasPhotoAttribute()
    {
        if (!$this->photo) {
            return false;
        }
        return Storage::exists('public/student_photos/' . $this->photo);
    }

    // ============================================
    // SCOPES (QUERY BUILDERS)
    // ============================================
    // These create reusable query constraints
    // ============================================

    /**
     * Scope for active students.
     * 
     * Allows: Student::active()->get()
     * 
     * Usage: $activeStudents = Student::active()->get();
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'Active');
    }

    /**
     * Scope for inactive students.
     * 
     * Allows: Student::inactive()->get()
     * 
     * Usage: $inactiveStudents = Student::inactive()->get();
     */
    public function scopeInactive($query)
    {
        return $query->where('status', 'Inactive');
    }

    /**
     * Scope for graduated students.
     * 
     * Allows: Student::graduated()->get()
     * 
     * Usage: $graduatedStudents = Student::graduated()->get();
     */
    public function scopeGraduated($query)
    {
        return $query->where('status', 'Graduated');
    }

    /**
     * Scope for searching students.
     * 
     * Allows: Student::search('John')->get()
     * 
     * Searches in: first_name, last_name, email
     * 
     * Usage: $results = Student::search('John')->get();
     */
    public function scopeSearch($query, $term)
    {
        return $query->where(function($q) use ($term) {
            $q->where('first_name', 'LIKE', "%{$term}%")
              ->orWhere('last_name', 'LIKE', "%{$term}%")
              ->orWhere('email', 'LIKE', "%{$term}%");
        });
    }

    /**
     * Scope for students belonging to a specific user.
     * 
     * Allows: Student::forUser($userId)->get()
     * 
     * Used to get students linked to a specific user account
     * 
     * Usage: $students = Student::forUser(1)->get();
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope for students with photos.
     * 
     * Allows: Student::withPhoto()->get()
     * 
     * Returns only students who have a photo
     * 
     * Usage: $studentsWithPhotos = Student::withPhoto()->get();
     */
    public function scopeWithPhoto($query)
    {
        return $query->whereNotNull('photo');
    }

    /**
     * Scope for students without photos.
     * 
     * Allows: Student::withoutPhoto()->get()
     * 
     * Returns only students without a photo
     * 
     * Usage: $studentsWithoutPhotos = Student::withoutPhoto()->get();
     */
    public function scopeWithoutPhoto($query)
    {
        return $query->whereNull('photo');
    }

    // ============================================
    // HELPER METHODS
    // ============================================
    // These are additional utility methods
    // ============================================

    /**
     * Delete the student's photo file.
     * 
     * Returns true if photo was deleted, false otherwise
     * 
     * @return bool
     */
    public function deletePhoto()
    {
        if ($this->photo) {
            $path = 'public/student_photos/' . $this->photo;
            if (Storage::exists($path)) {
                Storage::delete($path);
                $this->update(['photo' => null]);
                return true;
            }
        }
        return false;
    }

    // ============================================
    // BOOT METHOD
    // ============================================
    // This runs automatically when the model is instantiated
    // You can add global behaviors here
    // ============================================

    /**
     * The "booted" method of the model.
     * 
     * This runs when the model is first loaded
     * Used to register event listeners and global scopes
     */
    protected static function boot()
    {
        parent::boot();

        /**
         * Saving Event Listener
         * 
         * This runs every time a student is saved (created or updated)
         * Automatically capitalizes the first letter of names
         * Ensures consistent formatting in the database
         */
        static::saving(function ($student) {
            // Capitalize first letter of first name
            $student->first_name = ucfirst(strtolower($student->first_name));
            
            // Capitalize first letter of last name
            $student->last_name = ucfirst(strtolower($student->last_name));
        });

        /**
         * Creating Event Listener
         * 
         * This runs only when a student is first created
         * Can be used to set default values or perform actions on creation
         */
        static::creating(function ($student) {
            // If no user_id is set, you could set a default
            // or perform other actions on creation
        });

        /**
         * Deleted Event Listener (Soft Delete)
         * 
         * THIS IS NEW: Runs when a student is soft-deleted
         * Automatically deletes the student's photo file from storage
         * Prevents orphaned files from accumulating
         */
        static::deleted(function ($student) {
            // Delete the student's photo when the student is deleted
            if ($student->photo) {
                $path = 'public/student_photos/' . $student->photo;
                if (Storage::exists($path)) {
                    Storage::delete($path);
                }
            }
        });

        /**
         * Force Deleted Event Listener
         * 
         * THIS IS NEW: Runs when a student is permanently deleted
         * Also deletes the photo file
         */
        static::forceDeleted(function ($student) {
            // Delete the student's photo when force deleted
            if ($student->photo) {
                $path = 'public/student_photos/' . $student->photo;
                if (Storage::exists($path)) {
                    Storage::delete($path);
                }
            }
        });

        /**
         * Restored Event Listener
         * 
         * THIS IS NEW: Runs when a student is restored from soft delete
         * Note: Photo file is not restored automatically
         */
        static::restored(function ($student) {
            // When restoring a student, you might want to handle the photo
            // But since the photo file is deleted on soft delete, it won't be restored
            // You could log this or handle it differently
        });
    }
}