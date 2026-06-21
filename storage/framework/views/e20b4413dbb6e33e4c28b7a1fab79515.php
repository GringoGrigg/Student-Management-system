

<?php $__env->startSection('title', Auth::user()->isStudent() ? 'Edit My Profile' : 'Edit Student'); ?>

<?php $__env->startSection('content'); ?>
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">
                    <?php if(Auth::user()->isStudent()): ?>
                        <i class="bi bi-pencil-square text-success"></i> Edit My Profile
                    <?php else: ?>
                        <i class="bi bi-pencil-square"></i> ✏️ Edit Student
                    <?php endif; ?>
                </h4>
            </div>
            <div class="card-body">
                
                <?php if(Auth::user()->isStudent()): ?>
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <i class="bi bi-info-circle-fill"></i>
                        <strong>Editing Your Profile!</strong> You are updating your own personal information.
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                
                <form action="<?php echo e(route('students.update', $student)); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <div class="row">
                        
                        <div class="col-md-6 mb-3">
                            <label for="first_name" class="form-label fw-semibold">
                                <i class="bi bi-person"></i> First Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control <?php $__errorArgs = ['first_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="first_name" 
                                   name="first_name" 
                                   value="<?php echo e(old('first_name', $student->first_name)); ?>" 
                                   required>
                            <?php $__errorArgs = ['first_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div class="col-md-6 mb-3">
                            <label for="last_name" class="form-label fw-semibold">
                                <i class="bi bi-person"></i> Last Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control <?php $__errorArgs = ['last_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="last_name" 
                                   name="last_name" 
                                   value="<?php echo e(old('last_name', $student->last_name)); ?>" 
                                   required>
                            <?php $__errorArgs = ['last_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="row">
                        
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label fw-semibold">
                                <i class="bi bi-envelope"></i> Email <span class="text-danger">*</span>
                            </label>
                            <input type="email" 
                                   class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="email" 
                                   name="email" 
                                   value="<?php echo e(old('email', $student->email)); ?>" 
                                   required>
                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label fw-semibold">
                                <i class="bi bi-phone"></i> Phone
                            </label>
                            <input type="text" 
                                   class="form-control <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="phone" 
                                   name="phone" 
                                   value="<?php echo e(old('phone', $student->phone)); ?>">
                            <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="row">
                        
                        <div class="col-md-6 mb-3">
                            <label for="gender" class="form-label fw-semibold">
                                <i class="bi bi-gender-ambiguous"></i> Gender <span class="text-danger">*</span>
                            </label>
                            <select class="form-select <?php $__errorArgs = ['gender'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                    id="gender" 
                                    name="gender" 
                                    required>
                                <option value="">Select Gender</option>
                                <option value="Male" <?php echo e(old('gender', $student->gender) == 'Male' ? 'selected' : ''); ?>>Male</option>
                                <option value="Female" <?php echo e(old('gender', $student->gender) == 'Female' ? 'selected' : ''); ?>>Female</option>
                                <option value="Other" <?php echo e(old('gender', $student->gender) == 'Other' ? 'selected' : ''); ?>>Other</option>
                            </select>
                            <?php $__errorArgs = ['gender'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div class="col-md-6 mb-3">
                            <label for="date_of_birth" class="form-label fw-semibold">
                                <i class="bi bi-calendar"></i> Date of Birth <span class="text-danger">*</span>
                            </label>
                            <input type="date" 
                                   class="form-control <?php $__errorArgs = ['date_of_birth'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="date_of_birth" 
                                   name="date_of_birth" 
                                   value="<?php echo e(old('date_of_birth', $student->date_of_birth)); ?>" 
                                   required>
                            <?php $__errorArgs = ['date_of_birth'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="row">
                        
                        <div class="col-md-6 mb-3">
                            <label for="course" class="form-label fw-semibold">
                                <i class="bi bi-book"></i> Course <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control <?php $__errorArgs = ['course'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="course" 
                                   name="course" 
                                   value="<?php echo e(old('course', $student->course)); ?>" 
                                   required>
                            <?php $__errorArgs = ['course'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label fw-semibold">
                                <i class="bi bi-info-circle"></i> Status <span class="text-danger">*</span>
                            </label>
                            <select class="form-select <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                    id="status" 
                                    name="status" 
                                    required>
                                <option value="">Select Status</option>
                                <option value="Active" <?php echo e(old('status', $student->status) == 'Active' ? 'selected' : ''); ?>>Active</option>
                                <option value="Inactive" <?php echo e(old('status', $student->status) == 'Inactive' ? 'selected' : ''); ?>>Inactive</option>
                                <option value="Graduated" <?php echo e(old('status', $student->status) == 'Graduated' ? 'selected' : ''); ?>>Graduated</option>
                            </select>
                            <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            <i class="bi bi-image"></i> Profile Photo
                        </label>
                        
                        
                        <div class="text-center mb-3">
                            
                            <?php if($student->photo): ?>
                                <div id="currentPhotoContainer" class="d-block">
                                    <img src="<?php echo e($student->photo_url); ?>" 
                                         alt="Current Photo" 
                                         class="img-fluid rounded-circle"
                                         style="width: 150px; height: 150px; object-fit: cover; border: 3px solid #3498db;">
                                    <br>
                                    <small class="text-muted">Current photo</small>
                                    <br>
                                    
                                    
                                    <form action="<?php echo e(route('students.photo.delete', $student)); ?>" 
                                          method="POST" 
                                          style="display: inline-block;"
                                          onsubmit="return confirm('⚠️ Are you sure you want to delete this photo?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-danger btn-sm mt-2">
                                            <i class="bi bi-trash"></i> Remove Photo
                                        </button>
                                    </form>
                                </div>
                            <?php else: ?>
                                <div id="currentPhotoContainer" class="d-none"></div>
                                
                                
                                <div id="photoPlaceholder" class="d-block">
                                    <img src="https://ui-avatars.com/api/?name=<?php echo e(urlencode($student->full_name)); ?>&size=150&background=3498db&color=ffffff&bold=true" 
                                         alt="Current Avatar" 
                                         class="img-fluid rounded-circle"
                                         style="width: 150px; height: 150px; object-fit: cover; border: 3px solid #3498db;">
                                    <br>
                                    <small class="text-muted">Current avatar (no photo uploaded)</small>
                                </div>
                            <?php endif; ?>
                            
                            
                            <div id="photoPreviewContainer" class="d-none">
                                <img id="photoPreview" 
                                     src="#" 
                                     alt="Photo Preview" 
                                     class="img-fluid rounded-circle"
                                     style="width: 150px; height: 150px; object-fit: cover; border: 3px solid #27ae60;">
                                <br>
                                <small class="text-success">✅ New photo preview</small>
                            </div>
                        </div>
                        
                        
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="bi bi-cloud-upload"></i>
                            </span>
                            <input type="file" 
                                   class="form-control <?php $__errorArgs = ['photo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="photo" 
                                   name="photo" 
                                   accept="image/*"
                                   onchange="previewImage(event)">
                        </div>
                        
                        <small class="text-muted">
                            <i class="bi bi-info-circle"></i> 
                            Max size: 2MB. Allowed: jpeg, png, jpg, gif, webp
                            <br>
                            <i class="bi bi-check-circle"></i> 
                            Images will be automatically resized to 400x400px
                            <br>
                            <i class="bi bi-arrow-repeat"></i> 
                            Leave empty to keep current photo
                        </small>
                        
                        <?php $__errorArgs = ['photo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback d-block">
                                <i class="bi bi-exclamation-circle"></i> <?php echo e($message); ?>

                            </div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    
                    <div class="d-flex justify-content-between">
                        <?php if(Auth::user()->isStudent()): ?>
                            
                            <a href="<?php echo e(route('students.show', $student->id)); ?>" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-check-circle"></i> Update My Profile
                            </button>
                        <?php else: ?>
                            
                            <a href="<?php echo e(route('students.index')); ?>" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Update Student
                            </button>
                        <?php endif; ?>
                    </div>
                </form>

                
                <?php if(Auth::user()->isStudent()): ?>
                    <div class="mt-4 text-center">
                        <small class="text-muted">
                            <i class="bi bi-shield-check"></i> 
                            Your personal information is secure and only visible to you and administrators.
                        </small>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>


<?php $__env->startPush('scripts'); ?>
<script>
    /**
     * Preview image before upload
     * Shows a live preview of the selected image
     * Validates file type and size
     */
    function previewImage(event) {
        const reader = new FileReader();
        const file = event.target.files[0];
        
        // Get DOM elements
        const preview = document.getElementById('photoPreview');
        const placeholder = document.getElementById('photoPlaceholder');
        const previewContainer = document.getElementById('photoPreviewContainer');
        const currentContainer = document.getElementById('currentPhotoContainer');
        
        if (file) {
            // ===== VALIDATE FILE TYPE =====
            // Check if the selected file is an image
            if (!file.type.startsWith('image/')) {
                alert('❌ Please select an image file (jpeg, png, jpg, gif, webp).');
                event.target.value = ''; // Clear the input
                return;
            }
            
            // ===== VALIDATE FILE SIZE =====
            // Check if file is under 2MB
            if (file.size > 2 * 1024 * 1024) {
                alert('❌ File size exceeds 2MB limit. Please select a smaller image.');
                event.target.value = ''; // Clear the input
                return;
            }
            
            // ===== DISPLAY PREVIEW =====
            reader.onload = function(e) {
                // Set the preview image source
                preview.src = e.target.result;
                
                // Show preview container, hide placeholder and current photo
                previewContainer.classList.remove('d-none');
                previewContainer.classList.add('d-block');
                
                if (placeholder) {
                    placeholder.classList.add('d-none');
                }
                
                if (currentContainer) {
                    currentContainer.classList.add('d-none');
                }
            };
            
            // Read the file as data URL
            reader.readAsDataURL(file);
            
        } else {
            // ===== RESET PREVIEW =====
            // No file selected - show placeholder/current photo
            previewContainer.classList.add('d-none');
            previewContainer.classList.remove('d-block');
            
            if (placeholder) {
                placeholder.classList.remove('d-none');
            }
            
            if (currentContainer) {
                currentContainer.classList.remove('d-none');
            }
        }
    }
</script>
<?php $__env->stopPush(); ?>


<?php $__env->startPush('styles'); ?>
<style>
    /* Photo preview animation */
    #photoPreviewContainer img {
        animation: fadeIn 0.3s ease-in;
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: scale(0.9);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }
    
    /* File input styling */
    .input-group-text {
        background: #f8f9fa;
        border: 2px solid #e9ecef;
        border-right: none;
    }
    
    .input-group .form-control {
        border: 2px solid #e9ecef;
        border-left: none;
    }
    
    .input-group .form-control:focus {
        border-color: #3498db;
        box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
    }
    
    /* Delete photo button hover effect */
    .btn-danger {
        transition: all 0.3s ease;
    }
    
    .btn-danger:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(231, 76, 60, 0.3);
    }
</style>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\student-management-system\resources\views/students/edit.blade.php ENDPATH**/ ?>