<?php

// ============================================
// MODEL: User
// ============================================
// Purpose: Represents a user in the system
// Handles authentication, roles, and user data
// Supports Admin and Student roles with different permissions
// ============================================

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * User Model
 * 
 * This model represents a user account in the system.
 * Each user can have one of two roles: 'admin' or 'student'.
 * 
 * Relationships:
 * - Has one Student record (for student users)
 * - Can be associated with a student record
 */
#[Fillable(['name', 'email', 'password', 'role'])] // Added 'role' to fillable
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    // ============================================
    // MASS ASSIGNMENT ATTRIBUTES
    // ============================================
    // These fields can be filled using create() or update()
    // Any field NOT in this array cannot be mass-assigned (security feature)
    // ============================================
    
    /**
     * The attributes that are mass assignable.
     * 
     * @var array<int, string>
     * 
     * Note: We're using the #[Fillable] attribute above the class
     * This is a PHP 8+ attribute that defines fillable fields
     * 
     * The attribute above says: #[Fillable(['name', 'email', 'password', 'role'])]
     */
    
    // ============================================
    // HIDDEN ATTRIBUTES
    // ============================================
    // These fields are hidden when the user is returned as JSON
    // Prevents sensitive data from being exposed in API responses
    // ============================================
    
    /**
     * The attributes that should be hidden for serialization.
     * 
     * @var array<int, string>
     * 
     * Note: We're using the #[Hidden] attribute above the class
     * This is a PHP 8+ attribute that defines hidden fields
     * 
     * The attribute above says: #[Hidden(['password', 'remember_token'])]
     */

    // ============================================
    // RELATIONSHIPS
    // ============================================
    // These define how the User model relates to other models
    // ============================================

    /**
     * Get the student record associated with this user.
     * 
     * Relationship: User has one Student
     * 
     * This is used for role-based access control:
     * - Each student user has one student record
     * - Students can only access their own record
     * - Admins have no student record (or may have one for testing)
     * 
     * Usage: $user->student (returns the Student model or null)
     * 
     * Example:
     *   if ($user->student) {
     *       // User has a student record
     *       $student = $user->student;
     *   }
     */
    public function student()
    {
        // hasOne() means this model has a foreign key 'user_id' in the 'students' table
        // This creates a one-to-one relationship
        return $this->hasOne(Student::class);
    }

    // ============================================
    // ROLE CHECK METHODS
    // ============================================
    // These methods make it easy to check a user's role
    // Usage: $user->isAdmin() or $user->isStudent()
    // ============================================

    /**
     * Check if the user is an administrator.
     * 
     * Returns true if the user's role is 'admin'
     * Returns false if the user's role is anything else
     * 
     * This is used throughout the application to control access:
     * - Show/hide admin features in views
     * - Restrict access to certain routes
     * - Control what data is displayed
     * 
     * Usage in views:
     *   @if(Auth::user()->isAdmin())
     *       // Show admin-only content
     *   @endif
     * 
     * Usage in controllers:
     *   if ($user->isAdmin()) {
     *       // Allow admin action
     *   }
     * 
     * @return bool
     */
    public function isAdmin()
    {
        // Compare the user's role with 'admin'
        // The 'role' column must exist in the users table
        return $this->role === 'admin';
        
        // WHAT THIS DOES:
        // 1. Checks if the 'role' column equals 'admin'
        // 2. Returns true if admin, false otherwise
        // 3. Used throughout the app for access control
    }

    /**
     * Check if the user is a student.
     * 
     * Returns true if the user's role is 'student'
     * Returns false if the user's role is anything else
     * 
     * This is used to:
     * - Show student-specific features
     * - Restrict students from accessing admin areas
     * - Control navigation visibility
     * 
     * Usage in views:
     *   @if(Auth::user()->isStudent())
     *       // Show student-only content
     *   @endif
     * 
     * Usage in controllers:
     *   if ($user->isStudent()) {
     *       // Redirect to student profile
     *   }
     * 
     * @return bool
     */
    public function isStudent()
    {
        // Compare the user's role with 'student'
        return $this->role === 'student';
        
        // WHAT THIS DOES:
        // 1. Checks if the 'role' column equals 'student'
        // 2. Returns true if student, false otherwise
        // 3. Used for student-specific logic
    }

    /**
     * Check if the user has a specific role.
     * 
     * This is a more generic role checker that can be used
     * to check for any role value.
     * 
     * Usage: $user->hasRole('admin') or $user->hasRole('student')
     * 
     * @param string $role The role to check ('admin' or 'student')
     * @return bool
     */
    public function hasRole(string $role): bool
    {
        // Check if the user's role matches the requested role
        return $this->role === $role;
        
        // WHAT THIS DOES:
        // 1. Compares the user's role with the provided role
        // 2. Returns true if they match
        // 3. A more flexible way to check roles
    }

    /**
     * Get the role of the user with proper formatting.
     * 
     * Returns the role with first letter capitalized for display.
     * 
     * Usage: {{ $user->getFormattedRole() }} // Returns "Admin" or "Student"
     * 
     * @return string
     */
    public function getFormattedRole(): string
    {
        // Capitalize the first letter of the role
        // Example: 'admin' becomes 'Admin', 'student' becomes 'Student'
        return ucfirst($this->role);
    }

    /**
     * Check if user can access student management features.
     * 
     * Only admins can manage students (create, edit, delete)
     * 
     * @return bool
     */
    public function canManageStudents(): bool
    {
        // Only admins can manage students
        return $this->isAdmin();
    }

    /**
     * Check if user can view student profiles.
     * 
     * Admins can view all students
     * Students can only view their own profile
     * 
     * @param int $studentId The ID of the student to check
     * @return bool
     */
    public function canViewStudent(int $studentId): bool
    {
        // Admins can view any student
        if ($this->isAdmin()) {
            return true;
        }
        
        // Students can only view their own profile
        if ($this->isStudent() && $this->student) {
            return $this->student->id === $studentId;
        }
        
        // Anyone else cannot view student profiles
        return false;
    }

    /**
     * Get the dashboard route for this user based on their role.
     * 
     * @return string The route name
     */
    public function getDashboardRoute(): string
    {
        if ($this->isAdmin()) {
            return 'dashboard'; // Admin dashboard with full stats
        } else {
            return 'students.show'; // Student's own profile
        }
    }

    /**
     * Get the redirect URL for this user after login.
     * 
     * @return string The URL
     */
    public function getRedirectUrl(): string
    {
        if ($this->isAdmin()) {
            return route('dashboard');
        } else {
            // Redirect to student's own profile if they have one
            if ($this->student) {
                return route('students.show', $this->student->id);
            }
            return route('dashboard');
        }
    }

    // ============================================
    // CASTS
    // ============================================
    // These define how attributes should be cast when accessed
    // ============================================

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime', // Converts to Carbon datetime
            'password' => 'hashed',            // Automatically hashes passwords
            'created_at' => 'datetime',        // Converts to Carbon datetime
            'updated_at' => 'datetime',        // Converts to Carbon datetime
        ];
    }

    // ============================================
    // BOOT METHOD
    // ============================================
    // This runs automatically when the model is instantiated
    // Used for event listeners and global behaviors
    // ============================================

    /**
     * The "booted" method of the model.
     * 
     * This runs when the model is first loaded
     * Used to register event listeners
     */
    protected static function booted(): void
    {
        /**
         * Creating Event Listener
         * 
         * This runs when a user is first created
         * Sets default role to 'student' if not specified
         */
        static::creating(function ($user) {
            // If role is not set, default to 'student'
            if (!isset($user->role)) {
                $user->role = 'student';
            }
        });

        /**
         * Saving Event Listener
         * 
         * This runs every time a user is saved
         * Can be used for validation or formatting
         */
        static::saving(function ($user) {
            // Ensure email is lowercase for consistency
            $user->email = strtolower($user->email);
            
            // Ensure name is properly capitalized
            $user->name = ucwords(strtolower($user->name));
        });
    }
}