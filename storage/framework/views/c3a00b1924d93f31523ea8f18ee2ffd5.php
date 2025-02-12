<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Default Title'); ?></title>
    <link href="<?php echo e(asset('assets/vendor/google-font/google-fonts.css')); ?>" rel="stylesheet">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <link href="<?php echo e(asset('assets/vendor/bootstrap/css/bootstrap.min.css')); ?>" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="<?php echo e(asset('assets/vendor/google-font/google-fonts.css')); ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/style.css')); ?>">
</head>

<body>
    <?php if(session('success-delete')): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: '<?php echo e(session("success-delete")); ?>',
                showConfirmButton: false,
                timer: 4000
            });
        </script>
    <?php endif; ?>

    <?php if(session('success')): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: '<?php echo e(session("success")); ?>',
                showConfirmButton: false,
                timer: 4000
            });
        </script>
    <?php elseif(session('error')): ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: '<?php echo e(session("error")); ?>',
                showConfirmButton: false,
                timer: 4000
            });
        </script>
    <?php endif; ?>

    <?php echo $__env->yieldContent('content'); ?>

    <script src="<?php echo e(asset('assets/js/script.js')); ?>"></script>
</body>

</html>
<?php /**PATH C:\xampp\htdocs\boardinghouse\resources\views/layouts/auth.blade.php ENDPATH**/ ?>