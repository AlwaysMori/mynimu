<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Nimu</title>
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
    <br>
    <!-- Konten halaman -->
    <div class="container mx-auto px-4">
        <div class="flex justify-center">
            <form id="anime-search-form" class="flex items-center space-x-2 w-full max-w-3xl custom-search-form">
                <input 
                    type="text" 
                    id="anime-search-input" 
                    name="query" 
                    placeholder="Search..." 
                    class="w-full p-2 rounded-none border border-white bg-gray-700 text-white focus:outline-none photo-card solid-shadow focus:ring-2 focus:ring-blue-400 custom-input"
                />
                <button 
                    type="button" 
                    id="anime-search-button" 
                    class="p-2 bg-blue-800 text-white border border-white rounded-none hover:bg-blue-900 photo-card solid-shadow transition custom-button"
                >
                    Search
                </button>
            </form>
        </div>
    </div>
    <div id="recommended-section" class="container mx-auto px-4 mt-6">
        <h2 class="text-2xl font-bold text-white mb-2">Recommended</h2>
        <hr class="border-t-2 border-gray-600 mb-4">
        <div id="recommended-anime" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Rekomendasi anime akan ditampilkan di sini -->
        </div>
    </div>
    <div id="search-section" class="container mx-auto px-4 mt-8 hidden">
        <h2 class="text-2xl font-bold text-white mb-2">Search Results</h2>
        <hr class="border-t-2 border-gray-600 mb-4">
        <div id="search-results" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Hasil pencarian akan ditampilkan di sini -->
        </div>
    </div>
    <div id="user-bookmarks-section" class="container mx-auto px-4 mt-8 mb-20">
        <h2 class="text-2xl font-bold text-white mb-2">Your Bookmarks</h2>
        <hr class="border-t-2 border-gray-600 mb-4">
        <div id="user-bookmarks" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Bookmark user akan ditampilkan di sini -->
            <script>
                document.addEventListener('click', async (event) => {
                    if (event.target.closest('.favorite-button')) {
                        const button = event.target.closest('.favorite-button');
                        const bookmarkId = button.getAttribute('data-bookmark-id');

                        try {
                            const response = await fetch(`/anime/bookmark/${bookmarkId}/favorite`, {
                                method: 'PATCH',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                },
                            });

                            const result = await response.json();
                            alert(result.message);
                        } catch (error) {
                            console.error(error);
                            alert('An error occurred while toggling favorite status.');
                        }
                    }

                    if (event.target.closest('.finished-button')) {
                        const button = event.target.closest('.finished-button');
                        const bookmarkId = button.getAttribute('data-bookmark-id');

                        try {
                            const response = await fetch(`/anime/bookmark/${bookmarkId}/finished`, {
                                method: 'PATCH',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                },
                            });

                            const result = await response.json();
                            alert(result.message);
                        } catch (error) {
                            console.error(error);
                            alert('An error occurred while toggling finished status.');
                        }
                    }
                });
            </script>
        </div>
    </div>

    <!-- Notifikasi Pop-Up -->
    <div id="notification-popup" class="">
        Anime added to wishlist!
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', async () => {
            const searchButton = document.getElementById('anime-search-button');
            const searchInput = document.getElementById('anime-search-input');
            const resultsContainer = document.getElementById('search-results');
            const recommendedSection = document.getElementById('recommended-section');
            const searchSection = document.getElementById('search-section');
            const recommendedContainer = document.getElementById('recommended-anime');
            const notificationPopup = document.getElementById('notification-popup');
            const bookmarksContainer = document.getElementById('user-bookmarks');

            // Fetch rekomendasi anime secara acak saat halaman dimuat
            try {
                const response = await fetch('/random-anime');
                if (!response.ok) {
                    throw new Error('Failed to fetch random anime.');
                }

                const recommendations = await response.json();

                recommendations.forEach(async anime => {
                    const response = await fetch(`/anime/bookmark-status/${anime.mal_id}`);
                    const { isBookmarked, is_finished } = await response.json();

                    const animeCard = document.createElement('div');
                    animeCard.classList.add('photo-card', 'bg-gray-800', 'border', 'border-blue-800', 'p-6', 'fade-in', 'rounded-none', 'solid-shadow', 'hover:shadow-lg', 'transition', 'flex', 'relative');
                    animeCard.innerHTML = `
                        <img src="${anime.images.jpg.image_url}" alt="${anime.title}" class="w-32 h-32 object-cover rounded-none">
                        <div class="absolute top-2 right-2">
                            <img src="${is_finished ? 'https://img.icons8.com/?size=100&id=123575&format=png&color=FAB005' : 'https://img.icons8.com/?size=100&id=102698&format=png&color=FAB005'}" alt="${is_finished ? 'Finished' : 'Not Finished'}" class="w-6 h-6">
                        </div>
                        <div class="flex-1 pl-4">
                            <h3 class="text-xl font-bold text-white">${anime.title}</h3>
                            <p class="text-sm text-gray-400 mt-2">Rating: ${anime.score ?? 'N/A'}</p>
                            <div class="mt-4 flex justify-between">
                                <button class="p-2 wishlist-button ${isBookmarked ? 'wishlisted' : ''}" data-anime-id="${anime.mal_id}" data-title="${anime.title}" data-image-url="${anime.images.jpg.image_url}">
                                    <img src="${isBookmarked ? 'https://img.icons8.com/?size=100&id=26083&format=png&color=40C057' : 'https://img.icons8.com/?size=100&id=25157&format=png&color=40C057'}" alt="${isBookmarked ? 'Already Bookmarked' : 'Add to Wishlist'}" class="w-6 h-6 love-icon">
                                </button>
                                <button 
                                    class="p-2 bg-blue-600 text-white rounded-none photo-card solid-shadow hover:bg-blue-700 transition details-button" 
                                    data-anime-id="${anime.mal_id}"
                                    onclick="window.location.href='/anime/detail/${anime.mal_id}'"
                                >
                                    Details
                                </button>
                            </div>
                        </div>
                    `;
                    recommendedContainer.appendChild(animeCard);
                });
            } catch (error) {
                console.error(error);
                alert('An error occurred while fetching random anime.');
            }

            searchButton.addEventListener('click', async () => {
                const query = searchInput.value.trim();
                if (!query) {
                    alert('Please enter a search term.');
                    return;
                }

                try {
                    const response = await fetch(`/search-anime?query=${encodeURIComponent(query)}`);
                    if (!response.ok) {
                        throw new Error('Failed to fetch search results.');
                    }

                    const results = await response.json();
                    resultsContainer.innerHTML = ''; // Bersihkan hasil sebelumnya

                    results.forEach(async anime => {
                        const response = await fetch(`/anime/bookmark-status/${anime.mal_id}`);
                        const { isBookmarked, is_finished } = await response.json();

                        const animeCard = document.createElement('div');
                        animeCard.classList.add('photo-card', 'bg-gray-800', 'p-6', 'border', 'border-blue-800', 'fade-in', 'rounded', 'solid-shadow', 'hover:shadow-lg', 'transition', 'flex', 'relative');
                        animeCard.innerHTML = `
                            <img src="${anime.images.jpg.image_url}" alt="${anime.title}" class="w-32 h-32 object-cover rounded">
                            <div class="absolute top-2 right-2">
                                <img src="${is_finished ? 'https://img.icons8.com/?size=100&id=123575&format=png&color=FAB005' : 'https://img.icons8.com/?size=100&id=102698&format=png&color=FAB005'}" alt="${is_finished ? 'Finished' : 'Not Finished'}" class="w-6 h-6">
                            </div>
                            <div class="flex-1 pl-4">
                                <h3 class="text-xl font-bold text-white">${anime.title}</h3>
                                <p class="text-sm text-gray-400 mt-2">Rating: ${anime.score ?? 'N/A'}</p>
                                <div class="mt-4 flex justify-between">
                                    <button class="p-2 wishlist-button ${isBookmarked ? 'wishlisted' : ''}" data-anime-id="${anime.mal_id}" data-title="${anime.title}" data-image-url="${anime.images.jpg.image_url}">
                                        <img src="${isBookmarked ? 'https://img.icons8.com/?size=100&id=26083&format=png&color=40C057' : 'https://img.icons8.com/?size=100&id=25157&format=png&color=40C057'}" alt="${isBookmarked ? 'Already Bookmarked' : 'Add to Wishlist'}" class="w-6 h-6 love-icon">
                                    </button>
                                    <button 
                                        class="p-2 bg-blue-600 text-white rounded-none photo-card solid-shadow  hover:bg-blue-700 transition details-button" 
                                        data-anime-id="${anime.mal_id}"
                                        onclick="window.location.href='/anime/detail/${anime.mal_id}'"
                                    >
                                        Details
                                    </button>
                                </div>
                            </div>
                        `;
                        resultsContainer.appendChild(animeCard);
                    });

                    // Sembunyikan rekomendasi dan tampilkan hasil pencarian
                    recommendedSection.classList.add('hidden');
                    searchSection.classList.remove('hidden');
                } catch (error) {
                    console.error(error);
                    alert('An error occurred while fetching search results.');
                }
            });

            document.addEventListener('click', async (event) => {
                if (event.target.closest('.wishlist-button')) {
                    const button = event.target.closest('.wishlist-button');
                    const animeId = button.getAttribute('data-anime-id');
                    const title = button.getAttribute('data-title');
                    const imageUrl = button.getAttribute('data-image-url');
                    const loveIcon = button.querySelector('.love-icon');

                    try {
                        // Kirim permintaan ke backend untuk menambahkan bookmark
                        const response = await fetch('/anime/bookmark', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            },
                            body: JSON.stringify({ anime_id: animeId, title: title, image_url: imageUrl }),
                        });

                        const result = await response.json();

                        if (result.status === 'exists') {
                            alert(`${title} is already in your bookmarks.`);
                            return; // Jangan lakukan apa-apa jika sudah dibookmark
                        }

                        if (result.status === 'success') {
                            // Ubah status tombol menjadi "wishlisted"
                            loveIcon.classList.add('wishlisted');
                            loveIcon.src = "https://img.icons8.com/?size=100&id=26083&format=png&color=40C057"; // Change to green icon

                            // Tampilkan notifikasi dengan efek fade-in dan fade-out
                            notificationPopup.textContent = `${title} added to bookmarks!`;
                            notificationPopup.classList.add('show');
                            setTimeout(() => {
                                notificationPopup.classList.remove('show');
                            }, 3000); // Sembunyikan setelah 3 detik
                        }
                    } catch (error) {
                        console.error(error);
                        alert('An error occurred while updating the wishlist.');
                    }
                }
            });

            // Fetch user bookmarks
            try {
                const response = await fetch('/anime/bookmarks');
                if (!response.ok) {
                    throw new Error('Failed to fetch user bookmarks.');
                }

                const { bookmarks } = await response.json();

                bookmarks.forEach(bookmark => {
                    const bookmarkCard = document.createElement('div');
                    bookmarkCard.classList.add('photo-card', 'bg-gray-800', 'p-6', 'border', 'border-blue-800', 'fade-in', 'rounded', 'solid-shadow', 'hover:shadow-lg', 'transition', 'flex', 'relative');
                    bookmarkCard.innerHTML = `
                        <img src="${bookmark.image_url}" alt="${bookmark.title}" class="w-32 h-32 object-cover rounded">
                        <div class="absolute top-2 right-2">
                            <img src="${bookmark.is_finished ? 'https://img.icons8.com/?size=100&id=123575&format=png&color=FAB005' : 'https://img.icons8.com/?size=100&id=102698&format=png&color=FAB005'}" alt="${bookmark.is_finished ? 'Finished' : 'Not Finished'}" class="w-6 h-6">
                        </div>
                        <div class="flex-1 pl-4">
                            <h3 class="text-xl font-bold text-white">${bookmark.title}</h3>
                            <p class="text-sm text-gray-400 mt-2">Status: ${bookmark.status}</p>
                            <div class="mt-4 flex justify-between">
                                <button class="p-2 favorite-button ${bookmark.is_favorite ? 'favorited' : ''}" data-bookmark-id="${bookmark.id}">
                                    <img src="${bookmark.is_favorite ? 'https://img.icons8.com/?size=100&id=26083&format=png&color=40C057' : 'https://img.icons8.com/?size=100&id=25157&format=png&color=40C057'}" alt="${bookmark.is_favorite ? 'Favorited' : 'Add to Favorite'}" class="w-6 h-6">
                                </button>
                            </div>
                        </div>
                    `;
                    bookmarksContainer.appendChild(bookmarkCard);
                });
            } catch (error) {
                console.error(error);
                alert('An error occurred while fetching your bookmarks.');
            }
        });
    </script>
</body>
<x-footer-navbar />
</html>
