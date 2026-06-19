<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // 👈 ADD THIS for soft delete functionality

class Student extends Model
{
    // ===== TRAITS =====
    // HasFactory: Allows using factories for testing/database seeding
    // SoftDeletes: Adds soft delete capability (deleted_at column)
    use HasFactory, SoftDeletes; // 👈 ADD SoftDeletes here

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
        'photo',           // 👈 ADD THIS for profile photo filename
    ];

    // ===== DATE CASTING =====
    // These fields should be treated as Carbon/DateTime objects
    // Allows using methods like ->format(), ->diffForHumans(), etc.
    protected $casts = [
        'date_of_birth' => 'date',      // Converts to Carbon date object
        'created_at' => 'datetime',     // Converts to Carbon datetime object
        'updated_at' => 'datetime',     // Converts to Carbon datetime object
        'deleted_at' => 'datetime',     // 👈 ADD THIS for soft delete timestamp
    ];

    // ===== ACCESSOR (GETTER) =====
    // This creates a virtual property: $student->full_name
    // Example: If first_name = "John" and last_name = "Doe"
    // Then $student->full_name returns "John Doe"
    // Use: {{ $student->full_name }}
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    // ===== ACCESSOR FOR PHOTO URL =====
    // This creates a virtual property: $student->photo_url
    // Returns the full URL to the student's profile photo
    // Use: {{ $student->photo_url }}
    public function getPhotoUrlAttribute()
    {
        // Check if student has a photo
        if ($this->photo) {
            // Return the full URL using Laravel's asset() helper
            // asset() generates: http://yourdomain.com/storage/student_photos/filename.jpg
            return asset('storage/student_photos/' . $this->photo);
        }
        
        // Return default avatar if no photo exists
        // Using a free avatar service (ui-avatars.com)
        // Generates: https://ui-avatars.com/api/?name=John+Doe&size=100
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->full_name) . '&size=100';
    }

    // ===== ACCESSOR FOR AGE =====
    // Creates virtual property: $student->age
    // Calculates age based on date_of_birth
    // Use: {{ $student->age }} years old
    public function getAgeAttribute()
    {
        // Carbon's diffInYears() calculates the difference in years from now
        return $this->date_of_birth->age; // Carbon automatically handles this
    }

    // ===== ACCESSOR FOR FORMATTED DATE OF BIRTH =====
    // Creates virtual property: $student->formatted_dob
    // Use: {{ $student->formatted_dob }}
    public function getFormattedDobAttribute()
    {
        // Format the date as "January 15, 2000"
        return $this->date_of_birth->format('F d, Y');
    }

    // ===== SCOPE FOR ACTIVE STUDENTS =====
    // Allows: Student::active()->get()
    // This creates a reusable query constraint
    public function scopeActive($query)
    {
        return $query->where('status', 'Active');
    }

    // ===== SCOPE FOR INACTIVE STUDENTS =====
    // Allows: Student::inactive()->get()
    public function scopeInactive($query)
    {
        return $query->where('status', 'Inactive');
    }

    // ===== SCOPE FOR GRADUATED STUDENTS =====
    // Allows: Student::graduated()->get()
    public function scopeGraduated($query)
    {
        return $query->where('status', 'Graduated');
    }

    // ===== SCOPE FOR SEARCH =====
    // Allows: Student::search('John')->get()
    // Reusable search functionality
    public function scopeSearch($query, $term)
    {
        return $query->where(function($q) use ($term) {
            $q->where('first_name', 'LIKE', "%{$term}%")
              ->orWhere('last_name', 'LIKE', "%{$term}%")
              ->orWhere('email', 'LIKE', "%{$term}%");
        });
    }

    // ===== BOOT METHOD =====
    // This runs automatically when the model is instantiated
    // You can add global behaviors here
    protected static function boot()
    {
        parent::boot();

        // Example: Automatically uppercase first letter of names before saving
        static::saving(function ($student) {
            $student->first_name = ucfirst(strtolower($student->first_name));
            $student->last_name = ucfirst(strtolower($student->last_name));
        });
    }
}