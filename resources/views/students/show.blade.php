@extends('layouts.app')

@section('title', 'Student Details')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">👤 Student Details</h4>
                <div>
                    <a href="{{ route('students.edit', $student) }}" class="btn btn-warning btn-sm">✏️ Edit</a>
                    <a href="{{ route('students.index') }}" class="btn btn-secondary btn-sm">Back to List</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Full Name:</strong> {{ $student->first_name }} {{ $student->last_name }}</p>
                        <p><strong>Email:</strong> {{ $student->email }}</p>
                        <p><strong>Phone:</strong> {{ $student->phone ?? 'N/A' }}</p>
                        <p><strong>Gender:</strong> {{ $student->gender }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Date of Birth:</strong> {{ \Carbon\Carbon::parse($student->date_of_birth)->format('F d, Y') }}</p>
                        <p><strong>Age:</strong> {{ \Carbon\Carbon::parse($student->date_of_birth)->age }} years</p>
                        <p><strong>Course:</strong> {{ $student->course }}</p>
                        <p><strong>Status:</strong> 
                            <span class="status-{{ strtolower($student->status) }}">
                                {{ $student->status }}
                            </span>
                        </p>
                    </div>
                </div>
                <div class="mt-3">
                    <small class="text-muted">Created: {{ $student->created_at->format('M d, Y h:i A') }}</small>
                    <br>
                    <small class="text-muted">Last Updated: {{ $student->updated_at->format('M d, Y h:i A') }}</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection