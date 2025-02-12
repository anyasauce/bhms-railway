<?php $__env->startSection('title', 'Payments History'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <h3 class="mb-4">Payment History</h3>

    <?php if($payments->isEmpty()): ?>
        <div class="alert alert-warning" role="alert">
            No payment history available.
        </div>
    <?php else: ?>
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="card-title text-white">Payment History</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="history" class="table table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>Boarder Name</th>
                                <th>Room</th>
                                <th>Amount</th>
                                <th>Payment Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($payment->first_name); ?> <?php echo e($payment->last_name); ?></td>
                                    <td><?php echo e($payment->room_name); ?></td>
                                    <td>₱<?php echo e(number_format($payment->amount, 2)); ?></td>
                                    <td><?php echo e(\Carbon\Carbon::parse($payment->payment_date)->format('M d, Y')); ?></td>
                                    <td>
                                        <span class="badge <?php echo e($payment->status == 'paid' ? 'bg-success' : 'bg-warning'); ?>">
                                            <?php echo e(ucfirst($payment->status)); ?>

                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

    <script>
        $(document).ready(function () {
            $('#history').DataTable();
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.niceadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\boardinghouse\resources\views/history.blade.php ENDPATH**/ ?>