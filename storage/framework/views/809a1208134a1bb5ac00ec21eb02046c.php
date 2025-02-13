<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title><?php echo $__env->yieldContent('title', 'Default Title'); ?></title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link rel="icon" href="assets/img/logo.png" />

    <link href="assets/css/main.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>


</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
        <a href="/dashboard" class="logo d-flex align-items-center">
            <img src="assets/img/logo.png" alt="">
            <span class="d-none d-lg-block">BHMS Admin Panel</span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->

        <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">
            <li class="nav-item dropdown pe-3">

            <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                <img class="img-xs rounded-circle" src="assets/images/admin copy.png" style="width: 40px; height: 40px; object-fit: cover;" alt="Profile image">
                <span class="d-none d-md-block dropdown-toggle ps-2"> <?php echo e(Auth::user()->name); ?></span>
            </a><!-- End Profile Iamge Icon -->

            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                <li class="dropdown-header">
                <h6><?php echo e(Auth::user()->email); ?></h6>
                </li>
                <li>
                <hr class="dropdown-divider">
                </li>

                <li>
                <a class="dropdown-item d-flex align-items-center" href="/profile">
                    <i class="bi bi-person"></i>
                    <span>My Profile</span>
                </a>
                </li>
                <li>
                <hr class="dropdown-divider">
                </li>

                <li>
                <a class="dropdown-item d-flex align-items-center" href="<?php echo e(route('logout')); ?>">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Sign Out</span>
                </a>

                <hr class="dropdown-divider">
                </li>

            </ul><!-- End Profile Dropdown Items -->
            </li><!-- End Profile Nav -->

        </ul>
        </nav><!-- End Icons Navigation -->

    </header><!-- End Header -->

<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link" href="/dashboard" id="dashboard-link">
                <i class="bi bi-grid-fill"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <!-- Manage Boarders -->
        <li class="nav-item">
            <a class="nav-link" href="/boarders" id="manage-boarders-link">
                <i class="bi bi-person-fill"></i>
                <span>Manage Boarders</span>
            </a>
        </li><!-- End Manage Boarders Nav -->

        <!-- Manage Rooms -->
        <li class="nav-item">
            <a class="nav-link" href="/rooms" id="manage-rooms-link">
                <i class="bi bi-house-door-fill"></i>
                <span>Manage Rooms</span>
            </a>
        </li><!-- End Manage Rooms Nav -->

        <li class="nav-item">
            <a class="nav-link" href="/manage-applicants" id="manage-applicants-link">
                <i class="bi bi-person-check"></i> <!-- Icon for applicants -->
                <span>Manage Applicants</span>
            </a>
        </li><!-- End Manage Applicants Nav -->

        <!-- Payments -->
        <li class="nav-item">
            <a class="nav-link" href="/payments" id="payments-link">
                <i class="bi bi-cash-coin"></i>
                <span>Payments</span>
            </a>
        </li><!-- End Payments Nav -->

        <li class="nav-item">
            <a class="nav-link" href="/history" id="payments-history-link">
                <i class="bi bi-wallet2"></i> <!-- Changed to a wallet icon -->
                <span>Payments History</span>
            </a>
        </li><!-- End Payments History Nav -->

    </ul>
</aside><!-- End Sidebar -->

<script>
    const currentPath = window.location.pathname;

    function setActiveLink() {
        const allLinks = document.querySelectorAll('.nav-link');

        allLinks.forEach(link => {
            if (link.href.includes(currentPath)) {
                link.classList.add('active');
                link.classList.remove('collapsed');
            } else {
                link.classList.remove('active');
                link.classList.add('collapsed');
            }
        });
    }

    setActiveLink();
</script>


    <main id="main" class="main">

    <div class="pagetitle">
        <h1>Boarding House Admin Panel</h1>
    </div>

    <section class="section dashboard">
        <div class="row">

            <?php echo $__env->yieldContent('content'); ?>

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

        </div>
    </section>


    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="copyright">
        &copy; <strong><span>Josiah Danielle Gallenero</span></strong>. All Rights Reserved
        </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
    <!-- Vendor JS Files -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\boardinghouse\resources\views\layouts\niceadmin.blade.php ENDPATH**/ ?>