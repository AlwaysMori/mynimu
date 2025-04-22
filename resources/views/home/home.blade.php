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
        <form action="/search" method="GET" class="flex items-center space-x-2 custom-search-form">
            <input 
                type="text" 
                name="query" 
                placeholder="Search..." 
                class="w-full p-2 rounded-md bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-400 custom-input"
            />
            <button 
                type="submit" 
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

            // Event listener untuk menampilkan hasil pencarian
            document.addEventListener('animeSearchResults', (event) => {
                const resultsContainer = document.getElementById('search-results');
                resultsContainer.innerHTML = ''; // Bersihkan hasil sebelumnya

                const results = event.detail;
                results.forEach(anime => {
                    const animeCard = document.createElement('div');
                    animeCard.classList.add('bg-gray-800', 'p-4', 'rounded', 'shadow-md', 'hover:shadow-lg', 'transition');
                    animeCard.innerHTML = `
                        <img src="${anime.image_url}" alt="${anime.title}" class="w-full h-48 object-cover rounded">
                        <h3 class="mt-2 text-lg font-bold">${anime.title}</h3>
                    `;
                    resultsContainer.appendChild(animeCard);
                });
            });
        });
    </script>
</body>
</html>
