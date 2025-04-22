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
    <x-header :title="'Dashboard'" class="custom-header" />
    <br>
    <div class="container mx-auto px-4 custom-container">
        <form id="anime-search-form" class="flex items-center space-x-2 custom-search-form">
            <input 
                type="text" 
                id="anime-search-input" 
                name="query" 
                placeholder="Search..." 
                class="w-full p-2 rounded-md bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-400 custom-input"
            />
            <button 
                type="button" 
                id="anime-search-button" 
                class="p-2 bg-blue-800 text-white rounded-none hover:bg-blue-900 photo-card solid-shadow transition custom-button"
            >
                Search
            </button>
        </form>
        <div id="search-results" class="mt-4 grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <!-- Hasil pencarian akan ditampilkan di sini -->
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.body.classList.add('fade-in');

            const searchButton = document.getElementById('anime-search-button');
            const searchInput = document.getElementById('anime-search-input');
            const resultsContainer = document.getElementById('search-results');

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

                    results.forEach(anime => {
                        const animeCard = document.createElement('div');
                        animeCard.classList.add('bg-gray-800', 'p-4', 'rounded', 'shadow-md', 'hover:shadow-lg', 'transition');
                        animeCard.innerHTML = `
                            <img src="${anime.images.jpg.image_url}" alt="${anime.title}" class="w-full h-48 object-cover rounded">
                            <h3 class="mt-2 text-lg font-bold">${anime.title}</h3>
                            <button class="mt-2 p-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition" onclick="addBookmark('${anime.mal_id}', '${anime.title}', '${anime.images.jpg.image_url}')">
                                Add to Wishlist
                            </button>
                        `;
                        resultsContainer.appendChild(animeCard);
                    });
                } catch (error) {
                    console.error(error);
                    alert('An error occurred while fetching search results.');
                }
            });
        });

        async function addBookmark(animeId, title, imageUrl) {
            try {
                const response = await fetch('/anime/bookmark', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({ anime_id: animeId, title: title, image_url: imageUrl }),
                });

                if (!response.ok) {
                    throw new Error('Failed to add bookmark');
                }

                const result = await response.json();
                alert(result.message);
            } catch (error) {
                console.error(error);
                alert('An error occurred while adding the bookmark.');
            }
        }
    </script>
</body>
</html>
