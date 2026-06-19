<?php $__env->startSection('title', 'Register'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-lg border-0">
                <div class="card-header text-center py-4">
                    <h2 class="fw-bold mb-2">📝 Create Account</h2>
                    <p class="text-muted">Register to get started</p>
                </div>
                
                <div class="card-body p-4">
                    <form method="POST" action="<?php echo e(route('register')); ?>">
                        <?php echo csrf_field(); ?>
                        
                        
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">
                                <i class="bi bi-person"></i> Full Name
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="bi bi-person-fill"></i>
                                </span>
                                <input id="name" 
                                       type="text" 
                                       class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       name="name" 
                                       value="<?php echo e(old('name')); ?>" 
                                       placeholder="Enter your full name"
                                       required>
                            </div>
                            <?php $__errorArgs = ['name'];
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
                            <label for="email" class="form-label fw-semibold">
                                <i class="bi bi-envelope"></i> Email Address
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="bi bi-envelope-fill"></i>
                                </span>
                                <input id="email" 
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
                                       placeholder="Enter your email"
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
                            <label for="password" class="form-label fw-semibold">
                                <i class="bi bi-lock"></i> Password
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="bi bi-lock-fill"></i>
                                </span>
                                <input id="password" 
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
                            <small class="text-muted">Minimum 8 characters</small>
                        </div>
                        
                        
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label fw-semibold">
                                <i class="bi bi-check-circle"></i> Confirm Password
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="bi bi-check-circle-fill"></i>
                                </span>
                                <input id="password_confirmation" 
                                       type="password" 
                                       class="form-control" 
                                       name="password_confirmation" 
                                       placeholder="Confirm your password"
                                       required>
                            </div>
                        </div>
                        
                        
                        <div class="mb-3">
                            <label for="role" class="form-label fw-semibold">
                                <i class="bi bi-person-badge"></i> Register as
                            </label>
                            <select id="role" 
                                    name="role" 
                                    class="form-select <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    required>
                                <option value="student" selected>🎓 Student</option>
                                <option value="admin">👑 Admin (Requires Approval)</option>
                            </select>
                            <?php $__errorArgs = ['role'];
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
                            <small class="text-muted">
                                <i class="bi bi-info-circle"></i> 
                                Admin accounts require special approval
                            </small>
                        </div>
                        
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success btn-lg fw-bold">
                                <i class="bi bi-person-plus"></i> Create Account
                            </button>
                        </div>
                        
                        
                        <div class="text-center mt-3">
                            <small>
                                Already have an account? 
                                <a href="<?php echo e(route('login')); ?>" class="text-primary fw-bold">
                                    Login here
                                </a>
                            </small>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('styles'); ?>
<style>
    body {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
    }
    
    .card {
        border-radius: 20px;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        overflow: hidden;
        animation: fadeInUp 0.6s ease-out;
    }
    
    .card-header {
        background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
        color: white;
        border-bottom: none;
    }
    
    .card-header h2 {
        color: white;
        text-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }
    
    .card-header p {
        color: rgba(255,255,255,0.8);
    }
    
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
    
    .form-select {
        border-radius: 10px;
        border: 2px solid #e9ecef;
        padding: 10px 15px;
    }
    
    .form-select:focus {
        border-color: #3498db;
        box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
    }
    
    .input-group-text {
        border-radius: 10px 0 0 10px;
        border: 2px solid #e9ecef;
        border-right: none;
        background: #f8f9fa;
    }
    
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
    
    .btn-success {
        background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%);
        border: none;
    }
    
    .btn-success:hover {
        background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
    }
    
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
</style>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.guest', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\student-management-system\resources\views/auth/register.blade.php ENDPATH**/ ?>