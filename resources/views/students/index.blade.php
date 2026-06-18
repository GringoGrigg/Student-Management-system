@extends('layouts.app')

@section('title', 'Student List')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">📋 Student List</h4>
        <a href="{{ route('students.create') }}" class="btn btn-success btn-sm">
            ➕ Add New Student
        </a>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($students->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Course</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                                <td>{{ $student->email }}</td>
                                <td>{{ $student->phone ?? '-' }}</td>
                                <td>{{ $student->course }}</td>
                                <td>
                                    <span class="status-{{ strtolower($student->status) }}">
                                        {{ $student->status }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('students.show', $student) }}" 
                                       class="btn btn-primary btn-sm">👁️ View</a>
                                    <a href="{{ route('students.edit', $student) }}" 
                                       class="btn btn-warning btn-sm">✏️ Edit</a>
                                    <form action="{{ route('students.destroy', $student) }}" 
                                          method="POST" 
                                          style="display: inline-block;"
                                          onsubmit="return confirm('Are you sure you want to delete this student?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">🗑️ Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-4">
                <p class="text-muted">No students found. Click "Add New Student" to get started!</p>
            </div>
        @endif
    </div>
</div>
@endsection