<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My Nimu')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
<body class="bg-gray-900 text-white min-h-screen fade-in" style="font-family: 'Poppins', sans-serif;">
    @auth
        <x-header :title="'Dashboard'" class="custom-header" />
    @else
        <x-header :title="'Welcome'" class="custom-header" />
    @endauth

    <div class="container mx-auto px-4 py-6">
        @yield('content')
    </div>

    <x-footer-navbar />
</body>
</html>
