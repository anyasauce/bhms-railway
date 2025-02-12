<?php $__env->startSection('title', 'Profile'); ?>

<?php $__env->startSection('content'); ?>
<!-- Left side columns -->
<div class="col-lg-12">
    <div class="row">
        <div class="card">
            <div class="card-header">Update Profile Admin</div>

            <?php if(Auth::check()): ?>
                <div class="container mt-3" style="font-family: 'Poppins', sans-serif;">
                    <br>
                    <form action="<?php echo e(route('updateAdminProfile')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="container">
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="name" class="form-label"><strong>Admin Name</strong></label>
                                    <input type="text" class="form-control" id="name" name="name" required placeholder="Enter Admin Name"
                                        value="<?php echo e(Auth::user()->name); ?>">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="admin_email" class="form-label"><strong>Admin Email</strong></label>
                                    <input type="email" class="form-control" id="admin_email" name="email" required
                                        placeholder="Enter Admin Email" value="<?php echo e(Auth::user()->email); ?>">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="admin_password" class="form-label"><strong>Admin Password</strong></label>
                                    <input type="password" class="form-control" id="admin_password" name="password" placeholder="Enter New Admin Password">
                                </div>
                            </div>
                            <div class="form-check form-switch mt-2 mb-3">
                                <input class="form-check-input" type="checkbox" onclick="showPass()" id="showPassword">
                                <label class="form-check-label" for="showPassword">Show Password</label>
                            </div>
                            <div class="mb-3">
                                <button type="submit" style="color:white;" class="btn btn-primary"
                                    name="update_official">Update your Profile</button>
                            </div>
                        </div>
                    </form>
                </div>
            <?php else: ?>
                <div class='container mt-5'>
                    <div class='alert alert-danger'>Admin profile not found.</div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div><!-- End Left side columns -->

<script>
    function showPass() {
        var x = document.getElementById("admin_password");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.niceadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\boardinghouse\resources\views/profile.blade.php ENDPATH**/ ?>