

<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>

<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">📊 Dashboard</h4>
            </div>
            <div class="card-body">
                <p>Welcome back, <strong><?php echo e(Auth::user()->name); ?></strong>!</p>
                <p class="text-muted">
                    Role: 
                    <span class="badge <?php echo e(Auth::user()->role == 'admin' ? 'badge-admin' : 'badge-student'); ?>">
                        <?php echo e(ucfirst(Auth::user()->role)); ?>

                    </span>
                </p>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h6 class="card-title text-uppercase">Total Students</h6>
                <h2 class="card-text display-4"><?php echo e($totalStudents ?? 0); ?></h2>
                <small>All students in system</small>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h6 class="card-title text-uppercase">Active Students</h6>
                <h2 class="card-text display-4"><?php echo e($activeStudents ?? 0); ?></h2>
                <small>Currently active</small>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <h6 class="card-title text-uppercase">Inactive Students</h6>
                <h2 class="card-text display-4"><?php echo e($inactiveStudents ?? 0); ?></h2>
                <small>Currently inactive</small>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card text-white bg-secondary">
            <div class="card-body">
                <h6 class="card-title text-uppercase">Graduated</h6>
                <h2 class="card-text display-4"><?php echo e($graduatedStudents ?? 0); ?></h2>
                <small>Graduated students</small>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <h6 class="card-title text-uppercase">Total Courses</h6>
                <h2 class="card-text display-4"><?php echo e($totalCourses ?? 0); ?></h2>
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
                <?php if(isset($latestStudents) && $latestStudents->count() > 0): ?>
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
                                <?php $__currentLoopData = $latestStudents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($index + 1); ?></td>
                                        <td><?php echo e($student->full_name); ?></td>
                                        <td><?php echo e($student->email); ?></td>
                                        <td><?php echo e($student->course); ?></td>
                                        <td>
                                            <span class="status-<?php echo e(strtolower($student->status)); ?>">
                                                <?php echo e($student->status); ?>

                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-muted text-center">No students registered yet.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php if($isAdmin ?? false): ?>
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card border-primary">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">🔐 Admin Panel</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <a href="<?php echo e(route('students.index')); ?>" class="btn btn-primary btn-lg w-100">
                            <i class="bi bi-list-ul"></i> Manage Students
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="<?php echo e(route('students.trashed')); ?>" class="btn btn-warning btn-lg w-100 text-white">
                            <i class="bi bi-trash"></i> View Trash
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="<?php echo e(route('students.create')); ?>" class="btn btn-success btn-lg w-100">
                            <i class="bi bi-plus-circle"></i> Add Student
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body text-center text-muted">
                <small>
                    <i class="bi bi-database"></i> 
                    System Statistics: 
                    <span class="fw-bold"><?php echo e($totalStudents ?? 0); ?></span> Total Students | 
                    <span class="fw-bold text-success"><?php echo e($activeStudents ?? 0); ?></span> Active | 
                    <span class="fw-bold text-warning"><?php echo e($inactiveStudents ?? 0); ?></span> Inactive | 
                    <span class="fw-bold text-secondary"><?php echo e($graduatedStudents ?? 0); ?></span> Graduated |
                    <span class="fw-bold text-info"><?php echo e($totalCourses ?? 0); ?></span> Courses
                </small>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\student-management-system\resources\views/dashboard.blade.php ENDPATH**/ ?>