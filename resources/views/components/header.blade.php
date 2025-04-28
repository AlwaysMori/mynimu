<header class="bg-gray-800 text-white border-b-2 border-blue-700 shadow-md" style="font-family: 'Poppins', sans-serif;">
    <div class="container mx-auto flex justify-between items-center p-4">
        <h1 class="text-xl font-light">My Nimu</h1>
        <button id="menu-toggle" class="hidden md:hidden text-white focus:outline-none">
            <!-- Menu button is now hidden -->
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
        </button>
        <nav id="menu" class="md:flex space-x-4 hidden">
            <a href="/" class="hover:text-blue-400 transition">Home</a>
            <a href="/forum" class="hover:text-blue-400 transition">Forum</a>
            <a href="/anime/shelf" class="hover:text-blue-400 transition">Anime</a>
            <a href="/profile" class="hover:text-blue-400 transition">Profile</a>
            @auth
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="hover:text-blue-400 transition">
                    Logout
                </button>
            </form>
            @else
            <a href="{{ route('login') }}" class="hover:text-blue-400 transition">Login</a>
            @endauth
        </nav>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const menu = document.getElementById('menu');

            // Ensure menu is removed in mobile view
            window.addEventListener('resize', () => {
                if (window.innerWidth < 768) {
                    menu.classList.add('hidden');
                }
            });
        });
    </script>
</header>
