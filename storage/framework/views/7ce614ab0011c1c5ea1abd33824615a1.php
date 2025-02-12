<?php $__env->startSection('title', 'Manage Applicants'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4 class="card-title text-white">Applicants List</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="applicant" class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Referral Code</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $applications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $applicant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($index + 1); ?></td>
                                <td><?php echo e($applicant->first_name); ?> <?php echo e($applicant->last_name); ?></td>
                                <td><?php echo e($applicant->email); ?></td>
                                <td><?php echo e($applicant->referral_code ?? 'N/A'); ?></td>
                                <td>
                                    <span class="badge
                                        <?php echo e($applicant->status == 'pending' ? 'bg-warning' : 'bg-success'); ?>">
                                        <?php echo e(ucfirst($applicant->status)); ?>

                                    </span>
                                </td>
                                <td>
                                    <form action="<?php echo e(route('update.applicant.status', $applicant->id)); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PUT'); ?>
                                        <select name="status" class="form-select" onchange="this.form.submit()">
                                            <option value="pending" <?php echo e($applicant->status == 'pending' ? 'selected' : ''); ?>>Pending</option>
                                            <option value="approved" <?php echo e($applicant->status == 'approved' ? 'selected' : ''); ?>>Approved</option>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

    <script>
        $(document).ready(function () {
            $('#applicant').DataTable();
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.niceadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\boardinghouse\resources\views/applicants/index.blade.php ENDPATH**/ ?>