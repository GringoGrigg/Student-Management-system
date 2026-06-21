@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

{{-- ============================================
     WELCOME SECTION
     ============================================ --}}
<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">📊 Dashboard</h4>
            </div>
            <div class="card-body">
                <p>Welcome back, <strong>{{ Auth::user()->name }}</strong>!</p>
                <p class="text-muted">
                    Role: 
                    <span class="badge {{ Auth::user()->role == 'admin' ? 'badge-admin' : 'badge-student' }}">
                        {{ ucfirst(Auth::user()->role) }}
                    </span>
                </p>
            </div>
        </div>
    </div>
</div>

{{-- ============================================
     STATISTICS CARDS - ROW 1
     ============================================ --}}
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h6 class="card-title text-uppercase">Total Students</h6>
                <h2 class="card-text display-4">{{ $totalStudents ?? 0 }}</h2>
                <small>All students in system</small>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h6 class="card-title text-uppercase">Active Students</h6>
                <h2 class="card-text display-4">{{ $activeStudents ?? 0 }}</h2>
                <small>Currently active</small>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <h6 class="card-title text-uppercase">Inactive Students</h6>
                <h2 class="card-text display-4">{{ $inactiveStudents ?? 0 }}</h2>
                <small>Currently inactive</small>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card text-white bg-secondary">
            <div class="card-body">
                <h6 class="card-title text-uppercase">Graduated</h6>
                <h2 class="card-text display-4">{{ $graduatedStudents ?? 0 }}</h2>
                <small>Graduated students</small>
            </div>
        </div>
    </div>
</div>

{{-- ============================================
     CHARTS SECTION - PIE AND BAR
     ============================================ --}}
<div class="row mb-4">
    {{-- Pie Chart - Student Status Distribution --}}
    <div class="col-md-6 mb-3">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="mb-0">📊 Student Status Distribution</h5>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    {!! $pieChart->renderHtml() !!}
                </div>
            </div>
        </div>
    </div>

    {{-- Bar Chart - Students by Course --}}
    <div class="col-md-6 mb-3">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="mb-0">📊 Students by Course</h5>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    {!! $barChart->renderHtml() !!}
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ============================================
     LATEST STUDENTS AND COURSES
     ============================================ --}}
<div class="row">
    <div class="col-md-4 mb-3">
        <div class="card text-white bg-info h-100">
            <div class="card-body">
                <h6 class="card-title text-uppercase">Total Courses</h6>
                <h2 class="card-text display-4">{{ $totalCourses ?? 0 }}</h2>
                <small>Unique courses offered</small>
            </div>
        </div>
    </div>

    <div class="col-md-8 mb-3">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">🆕 Latest 5 Registered Students</h5>
            </div>
            <div class="card-body">
                @if(isset($latestStudents) && $latestStudents->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Course</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($latestStudents as $index => $student)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $student->full_name }}</td>
                                        <td>{{ $student->email }}</td>
                                        <td>{{ $student->course }}</td>
                                        <td>
                                            <span class="status-{{ strtolower($student->status) }}">
                                                {{ $student->status }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted text-center">No students registered yet.</p>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- ============================================
     ADMIN PANEL
     ============================================ --}}
@if($isAdmin ?? false)
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card border-primary">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">🔐 Admin Panel</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <a href="{{ route('students.index') }}" class="btn btn-primary btn-lg w-100">
                            <i class="bi bi-list-ul"></i> Manage Students
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ route('students.trashed') }}" class="btn btn-warning btn-lg w-100 text-white">
                            <i class="bi bi-trash"></i> View Trash
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ route('students.create') }}" class="btn btn-success btn-lg w-100">
                            <i class="bi bi-plus-circle"></i> Add Student
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

{{-- ============================================
     FOOTER STATISTICS
     ============================================ --}}
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body text-center text-muted">
                <small>
                    <i class="bi bi-database"></i> 
                    System Statistics: 
                    <span class="fw-bold">{{ $totalStudents ?? 0 }}</span> Total Students | 
                    <span class="fw-bold text-success">{{ $activeStudents ?? 0 }}</span> Active | 
                    <span class="fw-bold text-warning">{{ $inactiveStudents ?? 0 }}</span> Inactive | 
                    <span class="fw-bold text-secondary">{{ $graduatedStudents ?? 0 }}</span> Graduated |
                    <span class="fw-bold text-info">{{ $totalCourses ?? 0 }}</span> Courses
                </small>
            </div>
        </div>
    </div>
</div>

@endsection

{{-- ============================================
     CHART.JS SCRIPTS
     ============================================ --}}
@push('scripts')
    {!! $pieChart->renderChartJsLibrary() !!}
    {!! $pieChart->renderJs() !!}
    {!! $barChart->renderJs() !!}
@endpush

{{-- ============================================
     CHART CONTAINER STYLES
     ============================================ --}}
@push('styles')
<style>
    .chart-container {
        position: relative;
        height: 300px;
        width: 100%;
        margin: 10px 0;
    }
    
    .chart-container canvas {
        max-height: 300px;
        max-width: 100%;
    }
    
    /* Responsive chart adjustments */
    @media (max-width: 768px) {
        .chart-container {
            height: 250px;
        }
    }
</style>
@endpush