@extends('layouts.app')

@section('title', 'Student Details')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">👤 Student Details</h4>
                <div>
                    <a href="{{ route('students.edit', $student) }}" class="btn btn-warning btn-sm">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                    <a href="{{ route('students.index') }}" class="btn btn-secondary btn-sm">
                        <i class="bi bi-arrow-left"></i> Back
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    {{-- PHOTO SECTION --}}
                    <div class="col-md-4 text-center mb-3">
                        <img src="{{ $student->photo_url }}" 
                             alt="Profile Photo" 
                             class="img-fluid rounded-circle"
                             style="width: 200px; height: 200px; object-fit: cover; border: 3px solid #3498db;">
                        <p class="mt-2 text-muted">Student Photo</p>
                    </div>

                    {{-- DETAILS SECTION --}}
                    <div class="col-md-8">
                        <h3 class="mb-3">{{ $student->full_name }}</h3>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong><i class="bi bi-envelope"></i> Email:</strong> {{ $student->email }}</p>
                                <p><strong><i class="bi bi-phone"></i> Phone:</strong> {{ $student->phone ?? 'N/A' }}</p>
                                <p><strong><i class="bi bi-gender-ambiguous"></i> Gender:</strong> {{ $student->gender }}</p>
                                <p><strong><i class="bi bi-calendar"></i> Date of Birth:</strong> {{ $student->formatted_dob }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong><i class="bi bi-cake"></i> Age:</strong> {{ $student->age }} years</p>
                                <p><strong><i class="bi bi-book"></i> Course:</strong> {{ $student->course }}</p>
                                <p><strong><i class="bi bi-info-circle"></i> Status:</strong> 
                                    <span class="status-{{ strtolower($student->status) }}">
                                        {{ $student->status }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- TIMESTAMPS --}}
                <div class="mt-4 pt-3 border-top">
                    <small class="text-muted">
                        <i class="bi bi-clock"></i> Created: {{ $student->created_at->format('M d, Y h:i A') }}
                    </small>
                    <br>
                    <small class="text-muted">
                        <i class="bi bi-clock-history"></i> Last Updated: {{ $student->updated_at->format('M d, Y h:i A') }}
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection