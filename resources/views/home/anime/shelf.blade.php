<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anime Shelf</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
<body class="bg-gray-900 text-white min-h-screen fade-in" style="font-family: 'Poppins', sans-serif;">
    <x-header :title="'Anime Shelf'" class="custom-header" />
    <div class="container mx-auto px-4 mt-6">
        <h1 class="text-3xl font-bold text-white mb-4">Your Anime Shelf</h1>
        <hr class="border-t-2 border-gray-600 mb-6">
        <div id="anime-shelf" class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Wishlist Card -->
            <div class="photo-card bg-gray-800 p-6 border border-blue-800 fade-in rounded-none solid-shadow hover:shadow-lg transition flex flex-col items-center justify-center">
                <img src="https://img.icons8.com/?size=100&id=25157&format=png&color=40C057" alt="Wishlist Icon" class="w-12 h-12 mb-4">
                <h2 class="text-2xl font-bold text-white mb-4">Wishlist</h2>
                <button 
                    class="p-4 bg-blue-600 text-white rounded-none photo-card solid-shadow hover:bg-blue-700 transition details-button" 
                    onclick="window.location.href='/anime/shelf/wishlist'"
                >
                    View Wishlist
                </button>
            </div>
            <!-- Finished Card -->
            <div class="photo-card bg-gray-800 p-6 border border-blue-800 fade-in rounded-none solid-shadow hover:shadow-lg transition flex flex-col items-center justify-center">
                <img src="https://img.icons8.com/?size=100&id=123575&format=png&color=FAB005" alt="Finished Icon" class="w-12 h-12 mb-4">
                <h2 class="text-2xl font-bold text-white mb-4">Finished</h2>
                <button 
                    class="p-4 bg-blue-600 text-white rounded-none photo-card solid-shadow hover:bg-blue-700 transition details-button" 
                    onclick="window.location.href='/anime/shelf/finished'"
                >
                    View Finished
                </button>
            </div>
            <!-- Favorite Card -->
            <div class="photo-card bg-gray-800 p-6 border border-blue-800 fade-in rounded-none solid-shadow hover:shadow-lg transition flex flex-col items-center justify-center">
                <img src="https://img.icons8.com/?size=100&id=26083&format=png&color=40C057" alt="Favorite Icon" class="w-12 h-12 mb-4">
                <h2 class="text-2xl font-bold text-white mb-4">Favorite</h2>
                <button 
                    class="p-4 bg-blue-600 text-white rounded-none photo-card solid-shadow hover:bg-blue-700 transition details-button" 
                    onclick="window.location.href='/anime/shelf/favorite'"
                >
                    View Favorite
                </button>
            </div>
        </div>
    </div>
    <x-footer-navbar />
</body>
</html>
