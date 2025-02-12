<?php $__env->startSection('title', 'Online Application Form'); ?>

<?php $__env->startSection('content'); ?>
    <div class="card shadow-lg border-0 rounded-lg">
        <div class="card-body p-5">
            <h2 class="text-center mb-4">Boarding House Application</h2>

            <form action="<?php echo e(route('applications.store')); ?>" method="POST" class="needs-validation" novalidate>
                <?php echo csrf_field(); ?>

                <div class="form-floating mb-3">
                    <input type="text" name="first_name" class="form-control" id="first_name" placeholder="First Name"
                        required>
                    <label for="first_name">First Name</label>
                    <div class="invalid-feedback">Please enter your first name.</div>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" name="last_name" class="form-control" id="last_name" placeholder="Last Name"
                        required>
                    <label for="last_name">Last Name</label>
                    <div class="invalid-feedback">Please enter your last name.</div>
                </div>

                <div class="form-floating mb-3">
                    <input type="email" name="email" class="form-control" id="email" placeholder="Email" required>
                    <label for="email">Email</label>
                    <div class="invalid-feedback">Please enter a valid email address.</div>
                </div>

                <div class="form-floating mb-4">
                    <input type="text" name="referral_code" class="form-control" id="referral_code"
                        placeholder="Referral Code (Optional)">
                    <label for="referral_code">Referral Code (Optional)</label>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Submit Application</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        (function () {
            'use strict';
            var forms = document.querySelectorAll('.needs-validation');
            Array.prototype.slice.call(forms).forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        })();
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\boardinghouse\resources\views/auth/application-form.blade.php ENDPATH**/ ?>