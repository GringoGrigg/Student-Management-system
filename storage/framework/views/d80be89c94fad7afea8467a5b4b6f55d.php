<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    
    <title><?php echo $__env->yieldContent('title', 'Student Management System'); ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <style>
        /* ============================================
           GLOBAL STYLES
           ============================================ */
        
        /* Body styling with light background */
        body { 
            padding-top: 20px; 
            background: #f0f2f5; 
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        /* Container max width for better readability */
        .container { max-width: 1200px; }
        
        /* ============================================
           CARD STYLES
           ============================================ */
        .card { 
            margin-bottom: 20px; 
            border-radius: 12px; 
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            border: none;
        }
        
        .card-header { 
            background: #2c3e50; 
            color: white; 
            border-radius: 12px 12px 0 0 !important;
            padding: 15px 20px;
            font-weight: 600;
        }
        
        .card-body {
            padding: 20px;
        }
        
        /* ============================================
           BUTTON STYLES
           ============================================ */
        .btn-primary { background: #3498db; border: none; }
        .btn-primary:hover { background: #2980b9; }
        
        .btn-danger { background: #e74c3c; border: none; }
        .btn-danger:hover { background: #c0392b; }
        
        .btn-success { background: #2ecc71; border: none; }
        .btn-success:hover { background: #27ae60; }
        
        .btn-warning { background: #f39c12; border: none; color: white; }
        .btn-warning:hover { background: #e67e22; color: white; }
        
        .btn-secondary { background: #95a5a6; border: none; }
        .btn-secondary:hover { background: #7f8c8d; }
        
        /* ============================================
           TABLE STYLES
           ============================================ */
        .table th { 
            background: #34495e; 
            color: white;
            font-weight: 500;
            padding: 12px;
            vertical-align: middle;
        }
        
        .table td {
            padding: 12px;
            vertical-align: middle;
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
           NAVBAR STYLES
           ============================================ */
        .navbar-custom { 
            background: #2c3e50; 
            padding: 12px 0; 
            margin-bottom: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }
        
        .navbar-custom .navbar-brand { 
            color: white !important; 
            font-weight: bold; 
            font-size: 24px; 
        }
        
        .navbar-custom .navbar-brand:hover {
            color: #3498db !important;
        }
        
        .navbar-custom .nav-link { 
            color: rgba(255,255,255,0.8) !important;
            font-weight: 500;
            padding: 8px 16px;
            border-radius: 6px;
            transition: all 0.3s ease;
        }
        
        .navbar-custom .nav-link:hover { 
            color: white !important;
            background: rgba(255,255,255,0.1);
        }
        
        .navbar-custom .nav-link.active { 
            color: white !important; 
            font-weight: bold;
            background: rgba(255,255,255,0.15);
        }
        
        .navbar-custom .dropdown-toggle {
            color: white !important;
        }
        
        .navbar-custom .dropdown-toggle:hover {
            color: white !important;
        }
        
        /* ============================================
           DROPDOWN STYLES
           ============================================ */
        .dropdown-menu {
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            border: none;
            padding: 8px;
        }
        
        .dropdown-item {
            border-radius: 6px;
            padding: 8px 16px;
            transition: all 0.2s ease;
        }
        
        .dropdown-item:hover {
            background: #f0f2f5;
        }
        
        .dropdown-item.text-danger:hover {
            background: #fde8e8;
        }
        
        /* ============================================
           ROLE BADGES
           ============================================ */
        .badge-admin {
            background: #e74c3c;
            color: white;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 11px;
        }
        
        .badge-student {
            background: #3498db;
            color: white;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 11px;
        }
        
        /* ============================================
           ALERT STYLES
           ============================================ */
        .alert {
            border-radius: 8px;
            border: none;
        }
        
        /* ============================================
           FORM STYLES
           ============================================ */
        .form-control:focus, .form-select:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        }
        
        /* ============================================
           PROFILE PHOTO STYLES
           ============================================ */
        .profile-photo {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #3498db;
        }
        
        .profile-photo-large {
            width: 200px;
            height: 200px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid #3498db;
        }
        
        /* ============================================
           ONLINE STATUS INDICATOR
           ============================================ */
        .online-indicator {
            width: 16px;
            height: 16px;
            background: #2ecc71;
            border-radius: 50%;
            display: inline-block;
            border: 2px solid white;
            box-shadow: 0 0 10px rgba(46, 204, 113, 0.5);
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(46, 204, 113, 0.4);
            }
            70% {
                box-shadow: 0 0 0 10px rgba(46, 204, 113, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(46, 204, 113, 0);
            }
        }
        
        /* ============================================
           MOBILE TOGGLE BUTTON
           ============================================ */
        .navbar-toggler {
            border-color: rgba(255,255,255,0.5);
        }
        
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(255,255,255,0.8)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }
        
        /* ============================================
           RESPONSIVE STYLES
           ============================================ */
        @media (max-width: 768px) {
            .navbar-custom .navbar-brand {
                font-size: 18px;
            }
            
            .navbar-custom .nav-link {
                padding: 6px 12px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- ==========================================
        NAVIGATION BAR
        ========================================== -->
        <nav class="navbar navbar-expand-lg navbar-custom">
            <div class="container-fluid">
                <!-- Brand/Logo -->
                <a class="navbar-brand" href="<?php echo e(route('dashboard')); ?>">
                    🎓 Student Management System
                </a>
                
                <!-- Mobile Toggle Button -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <!-- Navigation Links -->
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        
                        <!-- ==========================================
                        AUTHENTICATED USER NAVIGATION
                        Shows when user is logged in
                        ========================================== -->
                        <?php if(auth()->guard()->check()): ?>
                            
                            <!-- ==========================================
                            ADMIN NAVIGATION LINKS
                            Only visible to admin users
                            ========================================== -->
                            <?php if(Auth::user()->isAdmin()): ?>
                                <!-- Dashboard Link -->
                                <li class="nav-item">
                                    <a class="nav-link <?php echo e(request()->routeIs('dashboard') ? 'active' : ''); ?>" 
                                       href="<?php echo e(route('dashboard')); ?>">
                                        <i class="bi bi-speedometer2"></i> Dashboard
                                    </a>
                                </li>
                                
                                <!-- Students List Link -->
                                <li class="nav-item">
                                    <a class="nav-link <?php echo e(request()->routeIs('students.index') ? 'active' : ''); ?>" 
                                       href="<?php echo e(route('students.index')); ?>">
                                        <i class="bi bi-list-ul"></i> Students
                                    </a>
                                </li>
                                
                                <!-- Trash Link -->
                                <li class="nav-item">
                                    <a class="nav-link <?php echo e(request()->routeIs('students.trashed') ? 'active' : ''); ?>" 
                                       href="<?php echo e(route('students.trashed')); ?>">
                                        <i class="bi bi-trash"></i> Trash
                                    </a>
                                </li>
                                
                                <!-- Add Student Link -->
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo e(route('students.create')); ?>">
                                        <i class="bi bi-plus-circle"></i> Add Student
                                    </a>
                                </li>
                            
                            <!-- ==========================================
                            STUDENT NAVIGATION LINKS
                            Only visible to student users
                            ========================================== -->
                            <?php else: ?>
                                <!-- My Profile Link -->
                                <?php if(Auth::user()->student): ?>
                                    <li class="nav-item">
                                        <a class="nav-link <?php echo e(request()->routeIs('students.show') ? 'active' : ''); ?>" 
                                           href="<?php echo e(route('students.show', Auth::user()->student->id)); ?>">
                                            <i class="bi bi-person-circle"></i> My Profile
                                        </a>
                                    </li>
                                <?php endif; ?>
                            <?php endif; ?>
                            
                            <!-- ==========================================
                            USER DROPDOWN WITH LOGOUT
                            Shows for both Admin and Student roles
                            ========================================== -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-person-circle"></i> 
                                    <?php echo e(Auth::user()->name); ?>

                                    
                                    <!-- Role Badge with Icon -->
                                    <?php if(Auth::user()->isAdmin()): ?>
                                        <span class="badge badge-admin">
                                            <i class="bi bi-shield-fill-check"></i> Admin
                                        </span>
                                    <?php else: ?>
                                        <span class="badge badge-student">
                                            <i class="bi bi-mortarboard-fill"></i> Student
                                        </span>
                                    <?php endif; ?>
                                    
                                    <!-- Online Status Indicator (Green Dot) -->
                                    <span class="online-indicator ms-1"></span>
                                </a>
                                
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <!-- Dashboard Link (Admin) -->
                                    <?php if(Auth::user()->isAdmin()): ?>
                                        <li>
                                            <a class="dropdown-item" href="<?php echo e(route('dashboard')); ?>">
                                                <i class="bi bi-speedometer2"></i> Dashboard
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    
                                    <!-- My Profile Link (Student) -->
                                    <?php if(Auth::user()->isStudent() && Auth::user()->student): ?>
                                        <li>
                                            <a class="dropdown-item" href="<?php echo e(route('students.show', Auth::user()->student->id)); ?>">
                                                <i class="bi bi-person"></i> My Profile
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    
                                    <!-- Admin can also access student list from dropdown -->
                                    <?php if(Auth::user()->isAdmin()): ?>
                                        <li>
                                            <a class="dropdown-item" href="<?php echo e(route('students.index')); ?>">
                                                <i class="bi bi-list-ul"></i> All Students
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    
                                    <li><hr class="dropdown-divider"></li>
                                    
                                    <!-- ==========================================
                                    LOGOUT BUTTON
                                    ========================================== -->
                                    <li>
                                        <form method="POST" action="<?php echo e(route('logout')); ?>">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="bi bi-box-arrow-right"></i> Logout
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        
                        <!-- ==========================================
                        GUEST NAVIGATION (Not Logged In)
                        Shows when user is NOT authenticated
                        ========================================== -->
                        <?php else: ?>
                            <!-- Login Link -->
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo e(route('login')); ?>">
                                    <i class="bi bi-box-arrow-in-right"></i> Login
                                </a>
                            </li>
                            
                            <!-- Register Link -->
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo e(route('register')); ?>">
                                    <i class="bi bi-person-plus"></i> Register
                                </a>
                            </li>
                        <?php endif; ?>
                        
                    </ul>
                </div>
            </div>
        </nav>
        
        <!-- ==========================================
        PAGE CONTENT
        Child views will be inserted here
        ========================================== -->
        <?php echo $__env->yieldContent('content'); ?>
    </div>
    
    <!-- ==========================================
    JAVASCRIPT
    Bootstrap JavaScript for interactive components
    ========================================== -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Additional scripts from child views -->
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH C:\xampp\htdocs\student-management-system\resources\views/layouts/app.blade.php ENDPATH**/ ?>