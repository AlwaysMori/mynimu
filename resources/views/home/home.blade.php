<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
<body class="bg-gray-900 text-white min-h-screen fade-in">
    <div class="relative w-full max-w-4xl p-8 space-y-6 bg-gray-800 transform transition duration-300 rgb-border photo-card mx-auto solid-shadow">
        <h1 class="text-3xl font-bold text-center text-blue-400 hover:text-blue-300 transition duration-300">Dashboard</h1>
        <!-- Add dashboard content here -->
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.body.classList.add('fade-in');
        });
    </script>
</body>
</html>
