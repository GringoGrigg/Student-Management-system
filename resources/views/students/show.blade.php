@extends('layouts.app')

@section('title', Auth::user()->isStudent() ? 'My Profile' : 'Student Details')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">
                    @if(Auth::user()->isStudent())
                        <i class="bi bi-person-circle text-success"></i> My Profile
                    @else
                        👤 Student Details
                    @endif
                </h4>
                <div>
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('students.edit', $student) }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <a href="{{ route('students.index') }}" class="btn btn-secondary btn-sm">
                            <i class="bi bi-arrow-left"></i> Back
                        </a>
                    @else
                        {{-- Student viewing their own profile --}}
                        <a href="{{ route('students.edit', $student) }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil"></i> Edit Profile
                        </a>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    {{-- ============================================
                         PHOTO SECTION WITH ONLINE STATUS
                         ============================================ --}}
                    <div class="col-md-4 text-center mb-3">
                        {{-- Profile Photo with Online Status --}}
                        <div class="position-relative d-inline-block">
                            {{-- Photo Container --}}
                            <div class="profile-photo-wrapper">
                                <img src="{{ $student->photo_url }}" 
                                     alt="Profile Photo" 
                                     class="img-fluid rounded-circle profile-photo-display"
                                     style="width: 200px; height: 200px; object-fit: cover; border: 3px solid #3498db;">
                                
                                {{-- Online Status Indicator (Pulsing Green Dot) --}}
                                <span class="position-absolute bottom-0 end-0 online-status-badge">
                                    <span class="badge bg-success rounded-circle p-2 online-dot" 
                                          style="border: 3px solid white; display: inline-block; width: 24px; height: 24px;">
                                        <span class="visually-hidden">Online</span>
                                    </span>
                                </span>
                            </div>
                            
                            {{-- Status Text Below Photo --}}
                            <div class="mt-2">
                                @if(Auth::user()->isStudent())
                                    <span class="badge bg-success" style="font-size: 13px; padding: 5px 15px;">
                                        <i class="bi bi-check-circle-fill"></i> Online Now
                                    </span>
                                    <br>
                                    <small class="text-muted">Currently active</small>
                                @else
                                    <span class="badge bg-info" style="font-size: 13px; padding: 5px 15px;">
                                        <i class="bi bi-eye"></i> Admin Viewing
                                    </span>
                                @endif
                            </div>
                            
                            {{-- Photo Info --}}
                            <div class="mt-2">
                                @if($student->photo)
                                    <span class="badge bg-light text-dark">
                                        <i class="bi bi-check-circle text-success"></i> Photo uploaded
                                    </span>
                                @else
                                    <span class="badge bg-light text-muted">
                                        <i class="bi bi-image"></i> No photo uploaded
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- ============================================
                         DETAILS SECTION
                         ============================================ --}}
                    <div class="col-md-8">
                        {{-- Full Name --}}
                        <h3 class="mb-2">{{ $student->full_name }}</h3>
                        
                        {{-- Role Badge --}}
                        <div class="mb-3">
                            @if(Auth::user()->isStudent())
                                <span class="badge bg-info text-white" style="font-size: 14px; padding: 8px 20px;">
                                    <i class="bi bi-mortarboard-fill"></i> Student Account
                                </span>
                            @else
                                <span class="badge bg-danger text-white" style="font-size: 14px; padding: 8px 20px;">
                                    <i class="bi bi-shield-lock-fill"></i> Admin Viewing
                                </span>
                            @endif
                        </div>

                        {{-- Details Grid --}}
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong><i class="bi bi-envelope"></i> Email:</strong> {{ $student->email }}</p>
                                <p><strong><i class="bi bi-phone"></i> Phone:</strong> {{ $student->phone ?? 'N/A' }}</p>
                                <p><strong><i class="bi bi-gender-ambiguous"></i> Gender:</strong> {{ $student->gender }}</p>
                                <p><strong><i class="bi bi-calendar"></i> Date of Birth:</strong> 
                                    {{ $student->formatted_dob ?? $student->date_of_birth->format('F d, Y') }}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p><strong><i class="bi bi-cake"></i> Age:</strong> 
                                    {{ $student->age ?? $student->date_of_birth->age }} years
                                </p>
                                <p><strong><i class="bi bi-book"></i> Course:</strong> 
                                    <span class="badge bg-primary">{{ $student->course }}</span>
                                </p>
                                <p><strong><i class="bi bi-info-circle"></i> Status:</strong> 
                                    <span class="status-{{ strtolower($student->status) }}">
                                        {{ $student->status }}
                                    </span>
                                </p>
                            </div>
                        </div>
                        
                        {{-- Student Info Alert --}}
                        @if(Auth::user()->isStudent() && Auth::user()->student && Auth::user()->student->id === $student->id)
                            <div class="alert alert-info mt-3">
                                <i class="bi bi-info-circle"></i> 
                                <strong>Welcome to your profile!</strong> 
                                You can view and edit your personal information here.
                                <br>
                                <small class="text-muted">
                                    <i class="bi bi-shield-check"></i> 
                                    Your information is secure and only visible to you and administrators.
                                </small>
                            </div>
                        @endif
                        
                        {{-- Admin Note --}}
                        @if(Auth::user()->isAdmin())
                            <div class="alert alert-secondary mt-3">
                                <i class="bi bi-eye"></i> 
                                <strong>Admin View:</strong> 
                                You are viewing this student's profile. 
                                <a href="{{ route('students.edit', $student) }}" class="alert-link">
                                    Edit this profile
                                </a>
                                if needed.
                            </div>
                        @endif
                    </div>
                </div>

                {{-- ============================================
                     TIMESTAMPS
                     ============================================ --}}
                <div class="mt-4 pt-3 border-top">
                    <div class="row">
                        <div class="col-md-6">
                            <small class="text-muted">
                                <i class="bi bi-clock"></i> 
                                <strong>Member since:</strong> 
                                {{ $student->created_at->format('F d, Y') }}
                            </small>
                            <br>
                            <small class="text-muted">
                                <i class="bi bi-clock-history"></i> 
                                <strong>Last Updated:</strong> 
                                {{ $student->updated_at->format('M d, Y h:i A') }}
                            </small>
                        </div>
                        <div class="col-md-6 text-md-end">
                            @if($student->created_at->diffInDays(now()) < 7)
                                <span class="badge bg-success">
                                    <i class="bi bi-star-fill"></i> New Member
                                </span>
                            @endif
                            
                            @if($student->updated_at->diffInMinutes(now()) < 5)
                                <span class="badge bg-info">
                                    <i class="bi bi-arrow-repeat"></i> Recently Updated
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                
                {{-- ============================================
                     STUDENT ACTIONS (Admin Only)
                     ============================================ --}}
                @if(Auth::user()->isAdmin())
                    <div class="mt-3 pt-3 border-top">
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                <i class="bi bi-tools"></i> 
                                Admin Actions
                            </small>
                            <div>
                                <form action="{{ route('students.destroy', $student) }}" 
                                      method="POST" 
                                      style="display: inline-block;"
                                      onsubmit="return confirm('⚠️ Are you sure you want to delete this student? This action can be undone via Trash.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm">
                                        <i class="bi bi-trash"></i> Delete Student
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- ============================================
     ADDITIONAL STYLES FOR PROFILE
     ============================================ --}}
@push('styles')
<style>
    /* ============================================
       PROFILE PHOTO WRAPPER
       ============================================ */
    .profile-photo-wrapper {
        position: relative;
        display: inline-block;
    }
    
    .profile-photo-display {
        transition: all 0.3s ease;
    }
    
    .profile-photo-display:hover {
        transform: scale(1.02);
        box-shadow: 0 8px 25px rgba(0,0,0,0.2);
    }
    
    /* ============================================
       ONLINE STATUS INDICATOR
       ============================================ */
    .online-status-badge {
        bottom: 8px;
        right: 8px;
    }
    
    .online-dot {
        background: #2ecc71;
        display: inline-block;
        animation: pulse-dot 2s infinite;
        box-shadow: 0 0 0 0 rgba(46, 204, 113, 0.7);
    }
    
    @keyframes pulse-dot {
        0% {
            box-shadow: 0 0 0 0 rgba(46, 204, 113, 0.7);
        }
        70% {
            box-shadow: 0 0 0 10px rgba(46, 204, 113, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(46, 204, 113, 0);
        }
    }
    
    /* ============================================
       STATUS BADGES
       ============================================ */
    .status-active {
        background: #2ecc71;
        color: white;
        padding: 3px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
        display: inline-block;
    }
    
    .status-inactive {
        background: #e74c3c;
        color: white;
        padding: 3px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
        display: inline-block;
    }
    
    .status-graduated {
        background: #f39c12;
        color: white;
        padding: 3px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
        display: inline-block;
    }
    
    /* ============================================
       RESPONSIVE DESIGN
       ============================================ */
    @media (max-width: 768px) {
        .profile-photo-display {
            width: 150px !important;
            height: 150px !important;
        }
        
        .online-status-badge {
            bottom: 5px;
            right: 5px;
        }
        
        .online-dot {
            width: 20px !important;
            height: 20px !important;
        }
    }
</style>
@endpush