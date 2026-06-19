

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
                        <label for="photo" class="form-label fw-semibold">
                            <i class="bi bi-image"></i> Profile Photo
                        </label>
                        <?php if($student->photo): ?>
                            <div class="mb-2">
                                <img src="<?php echo e($student->photo_url); ?>" 
                                     alt="Current Photo" 
                                     style="max-width: 100px; max-height: 100px; object-fit: cover; border-radius: 50%; border: 2px solid #3498db;">
                                <br>
                                <small class="text-muted">Current photo</small>
                            </div>
                        <?php else: ?>
                            <div class="mb-2">
                                <img src="https://ui-avatars.com/api/?name=<?php echo e(urlencode($student->full_name)); ?>&size=100" 
                                     alt="Current Avatar" 
                                     style="max-width: 100px; max-height: 100px; object-fit: cover; border-radius: 50%; border: 2px solid #3498db;">
                                <br>
                                <small class="text-muted">Current avatar (no photo uploaded)</small>
                            </div>
                        <?php endif; ?>
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
                               accept="image/*">
                        <small class="text-muted">
                            <i class="bi bi-info-circle"></i> Max size: 2MB. Allowed: jpeg, png, jpg, gif. Leave empty to keep current photo.
                        </small>
                        <?php $__errorArgs = ['photo'];
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\student-management-system\resources\views/students/edit.blade.php ENDPATH**/ ?>