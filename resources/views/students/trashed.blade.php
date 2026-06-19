@extends('layouts.app')

@section('title', 'Deleted Students')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">🗑️ Deleted Students (Trash)</h4>
        <a href="{{ route('students.index') }}" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Back to Students
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
                            <th>Photo</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Course</th>
                            <th>Deleted At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                            <tr>
                                <td>{{ $students->firstItem() + $loop->index }}</td>
                                <td>
                                    <img src="{{ $student->photo_url }}" 
                                         alt="Photo" 
                                         style="width: 40px; height: 40px; object-fit: cover; border-radius: 50%;">
                                </td>
                                <td>{{ $student->full_name }}</td>
                                <td>{{ $student->email }}</td>
                                <td>{{ $student->course }}</td>
                                <td>{{ $student->deleted_at->format('M d, Y h:i A') }}</td>
                                <td>
                                    {{-- Restore Button --}}
                                    <form action="{{ route('students.restore', $student->id) }}" 
                                          method="POST" 
                                          style="display: inline-block;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-success btn-sm">
                                            <i class="bi bi-arrow-counterclockwise"></i> Restore
                                        </button>
                                    </form>

                                    {{-- Force Delete Button --}}
                                    <form action="{{ route('students.force-delete', $student->id) }}" 
                                          method="POST" 
                                          style="display: inline-block;"
                                          onsubmit="return confirm('⚠️ Are you sure you want to permanently delete this student? This cannot be undone!')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="bi bi-trash"></i> Permanently Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="d-flex justify-content-center mt-3">
                {{ $students->links() }}
            </div>
        @else
            <div class="text-center py-4">
                <p class="text-muted">No deleted students found in trash.</p>
                <a href="{{ route('students.index') }}" class="btn btn-primary">
                    <i class="bi bi-arrow-left"></i> Go to Student List
                </a>
            </div>
        @endif
    </div>
</div>
@endsection