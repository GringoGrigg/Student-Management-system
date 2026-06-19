<?php $__env->startSection('title', 'Login'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-md-10 col-lg-8">
            
            <div class="card shadow-lg border-0">
                <div class="card-header text-center py-4">
                    
                    <h1 class="display-5 fw-bold mb-2">🎓 Student Management System</h1>
                    <p class="text-muted">Login to access your dashboard</p>
                </div>
                
                <div class="card-body p-4 p-md-5">
                    
                    <div class="row g-4">
                        
                        
                        <div class="col-md-6">
                            <div class="login-section admin-section p-4 rounded-3 h-100">
                                
                                <div class="text-center mb-4">
                                    <div class="admin-icon mb-3">
                                        <i class="bi bi-shield-lock-fill" style="font-size: 3rem; color: #e74c3c;"></i>
                                    </div>
                                    <h4 class="fw-bold">👑 Admin Login</h4>
                                    <p class="text-muted small">System administrators only</p>
                                    <span class="badge bg-danger">Restricted Access</span>
                                </div>
                                
                                
                                <form method="POST" action="<?php echo e(route('login')); ?>">
                                    <?php echo csrf_field(); ?>
                                    
                                    
                                    <input type="hidden" name="role" value="admin">
                                    
                                    
                                    <div class="mb-3">
                                        <label for="admin-email" class="form-label fw-semibold">
                                            <i class="bi bi-envelope"></i> Email Address
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">
                                                <i class="bi bi-envelope-fill text-danger"></i>
                                            </span>
                                            <input id="admin-email" 
                                                   type="email" 
                                                   class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                                   name="email" 
                                                   value="<?php echo e(old('email')); ?>" 
                                                   placeholder="admin@example.com"
                                                   required 
                                                   autofocus>
                                        </div>
                                        <?php $__errorArgs = ['email'];
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
                                    
                                    
                                    <div class="mb-3">
                                        <label for="admin-password" class="form-label fw-semibold">
                                            <i class="bi bi-lock"></i> Password
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">
                                                <i class="bi bi-lock-fill text-danger"></i>
                                            </span>
                                            <input id="admin-password" 
                                                   type="password" 
                                                   class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                                   name="password" 
                                                   placeholder="Enter your password"
                                                   required>
                                        </div>
                                        <?php $__errorArgs = ['password'];
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
                                    
                                    
                                    <div class="mb-3 form-check">
                                        <input class="form-check-input" 
                                               type="checkbox" 
                                               name="remember" 
                                               id="admin-remember" 
                                               <?php echo e(old('remember') ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="admin-remember">
                                            Remember me
                                        </label>
                                    </div>
                                    
                                    
                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-danger btn-lg fw-bold">
                                            <i class="bi bi-shield-check"></i> Login as Admin
                                        </button>
                                    </div>
                                    
                                    
                                    <div class="text-center mt-3">
                                        <small class="text-muted">
                                            <i class="bi bi-info-circle"></i> 
                                            Demo: admin@example.com / password
                                        </small>
                                    </div>
                                </form>
                            </div>
                        </div>
                        
                        
                        <div class="col-md-6">
                            <div class="login-section student-section p-4 rounded-3 h-100">
                                
                                <div class="text-center mb-4">
                                    <div class="student-icon mb-3">
                                        <i class="bi bi-mortarboard-fill" style="font-size: 3rem; color: #3498db;"></i>
                                    </div>
                                    <h4 class="fw-bold">🎓 Student Login</h4>
                                    <p class="text-muted small">Students & regular users</p>
                                    <span class="badge bg-primary">General Access</span>
                                </div>
                                
                                
                                <form method="POST" action="<?php echo e(route('login')); ?>">
                                    <?php echo csrf_field(); ?>
                                    
                                    
                                    <input type="hidden" name="role" value="student">
                                    
                                    
                                    <div class="mb-3">
                                        <label for="student-email" class="form-label fw-semibold">
                                            <i class="bi bi-envelope"></i> Email Address
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">
                                                <i class="bi bi-envelope-fill text-primary"></i>
                                            </span>
                                            <input id="student-email" 
                                                   type="email" 
                                                   class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                                   name="email" 
                                                   value="<?php echo e(old('email')); ?>" 
                                                   placeholder="student@example.com"
                                                   required>
                                        </div>
                                        <?php $__errorArgs = ['email'];
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
                                    
                                    
                                    <div class="mb-3">
                                        <label for="student-password" class="form-label fw-semibold">
                                            <i class="bi bi-lock"></i> Password
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">
                                                <i class="bi bi-lock-fill text-primary"></i>
                                            </span>
                                            <input id="student-password" 
                                                   type="password" 
                                                   class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                                   name="password" 
                                                   placeholder="Enter your password"
                                                   required>
                                        </div>
                                        <?php $__errorArgs = ['password'];
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
                                    
                                    
                                    <div class="mb-3 form-check">
                                        <input class="form-check-input" 
                                               type="checkbox" 
                                               name="remember" 
                                               id="student-remember" 
                                               <?php echo e(old('remember') ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="student-remember">
                                            Remember me
                                        </label>
                                    </div>
                                    
                                    
                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-primary btn-lg fw-bold">
                                            <i class="bi bi-box-arrow-in-right"></i> Login as Student
                                        </button>
                                    </div>
                                    
                                    
                                    <div class="text-center mt-3">
                                        <small class="text-muted">
                                            <i class="bi bi-info-circle"></i> 
                                            Demo: student@example.com / password
                                        </small>
                                    </div>
                                    
                                    
                                    <div class="text-center mt-3">
                                        <small>
                                            Don't have an account? 
                                            <a href="<?php echo e(route('register')); ?>" class="text-primary fw-bold">
                                                Register here
                                            </a>
                                        </small>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="text-center mt-4 pt-3 border-top">
                        <?php if(Route::has('password.request')): ?>
                            <a href="<?php echo e(route('password.request')); ?>" class="text-decoration-none text-muted">
                                <i class="bi bi-key"></i> Forgot your password?
                            </a>
                        <?php endif; ?>
                        
                        
                        <p class="text-muted small mt-2">
                            <i class="bi bi-shield-check"></i> Secure Login • 
                            Laravel <?php echo e(Illuminate\Foundation\Application::VERSION); ?>

                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php $__env->startPush('styles'); ?>
<style>
    /* ==========================================
       PAGE BACKGROUND
       ========================================== */
    body {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
    }
    
    /* ==========================================
       CARD CONTAINER
       ========================================== */
    .card {
        border-radius: 20px;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        overflow: hidden;
    }
    
    /* ==========================================
       CARD HEADER
       ========================================== */
    .card-header {
        background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
        color: white;
        border-bottom: none;
    }
    
    .card-header h1 {
        color: white;
        text-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }
    
    .card-header p {
        color: rgba(255,255,255,0.8);
    }
    
    /* ==========================================
       LOGIN SECTIONS
       ========================================== */
    .login-section {
        transition: all 0.3s ease;
        border: 2px solid transparent;
        height: 100%;
    }
    
    .login-section:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    
    /* ==========================================
       ADMIN SECTION
       ========================================== */
    .admin-section {
        background: linear-gradient(135deg, #fff5f5 0%, #ffffff 100%);
        border-color: #e74c3c;
    }
    
    .admin-section:hover {
        border-color: #c0392b;
        box-shadow: 0 10px 30px rgba(231, 76, 60, 0.2);
    }
    
    /* ==========================================
       STUDENT SECTION
       ========================================== */
    .student-section {
        background: linear-gradient(135deg, #f0f7ff 0%, #ffffff 100%);
        border-color: #3498db;
    }
    
    .student-section:hover {
        border-color: #2980b9;
        box-shadow: 0 10px 30px rgba(52, 152, 219, 0.2);
    }
    
    /* ==========================================
       ICON STYLING
       ========================================== */
    .admin-icon i,
    .student-icon i {
        background: white;
        padding: 15px;
        border-radius: 50%;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    
    /* ==========================================
       FORM INPUTS
       ========================================== */
    .form-control {
        border-radius: 10px;
        border: 2px solid #e9ecef;
        padding: 10px 15px;
        transition: all 0.3s ease;
    }
    
    .form-control:focus {
        border-color: #3498db;
        box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
    }
    
    .admin-section .form-control:focus {
        border-color: #e74c3c;
        box-shadow: 0 0 0 0.2rem rgba(231, 76, 60, 0.25);
    }
    
    .input-group-text {
        border-radius: 10px 0 0 10px;
        border: 2px solid #e9ecef;
        border-right: none;
    }
    
    .admin-section .input-group-text {
        background: #fff5f5 !important;
    }
    
    .student-section .input-group-text {
        background: #f0f7ff !important;
    }
    
    /* ==========================================
       BUTTONS
       ========================================== */
    .btn {
        border-radius: 10px;
        padding: 12px 24px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.2);
    }
    
    .btn-danger {
        background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
        border: none;
    }
    
    .btn-danger:hover {
        background: linear-gradient(135deg, #c0392b 0%, #e74c3c 100%);
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
        border: none;
    }
    
    .btn-primary:hover {
        background: linear-gradient(135deg, #2980b9 0%, #3498db 100%);
    }
    
    /* ==========================================
       BADGES
       ========================================== */
    .badge {
        padding: 5px 15px;
        font-weight: 500;
        border-radius: 20px;
    }
    
    /* ==========================================
       RESPONSIVE DESIGN
       ========================================== */
    @media (max-width: 768px) {
        .login-section {
            margin-bottom: 20px;
        }
        
        .card-body {
            padding: 20px !important;
        }
        
        .btn {
            font-size: 14px;
            padding: 10px 20px;
        }
    }
    
    /* ==========================================
       ANIMATIONS
       ========================================== */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .card {
        animation: fadeInUp 0.6s ease-out;
    }
</style>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.guest', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\student-management-system\resources\views/auth/login.blade.php ENDPATH**/ ?>