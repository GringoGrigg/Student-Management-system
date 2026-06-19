

<?php $__env->startSection('title', 'Student List'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">📋 Student List</h4>
        <a href="<?php echo e(route('students.create')); ?>" class="btn btn-success btn-sm">
            <i class="bi bi-plus-circle"></i> Add New Student
        </a>
    </div>
    <div class="card-body">
        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle"></i> <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle"></i> <?php echo e(session('error')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Search and Filter Section -->
        <form method="GET" action="<?php echo e(route('students.index')); ?>" class="mb-4">
            <div class="row g-3">
                <div class="col-md-4">
                    <input type="text" 
                           name="search" 
                           class="form-control" 
                           placeholder="🔍 Search by name or email..."
                           value="<?php echo e(request('search')); ?>">
                </div>
                <div class="col-md-3">
                    <select name="course" class="form-select">
                        <option value="">All Courses</option>
                        <?php if(isset($courses)): ?>
                            <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($course); ?>" <?php echo e(request('course') == $course ? 'selected' : ''); ?>>
                                    <?php echo e($course); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="Active" <?php echo e(request('status') == 'Active' ? 'selected' : ''); ?>>Active</option>
                        <option value="Inactive" <?php echo e(request('status') == 'Inactive' ? 'selected' : ''); ?>>Inactive</option>
                        <option value="Graduated" <?php echo e(request('status') == 'Graduated' ? 'selected' : ''); ?>>Graduated</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
                </div>
            </div>
            <?php if(request()->hasAny(['search', 'course', 'status'])): ?>
                <div class="mt-2">
                    <a href="<?php echo e(route('students.index')); ?>" class="btn btn-secondary btn-sm">Clear Filters</a>
                    <span class="text-muted ms-2">
                        Showing <?php echo e($students->total()); ?> results
                    </span>
                </div>
            <?php endif; ?>
        </form>

        <?php if(isset($students) && $students->count() > 0): ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Photo</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Course</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($students->firstItem() + $loop->index); ?></td>
                                <td>
                                    <img src="<?php echo e($student->photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($student->full_name) . '&size=50'); ?>" 
                                         alt="Photo" 
                                         class="profile-photo">
                                </td>
                                <td><?php echo e($student->full_name); ?></td>
                                <td><?php echo e($student->email); ?></td>
                                <td><?php echo e($student->phone ?? '-'); ?></td>
                                <td><?php echo e($student->course); ?></td>
                                <td>
                                    <span class="status-<?php echo e(strtolower($student->status)); ?>">
                                        <?php echo e($student->status); ?>

                                    </span>
                                </td>
                                <td>
                                    <a href="<?php echo e(route('students.show', $student)); ?>" 
                                       class="btn btn-primary btn-sm">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="<?php echo e(route('students.edit', $student)); ?>" 
                                       class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="<?php echo e(route('students.destroy', $student)); ?>" 
                                          method="POST" 
                                          style="display: inline-block;"
                                          onsubmit="return confirm('Are you sure you want to delete this student?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-3">
                <?php echo e($students->links()); ?>

            </div>
        <?php else: ?>
            <div class="text-center py-4">
                <p class="text-muted">No students found matching your criteria.</p>
                <a href="<?php echo e(route('students.create')); ?>" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Add Your First Student
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\student-management-system\resources\views/students/index.blade.php ENDPATH**/ ?>