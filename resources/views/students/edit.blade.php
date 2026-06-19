@extends('layouts.app')

@section('title', Auth::user()->isStudent() ? 'Edit My Profile' : 'Edit Student')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">
                    @if(Auth::user()->isStudent())
                        <i class="bi bi-pencil-square text-success"></i> Edit My Profile
                    @else
                        <i class="bi bi-pencil-square"></i> ✏️ Edit Student
                    @endif
                </h4>
            </div>
            <div class="card-body">
                {{-- ============================================
                     STUDENT WARNING - Only visible to students
                     ============================================ --}}
                @if(Auth::user()->isStudent())
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <i class="bi bi-info-circle-fill"></i>
                        <strong>Editing Your Profile!</strong> You are updating your own personal information.
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- IMPORTANT: Add enctype for file upload --}}
                <form action="{{ route('students.update', $student) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        {{-- First Name --}}
                        <div class="col-md-6 mb-3">
                            <label for="first_name" class="form-label fw-semibold">
                                <i class="bi bi-person"></i> First Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('first_name') is-invalid @enderror" 
                                   id="first_name" 
                                   name="first_name" 
                                   value="{{ old('first_name', $student->first_name) }}" 
                                   required>
                            @error('first_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Last Name --}}
                        <div class="col-md-6 mb-3">
                            <label for="last_name" class="form-label fw-semibold">
                                <i class="bi bi-person"></i> Last Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('last_name') is-invalid @enderror" 
                                   id="last_name" 
                                   name="last_name" 
                                   value="{{ old('last_name', $student->last_name) }}" 
                                   required>
                            @error('last_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        {{-- Email --}}
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label fw-semibold">
                                <i class="bi bi-envelope"></i> Email <span class="text-danger">*</span>
                            </label>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email', $student->email) }}" 
                                   required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Phone --}}
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label fw-semibold">
                                <i class="bi bi-phone"></i> Phone
                            </label>
                            <input type="text" 
                                   class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" 
                                   name="phone" 
                                   value="{{ old('phone', $student->phone) }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        {{-- Gender --}}
                        <div class="col-md-6 mb-3">
                            <label for="gender" class="form-label fw-semibold">
                                <i class="bi bi-gender-ambiguous"></i> Gender <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('gender') is-invalid @enderror" 
                                    id="gender" 
                                    name="gender" 
                                    required>
                                <option value="">Select Gender</option>
                                <option value="Male" {{ old('gender', $student->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ old('gender', $student->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                                <option value="Other" {{ old('gender', $student->gender) == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('gender')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Date of Birth --}}
                        <div class="col-md-6 mb-3">
                            <label for="date_of_birth" class="form-label fw-semibold">
                                <i class="bi bi-calendar"></i> Date of Birth <span class="text-danger">*</span>
                            </label>
                            <input type="date" 
                                   class="form-control @error('date_of_birth') is-invalid @enderror" 
                                   id="date_of_birth" 
                                   name="date_of_birth" 
                                   value="{{ old('date_of_birth', $student->date_of_birth) }}" 
                                   required>
                            @error('date_of_birth')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        {{-- Course --}}
                        <div class="col-md-6 mb-3">
                            <label for="course" class="form-label fw-semibold">
                                <i class="bi bi-book"></i> Course <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('course') is-invalid @enderror" 
                                   id="course" 
                                   name="course" 
                                   value="{{ old('course', $student->course) }}" 
                                   required>
                            @error('course')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Status --}}
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label fw-semibold">
                                <i class="bi bi-info-circle"></i> Status <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('status') is-invalid @enderror" 
                                    id="status" 
                                    name="status" 
                                    required>
                                <option value="">Select Status</option>
                                <option value="Active" {{ old('status', $student->status) == 'Active' ? 'selected' : '' }}>Active</option>
                                <option value="Inactive" {{ old('status', $student->status) == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="Graduated" {{ old('status', $student->status) == 'Graduated' ? 'selected' : '' }}>Graduated</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- PHOTO SECTION --}}
                    <div class="mb-3">
                        <label for="photo" class="form-label fw-semibold">
                            <i class="bi bi-image"></i> Profile Photo
                        </label>
                        @if($student->photo)
                            <div class="mb-2">
                                <img src="{{ $student->photo_url }}" 
                                     alt="Current Photo" 
                                     style="max-width: 100px; max-height: 100px; object-fit: cover; border-radius: 50%; border: 2px solid #3498db;">
                                <br>
                                <small class="text-muted">Current photo</small>
                            </div>
                        @else
                            <div class="mb-2">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($student->full_name) }}&size=100" 
                                     alt="Current Avatar" 
                                     style="max-width: 100px; max-height: 100px; object-fit: cover; border-radius: 50%; border: 2px solid #3498db;">
                                <br>
                                <small class="text-muted">Current avatar (no photo uploaded)</small>
                            </div>
                        @endif
                        <input type="file" 
                               class="form-control @error('photo') is-invalid @enderror" 
                               id="photo" 
                               name="photo" 
                               accept="image/*">
                        <small class="text-muted">
                            <i class="bi bi-info-circle"></i> Max size: 2MB. Allowed: jpeg, png, jpg, gif. Leave empty to keep current photo.
                        </small>
                        @error('photo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- ============================================
                         FORM BUTTONS - Role-based
                         ============================================ --}}
                    <div class="d-flex justify-content-between">
                        @if(Auth::user()->isStudent())
                            {{-- Student: Back to My Profile --}}
                            <a href="{{ route('students.show', $student->id) }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-check-circle"></i> Update My Profile
                            </button>
                        @else
                            {{-- Admin: Back to Student List --}}
                            <a href="{{ route('students.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Update Student
                            </button>
                        @endif
                    </div>
                </form>

                {{-- ============================================
                     STUDENT FOOTER NOTE
                     ============================================ --}}
                @if(Auth::user()->isStudent())
                    <div class="mt-4 text-center">
                        <small class="text-muted">
                            <i class="bi bi-shield-check"></i> 
                            Your personal information is secure and only visible to you and administrators.
                        </small>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection