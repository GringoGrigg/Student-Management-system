@extends('layouts.app')

@section('title', 'Student List')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">📋 Student List</h4>
        <a href="{{ route('students.create') }}" class="btn btn-success btn-sm">
            <i class="bi bi-plus-circle"></i> Add New Student
        </a>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Search and Filter Section -->
        <form method="GET" action="{{ route('students.index') }}" class="mb-4">
            <div class="row g-3">
                <div class="col-md-4">
                    <input type="text" 
                           name="search" 
                           class="form-control" 
                           placeholder="🔍 Search by name or email..."
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="course" class="form-select">
                        <option value="">All Courses</option>
                        @if(isset($courses))
                            @foreach($courses as $course)
                                <option value="{{ $course }}" {{ request('course') == $course ? 'selected' : '' }}>
                                    {{ $course }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="Active" {{ request('status') == 'Active' ? 'selected' : '' }}>Active</option>
                        <option value="Inactive" {{ request('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="Graduated" {{ request('status') == 'Graduated' ? 'selected' : '' }}>Graduated</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
                </div>
            </div>
            @if(request()->hasAny(['search', 'course', 'status']))
                <div class="mt-2">
                    <a href="{{ route('students.index') }}" class="btn btn-secondary btn-sm">Clear Filters</a>
                    <span class="text-muted ms-2">
                        Showing {{ $students->total() }} results
                    </span>
                </div>
            @endif
        </form>

        @if(isset($students) && $students->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Photo</th>
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
                                <td>{{ $students->firstItem() + $loop->index }}</td>
                                <td>
                                    <img src="{{ $student->photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($student->full_name) . '&size=50' }}" 
                                         alt="Photo" 
                                         class="profile-photo">
                                </td>
                                <td>{{ $student->full_name }}</td>
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
                                       class="btn btn-primary btn-sm">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('students.edit', $student) }}" 
                                       class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('students.destroy', $student) }}" 
                                          method="POST" 
                                          style="display: inline-block;"
                                          onsubmit="return confirm('Are you sure you want to delete this student?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-3">
                {{ $students->links() }}
            </div>
        @else
            <div class="text-center py-4">
                <p class="text-muted">No students found matching your criteria.</p>
                <a href="{{ route('students.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Add Your First Student
                </a>
            </div>
        @endif
    </div>
</div>
@endsection