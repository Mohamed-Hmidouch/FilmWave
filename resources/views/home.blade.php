<!DOCTYPE html>
<html lang="en" x-data="{ isOpen: false, activeTab: 'movies' }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FilmWave - Your Ultimate Streaming Platform</title>
    <meta name="description" content="Stream the latest movies and TV shows on FilmWave">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'film-dark': '#0F0F0F',
                        'film-gray': '#1A1A1A',
                        'film-light': '#E5E5E5',
                        'film-red': '#E50914',
                        'film-accent': '#E50914',
                        'film-blue': '#1E40AF',
                        primary: {
                            50: '#f5f3ff',
                            100: '#ede9fe',
                            200: '#ddd6fe',
                            300: '#c4b5fd',
                            400: '#a78bfa',
                            500: '#8b5cf6',
                            600: '#7c3aed',
                            700: '#6d28d9',
                            800: '#5b21b6',
                            900: '#4c1d95',
                        },
                        secondary: {
                            500: '#EC4899',
                            600: '#DB2777',
                        },
                        dark: {
                            800: '#1A1A1A',
                            900: '#0F0F0F',
                        }
                    },
                    animation: {
                        'pulse-slow': 'pulse 3s infinite',
                    },
                }
            }
        }
    </script>
    <style>
        [x-cloak] { display: none !important; }
        .gradient-text {
            background: linear-gradient(45deg, #E50914, #FF5F1F);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .glass-effect {
            background: rgba(26, 26, 26, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
        .movie-card-hover {
            transition: all 0.3s ease;
        }
        .movie-card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 25px -5px rgba(229, 9, 20, 0.3);
        }
        .gradient-bg {
            background: linear-gradient(to right, #0F0F0F, #1A1A1A);
        }
        .tag {
            background-color: rgba(229, 9, 20, 0.2);
            color: #E50914;
            border-radius: 4px;
            padding: 2px 8px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        body {
          min-height: 100vh;
          display: flex;
          flex-direction: column;
        }
        
        footer {
          margin-bottom: 0;
          margin-top: auto;
        }
            
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .movie-card {
            transition: transform 0.3s ease;
        }

        .movie-card:hover {
            transform: scale(1.05);
        }

        /* Sidebar specific styles */
        .sidebar-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .sidebar-icon:hover {
            background-color: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }

        /* Main content layout */
        .main-content {
            transition: margin-left 0.3s ease-in-out;
        }

        /* Responsive adjustments */
        @media (min-width: 1024px) {
            .main-content {
                margin-left: 16rem; /* w-64 */
            }
        }

        @media (min-width: 768px) and (max-width: 1023px) {
            .main-content {
                margin-left: 18rem; /* w-72 */
            }
        }
    </style>
</head>
<body class="bg-film-dark text-white min-h-screen">
    <!-- Notification element for movies -->
    <div id="notification" class="notification">
        <span id="notification-message"></span>
                    </div>
                    
    <!-- Include sidebar -->
    @include('partials.sidebar')

    <!-- Main content wrapper -->
    <div class="main-content">
        @include('partials.navbar')
        
        <!-- Main content area -->
        <div class="w-full py-6">
            <!-- Hero Section -->
            <section class="relative pt-32 pb-20">
                <div class="absolute inset-0 bg-gradient-to-r from-film-dark to-transparent z-10"></div>
                <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('https://wallpapercave.com/wp/wp6581266.jpg');"></div>
                <div class="container mx-auto px-4 relative z-20">
                    <div class="max-w-2xl">
                        <div class="flex items-center space-x-2 mb-3">
                            <span class="tag">Drama</span>
                            <span class="tag">Crime</span>
                            <span class="tag">Thriller</span>
                                </div>
                        <h1 class="text-5xl font-bold mb-4">Succession</h1>
                        <div class="flex items-center space-x-4 mb-4">
                            <span class="text-film-red">2018-2023</span>
                            <span class="bg-film-red text-white text-xs px-2 py-1 rounded">HD</span>
                            <span class="text-gray-300">4 Seasons</span>
                            <div class="flex items-center">
                                <i class="fas fa-star text-yellow-500 mr-1"></i>
                                <span>8.9/10</span>
                            </div>
                        </div>
                        <p class="text-gray-300 mb-6">The Roy family is known for controlling the biggest media and entertainment company in the world. However, their world changes when their father steps down from the company.</p>
                        <div class="flex space-x-4">
                            <button class="bg-film-red hover:bg-red-700 text-white px-6 py-3 rounded-lg flex items-center space-x-2 transition">
                                <i class="fas fa-play"></i>
                                <span>Watch Now</span>
                            </button>
                            <button class="bg-film-gray hover:bg-gray-800 border border-film-red text-white px-6 py-3 rounded-lg flex items-center space-x-2 transition">
                                <i class="fas fa-plus"></i>
                                <span>My List</span>
                            </button>
                    </div>
                </div>
            </div>
        </section>

            <!-- Popular Series Section -->
            @include('partials._featured_movies', ['series' => $series])

            <!-- Content Tabs -->
            <section class="py-12">
            <div class="container mx-auto px-4">
                    <div class="flex items-center justify-between mb-8">
                        <div class="flex space-x-4 border-b border-film-gray pb-4">
                            <button @click="activeTab = 'movies'" :class="{ 'text-film-red border-b-2 border-film-red': activeTab === 'movies' }" class="text-gray-400 hover:text-film-red transition px-4 py-2">
                                Latest Movies
                            </button>
                            <button @click="activeTab = 'shows'" :class="{ 'text-film-red border-b-2 border-film-red': activeTab === 'shows' }" class="text-gray-400 hover:text-film-red transition px-4 py-2">
                                Latest Series
                            </button>
                            <button @click="activeTab = 'trending'" :class="{ 'text-film-red border-b-2 border-film-red': activeTab === 'trending' }" class="text-gray-400 hover:text-film-red transition px-4 py-2">
                                Trending Now
                            </button>
                            <button @click="activeTab = 'upcoming'" :class="{ 'text-film-red border-b-2 border-film-red': activeTab === 'upcoming' }" class="text-gray-400 hover:text-film-red transition px-4 py-2">
                                Upcoming
                            </button>
                        </div>
                    </div>

                    <!-- Movies Tab -->
                    <div x-show="activeTab === 'movies'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
                            <!-- Movie Card -->
                            <div class="group relative movie-card bg-film-gray rounded-lg overflow-hidden">
                                <div class="aspect-w-2 aspect-h-3">
                                    <img src="https://m.media-amazon.com/images/M/MV5BMTMxNTMwODM0NF5BMl5BanBnXkFtZTcwODAyMTk2Mw@@._V1_.jpg" alt="The Dark Knight" class="w-full h-64 object-cover">
                                    <div class="absolute inset-0 bg-gradient-to-t from-film-dark to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex items-end">
                                        <div class="p-4">
                                            <h3 class="text-white font-bold">The Dark Knight</h3>
                                            <div class="flex items-center text-sm mt-1">
                                                <span class="text-film-red mr-2">2008</span>
                                                <span class="text-yellow-500 flex items-center">
                                                    <i class="fas fa-star mr-1"></i> 9.0
                                                </span>
                                            </div>
                                            <div class="mt-3">
                                                <button class="bg-film-red hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                                                    <i class="fas fa-play mr-1"></i> Watch
                                                </button>
                    </div>
                </div>
                        </div>
                        </div>
                    </div>
                    
                    <!-- Movie Card 2 -->
                            <div class="group relative movie-card bg-film-gray rounded-lg overflow-hidden">
                                <div class="aspect-w-2 aspect-h-3">
                                    <img src="https://m.media-amazon.com/images/M/MV5BZjdkOTU3MDktN2IxOS00OGEyLWFmMjktY2FiMmZkNWIyODZiXkEyXkFqcGdeQXVyMTMxODk2OTU@._V1_.jpg" alt="Interstellar" class="w-full h-64 object-cover">
                                    <div class="absolute inset-0 bg-gradient-to-t from-film-dark to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex items-end">
                                        <div class="p-4">
                                            <h3 class="text-white font-bold">Interstellar</h3>
                                            <div class="flex items-center text-sm mt-1">
                                                <span class="text-film-red mr-2">2014</span>
                                                <span class="text-yellow-500 flex items-center">
                                                    <i class="fas fa-star mr-1"></i> 8.6
                                                </span>
                                            </div>
                                            <div class="mt-3">
                                                <button class="bg-film-red hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                                                    <i class="fas fa-play mr-1"></i> Watch
                                                </button>
                                            </div>
                                        </div>
                        </div>
                        </div>
                    </div>
                    
                    <!-- Movie Card 3 -->
                            <div class="group relative movie-card bg-film-gray rounded-lg overflow-hidden">
                                <div class="aspect-w-2 aspect-h-3">
                                    <img src="https://m.media-amazon.com/images/M/MV5BNzA1Njg4NzYxOV5BMl5BanBnXkFtZTgwODk5NjU3MzI@._V1_.jpg" alt="Blade Runner 2049" class="w-full h-64 object-cover">
                                    <div class="absolute inset-0 bg-gradient-to-t from-film-dark to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex items-end">
                                        <div class="p-4">
                                            <h3 class="text-white font-bold">Blade Runner 2049</h3>
                                            <div class="flex items-center text-sm mt-1">
                                                <span class="text-film-red mr-2">2017</span>
                                                <span class="text-yellow-500 flex items-center">
                                                    <i class="fas fa-star mr-1"></i> 8.1
                                                </span>
                                            </div>
                                            <div class="mt-3">
                                                <button class="bg-film-red hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                                                    <i class="fas fa-play mr-1"></i> Watch
                                                </button>
                                            </div>
                                        </div>
                        </div>
                        </div>
                    </div>
                    
                    <!-- Movie Card 4 -->
                            <div class="group relative movie-card bg-film-gray rounded-lg overflow-hidden">
                                <div class="aspect-w-2 aspect-h-3">
                                    <img src="https://m.media-amazon.com/images/M/MV5BNDE3ODcxYzMtY2YzZC00NmNlLWJiNDMtZDViZWM2MzIxZDYwXkEyXkFqcGdeQXVyNjAwNDUxODI@._V1_.jpg" alt="The Shawshank Redemption" class="w-full h-64 object-cover">
                                    <div class="absolute inset-0 bg-gradient-to-t from-film-dark to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex items-end">
                                        <div class="p-4">
                                            <h3 class="text-white font-bold">The Shawshank Redemption</h3>
                                            <div class="flex items-center text-sm mt-1">
                                                <span class="text-film-red mr-2">1994</span>
                                                <span class="text-yellow-500 flex items-center">
                                                    <i class="fas fa-star mr-1"></i> 9.3
                                                </span>
                                            </div>
                                            <div class="mt-3">
                                                <button class="bg-film-red hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                                                    <i class="fas fa-play mr-1"></i> Watch
                                                </button>
                                            </div>
                                        </div>
                        </div>
                        </div>
                    </div>
                    
                    <!-- Movie Card 5 -->
                            <div class="group relative movie-card bg-film-gray rounded-lg overflow-hidden">
                                <div class="aspect-w-2 aspect-h-3">
                                    <img src="https://m.media-amazon.com/images/M/MV5BYWZjMjk3ZTItODQ2ZC00NTY5LWE0ZDYtZTI3MjcwN2Q5NTVkXkEyXkFqcGdeQXVyODk4OTc3MTY@._V1_.jpg" alt="Parasite" class="w-full h-64 object-cover">
                                    <div class="absolute inset-0 bg-gradient-to-t from-film-dark to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex items-end">
                                        <div class="p-4">
                                            <h3 class="text-white font-bold">Parasite</h3>
                                            <div class="flex items-center text-sm mt-1">
                                                <span class="text-film-red mr-2">2019</span>
                                                <span class="text-yellow-500 flex items-center">
                                                    <i class="fas fa-star mr-1"></i> 8.5
                                                </span>
                                            </div>
                                            <div class="mt-3">
                                                <button class="bg-film-red hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                                                    <i class="fas fa-play mr-1"></i> Watch
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        </div>
                    </div>
                    
                    <!-- TV Shows Tab -->
                    <div x-show="activeTab === 'shows'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
                            <!-- TV Show Card 1 -->
                            <div class="group relative movie-card bg-film-gray rounded-lg overflow-hidden">
                                <div class="aspect-w-2 aspect-h-3">
                                    <img src="https://m.media-amazon.com/images/M/MV5BNDkyZThhNmMtZDBjYS00NDBmLTlkMjgtNWM2ZWYzZDQxZWU1XkEyXkFqcGdeQXVyMTMzODk3NDU0._V1_.jpg" alt="Breaking Bad" class="w-full h-64 object-cover">
                                    <div class="absolute inset-0 bg-gradient-to-t from-film-dark to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex items-end">
                                        <div class="p-4">
                                            <h3 class="text-white font-bold">Breaking Bad</h3>
                                            <div class="flex items-center text-sm mt-1">
                                                <span class="text-film-red mr-2">5 Seasons</span>
                                                <span class="text-yellow-500 flex items-center">
                                                    <i class="fas fa-star mr-1"></i> 9.5
                                                </span>
                                            </div>
                                            <div class="mt-3">
                                                <button class="bg-film-red hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                                                    <i class="fas fa-play mr-1"></i> Watch
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- TV Show Card 2 -->
                            <div class="group relative movie-card bg-film-gray rounded-lg overflow-hidden">
                                <div class="aspect-w-2 aspect-h-3">
                                    <img src="https://m.media-amazon.com/images/M/MV5BMDZkYmVhNjMtNWU4MC00MDQxLWE3MjYtZGMzZWI1ZjhlOWJmXkEyXkFqcGdeQXVyMTkxNjUyNQ@@._V1_.jpg" alt="Stranger Things" class="w-full h-64 object-cover">
                                    <div class="absolute inset-0 bg-gradient-to-t from-film-dark to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex items-end">
                                        <div class="p-4">
                                            <h3 class="text-white font-bold">Stranger Things</h3>
                                            <div class="flex items-center text-sm mt-1">
                                                <span class="text-film-red mr-2">4 Seasons</span>
                                                <span class="text-yellow-500 flex items-center">
                                                    <i class="fas fa-star mr-1"></i> 8.7
                                                </span>
                                            </div>
                                            <div class="mt-3">
                                                <button class="bg-film-red hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                                                    <i class="fas fa-play mr-1"></i> Watch
                                                </button>
                                            </div>
                                        </div>
                        </div>
                        </div>
                    </div>
                    
                            <!-- TV Show Card 3 -->
                            <div class="group relative movie-card bg-film-gray rounded-lg overflow-hidden">
                                <div class="aspect-w-2 aspect-h-3">
                                    <img src="https://m.media-amazon.com/images/M/MV5BYTRiNDQwYzAtMzVlZS00NTI5LWJjYjUtMzkwNTUzMWMxZTllXkEyXkFqcGdeQXVyNDIzMzcwNjc@._V1_.jpg" alt="Game of Thrones" class="w-full h-64 object-cover">
                                    <div class="absolute inset-0 bg-gradient-to-t from-film-dark to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex items-end">
                                        <div class="p-4">
                                            <h3 class="text-white font-bold">Game of Thrones</h3>
                                            <div class="flex items-center text-sm mt-1">
                                                <span class="text-film-red mr-2">8 Seasons</span>
                                                <span class="text-yellow-500 flex items-center">
                                                    <i class="fas fa-star mr-1"></i> 9.2
                                                </span>
                                            </div>
                                            <div class="mt-3">
                                                <button class="bg-film-red hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                                                    <i class="fas fa-play mr-1"></i> Watch
                                                </button>
                                            </div>
                                        </div>
                        </div>
                        </div>
                    </div>
                    
                            <!-- TV Show Card 4 -->
                            <div class="group relative movie-card bg-film-gray rounded-lg overflow-hidden">
                                <div class="aspect-w-2 aspect-h-3">
                                    <img src="https://m.media-amazon.com/images/M/MV5BYTU3ZWI5ZGMtZDdmMy00MjI2LWJmZjMtODk1OGU0MmU3MjM2XkEyXkFqcGdeQXVyMTkxNjUyNQ@@._V1_FMjpg_UX1000_.jpg" alt="The Mandalorian" class="w-full h-64 object-cover">
                                    <div class="absolute inset-0 bg-gradient-to-t from-film-dark to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex items-end">
                                        <div class="p-4">
                                            <h3 class="text-white font-bold">The Mandalorian</h3>
                                            <div class="flex items-center text-sm mt-1">
                                                <span class="text-film-red mr-2">3 Seasons</span>
                                                <span class="text-yellow-500 flex items-center">
                                                    <i class="fas fa-star mr-1"></i> 8.8
                                                </span>
                                            </div>
                                            <div class="mt-3">
                                                <button class="bg-film-red hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                                                    <i class="fas fa-play mr-1"></i> Watch
                                                </button>
                                            </div>
                                        </div>
                        </div>
                        </div>
                    </div>
                    
                            <!-- TV Show Card 5 -->
                            <div class="group relative movie-card bg-film-gray rounded-lg overflow-hidden">
                                <div class="aspect-w-2 aspect-h-3">
                                    <img src="https://m.media-amazon.com/images/M/MV5BN2FjNmEyNWMtYzM0ZS00NjIyLTg5YzYtYThlMGVjNzE1OGViXkEyXkFqcGdeQXVyMTkxNjUyNQ@@._V1_FMjpg_UX1000_.jpg" alt="The Witcher" class="w-full h-64 object-cover">
                                    <div class="absolute inset-0 bg-gradient-to-t from-film-dark to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex items-end">
                                        <div class="p-4">
                                            <h3 class="text-white font-bold">The Witcher</h3>
                                            <div class="flex items-center text-sm mt-1">
                                                <span class="text-film-red mr-2">2 Seasons</span>
                                                <span class="text-yellow-500 flex items-center">
                                                    <i class="fas fa-star mr-1"></i> 8.2
                                                </span>
                                            </div>
                                            <div class="mt-3">
                                                <button class="bg-film-red hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                                                    <i class="fas fa-play mr-1"></i> Watch
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        </div>
                    </div>
                    
                    <!-- Trending Tab -->
                    <div x-show="activeTab === 'trending'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
                            <!-- Trending content here -->
                    </div>
                </div>
            </div>
        </section>

            <!-- Genre Section -->
            <section class="py-12 bg-film-gray">
            <div class="container mx-auto px-4">
                    <h2 class="text-2xl font-bold mb-6">Browse by Genre</h2>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                        @foreach(['Action', 'Comedy', 'Drama', 'Horror', 'Sci-Fi', 'Thriller', 'Animation', 'Romance', 'Fantasy', 'Adventure', 'Crime', 'Documentary'] as $genre)
                        <a href="#" class="bg-film-dark hover:bg-film-gray border border-film-red text-white px-4 py-3 rounded-lg text-center transition hover:text-film-red">
                        {{ $genre }}
                    </a>
                    @endforeach
                </div>
            </div>
        </section>

            <!-- Featured Series -->
            <section class="py-12">
            <div class="container mx-auto px-4">
                <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold">Featured Series</h2>
                        <a href="#" class="text-film-red hover:text-red-600">View All</a>
                </div>
                        <div class="relative">
                        <div class="flex space-x-6 overflow-x-auto pb-4 scrollbar-hide">
                            <!-- Featured Show 1 -->
                            <div class="flex-shrink-0 w-[350px] rounded-lg overflow-hidden bg-film-gray movie-card-hover">
                                <div class="relative h-48">
                                    <img src="https://m.media-amazon.com/images/M/MV5BZGRjYjNmYmQtZTI4NS00ZGQwLTg1YzQtMzc4MjBhZDAxZjNkXkEyXkFqcGdeQXVyMTkxNjUyNQ@@._V1_.jpg" alt="The Last of Us" class="w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-gradient-to-t from-film-dark to-transparent"></div>
                                    <div class="absolute bottom-0 left-0 p-4">
                                        <span class="bg-film-red text-white px-2 py-1 rounded text-xs">NEW EPISODE</span>
                                    </div>
                                </div>
                                <div class="p-4">
                                    <h3 class="font-bold text-lg">The Last of Us</h3>
                                    <div class="flex items-center text-sm mt-1 text-gray-400">
                                        <span>HBO</span>
                                        <span class="mx-2">•</span>
                                        <span>Drama</span>
                                        <span class="mx-2">•</span>
                                        <span>2023</span>
                                    </div>
                                    <div class="flex items-center mt-2">
                                        <div class="flex items-center">
                                            <i class="fas fa-star text-yellow-500 mr-1"></i>
                                            <span>9.2</span>
                                        </div>
                                        <div class="ml-auto">
                                            <button class="bg-film-red hover:bg-red-700 text-white p-2 rounded-full">
                                                <i class="fas fa-play"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Featured Show 2 -->
                            <div class="flex-shrink-0 w-[350px] rounded-lg overflow-hidden bg-film-gray movie-card-hover">
                                <div class="relative h-48">
                                    <img src="https://m.media-amazon.com/images/M/MV5BZjBiOGIyY2YtOTA3OC00YzY1LThkYjktMGRkYTNhNTExY2I2XkEyXkFqcGdeQXVyMTkxNjUyNQ@@._V1_.jpg" alt="House of the Dragon" class="w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-gradient-to-t from-film-dark to-transparent"></div>
                                    <div class="absolute bottom-0 left-0 p-4">
                                        <span class="bg-film-red text-white px-2 py-1 rounded text-xs">POPULAR</span>
                                    </div>
                                </div>
                                <div class="p-4">
                                    <h3 class="font-bold text-lg">House of the Dragon</h3>
                                    <div class="flex items-center text-sm mt-1 text-gray-400">
                                        <span>HBO</span>
                                        <span class="mx-2">•</span>
                                        <span>Fantasy</span>
                                        <span class="mx-2">•</span>
                                        <span>2022</span>
                        </div>
                                    <div class="flex items-center mt-2">
                                        <div class="flex items-center">
                                            <i class="fas fa-star text-yellow-500 mr-1"></i>
                                            <span>8.8</span>
                            </div>
                                        <div class="ml-auto">
                                            <button class="bg-film-red hover:bg-red-700 text-white p-2 rounded-full">
                                                <i class="fas fa-play"></i>
                                            </button>
                        </div>
                    </div>
                                </div>
                            </div>

                            <!-- Featured Show 3 -->
                            <div class="flex-shrink-0 w-[350px] rounded-lg overflow-hidden bg-film-gray movie-card-hover">
                                <div class="relative h-48">
                                    <img src="https://m.media-amazon.com/images/M/MV5BZDdjN2FlNDEtOTlkOS00ZmI0LTllMzMtZjQzYzJjYzAwNWMwXkEyXkFqcGdeQXVyMTkxNjUyNQ@@._V1_.jpg" alt="Wednesday" class="w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-gradient-to-t from-film-dark to-transparent"></div>
                                    <div class="absolute bottom-0 left-0 p-4">
                                        <span class="bg-green-600 text-white px-2 py-1 rounded text-xs">100% MATCH</span>
                                    </div>
                                </div>
                                <div class="p-4">
                                    <h3 class="font-bold text-lg">Wednesday</h3>
                                    <div class="flex items-center text-sm mt-1 text-gray-400">
                                        <span>Netflix</span>
                                        <span class="mx-2">•</span>
                                        <span>Comedy Horror</span>
                                        <span class="mx-2">•</span>
                                        <span>2022</span>
                        </div>
                                    <div class="flex items-center mt-2">
                                        <div class="flex items-center">
                                            <i class="fas fa-star text-yellow-500 mr-1"></i>
                                            <span>8.2</span>
                            </div>
                                        <div class="ml-auto">
                                            <button class="bg-film-red hover:bg-red-700 text-white p-2 rounded-full">
                                                <i class="fas fa-play"></i>
                                            </button>
                        </div>
                    </div>
                                </div>
                            </div>

                            <!-- Featured Show 4 -->
                            <div class="flex-shrink-0 w-[350px] rounded-lg overflow-hidden bg-film-gray movie-card-hover">
                                <div class="relative h-48">
                                    <img src="https://m.media-amazon.com/images/M/MV5BZGE4ZWQ0MTAtMTM1NC00Y2FmLWJkMTctYjkzZDJlZjk5NTA3XkEyXkFqcGdeQXVyMTkxNjUyNQ@@._V1_.jpg" alt="The Bear" class="w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-gradient-to-t from-film-dark to-transparent"></div>
                                    <div class="absolute bottom-0 left-0 p-4">
                                        <span class="bg-film-red text-white px-2 py-1 rounded text-xs">TRENDING</span>
                                    </div>
                                </div>
                                <div class="p-4">
                                    <h3 class="font-bold text-lg">The Bear</h3>
                                    <div class="flex items-center text-sm mt-1 text-gray-400">
                                        <span>FX</span>
                                        <span class="mx-2">•</span>
                                        <span>Comedy Drama</span>
                                        <span class="mx-2">•</span>
                                        <span>2022</span>
                        </div>
                                    <div class="flex items-center mt-2">
                                        <div class="flex items-center">
                                            <i class="fas fa-star text-yellow-500 mr-1"></i>
                                            <span>8.7</span>
                            </div>
                                        <div class="ml-auto">
                                            <button class="bg-film-red hover:bg-red-700 text-white p-2 rounded-full">
                                                <i class="fas fa-play"></i>
                                            </button>
                        </div>
                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
            
            <!-- Additional content here -->
        </div>
        <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-20 hidden md:hidden"></div>
    </div>
    
    @include('partials.footer')
    @include('partials.scripts')
</body>
</html>