<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Default Title')</title>
    <link href="{{ asset('assets/vendor/google-font/google-fonts.css') }}" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="{{ asset('assets/vendor/google-font/google-fonts.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>

<body>
    @if(session('success-delete'))
        <script>
            Swal.fire({
                icon: 'success',
                title: '{{ session("success-delete") }}',
                showConfirmButton: false,
                timer: 4000
            });
        </script>
    @endif

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

    @yield('content')

    <script src="{{ asset('assets/js/script.js') }}"></script>
</body>

</html>
