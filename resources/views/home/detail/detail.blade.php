<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $anime['title'] }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
<body class="bg-gray-900 text-white min-h-screen fade-in" style="font-family: 'Poppins', sans-serif;">
    <x-header :title="$anime['title']" class="custom-header" />
    <div class="container mx-auto px-4 mt-4">
        <div class="flex justify-center">
            <form id="anime-search-form" class="flex items-center space-x-2 w-full max-w-3xl custom-search-form" action="{{ url('/') }}" method="GET">
                <input 
                    type="text" 
                    id="anime-search-input" 
                    name="query" 
                    placeholder="Search..." 
                    class="w-full p-2 rounded-none border border-white bg-gray-700 text-white focus:outline-none photo-card solid-shadow focus:ring-2 focus:ring-blue-400 custom-input"
                />
                <button 
                    type="submit" 
                    id="anime-search-button" 
                    class="p-2 bg-blue-800 text-white border border-white rounded-none hover:bg-blue-900 photo-card solid-shadow transition custom-button"
                >
                    Search
                </button>
            </form>
        </div>
    </div>
    <main class="container mx-auto px-4 rounded-none mt-6">
        <div class="flex flex-col md:flex-row custom-container rounded-none photo-card solid-shadow">
            <!-- Anime Image -->
            <img src="{{ $anime['images']['jpg']['image_url'] }}" alt="{{ $anime['title'] }}" class="w-64 h-auto rounded-none">
            <div class="md:ml-6 mt-4 md:mt-0 flex-1 rounded-none">
                <!-- Anime Details -->
                <h1 class="text-3xl font-bold">{{ $anime['title'] }}</h1>
                <hr class="border-t-2 border-gray-600 my-4">
                <p class="text-lg mt-2"><strong>Genres:</strong> {{ implode(', ', array_column($anime['genres'], 'name')) }}</p>
                <hr class="border-t-2 border-gray-600 my-4">
                <p class="text-lg mt-2"><strong>Episodes:</strong> {{ $anime['episodes'] ?? 'N/A' }}</p>
                <hr class="border-t-2 border-gray-600 my-4">
                <p class="text-lg mt-2"><strong>Rating:</strong> {{ $anime['score'] ?? 'N/A' }}</p>
                <hr class="border-t-2 border-gray-600 my-4">
                <p class="text-lg mt-2"><strong>Finished:</strong> {{ $animeBookmark && $animeBookmark->is_finished ? 'Yes' : 'No' }}</p>
                <hr class="border-t-2 border-gray-600 my-4">
                
                <!-- Icons Section -->
                <div class="flex items-center space-x-4 mt-4">
                    <!-- Favorite Icon -->
                    <div class="flex items-center">
                        <img 
                            src="{{ $animeBookmark && $animeBookmark->is_favorite ? 'https://img.icons8.com/?size=100&id=10287&format=png&color=FAB005' : 'https://img.icons8.com/?size=100&id=581&format=png&color=FAB005' }}" 
                            alt="Favorite Icon" 
                            class="w-6 h-6 love-icon cursor-pointer"
                            onclick="toggleFavorite({{ $animeBookmark->id ?? 'null' }})"
                        >
                        <span class="ml-2">{{ $animeBookmark && $animeBookmark->is_favorite ? 'Favorited' : 'Not Favorited' }}</span>
                    </div>
                    <!-- Finished Icon -->
                    <div class="flex items-center">
                        <img 
                            src="{{ $animeBookmark && $animeBookmark->is_finished ? 'https://img.icons8.com/?size=100&id=123575&format=png&color=FAB005' : 'https://img.icons8.com/?size=100&id=102698&format=png&color=FAB005' }}" 
                            alt="Finished Icon" 
                            class="w-6 h-6 cursor-pointer"
                            onclick="toggleFinished({{ $animeBookmark->id ?? 'null' }})"
                        >
                        <span class="ml-2">{{ $animeBookmark && $animeBookmark->is_finished ? 'Finished' : 'Not Finished' }}</span>
                    </div>
                    <!-- Wishlist Icon -->
                    <div class="flex items-center">
                        <img 
                            src="{{ $animeBookmark ? 'https://img.icons8.com/?size=100&id=26083&format=png&color=40C057' : 'https://img.icons8.com/?size=100&id=25157&format=png&color=40C057' }}" 
                            alt="Wishlist Icon" 
                            class="w-6 h-6 cursor-pointer"
                            onclick="deleteBookmark({{ $animeBookmark->id ?? 'null' }})"
                        >
                        <span class="ml-2">{{ $animeBookmark ? 'In Wishlist' : 'Not in Wishlist' }}</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- Anime Synopsis -->
        <div class="mt-6 custom-container rounded-none photo-card solid-shadow mb-20">
            <h2 class="text-2xl font-bold">Anime Details</h2>
            <hr class="border-t-2 border-gray-600 my-4">
            <p class="mt-2">{{ $anime['synopsis'] }}</p>
        </div>
    </main>
    <x-footer-navbar />
    <script>
        async function toggleFavorite(bookmarkId) {
            try {
                const response = await fetch(`/anime/bookmark/${bookmarkId || 'null'}/favorite`, {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        anime_id: '{{ $anime["mal_id"] }}',
                        title: '{{ $anime["title"] }}',
                        image_url: '{{ $anime["images"]["jpg"]["image_url"] }}',
                    }),
                });
                const result = await response.json();
                alert(result.message);
                location.reload();
            } catch (error) {
                console.error(error);
                alert('An error occurred while toggling favorite status.');
            }
        }

        async function toggleFinished(bookmarkId) {
            try {
                const response = await fetch(`/anime/bookmark/${bookmarkId || 'null'}/finished`, {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        anime_id: '{{ $anime["mal_id"] }}',
                        title: '{{ $anime["title"] }}',
                        image_url: '{{ $anime["images"]["jpg"]["image_url"] }}',
                    }),
                });
                const result = await response.json();
                alert(result.message);
                location.reload();
            } catch (error) {
                console.error(error);
                alert('An error occurred while toggling finished status.');
            }
        }

        async function deleteBookmark(bookmarkId) {
            if (!bookmarkId) {
                alert('Bookmark not found.');
                return;
            }
            if (!confirm('Are you sure you want to delete this bookmark?')) return;

            try {
                const response = await fetch(`/anime/bookmark/${bookmarkId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                });
                const result = await response.json();
                alert(result.message);

                if (result.status === 'deleted') {
                    location.reload();
                }
            } catch (error) {
                console.error(error);
                alert('An error occurred while deleting the bookmark.');
            }
        }
    </script>
</body>
</html>
