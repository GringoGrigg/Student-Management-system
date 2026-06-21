

<?php $__env->startSection('title', Auth::user()->isStudent() ? 'My Profile' : 'Student Details'); ?>

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
                            
                            <div class="profile-photo-wrapper" onclick="openModal('<?php echo e($student->photo_url); ?>')">
                                <?php if($student->photo): ?>
                                    <img src="<?php echo e(asset('storage/student_photos/' . $student->photo)); ?>" 
                                         alt="<?php echo e($student->full_name); ?>'s Photo" 
                                         class="img-fluid rounded-circle profile-photo-display"
                                         style="width: 200px; height: 200px; object-fit: cover; border: 3px solid #3498db; cursor: pointer;"
                                         title="Click to zoom">
                                <?php else: ?>
                                    <img src="https://ui-avatars.com/api/?name=<?php echo e(urlencode($student->full_name)); ?>&size=200&background=3498db&color=ffffff&bold=true&rounded=true" 
                                         alt="<?php echo e($student->full_name); ?>" 
                                         class="img-fluid rounded-circle profile-photo-display"
                                         style="width: 200px; height: 200px; object-fit: cover; border: 3px solid #3498db; cursor: pointer;">
                                <?php endif; ?>
                                
                                
                                <div class="zoom-overlay">
                                    <i class="bi bi-zoom-in" style="font-size: 1.8rem; color: white; text-shadow: 0 2px 10px rgba(0,0,0,0.5);"></i>
                                </div>
                                
                                
                                <span class="position-absolute bottom-0 end-0 online-status-badge">
                                    <span class="badge bg-success rounded-circle p-2 online-dot" 
                                          style="border: 3px solid white; display: inline-block; width: 24px; height: 24px;">
                                        <span class="visually-hidden">Online</span>
                                    </span>
                                </span>
                            </div>
                            
                            
                            <div class="mt-2">
                                <?php if(Auth::user()->isStudent()): ?>
                                    <span class="badge bg-success" style="font-size: 13px; padding: 5px 15px;">
                                        <i class="bi bi-check-circle-fill"></i> Online Now
                                    </span>
                                    <br>
                                    <small class="text-muted">Currently active</small>
                                <?php else: ?>
                                    <span class="badge bg-info" style="font-size: 13px; padding: 5px 15px;">
                                        <i class="bi bi-eye"></i> Admin Viewing
                                    </span>
                                <?php endif; ?>
                            </div>
                            
                            
                            <div class="mt-2">
                                <?php if($student->photo): ?>
                                    <span class="badge bg-light text-dark">
                                        <i class="bi bi-check-circle text-success"></i> Photo uploaded
                                    </span>
                                    <br>
                                    <small class="text-muted">Click photo to enlarge</small>
                                <?php else: ?>
                                    <span class="badge bg-light text-muted">
                                        <i class="bi bi-image"></i> No photo uploaded
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    
                    <div class="col-md-8">
                        
                        <h3 class="mb-2"><?php echo e($student->full_name); ?></h3>
                        
                        
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
                                <p><strong><i class="bi bi-calendar"></i> Date of Birth:</strong> 
                                    <?php echo e($student->formatted_dob ?? $student->date_of_birth->format('F d, Y')); ?>

                                </p>
                            </div>
                            <div class="col-md-6">
                                <p><strong><i class="bi bi-cake"></i> Age:</strong> 
                                    <?php echo e($student->age ?? $student->date_of_birth->age); ?> years
                                </p>
                                <p><strong><i class="bi bi-book"></i> Course:</strong> 
                                    <span class="badge bg-primary"><?php echo e($student->course); ?></span>
                                </p>
                                <p><strong><i class="bi bi-info-circle"></i> Status:</strong> 
                                    <span class="status-<?php echo e(strtolower($student->status)); ?>">
                                        <?php echo e($student->status); ?>

                                    </span>
                                </p>
                            </div>
                        </div>
                        
                        
                        <?php if(Auth::user()->isStudent() && Auth::user()->student && Auth::user()->student->id === $student->id): ?>
                            <div class="alert alert-info mt-3">
                                <i class="bi bi-info-circle"></i> 
                                <strong>Welcome to your profile!</strong> 
                                You can view and edit your personal information here.
                                <br>
                                <small class="text-muted">
                                    <i class="bi bi-shield-check"></i> 
                                    Your information is secure and only visible to you and administrators.
                                </small>
                            </div>
                        <?php endif; ?>
                        
                        
                        <?php if(Auth::user()->isAdmin()): ?>
                            <div class="alert alert-secondary mt-3">
                                <i class="bi bi-eye"></i> 
                                <strong>Admin View:</strong> 
                                You are viewing this student's profile. 
                                <a href="<?php echo e(route('students.edit', $student)); ?>" class="alert-link">
                                    Edit this profile
                                </a>
                                if needed.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                
                <div class="mt-4 pt-3 border-top">
                    <div class="row">
                        <div class="col-md-6">
                            <small class="text-muted">
                                <i class="bi bi-clock"></i> 
                                <strong>Member since:</strong> 
                                <?php echo e($student->created_at->format('F d, Y')); ?>

                            </small>
                            <br>
                            <small class="text-muted">
                                <i class="bi bi-clock-history"></i> 
                                <strong>Last Updated:</strong> 
                                <?php echo e($student->updated_at->format('M d, Y h:i A')); ?>

                            </small>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <?php if($student->created_at->diffInDays(now()) < 7): ?>
                                <span class="badge bg-success">
                                    <i class="bi bi-star-fill"></i> New Member
                                </span>
                            <?php endif; ?>
                            
                            <?php if($student->updated_at->diffInMinutes(now()) < 5): ?>
                                <span class="badge bg-info">
                                    <i class="bi bi-arrow-repeat"></i> Recently Updated
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                
                <?php if(Auth::user()->isAdmin()): ?>
                    <div class="mt-3 pt-3 border-top">
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                <i class="bi bi-tools"></i> 
                                Admin Actions
                            </small>
                            <div>
                                <form action="<?php echo e(route('students.destroy', $student)); ?>" 
                                      method="POST" 
                                      style="display: inline-block;"
                                      onsubmit="return confirm('⚠️ Are you sure you want to delete this student? This action can be undone via Trash.')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-outline-danger btn-sm">
                                        <i class="bi bi-trash"></i> Delete Student
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>


<div id="imageModal" class="modal" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.92); cursor: pointer;" onclick="closeModal()">
    <span style="position: absolute; top: 20px; right: 40px; color: white; font-size: 45px; font-weight: bold; cursor: pointer; z-index: 10000; transition: all 0.3s ease;" 
          onclick="closeModal()" 
          onmouseover="this.style.transform='scale(1.2)'" 
          onmouseout="this.style.transform='scale(1)'">
        &times;
    </span>
    <img id="modalImage" src="" alt="Profile Photo" 
         style="display: block; max-width: 90%; max-height: 90%; margin: auto; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); border-radius: 10px; box-shadow: 0 0 50px rgba(0,0,0,0.6);">
</div>

<script>
    function openModal(imageSrc) {
        var modal = document.getElementById('imageModal');
        var modalImg = document.getElementById('modalImage');
        modal.style.display = 'block';
        modalImg.src = imageSrc;
        document.body.style.overflow = 'hidden'; // Prevent scrolling
    }
    
    function closeModal() {
        document.getElementById('imageModal').style.display = 'none';
        document.body.style.overflow = 'auto'; // Restore scrolling
    }
    
    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeModal();
        }
    });
</script>


<?php $__env->startPush('styles'); ?>
<style>
    /* ============================================
       PROFILE PHOTO WRAPPER
       ============================================ */
    .profile-photo-wrapper {
        position: relative;
        display: inline-block;
        border-radius: 50%;
        overflow: hidden;
        cursor: pointer;
    }
    
    .profile-photo-display {
        transition: all 0.3s ease;
    }
    
    .profile-photo-wrapper:hover .profile-photo-display {
        transform: scale(1.05);
        box-shadow: 0 8px 25px rgba(0,0,0,0.25);
    }
    
    /* ============================================
       ZOOM OVERLAY
       ============================================ */
    .zoom-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.4);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: all 0.3s ease;
        border-radius: 50%;
    }
    
    .profile-photo-wrapper:hover .zoom-overlay {
        opacity: 1;
    }
    
    /* ============================================
       ONLINE STATUS INDICATOR
       ============================================ */
    .online-status-badge {
        bottom: 8px;
        right: 8px;
    }
    
    .online-dot {
        background: #2ecc71;
        display: inline-block;
        animation: pulse-dot 2s infinite;
        box-shadow: 0 0 0 0 rgba(46, 204, 113, 0.7);
    }
    
    @keyframes pulse-dot {
        0% {
            box-shadow: 0 0 0 0 rgba(46, 204, 113, 0.7);
        }
        70% {
            box-shadow: 0 0 0 10px rgba(46, 204, 113, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(46, 204, 113, 0);
        }
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
       MODAL ANIMATION
       ============================================ */
    #imageModal {
        animation: fadeIn 0.3s ease-out;
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }
    
    #modalImage {
        animation: zoomIn 0.4s ease-out;
    }
    
    @keyframes zoomIn {
        from {
            transform: translate(-50%, -50%) scale(0.5);
            opacity: 0;
        }
        to {
            transform: translate(-50%, -50%) scale(1);
            opacity: 1;
        }
    }
    
    /* ============================================
       RESPONSIVE DESIGN
       ============================================ */
    @media (max-width: 768px) {
        .profile-photo-display {
            width: 150px !important;
            height: 150px !important;
        }
        
        .online-status-badge {
            bottom: 5px;
            right: 5px;
        }
        
        .online-dot {
            width: 20px !important;
            height: 20px !important;
        }
        
        #modalImage {
            max-width: 95%;
            max-height: 80%;
        }
        
        .zoom-overlay i {
            font-size: 1.2rem !important;
        }
    }
</style>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\student-management-system\resources\views/students/show.blade.php ENDPATH**/ ?>