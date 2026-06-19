

<?php $__env->startSection('title', 'My Profile'); ?>

<?php $__env->startSection('content'); ?>
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">
                    <?php if(Auth::user()->isStudent()): ?>
                        <i class="bi bi-person-circle text-success"></i> My Profile
                    <?php else: ?>
                        👤 Student Details
                    <?php endif; ?>
                </h4>
                <div>
                    <?php if(Auth::user()->isAdmin()): ?>
                        <a href="<?php echo e(route('students.edit', $student)); ?>" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <a href="<?php echo e(route('students.index')); ?>" class="btn btn-secondary btn-sm">
                            <i class="bi bi-arrow-left"></i> Back
                        </a>
                    <?php else: ?>
                        
                        <a href="<?php echo e(route('students.edit', $student)); ?>" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil"></i> Edit Profile
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    
                    <div class="col-md-4 text-center mb-3">
                        <div class="position-relative d-inline-block">
                            <img src="<?php echo e($student->photo_url); ?>" 
                                 alt="Profile Photo" 
                                 class="img-fluid rounded-circle"
                                 style="width: 200px; height: 200px; object-fit: cover; border: 3px solid #3498db;">
                            
                            <span class="position-absolute bottom-0 end-0">
                                <span class="badge bg-success rounded-pill p-2" style="border: 3px solid white;">
                                    <i class="bi bi-check-circle-fill"></i>
                                </span>
                            </span>
                        </div>
                        <p class="mt-2 text-muted">
                            <?php if(Auth::user()->isStudent()): ?>
                                <span class="badge bg-success">🟢 Online</span>
                            <?php endif; ?>
                        </p>
                    </div>

                    
                    <div class="col-md-8">
                        <h3 class="mb-3"><?php echo e($student->full_name); ?></h3>
                        
                        
                        <div class="mb-3">
                            <?php if(Auth::user()->isStudent()): ?>
                                <span class="badge bg-info text-white" style="font-size: 14px; padding: 8px 20px;">
                                    <i class="bi bi-mortarboard-fill"></i> Student Account
                                </span>
                            <?php else: ?>
                                <span class="badge bg-danger text-white" style="font-size: 14px; padding: 8px 20px;">
                                    <i class="bi bi-shield-lock-fill"></i> Admin Viewing
                                </span>
                            <?php endif; ?>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <p><strong><i class="bi bi-envelope"></i> Email:</strong> <?php echo e($student->email); ?></p>
                                <p><strong><i class="bi bi-phone"></i> Phone:</strong> <?php echo e($student->phone ?? 'N/A'); ?></p>
                                <p><strong><i class="bi bi-gender-ambiguous"></i> Gender:</strong> <?php echo e($student->gender); ?></p>
                                <p><strong><i class="bi bi-calendar"></i> Date of Birth:</strong> <?php echo e($student->formatted_dob ?? $student->date_of_birth->format('F d, Y')); ?></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong><i class="bi bi-cake"></i> Age:</strong> <?php echo e($student->age ?? $student->date_of_birth->age); ?> years</p>
                                <p><strong><i class="bi bi-book"></i> Course:</strong> <?php echo e($student->course); ?></p>
                                <p><strong><i class="bi bi-info-circle"></i> Status:</strong> 
                                    <span class="status-<?php echo e(strtolower($student->status)); ?>">
                                        <?php echo e($student->status); ?>

                                    </span>
                                </p>
                                <?php if(Auth::user()->isStudent()): ?>
                                    <p class="text-muted small mt-3">
                                        <i class="bi bi-shield-check"></i> This is your personal profile. Only you and administrators can view this information.
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        
                        <?php if(Auth::user()->isStudent() && Auth::user()->student && Auth::user()->student->id === $student->id): ?>
                            <div class="alert alert-info mt-3">
                                <i class="bi bi-info-circle"></i> 
                                <strong>Welcome to your profile!</strong> You can view and edit your personal information here.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                
                <div class="mt-4 pt-3 border-top">
                    <small class="text-muted">
                        <i class="bi bi-clock"></i> Member since: <?php echo e($student->created_at->format('F d, Y')); ?>

                    </small>
                    <br>
                    <small class="text-muted">
                        <i class="bi bi-clock-history"></i> Last Updated: <?php echo e($student->updated_at->format('M d, Y h:i A')); ?>

                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\student-management-system\resources\views/students/show.blade.php ENDPATH**/ ?>