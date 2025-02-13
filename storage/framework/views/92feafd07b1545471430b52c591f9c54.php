<?php $__env->startSection('title', 'Refer & Earn Discounts'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <div class="card shadow-lg border-0 rounded-lg">
        <div class="card-header bg-primary text-white text-center">
            <h4>Refer & Earn Discounts!</h4>
        </div>

        <div class="card-body">
            <div class="row text-center mt-4">
                <div class="col-md-4">
                    <h5 class="text-muted">Your Referral Code:</h5>
                    <h3 class="text-success font-weight-bold"><?php echo e($referralCode); ?></h3>
                </div>
                <div class="col-md-4">
                    <h5 class="text-muted">Total People Referred:</h5>
                    <h3 class="text-primary font-weight-bold"><?php echo e($totalReferrals); ?></h3>
                </div>
                <div class="col-md-4">
                    <h5 class="text-muted">Your Earned Points:</h5>
                    <h3 class="text-warning font-weight-bold"><?php echo e($totalPoints); ?></h3>
                </div>
            </div>

            <hr>

            <div class="mt-4">
                <h5 class="text-center">People You Referred:</h5>
                <?php if($referredPeople->isEmpty()): ?>
                    <p class="text-muted text-center">No referrals yet. Start referring friends to earn rewards!</p>
                <?php else: ?>
                    <ul class="list-group mt-4">
                        <?php $__currentLoopData = $referredPeople; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $referral): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center mb-3">
                                <strong><?php echo e($referral->application->first_name); ?> <?php echo e($referral->application->last_name); ?></strong>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                <?php endif; ?>
            </div>

            <hr>

            <!-- Redeem Discount Section -->
            <div class="mt-4= text-center">
                <h5>Redeem Your Points for Discounts:</h5>
                <?php
                    $discounts = [
                        60 => 500,
                        50 => 400,
                        40 => 300,
                        20 => 200,
                        10 => 100
                    ];

                    $availableDiscount = 0;
                    foreach ($discounts as $points => $discount) {
                        if ($totalPoints >= $points) {
                            $availableDiscount = $discount;
                            break;
                        }
                    }
                ?>

                <?php if($availableDiscount > 0): ?>
                    <h4 class="text-success">You can redeem ₱<?php echo e($availableDiscount); ?> off your next payment!</h4>
                    <form action="<?php echo e(route('redeem.discount')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="discount" value="<?php echo e($availableDiscount); ?>">
                        <button type="submit" class="btn btn-primary mt-3">Redeem Now</button>
                    </form>
                <?php else: ?>
                    <p class="text-muted">Earn more points to unlock discounts!</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.boarderportal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\boardinghouse\resources\views\boarders\referral.blade.php ENDPATH**/ ?>