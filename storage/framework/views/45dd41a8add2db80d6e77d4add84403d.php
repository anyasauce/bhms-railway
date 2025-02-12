<?php $__env->startSection('title', 'Login Authentication'); ?>
<?php $__env->startSection('content'); ?>
<div class="card shadow-lg border-0 rounded-lg">
    <div class="card-body p-5">
        <form action="<?php echo e(route('login')); ?>" method="POST" id="login-form" class="needs-validation" novalidate>
            <h3 class="card-title mb-4 text-center">Welcome Back</h3>
            <?php echo csrf_field(); ?>
            <div class="form-floating mb-3">
                <input type="email" class="form-control" id="login-email" placeholder="Enter your email" name="email"
                    required>
                <label for="login-email">Email Address</label>
                <div class="invalid-feedback">
                    Please enter a valid email address.
                </div>
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="login-password" placeholder="Enter your password"
                    name="password" required>
                <label for="login-password">Password</label>
                <div class="invalid-feedback">
                    Please enter your password.
                </div>
                <div class="form-check form-switch mt-2">
                    <input class="form-check-input" type="checkbox" onclick="showPass()" id="showPassword">
                    <label class="form-check-label" for="showPassword">Show Password</label>
                </div>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Login</button>
            </div>
        </form>

        <!-- Google Login Button -->
        <div class="d-flex justify-content-center mt-3">
            <a href="<?php echo e(url('login/google')); ?>" class="btn btn-outline-danger d-flex align-items-center">
                <img src="<?php echo e(asset('assets/images/google.png')); ?>" alt="Google Icon" class="me-2"
                    style="width: 20px; height: 20px;">
                <span class="ms-2">Login with Google</span>
            </a>
        </div>

        <div class="text-center mt-3">
            <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#forgotPasswordModal">
                Forgot Password?
            </button>
        </div>
    </div>
</div>



<!-- Forgot Password Modal -->
<div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="forgotPasswordModalLabel">Reset Your Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="forgot-password-form" method="POST" action="<?php echo e(route('forgot.password')); ?>"
                    class="needs-validation" novalidate>
                    <?php echo csrf_field(); ?>
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" placeholder="Enter your email" id="email" name="email"
                            required>
                        <label for="email">Enter your email address</label>
                        <div class="invalid-feedback">
                            Please enter a valid email address.
                        </div>
                    </div>
                    <div class="d-grid mt-3">
                        <button type="submit" class="btn btn-primary">Send Reset Link</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function showPass() {
        var x = document.getElementById("login-password");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }

    (function () {
        'use strict'

        var forms = document.querySelectorAll('.needs-validation')

        Array.prototype.slice.call(forms)
            .forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
    })()
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\boardinghouse\resources\views/auth/login.blade.php ENDPATH**/ ?>