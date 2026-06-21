@extends('layouts.app')

@section('title', 'Add New Student')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">➕ Add New Student</h4>
            </div>
            <div class="card-body">
                {{-- IMPORTANT: Add enctype="multipart/form-data" for file uploads --}}
                <form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('first_name') is-invalid @enderror" 
                                   id="first_name" 
                                   name="first_name" 
                                   value="{{ old('first_name') }}" 
                                   required>
                            @error('first_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('last_name') is-invalid @enderror" 
                                   id="last_name" 
                                   name="last_name" 
                                   value="{{ old('last_name') }}" 
                                   required>
                            @error('last_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" 
                                   class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" 
                                   name="phone" 
                                   value="{{ old('phone') }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="gender" class="form-label">Gender <span class="text-danger">*</span></label>
                            <select class="form-select @error('gender') is-invalid @enderror" 
                                    id="gender" 
                                    name="gender" 
                                    required>
                                <option value="">Select Gender</option>
                                <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                                <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('gender')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="date_of_birth" class="form-label">Date of Birth <span class="text-danger">*</span></label>
                            <input type="date" 
                                   class="form-control @error('date_of_birth') is-invalid @enderror" 
                                   id="date_of_birth" 
                                   name="date_of_birth" 
                                   value="{{ old('date_of_birth') }}" 
                                   required>
                            @error('date_of_birth')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="course" class="form-label">Course <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('course') is-invalid @enderror" 
                                   id="course" 
                                   name="course" 
                                   value="{{ old('course') }}" 
                                   required>
                            @error('course')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" 
                                    id="status" 
                                    name="status" 
                                    required>
                                <option value="">Select Status</option>
                                <option value="Active" {{ old('status') == 'Active' ? 'selected' : '' }}>Active</option>
                                <option value="Inactive" {{ old('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="Graduated" {{ old('status') == 'Graduated' ? 'selected' : '' }}>Graduated</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- ============================================
                         PHOTO UPLOAD WITH PREVIEW
                         ============================================ --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            <i class="bi bi-image"></i> Profile Photo
                        </label>
                        
                        {{-- Image Preview Container --}}
                        <div class="text-center mb-3">
                            <div id="photoPreviewContainer" class="d-none">
                                <img id="photoPreview" 
                                     src="#" 
                                     alt="Photo Preview" 
                                     class="img-fluid rounded-circle border border-success border-3"
                                     style="width: 150px; height: 150px; object-fit: cover;">
                                <br>
                                <small class="text-success">
                                    <i class="bi bi-check-circle"></i> Preview
                                </small>
                            </div>
                            <div id="photoPlaceholder">
                                <div style="width: 150px; height: 150px; border-radius: 50%; background: #ecf0f1; display: flex; align-items: center; justify-content: center; margin: 0 auto; border: 3px dashed #bdc3c7;">
                                    <span style="font-size: 60px; color: #95a5a6;">📷</span>
                                </div>
                                <small class="text-muted">No photo selected</small>
                            </div>
                        </div>
                        
                        {{-- File Input with Drag & Drop Support --}}
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="bi bi-cloud-upload"></i>
                            </span>
                            <input type="file" 
                                   class="form-control @error('photo') is-invalid @enderror" 
                                   id="photo" 
                                   name="photo" 
                                   accept="image/*"
                                   onchange="previewImage(event)"
                                   aria-describedby="photoHelp">
                        </div>
                        
                        <div id="photoHelp" class="form-text">
                            <i class="bi bi-info-circle text-primary"></i> 
                            <strong>Max size:</strong> 2MB | 
                            <strong>Allowed:</strong> jpeg, png, jpg, gif, webp
                            <br>
                            <i class="bi bi-check-circle text-success"></i> 
                            Images will be automatically resized to 400x400px for optimal display
                        </div>
                        
                        {{-- File size warning --}}
                        <div id="fileSizeWarning" class="alert alert-warning mt-2 d-none">
                            <i class="bi bi-exclamation-triangle"></i>
                            File size exceeds 2MB limit. Please select a smaller image.
                        </div>
                        
                        @error('photo')
                            <div class="invalid-feedback d-block">
                                <i class="bi bi-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('students.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- ============================================
     IMAGE PREVIEW JAVASCRIPT
     ============================================ --}}
@push('scripts')
<script>
    function previewImage(event) {
        const reader = new FileReader();
        const file = event.target.files[0];
        const preview = document.getElementById('photoPreview');
        const placeholder = document.getElementById('photoPlaceholder');
        const container = document.getElementById('photoPreviewContainer');
        const warning = document.getElementById('fileSizeWarning');
        
        // Reset warning
        warning.classList.add('d-none');
        
        if (file) {
            // ============================================
            // VALIDATION: Check if file is an image
            // ============================================
            if (!file.type.startsWith('image/')) {
                alert('❌ Please select a valid image file.');
                event.target.value = '';
                return;
            }
            
            // ============================================
            // VALIDATION: Check file size (2MB max)
            // ============================================
            if (file.size > 2 * 1024 * 1024) {
                warning.classList.remove('d-none');
                event.target.value = '';
                return;
            }
            
            // ============================================
            // DISPLAY PREVIEW
            // ============================================
            reader.onload = function(e) {
                preview.src = e.target.result;
                container.classList.remove('d-none');
                container.classList.add('d-block');
                placeholder.classList.add('d-none');
            };
            
            reader.readAsDataURL(file);
        } else {
            // ============================================
            // RESET PREVIEW
            // ============================================
            container.classList.add('d-none');
            container.classList.remove('d-block');
            placeholder.classList.remove('d-none');
        }
    }
    
    // ============================================
    // DRAG AND DROP SUPPORT
    // ============================================
    document.addEventListener('DOMContentLoaded', function() {
        const dropArea = document.querySelector('.input-group');
        
        // Prevent default drag behaviors
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, preventDefaults, false);
        });
        
        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }
        
        // Highlight drop area when item is dragged over it
        ['dragenter', 'dragover'].forEach(eventName => {
            dropArea.addEventListener(eventName, () => {
                dropArea.classList.add('border-primary', 'bg-light');
            }, false);
        });
        
        ['dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, () => {
                dropArea.classList.remove('border-primary', 'bg-light');
            }, false);
        });
        
        // Handle dropped files
        dropArea.addEventListener('drop', function(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            const fileInput = document.getElementById('photo');
            
            if (files.length > 0) {
                fileInput.files = files;
                // Trigger change event to show preview
                const event = new Event('change');
                fileInput.dispatchEvent(event);
            }
        }, false);
    });
</script>
@endpush