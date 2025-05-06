<!-- Add Alpine.js functionality to navbar -->
<nav id="navbar" class="fixed top-0 left-0 right-0 z-30 bg-film-dark" 
     x-data="{ 
        isScrolled: false, 
        showMobileMenu: false,
        showSearchBar: false,
        searchQuery: ''
     }"
     @scroll.window="isScrolled = (window.pageYOffset > 50)">
    
    <div class="px-4 md:px-8 py-3" :class="{ 'shadow-lg backdrop-blur-sm bg-film-dark/90': isScrolled, 'bg-gradient-to-b from-black/80 via-film-dark/70 to-film-dark': !isScrolled }">
        <div class="container mx-auto flex justify-between items-center">
            <!-- Logo -->
            <a href="#" class="flex items-center group">
                <div class="w-10 h-10 bg-film-red rounded flex items-center justify-center overflow-hidden transform group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2 6a2 2 0 012-2h12a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"></path>
                    </svg>
                </div>
                <img src="{{ asset('images/image.png') }}" alt="FilmWave Logo" class="h-10">            </a>
            
            <!-- Mobile menu button -->
            <button 
                @click="showMobileMenu = !showMobileMenu" 
                class="lg:hidden text-white hover:text-film-red focus:outline-none"
                aria-label="Toggle mobile menu"
            >
                <svg x-show="!showMobileMenu" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <svg x-show="showMobileMenu" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            
            <!-- Main Navigation Links (Desktop) -->
            <div class="hidden lg:flex space-x-6">
                <a href="{{ route('home') }}" class="text-white hover:text-film-red transition flex items-center gap-1">
                    <i class="fas fa-home"></i> <span>Accueil</span>
                </a>
                <a href="#" class="text-white hover:text-film-red transition flex items-center gap-1">
                    <i class="fas fa-dragon"></i> <span>Anime</span>
                </a>
                <a href="#" class="text-white hover:text-film-red transition flex items-center gap-1">
                    <i class="fas fa-tv"></i> <span>Séries TV</span>
                </a>
                <a href="#" 
                   class="group relative px-4 py-1 text-white hover:text-film-red transition"
                   @mouseenter="$dispatch('notify', {message: 'Code promo disponible!', type: 'info'})">
                    <i class="fas fa-ticket-alt"></i>
                    <span class="ml-1">Promos</span>
                    <span class="absolute -top-1 -right-1 flex h-3 w-3">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-film-red opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-film-red"></span>
                    </span>
                </a>
            </div>
            
            <!-- Right Side Actions -->
            <div class="hidden lg:flex items-center space-x-4">
                <!-- Search bar toggle -->
                <button 
                    @click="showSearchBar = !showSearchBar"
                    class="text-white hover:text-film-red focus:outline-none"
                    aria-label="Toggle search"
                >
                    <i class="fas fa-search"></i>
                </button>
                
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
                
                <!-- Voucher redeem button -->
                <button 
                    @click="$dispatch('show-promo')" 
                    class="bg-gradient-to-r from-film-red to-red-700 hover:from-red-700 hover:to-film-red text-white px-3 py-1 rounded-md transition-all duration-300 shadow-md hover:shadow-red-500/30"
                >
                    <i class="fas fa-gift mr-1"></i> Redeem
                </button>
            </div>
        </div>
    </div>
    
    <!-- Expanded Search bar (appears when toggled) -->
    <div 
        id="searchContainer"
        x-show="showSearchBar" 
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 transform -translate-y-4"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 transform translate-y-0"
        x-transition:leave-end="opacity-0 transform -translate-y-4"
        class="absolute top-full left-0 right-0 bg-film-gray/95 backdrop-blur-md shadow-lg z-50 px-4 py-3"
        style="display: none;"
    >
        <div class="container mx-auto">
            <div class="relative">
                <form id="navSearchForm">
                    <input 
                        id="navSearchInput"
                        type="text" 
                        placeholder="Rechercher films, séries, acteurs..." 
                        x-model="searchQuery"
                        @keydown.escape="showSearchBar = false"
                        class="w-full bg-black/50 text-white px-4 py-3 pr-10 rounded-lg border border-gray-700 focus:outline-none focus:ring-2 focus:ring-film-red"
                        autofocus
                    >
                    <button type="submit" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-film-red">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
            
            <!-- Quick suggestions -->
            <div class="mt-4 grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-2" x-show="searchQuery.length == 0">
                <div class="p-2 bg-black/30 rounded text-center hover:bg-film-red/20 cursor-pointer transition">
                    <span class="text-sm text-white">Films d'action</span>
                </div>
                <div class="p-2 bg-black/30 rounded text-center hover:bg-film-red/20 cursor-pointer transition">
                    <span class="text-sm text-white">Séries populaires</span>
                </div>
                <div class="p-2 bg-black/30 rounded text-center hover:bg-film-red/20 cursor-pointer transition">
                    <span class="text-sm text-white">Nouveautés</span>
                </div>
                <div class="p-2 bg-black/30 rounded text-center hover:bg-film-red/20 cursor-pointer transition">
                    <span class="text-sm text-white">Anime</span>
                </div>
                <div class="p-2 bg-black/30 rounded text-center hover:bg-film-red/20 cursor-pointer transition">
                    <span class="text-sm text-white">Dessins animés</span>
                </div>
                <div class="p-2 bg-black/30 rounded text-center hover:bg-film-red/20 cursor-pointer transition">
                    <span class="text-sm text-white">Science-fiction</span>
                </div>
            </div>
            
            <!-- Search Results Container -->
            <div id="search-results" class="mt-3 bg-film-gray/80 rounded-lg shadow-md max-h-[70vh] overflow-y-auto" x-show="searchQuery.length > 1">
                <!-- Results will be populated by JavaScript -->
            </div>
        </div>
    </div>
    
    <!-- Mobile Menu (full screen) -->
    <div 
        x-show="showMobileMenu" 
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 transform scale-95"
        x-transition:enter-end="opacity-100 transform scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-95"
        class="lg:hidden fixed inset-0 bg-film-dark/98 z-50 flex flex-col pt-16"
        style="display: none;"
    >
        <!-- Mobile Search -->
        <div class="px-6 py-4">
            <div class="relative">
                <input 
                    type="text" 
                    placeholder="Rechercher..." 
                    class="w-full bg-film-gray/50 text-white px-4 py-3 pr-10 rounded-lg border border-gray-700 focus:outline-none focus:ring-2 focus:ring-film-red"
                >
                <button class="absolute right-3 top-1/2 transform -translate-y-1/2 text-film-red">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
        
        <!-- Mobile Nav Links -->
        <div class="px-6 py-4 space-y-4 flex-1">
            <a href="#" class="block py-2 px-4 text-white hover:text-film-red text-lg border-b border-gray-800">
                <i class="fas fa-home w-8"></i> Accueil
            </a>
            <a href="#" class="block py-2 px-4 text-white hover:text-film-red text-lg border-b border-gray-800">
                <i class="fas fa-film w-8"></i> Films
            </a>
            <a href="#" class="block py-2 px-4 text-white hover:text-film-red text-lg border-b border-gray-800">
                <i class="fas fa-dragon w-8"></i> Anime
            </a>
            <a href="#" class="block py-2 px-4 text-white hover:text-film-red text-lg border-b border-gray-800">
                <i class="fas fa-tv w-8"></i> Séries TV
            </a>
            <a href="#" class="block py-2 px-4 text-white hover:text-film-red text-lg border-b border-gray-800 flex items-center">
                <i class="fas fa-ticket-alt w-8"></i> Promos
                <span class="ml-2 bg-film-red text-white text-xs py-1 px-2 rounded-full">NEW</span>
            </a>
        </div>
        
        <!-- Mobile Account Actions -->
        <div class="px-6 py-6 bg-film-gray/30">
            @guest
                <div class="grid grid-cols-2 gap-3">
                    <a href="{{ route('login') }}" class="bg-transparent border border-film-red text-white py-2 rounded-md text-center hover:bg-film-red/20 transition">
                        Connexion
                    </a>
                    <a href="{{ route('register') }}" class="bg-film-red text-white py-2 rounded-md text-center hover:bg-red-700 transition">
                        Inscription
                    </a>
                </div>
            @else
                <div class="text-center mb-4">
                    <p class="text-gray-400">Connecté en tant que</p>
                    <p class="text-white font-medium text-lg">{{ Auth::user()->name }}</p>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <a href="{{ route('profile') }}" class="bg-transparent border border-gray-700 text-white py-2 rounded-md text-center hover:border-film-red transition">
                        Profil
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full bg-film-red text-white py-2 rounded-md text-center hover:bg-red-700 transition">
                            Déconnexion
                        </button>
                    </form>
                </div>
            @endguest
            
            <!-- Mobile Voucher button -->
            <button 
                @click="$dispatch('show-promo'); showMobileMenu = false" 
                class="w-full mt-4 bg-gradient-to-r from-film-red to-red-700 hover:from-red-700 hover:to-film-red text-white py-3 rounded-md transition-all duration-300 shadow-md flex items-center justify-center gap-2"
            >
                <i class="fas fa-gift"></i> Redeem Promo Code
            </button>
        </div>
    </div>
</nav>