<nav id="navbar" class="fixed top-0 left-0 right-0 z-30 bg-film-dark">
    <div class="px-4 md:px-8 py-3">
        <div class="container mx-auto flex justify-between items-center">
            <!-- Logo -->
            <a href="#" class="flex items-center group">
                <div class="w-10 h-10 bg-film-red rounded flex items-center justify-center overflow-hidden transform group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2 6a2 2 0 012-2h12a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"></path>
                    </svg>
                </div>
                <span class="ml-2 text-film-red font-bold text-2xl md:text-3xl tracking-tighter group-hover:tracking-tight transition-all duration-300">FilmWave</span>
            </a>
            
            <!-- Main Navigation Links -->
            <div class="hidden md:flex space-x-6">
                <a href="#" class="text-white hover:text-film-red transition">Home</a>
                <a href="#" class="text-white hover:text-film-red transition">Movies</a>
                <a href="#" class="text-white hover:text-film-red transition">Anime</a>
                <a href="#" class="text-white hover:text-film-red transition">TV Programs</a>
            </div>
            
            <!-- Right Side Actions -->
            <div class="flex items-center space-x-4">
                <div class="relative hidden md:block">
                    <input type="text" placeholder="Search..." class="bg-film-gray text-gray-200 rounded-full py-1 px-4 pr-8 focus:outline-none focus:ring-1 focus:ring-film-red w-36 lg:w-48 transition-all duration-300 focus:w-56">
                    <button class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-film-red">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                
                <a href="{{ route('login') }}" class="bg-transparent hover:bg-film-red/20 text-white px-4 py-1 rounded-md border border-film-red transition">
                    Log In
                </a>
                
                <a href="{{ route('register') }}" class="bg-film-red hover:bg-film-red/90 text-white px-4 py-1 rounded-md transition">
                    Sign Up
                </a>
            </div>
        </div>
    </div>
</nav>