<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>@yield('title', 'Default Title')</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link rel="icon" href="{{ asset('assets/img/logo.png') }}" />

    <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>


</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
        <a href="/boarderdashboard" class="logo d-flex align-items-center">
            <img src="assets/img/logo.png" alt="">
            <span class="d-none d-lg-block">Boarder's Portal</span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->

        <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">
            <li class="nav-item dropdown pe-3">

            <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                <img class="img-xs rounded-circle" src="{{ asset('assets/images/user.png') }}"
                    style="width: 40px; height: 40px; object-fit: cover;" alt="Profile image">
                <span class="d-none d-md-block dropdown-toggle ps-2"> {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</span>
            </a><!-- End Profile Iamge Icon -->

            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                <li class="dropdown-header">
                <h6>{{ Auth::user()->email }}</h6>
                </li>
                <li>
                <hr class="dropdown-divider">
                </li>

                <li>
                <a class="dropdown-item d-flex align-items-center" href="/boarders/profile">
                    <i class="bi bi-person"></i>
                    <span>My Profile</span>
                </a>
                </li>
                <li>
                <hr class="dropdown-divider">
                </li>

                <li>
                <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}">
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
        <!-- Dashboard with Balance Display -->
        <li class="nav-item">
            <a class="nav-link" href="/boarderdashboard" id="dashboard-link">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
                <span class="badge bg-danger" id="balance-amount"></span> <!-- Placeholder balance -->
            </a>
        </li><!-- End Dashboard Nav -->

        <!-- Online Payment -->
        <li class="nav-item">
            <a class="nav-link" href="/online-payment" id="online-payment-link">
                <i class="bi bi-credit-card-fill"></i>
                <span>Online Payment</span>
            </a>
        </li><!-- End Online Payment Nav -->

        <!-- Referral -->
        <li class="nav-item">
            <a class="nav-link" href="/referral" id="referral-link">
                <i class="bi bi-people-fill"></i>
                <span>Referral</span>
            </a>
        </li><!-- End Referral Nav -->

        <!-- Document Uploads -->
        <li class="nav-item">
            <a class="nav-link" href="/documents" id="document-uploads-link">
                <i class="bi bi-file-earmark-arrow-up-fill"></i>
                <span>Document Uploads</span>
            </a>
        </li><!-- End Document Uploads Nav -->

        <!-- Payment History & Receipts -->
        <li class="nav-item">
            <a class="nav-link" href="/boarder-payments-history" id="payments-history-link">
                <i class="bi bi-receipt-cutoff"></i>
                <span>Payment History & Receipts</span>
            </a>
        </li><!-- End Payments History & Receipts Nav -->

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
        <h1>Boarder's Portal</h1>
    </div>

    <section class="section dashboard">
        <div class="row">

            @yield('content')

            @if(session('success'))
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: '{{ session("success") }}',
                        showConfirmButton: false,
                        timer: 4000
                    });
                </script>
            @elseif(session('error'))
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: '{{ session("error") }}',
                        showConfirmButton: false,
                        timer: 4000
                    });
                </script>
            @endif

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
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>

</body>
</html>
