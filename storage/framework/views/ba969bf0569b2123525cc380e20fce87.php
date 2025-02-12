<?php $__env->startSection('title', 'Online Payment'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mt-5">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-primary text-white">
            <h4><i class="fas fa-credit-card"></i> Online Payment</h4>
        </div>
        <div class="card-body">
            <?php if($payments->isEmpty()): ?>
                <div class="alert alert-info mt-4">
                    <h5 class="text-center text-primary">No upcoming payment.</h5>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>Payment ID</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($payment->id); ?></td>
                                    <td><strong>₱<?php echo e(number_format($payment->amount, 2)); ?></strong></td>
                                    <td>
                                        <?php if($payment->status == 'pending'): ?>
                                            <span class="badge bg-warning">Pending</span>
                                        <?php elseif($payment->status == 'paid'): ?>
                                            <span class="badge bg-success">Paid</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e($payment->created_at->format('Y-m-d')); ?></td>
                                    <td>
                                        <?php if($payment->status == 'pending'): ?>
                                            <a href="<?php echo e(route('payment.pay', $payment->id)); ?>" class="btn btn-success btn-sm"
                                                data-toggle="tooltip" data-placement="top" title="Proceed with payment">
                                                <i class="fas fa-money-check-alt"></i> Pay Online
                                            </a>
                                        <?php else: ?>
                                            <button class="btn btn-secondary btn-sm" disabled>
                                                <i class="fas fa-check-circle"></i> Paid
                                            </button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="card mt-4 shadow-lg border-0">
        <div class="card-header bg-secondary text-white">
            <h4><i class="fas fa-history"></i> Recent Transactions</h4>
        </div>
        <div class="card-body">
            <?php if($transactions->isEmpty()): ?>
                <div class="alert alert-light text-center">
                    <h5 class="text-muted">No recent transactions found.</h5>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th>Transaction ID</th>
                                <th>Type</th>
                                <th>Amount</th>
                                <th>Description</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($transaction->id); ?></td>
                                    <td><?php echo e(ucfirst($transaction->type)); ?></td>
                                    <td><strong>₱<?php echo e(number_format($transaction->amount, 2)); ?></strong></td>
                                    <td><?php echo e($transaction->description); ?></td>
                                    <td><?php echo e($transaction->created_at->format('Y-m-d h:i A')); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Tooltips Initialization -->
<script>
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.boarderportal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\boardinghouse\resources\views/boarders/online-payment.blade.php ENDPATH**/ ?>