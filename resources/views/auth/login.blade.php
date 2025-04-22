<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
<body class="bg-gray-900 text-white flex items-center justify-center min-h-screen fade-in">
    <div class="relative w-full max-w-md p-8 space-y-6 bg-gray-800 border border-blue-500 transform transition duration-300 rgb-border photo-card solid-shadow">
        <div class="flex justify-center">
            <img src="https://mystickermania.com/cdn/stickers/anime/rimuru-tempest-exclamation-512x512.png" alt="Gamer Logo" 
                class="w-40 h-40 shadow-md hover:shadow-lg transition duration-300">
        </div>
        <h1 class="text-3xl font-bold text-center text-blue-400 hover:text-blue-300 transition duration-300">Hi, Welcome Back!</h1>
        <form action="/login" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="username" class="block text-sm font-medium text-gray-300 ">Username</label>
                <input type="text" id="username" name="username" required 
                    class="w-full px-4 py-2 mt-1 text-gray-900 bg-gray-200 photo-card solid-shadow rounded-none focus:outline-none focus:ring-2 focus:ring-blue-500 hover:ring-2 hover:ring-blue-400 transition duration-300 border border-gray-300">
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-gray-300">Password</label>
                <input type="password" id="password" name="password" required 
                    class="w-full px-4 py-2 mt-1 text-gray-900 bg-gray-200 photo-card solid-shadow rounded-none focus:outline-none focus:ring-2 focus:ring-blue-500 hover:ring-2 hover:ring-blue-400 transition duration-300 border border-gray-300">
            </div>
            <button type="submit" 
                class="w-full px-4 py-2 font-bold text-white bg-blue-600 photo-card solid-shadow rounded-none hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300 border border-gray-300">
                Login
            </button>
        </form>
        <p class="text-sm text-center text-gray-400">
            Don't have an account? <a href="/register" class="text-blue-400 hover:text-blue-300 hover:underline transition duration-300">Register here</a>
        </p>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.body.classList.add('fade-in');
        });
    </script>
</body>
</html>
