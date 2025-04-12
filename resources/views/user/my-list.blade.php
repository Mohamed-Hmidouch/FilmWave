<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>My List - FilmWave</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'film-dark': '#0f0f0f',
                        'film-gray': '#1a1a1a',
                        'film-red': '#e50914',
                    }
                }
            }
        }
    </script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-film-dark text-white">
    <!-- Include navbar -->
    @include('partials.navbar')
    
    <div class="container mx-auto pt-24 px-4 md:px-6 lg:px-8 pb-12">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
                <div>
                    <h1 class="text-3xl font-bold">My List</h1>
                    <p class="text-gray-400 mt-1">Your saved movies and TV shows</p>
                </div>
                
                <div class="mt-4 md:mt-0 flex items-center space-x-4">
                    <!-- Filter dropdown -->
                    <div x-data="{ open: false }" class="relative">
                        <button 
                            @click="open = !open"
                            class="px-4 py-2 bg-film-gray hover:bg-gray-700 text-white rounded flex items-center space-x-2 border border-gray-700"
                        >
                            <i class="fas fa-filter"></i>
                            <span>Filter</span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        
                        <div 
                            x-show="open"
                            @click.away="open = false"
                            class="absolute right-0 mt-2 w-48 bg-film-gray rounded shadow-lg z-50"
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            style="display: none;"
                        >
                            <div class="py-2 px-3">
                                <p class="text-sm font-medium text-gray-300 mb-2">Content Type</p>
                                <div class="space-y-2">
                                    <label class="flex items-center">
                                        <input type="checkbox" checked class="rounded bg-gray-800 border-gray-700 text-film-red focus:ring-film-red">
                                        <span class="ml-2 text-sm text-gray-300">Movies</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" checked class="rounded bg-gray-800 border-gray-700 text-film-red focus:ring-film-red">
                                        <span class="ml-2 text-sm text-gray-300">TV Shows</span>
                                    </label>
                                </div>
                                
                                <div class="border-t border-gray-700 my-3"></div>
                                
                                <p class="text-sm font-medium text-gray-300 mb-2">Genre</p>
                                <div class="space-y-2 max-h-36 overflow-y-auto">
                                    <label class="flex items-center">
                                        <input type="checkbox" class="rounded bg-gray-800 border-gray-700 text-film-red focus:ring-film-red">
                                        <span class="ml-2 text-sm text-gray-300">Action</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" class="rounded bg-gray-800 border-gray-700 text-film-red focus:ring-film-red">
                                        <span class="ml-2 text-sm text-gray-300">Comedy</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" class="rounded bg-gray-800 border-gray-700 text-film-red focus:ring-film-red">
                                        <span class="ml-2 text-sm text-gray-300">Drama</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" class="rounded bg-gray-800 border-gray-700 text-film-red focus:ring-film-red">
                                        <span class="ml-2 text-sm text-gray-300">Horror</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" class="rounded bg-gray-800 border-gray-700 text-film-red focus:ring-film-red">
                                        <span class="ml-2 text-sm text-gray-300">Sci-Fi</span>
                                    </label>
                                </div>
                                
                                <div class="border-t border-gray-700 my-3"></div>
                                
                                <div class="flex justify-between">
                                    <button class="text-xs text-gray-400 hover:text-white">Clear All</button>
                                    <button class="text-xs text-film-red hover:text-red-400">Apply Filters</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Sort dropdown -->
                    <div x-data="{ open: false }" class="relative">
                        <button 
                            @click="open = !open"
                            class="px-4 py-2 bg-film-gray hover:bg-gray-700 text-white rounded flex items-center space-x-2 border border-gray-700"
                        >
                            <i class="fas fa-sort"></i>
                            <span>Sort</span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        
                        <div 
                            x-show="open"
                            @click.away="open = false"
                            class="absolute right-0 mt-2 w-48 bg-film-gray rounded shadow-lg z-50"
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            style="display: none;"
                        >
                            <div class="py-1">
                                <button class="block w-full text-left px-4 py-2 text-sm text-white hover:bg-film-red/20">
                                    Recently Added
                                </button>
                                <button class="block w-full text-left px-4 py-2 text-sm text-white hover:bg-film-red/20">
                                    Alphabetical (A-Z)
                                </button>
                                <button class="block w-full text-left px-4 py-2 text-sm text-white hover:bg-film-red/20">
                                    Alphabetical (Z-A)
                                </button>
                                <button class="block w-full text-left px-4 py-2 text-sm text-white hover:bg-film-red/20">
                                    Release Date (Newest)
                                </button>
                                <button class="block w-full text-left px-4 py-2 text-sm text-white hover:bg-film-red/20">
                                    Release Date (Oldest)
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- View toggle -->
                    <div x-data="{ gridView: true }" class="flex items-center bg-film-gray rounded border border-gray-700 overflow-hidden">
                        <button 
                            @click="gridView = true"
                            :class="gridView ? 'bg-gray-700 text-white' : 'text-gray-400 hover:text-white'"
                            class="px-3 py-2 focus:outline-none transition"
                        >
                            <i class="fas fa-th-large"></i>
                        </button>
                        <button 
                            @click="gridView = false"
                            :class="!gridView ? 'bg-gray-700 text-white' : 'text-gray-400 hover:text-white'"
                            class="px-3 py-2 focus:outline-none transition"
                        >
                            <i class="fas fa-list"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Content Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 md:gap-6">
                <!-- Sample content items - in a real app, these would come from the database -->
                @for ($i = 1; $i <= 10; $i++)
                    <div class="group relative rounded-lg overflow-hidden bg-film-gray">
                        <!-- Movie/Show image -->
                        <div class="aspect-[2/3] bg-gray-800 overflow-hidden">
                            <img 
                                src="https://picsum.photos/id/{{ $i + 20 }}/300/450" 
                                alt="Movie poster" 
                                class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
                            >
                            
                            <!-- Overlay with actions -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex flex-col justify-end p-4">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex space-x-2">
                                        <button class="w-8 h-8 rounded-full bg-white flex items-center justify-center hover:bg-film-red transition">
                                            <i class="fas fa-play text-black text-xs"></i>
                                        </button>
                                        <button class="w-8 h-8 rounded-full bg-gray-800/80 flex items-center justify-center hover:bg-gray-700 transition">
                                            <i class="fas fa-check text-white text-xs"></i>
                                        </button>
                                    </div>
                                    <button class="w-8 h-8 rounded-full bg-gray-800/80 flex items-center justify-center hover:bg-gray-700 transition">
                                        <i class="fas fa-ellipsis-v text-white text-xs"></i>
                                    </button>
                                </div>
                                <div>
                                    <p class="text-white font-medium">{{ ['Inception', 'The Dark Knight', 'Interstellar', 'The Matrix', 'Pulp Fiction', 'Fight Club', 'Forrest Gump', 'Parasite', 'Joker', 'Whiplash'][$i-1] }}</p>
                                    <div class="flex items-center text-xs text-gray-300 mt-1">
                                        <span class="text-green-400 font-medium">98% Match</span>
                                        <span class="mx-1">•</span>
                                        <span>{{ rand(2010, 2023) }}</span>
                                        <span class="mx-1">•</span>
                                        <span class="border border-gray-600 px-1 text-xs">{{ ['PG-13', 'R', 'PG', 'G', 'PG-13'][rand(0, 4)] }}</span>
                                    </div>
                                    <div class="text-xs text-gray-300 mt-1">
                                        {{ ['Action, Sci-Fi', 'Drama, Thriller', 'Adventure, Drama', 'Comedy, Romance', 'Horror, Mystery'][rand(0, 4)] }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Title for small screens/no hover -->
                        <div class="p-2 md:hidden">
                            <p class="text-sm font-medium truncate">{{ ['Inception', 'The Dark Knight', 'Interstellar', 'The Matrix', 'Pulp Fiction', 'Fight Club', 'Forrest Gump', 'Parasite', 'Joker', 'Whiplash'][$i-1] }}</p>
                            <p class="text-xs text-gray-400">{{ rand(2010, 2023) }}</p>
                        </div>
                    </div>
                @endfor
            </div>
            
            <!-- Empty state - show when no content in list -->
            @if(false) <!-- Toggle this condition to show/hide the empty state -->
                <div class="flex flex-col items-center justify-center py-20">
                    <div class="w-20 h-20 rounded-full bg-film-gray flex items-center justify-center mb-4">
                        <i class="fas fa-folder-open text-2xl text-gray-500"></i>
                    </div>
                    <h3 class="text-xl font-medium text-white">Your list is empty</h3>
                    <p class="text-gray-400 mt-2 text-center max-w-md">Save movies and shows to your list to watch them later</p>
                    <div class="mt-6">
                        <a href="{{ route('movies') }}" class="px-6 py-2 bg-film-red hover:bg-red-700 text-white rounded-md transition">
                            Browse Content
                        </a>
                    </div>
                </div>
            @endif
            
            <!-- Pagination -->
            <div class="mt-10 flex justify-center">
                <nav class="flex items-center space-x-1">
                    <button class="px-3 py-1 rounded bg-film-gray text-gray-400 hover:text-white border border-gray-700">
                        <i class="fas fa-chevron-left text-xs"></i>
                    </button>
                    <button class="px-3 py-1 rounded bg-film-red text-white">1</button>
                    <button class="px-3 py-1 rounded bg-film-gray text-gray-400 hover:text-white border border-gray-700">2</button>
                    <button class="px-3 py-1 rounded bg-film-gray text-gray-400 hover:text-white border border-gray-700">3</button>
                    <span class="px-2 text-gray-500">...</span>
                    <button class="px-3 py-1 rounded bg-film-gray text-gray-400 hover:text-white border border-gray-700">10</button>
                    <button class="px-3 py-1 rounded bg-film-gray text-gray-400 hover:text-white border border-gray-700">
                        <i class="fas fa-chevron-right text-xs"></i>
                    </button>
                </nav>
            </div>
        </div>
    </div>
    
    <!-- Include footer if you have one -->
    @if(View::exists('partials.footer'))
        @include('partials.footer')
    @endif

    <script>
        // Additional JavaScript functionality can be added here
    </script>
</body>
</html>