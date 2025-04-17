<!-- Add Alpine.js library right at the top of the navbar partial -->
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
                <a href="#" class="text-white hover:text-film-red transition">Accueil</a>
                <a href="#" class="text-white hover:text-film-red transition">Films</a>
                <a href="#" class="text-white hover:text-film-red transition">Anime</a>
                <a href="#" class="text-white hover:text-film-red transition">Séries TV</a>
            </div>
            
            <!-- Right Side Actions -->
            <div class="flex items-center space-x-4">
                <div class="relative hidden md:block">
                    <input type="text" placeholder="Rechercher..." class="bg-film-gray text-gray-200 rounded-full py-1 px-4 pr-8 focus:outline-none focus:ring-1 focus:ring-film-red w-36 lg:w-48 transition-all duration-300 focus:w-56">
                    <button class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-film-red">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                
                @guest
                    <a href="{{ route('login') }}" class="bg-transparent hover:bg-film-red/20 text-white px-4 py-1 rounded-md border border-film-red transition">
                        Connexion
                    </a>
                    
                    <a href="{{ route('register') }}" class="bg-film-red hover:bg-film-red/90 text-white px-4 py-1 rounded-md transition">
                        Inscription
                    </a>
                @else
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-2 text-white hover:text-film-red focus:outline-none">
                            <span class="text-sm">{{ Auth::user()->name }}</span>
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                        <div x-show="open" 
                             @click.away="open = false" 
                             x-transition:enter="transition ease-out duration-100" 
                             x-transition:enter-start="transform opacity-0 scale-95" 
                             x-transition:enter-end="transform opacity-100 scale-100" 
                             x-transition:leave="transition ease-in duration-75" 
                             x-transition:leave-start="transform opacity-100 scale-100" 
                             x-transition:leave-end="transform opacity-0 scale-95" 
                             style="display: none;"
                             class="absolute right-0 mt-2 w-48 bg-film-gray rounded-md shadow-lg z-10">
                            <div class="py-1">
                                <a href="{{ route('profile') }}" class="block px-4 py-2 text-sm text-white hover:bg-film-red/20 hover:text-film-red">Profil</a>
                                <a href="{{ route('settings') }}" class="block px-4 py-2 text-sm text-white hover:bg-film-red/20 hover:text-film-red">Paramètres</a>
                                <a href="{{ route('my-list') }}" class="block px-4 py-2 text-sm text-white hover:bg-film-red/20 hover:text-film-red">Ma Liste</a>
                                <div class="border-t border-gray-700"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-white hover:bg-film-red/20 hover:text-film-red">
                                        Déconnexion
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</nav>