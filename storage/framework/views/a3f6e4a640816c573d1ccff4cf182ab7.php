<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="<?php echo e(asset('assets/vendor/google-font/google-fonts.css')); ?>" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            transition: background-color 0.3s, color 0.3s;
        }
    </style>
</head>
<body class="bg-white text-gray-900 dark:bg-gray-900 dark:text-gray-100">
    <main class="grid min-h-screen place-items-center px-6 py-24 sm:py-32 lg:px-8">
        <div class="text-center">
            <p class="text-base font-semibold text-indigo-600 dark:text-indigo-400">404</p>
            <h1 class="mt-4 text-5xl font-semibold tracking-tight text-gray-900 dark:text-gray-100 sm:text-7xl">Page not found</h1>
            <p class="mt-6 text-lg font-medium text-gray-500 dark:text-gray-400 sm:text-xl">
                Sorry, we couldn’t find the page you’re looking for.
            </p>
            <div class="mt-10 flex items-center justify-center gap-x-6">
                <a href="/" class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Go back home</a>
            </div>
        </div>
    </main>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\boardinghouse\resources\views\errors\404.blade.php ENDPATH**/ ?>