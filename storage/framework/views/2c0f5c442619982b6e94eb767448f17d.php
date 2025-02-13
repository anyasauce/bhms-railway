<?php $__env->startSection('title', 'Payments'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <?php if($payments->isEmpty()): ?>
        <div class="alert alert-warning" role="alert">
            No payment available.
        </div>
    <?php else: ?>
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="card-title text-white">Pending Payment</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="payment" class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Boarder Name</th>
                                <th>Room Name</th>
                                <th>Amount</th>
                                <th>Partial Amount</th>
                                <th>Balance</th>
                                <th>Due Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($payment->first_name . " " . $payment->last_name); ?></td>
                                    <td><?php echo e($payment->room_name); ?></td>
                                    <td>₱<?php echo e($payment->amount); ?></td>
                                    <td>₱<?php echo e($payment->partial_amount); ?></td>
                                    <td>₱<?php echo e($payment->amount - $payment->partial_amount); ?></td>
                                    <td><?php echo e($payment->payment_due_date); ?></td>
                                    <td>
                                        <?php if($payment->status == 'pending'): ?>
                                            <span class="badge bg-warning">Pending</span>
                                        <?php elseif($payment->status == 'partial'): ?>
                                            <span class="badge bg-warning">Partial</span>
                                        <?php elseif($payment->status == 'paid'): ?>
                                            <span class="badge bg-success">Paid</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-info text-white" data-bs-toggle="modal"
                                            data-bs-target="#paymentModal<?php echo e($payment->id); ?>"><i class="bi bi-eye"></i></button>

                                        <!-- Modal for payment details -->
                                        <div class="modal fade" id="paymentModal<?php echo e($payment->id); ?>" tabindex="-1" aria-labelledby="paymentModalLabel<?php echo e($payment->id); ?>" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="paymentModalLabel<?php echo e($payment->id); ?>">Payment Details</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p><strong>Name:</strong> <?php echo e($payment->name); ?></p>
                                                        <p><strong>Room Name:</strong> <?php echo e($payment->room_name); ?></p>
                                                        <p><strong>Amount:</strong> ₱<?php echo e($payment->amount); ?></p>
                                                        <p><strong>Description:</strong> <?php echo e($payment->description ?? 'N/A'); ?></p>
                                                        <p><strong>Payment Due Date:</strong> <?php echo e($payment->payment_due_date); ?></p>
                                                        <p><strong>Status:</strong> <?php echo e(ucfirst($payment->status)); ?></p>
                                                        <p><strong>Created At:</strong> <?php echo e($payment->created_at); ?></p>
                                                        <p><strong>Updated At:</strong> <?php echo e($payment->updated_at); ?></p>

                                                        <?php if(in_array($payment->status, ['pending', 'partial'])): ?>
                                                            <div class="mb-3">
                                                                <form action="<?php echo e(route('payments.partialPayment', $payment->id)); ?>" method="POST">
                                                                <label for="partialAmount" class="form-label">Enter Partial Payment Amount</label>
                                                                <input type="number" name="partialAmount" class="form-control" placeholder="₱" min="0" max="<?php echo e($payment->amount); ?>"
                                                                    required>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="modal-footer">
                                                            <?php echo csrf_field(); ?>
                                                            <input type="hidden" name="payment_id" value="<?php echo e($payment->id); ?>">

                                                            <button type="submit" class="btn btn-success">Submit Partial Payment</button>
                                                        </form>

                                                        <form action="<?php echo e(route('payments.destroy', $payment->id)); ?>" method="POST" style="display:inline;">
                                                            <?php echo csrf_field(); ?>
                                                            <?php echo method_field('DELETE'); ?>
                                                            <button type="submit" class="btn btn-danger">Delete</button>
                                                        </form>
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

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
            $('#payment').DataTable();
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.niceadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\boardinghouse\resources\views\payments\index.blade.php ENDPATH**/ ?>