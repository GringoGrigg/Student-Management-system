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
        {{-- ============================================
             SUCCESS/ERROR MESSAGES
             ============================================ --}}
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

        {{-- ============================================
             SEARCH AND FILTER SECTION
             ============================================ --}}
        <form method="GET" action="{{ route('students.index') }}" class="mb-4">
            <div class="row g-3">
                {{-- Search Input --}}
                <div class="col-md-4">
                    <input type="text" 
                           name="search" 
                           class="form-control" 
                           placeholder="🔍 Search by name or email..."
                           value="{{ request('search') }}">
                </div>
                
                {{-- Course Filter Dropdown --}}
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
                
                {{-- Status Filter Dropdown --}}
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="Active" {{ request('status') == 'Active' ? 'selected' : '' }}>Active</option>
                        <option value="Inactive" {{ request('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="Graduated" {{ request('status') == 'Graduated' ? 'selected' : '' }}>Graduated</option>
                    </select>
                </div>
                
                {{-- Filter Button --}}
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-funnel"></i> Apply Filters
                    </button>
                </div>
            </div>
            
            {{-- Clear Filters Link --}}
            @if(request()->hasAny(['search', 'course', 'status']))
                <div class="mt-2">
                    <a href="{{ route('students.index') }}" class="btn btn-secondary btn-sm">
                        <i class="bi bi-x-circle"></i> Clear Filters
                    </a>
                    <span class="text-muted ms-2">
                        Showing {{ $students->total() }} results
                    </span>
                </div>
            @endif
        </form>

        {{-- ============================================
             STUDENT TABLE
             ============================================ --}}
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
                                {{-- Row Number --}}
                                <td>{{ $students->firstItem() + $loop->index }}</td>
                                
                                {{-- Photo Column with Thumbnail --}}
                                <td>
                                    @if($student->photo)
                                        {{-- If student has uploaded photo --}}
                                        <img src="{{ asset('storage/student_photos/' . $student->photo) }}" 
                                             alt="{{ $student->full_name }}" 
                                             class="profile-photo"
                                             style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%; border: 2px solid #3498db; cursor: pointer;"
                                             title="{{ $student->full_name }}"
                                             onclick="window.location.href='{{ route('students.show', $student) }}'">
                                    @else
                                        {{-- If no photo, show avatar with initials --}}
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($student->full_name) }}&size=50&background=3498db&color=ffffff&bold=true&rounded=true" 
                                             alt="{{ $student->full_name }}" 
                                             class="profile-photo"
                                             style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%; border: 2px solid #3498db; cursor: pointer;"
                                             title="{{ $student->full_name }}"
                                             onclick="window.location.href='{{ route('students.show', $student) }}'">
                                    @endif
                                </td>
                                
                                {{-- Student Details --}}
                                <td>
                                    <a href="{{ route('students.show', $student) }}" class="text-decoration-none fw-semibold">
                                        {{ $student->full_name }}
                                    </a>
                                </td>
                                <td>{{ $student->email }}</td>
                                <td>{{ $student->phone ?? '-' }}</td>
                                <td>
                                    <span class="badge bg-info">{{ $student->course }}</span>
                                </td>
                                <td>
                                    <span class="status-{{ strtolower($student->status) }}">
                                        {{ $student->status }}
                                    </span>
                                </td>
                                
                                {{-- Action Buttons --}}
                                <td>
                                    {{-- View Button --}}
                                    <a href="{{ route('students.show', $student) }}" 
                                       class="btn btn-primary btn-sm" 
                                       title="View Student">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    
                                    {{-- Edit Button --}}
                                    <a href="{{ route('students.edit', $student) }}" 
                                       class="btn btn-warning btn-sm" 
                                       title="Edit Student">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    
                                    {{-- Delete Button (Admin Only) --}}
                                    @if(Auth::user()->isAdmin())
                                        <form action="{{ route('students.destroy', $student) }}" 
                                              method="POST" 
                                              style="display: inline-block;"
                                              onsubmit="return confirm('⚠️ Are you sure you want to delete this student? This action can be undone via Trash.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Delete Student">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- ============================================
                 PAGINATION WITH ITEM INFO
                 ============================================ --}}
            <div class="d-flex justify-content-between align-items-center mt-3">
                {{-- Showing items info --}}
                <div class="text-muted small">
                    Showing {{ $students->firstItem() }} to {{ $students->lastItem() }} 
                    of {{ $students->total() }} students
                </div>
                
                {{-- Pagination Links --}}
                <div>
                    {{ $students->appends(request()->query())->links('pagination::bootstrap-5') }}
                </div>
            </div>
        @else
            {{-- ============================================
                 EMPTY STATE
                 ============================================ --}}
            <div class="text-center py-5">
                <i class="bi bi-inbox display-1 text-muted d-block mb-3"></i>
                <p class="text-muted">No students found matching your criteria.</p>
                <a href="{{ route('students.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Add Your First Student
                </a>
            </div>
        @endif
    </div>
</div>

{{-- ============================================
     ADDITIONAL STYLES FOR TABLE
     ============================================ --}}
@push('styles')
<style>
    /* ============================================
       PROFILE PHOTO THUMBNAIL
       ============================================ */
    .profile-photo {
        width: 45px;
        height: 45px;
        object-fit: cover;
        border-radius: 50%;
        border: 2px solid #3498db;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .profile-photo:hover {
        transform: scale(1.2);
        border-color: #2ecc71;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
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
       TABLE ROW HOVER EFFECT
       ============================================ */
    .table tbody tr {
        transition: all 0.2s ease;
    }
    
    .table tbody tr:hover {
        background-color: #f0f7ff;
        transform: scale(1.002);
    }
    
    /* ============================================
       ACTION BUTTONS
       ============================================ */
    .btn-sm {
        margin: 0 2px;
        border-radius: 6px;
        transition: all 0.2s ease;
    }
    
    .btn-sm:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0,0,0,0.15);
    }
    
    /* ============================================
       PAGINATION STYLING
       ============================================ */
    .pagination {
        margin-bottom: 0;
    }
    
    .pagination .page-link {
        border-radius: 6px;
        margin: 0 3px;
        color: #2c3e50;
        border: none;
        padding: 8px 14px;
        transition: all 0.2s ease;
    }
    
    .pagination .page-link:hover {
        background: #3498db;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(52, 152, 219, 0.3);
    }
    
    .pagination .active .page-link {
        background: #2c3e50;
        color: white;
        border: none;
    }
    
    .pagination .active .page-link:hover {
        background: #2c3e50;
        transform: none;
        box-shadow: none;
    }
    
    /* ============================================
       RESPONSIVE DESIGN
       ============================================ */
    @media (max-width: 768px) {
        .profile-photo {
            width: 35px;
            height: 35px;
        }
        
        .table th, 
        .table td {
            padding: 8px 6px;
            font-size: 13px;
        }
        
        .btn-sm {
            padding: 4px 8px;
            font-size: 12px;
        }
    }
</style>
@endpush