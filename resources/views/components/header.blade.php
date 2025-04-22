<header class="bg-gray-800 text-white border-b-2 border-blue-700 shadow-md" style="font-family: 'Poppins', sans-serif;">
    <div class="container mx-auto flex justify-between items-center p-4">
        <h1 class="text-xl font-bold">{{ $title ?? 'Default Title' }}</h1>
        <button id="menu-toggle" class="block md:hidden text-white focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
        </button>
        <nav id="menu" class="hidden md:flex space-x-4">
            <a href="/" class="hover:text-blue-400 transition">Home</a>
            <a href="/about" class="hover:text-blue-400 transition">About</a>
            <a href="/contact" class="hover:text-blue-400 transition">Contact</a>
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="hover:text-blue-400 transition">
                    Logout
                </button>
            </form>
        </nav>
    </div>
    <script>
        document.getElementById('menu-toggle').addEventListener('click', () => {
            const menu = document.getElementById('menu');
            menu.classList.toggle('hidden');
        });
    </script>
</header>
