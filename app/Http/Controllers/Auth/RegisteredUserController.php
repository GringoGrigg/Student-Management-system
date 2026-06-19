<?php

// ============================================
// CONTROLLER: RegisteredUserController
// ============================================
// Purpose: Handles user registration
// Creates both user account and student profile if needed
// Uses the User model which already has role methods
// ============================================

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Student; // 👈 ADD THIS - for creating student profiles
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     * 
     * URL: GET /register
     * Access: Public (anyone can view)
     * 
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
        // Return the registration view
        // This shows the form with role selection
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     * 
     * URL: POST /register
     * Access: Public (anyone can submit)
     * 
     * Steps:
     * 1. Validate input (name, email, password, role)
     * 2. Create user account with role
     * 3. If student role, create student profile
     * 4. Fire registered event
     * 5. Log the user in
     * 6. Redirect based on role
     *
     * @throws ValidationException
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // ============================================
        // STEP 1: VALIDATE INPUT
        // ============================================
        // Validate all fields including role
        // The role must be either 'admin' or 'student'
        // ============================================
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:admin,student'], // 👈 ADDED: Validate role
        ]);

        // ============================================
        // STEP 2: CREATE USER
        // ============================================
        // Create the user with role included
        // The User model has role in its fillable array
        // ============================================
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role, // 👈 ADDED: Save the role
        ]);

        // ============================================
        // STEP 3: CREATE STUDENT PROFILE (IF STUDENT)
        // ============================================
        // If registering as a student, create a student profile
        // This links the student record to the user account
        // The User model has a student() relationship for this
        // ============================================
        if ($request->role === 'student') {
            // Create student profile linked to this user
            Student::create([
                'user_id' => $user->id,
                'first_name' => explode(' ', $request->name)[0] ?? 'Student',
                'last_name' => explode(' ', $request->name)[1] ?? 'User',
                'email' => $request->email,
                'phone' => null,
                'gender' => 'Other',
                'date_of_birth' => now()->subYears(20)->format('Y-m-d'), // Default DOB
                'course' => 'General Studies',
                'status' => 'Active',
            ]);
        }

        // ============================================
        // STEP 4: FIRE REGISTERED EVENT
        // ============================================
        // This sends verification email if enabled
        // ============================================
        event(new Registered($user));

        // ============================================
        // STEP 5: LOG USER IN
        // ============================================
        // Automatically log in the newly registered user
        // ============================================
        Auth::login($user);

        // ============================================
        // STEP 6: ROLE-BASED REDIRECTION
        // ============================================
        // Redirect based on user role:
        // - Admin → Dashboard
        // - Student → Their profile page
        // Uses the isAdmin() and isStudent() methods from User model
        // ============================================
        if ($user->isAdmin()) {
            // Admins go to dashboard with full statistics
            return redirect()->route('dashboard')
                ->with('success', 'Welcome Admin! You are now logged in.');
        } else {
            // Students go to their profile page
            // Check if student record exists (it should)
            if ($user->student) {
                return redirect()->route('students.show', $user->student->id)
                    ->with('success', 'Welcome! Your student profile has been created.');
            }
            // Fallback (should never happen)
            return redirect()->route('dashboard')
                ->with('info', 'Welcome! Please contact admin if you have issues.');
        }
    }
}