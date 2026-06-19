<?php

// ============================================
// CONTROLLER: AuthenticatedSessionController
// ============================================
// Purpose: Handles user login and logout operations
// This is the core authentication controller
// ============================================

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     * 
     * This method shows the login page to users
     * It returns the auth.login view which we customized
     * 
     * URL: GET /login
     * Access: Public (anyone can view)
     * 
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
        // Return the login view
        // This will show our custom login page with Admin/Student sections
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     * 
     * This is the main login handler method.
     * It validates credentials, logs the user in,
     * and redirects based on user role.
     * 
     * URL: POST /login
     * Access: Public (anyone can submit)
     * 
     * @param \App\Http\Requests\Auth\LoginRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // ============================================
        // STEP 1: AUTHENTICATE THE USER
        // ============================================
        // The LoginRequest handles validation automatically
        // It checks email, password, and credentials
        // ============================================
        
        /**
         * Authenticate the user credentials
         * 
         * This method:
         * 1. Validates email and password
         * 2. Checks if user exists in database
         * 3. Verifies the password matches
         * 4. Logs the user in if successful
         */
        $request->authenticate();

        // ============================================
        // STEP 2: REGENERATE SESSION
        // ============================================
        // Prevents session fixation attacks
        // This creates a new session ID for security
        // ============================================
        
        /**
         * Regenerate the session ID
         * 
         * Security measure to prevent session hijacking
         * Creates a new session ID while keeping session data
         */
        $request->session()->regenerate();

        // ============================================
        // STEP 3: GET THE AUTHENTICATED USER
        // ============================================
        // Retrieve the user object for role checking
        // ============================================
        
        /**
         * Get the currently authenticated user
         * 
         * This gives us access to the user's data
         * We need this to check their role
         */
        $user = Auth::user();

        // ============================================
        // STEP 4: ROLE-BASED REDIRECTION
        // ============================================
        // Redirect users to different pages based on role
        // Admin → Dashboard (with full access)
        // Student → Dashboard (with limited access)
        // ============================================
        
        /**
         * Redirect based on user role
         * 
         * Check if user is admin or student
         * Both go to dashboard but with different permissions
         * The dashboard view shows/hides features based on role
         */
        if ($user->role === 'admin') {
            // ===== ADMIN REDIRECT =====
            // Admins go to dashboard with full privileges
            // They can see admin panel, manage students, etc.
            return redirect()->intended(route('dashboard'));
        } else {
            // ===== STUDENT REDIRECT =====
            // Students go to dashboard with limited privileges
            // They can only view their own data (if restricted)
            return redirect()->intended(route('dashboard'));
        }
        
        // ============================================
        // OPTIONAL: Separate Dashboards
        // ============================================
        // If you want separate dashboards for admin/student:
        // if ($user->role === 'admin') {
        //     return redirect()->intended(route('admin.dashboard'));
        // } else {
        //     return redirect()->intended(route('student.dashboard'));
        // }
        // ============================================
    }

    /**
     * Destroy an authenticated session.
     * 
     * This handles user logout functionality
     * It clears the session and redirects to home
     * 
     * URL: POST /logout
     * Access: Requires authentication
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request): RedirectResponse
    {
        // ============================================
        // STEP 1: LOGOUT THE USER
        // ============================================
        // Log the user out of the web guard
        // ============================================
        
        /**
         * Logout the user
         * 
         * This clears the authentication state
         * The user is no longer considered logged in
         */
        Auth::guard('web')->logout();

        // ============================================
        // STEP 2: INVALIDATE SESSION
        // ============================================
        // Clear all session data
        // This ensures no session data persists after logout
        // ============================================
        
        /**
         * Invalidate the session
         * 
         * Clears all session data
         * Prevents session reuse after logout
         */
        $request->session()->invalidate();

        // ============================================
        // STEP 3: REGENERATE CSRF TOKEN
        // ============================================
        // Generate a new CSRF token for security
        // Prevents CSRF attacks on the next login
        // ============================================
        
        /**
         * Regenerate the CSRF token
         * 
         * Creates a new CSRF token for security
         * Prevents cross-site request forgery attacks
         */
        $request->session()->regenerateToken();

        // ============================================
        // STEP 4: REDIRECT TO HOME
        // ============================================
        // Send user back to the home page
        // They will see the welcome page with login option
        // ============================================
        
        /**
         * Redirect to home page
         * 
         * After logout, user goes to the welcome page
         * They can then login again if they want
         */
        return redirect('/');
    }
}