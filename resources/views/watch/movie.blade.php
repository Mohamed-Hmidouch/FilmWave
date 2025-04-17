<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $movie->title }} - FilmWave</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.0/css/all.min.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body {
            background-color: #0F0F0F;
            color: #fff;
        }
        .video-container {
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .video-container iframe, 
        .video-container video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
        .movie-card {
            transition: all 0.3s ease;
        }
        .movie-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.4);
        }
        .control-button {
            transition: all 0.3s ease;
        }
        .control-button:hover {
            transform: translateY(-2px);
        }
        .control-button:hover::before {
            left: 100%;
        }
        .notification-toast {
            animation: fadeOut 0.5s ease 5s forwards;
        }
        @keyframes fadeOut {
            from { opacity: 1; }
            to { opacity: 0; visibility: hidden; }
        }
        .player-controls-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.9) 0%, rgba(0,0,0,0) 100%);
            padding: 30px 20px 10px;
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: 10;
        }
        .player-controls-overlay a {
            font-size: 1.2rem;
            transition: all 0.2s ease;
        }
        .player-controls-overlay a:hover {
            color: #E50914 !important;
            transform: scale(1.1);
        }
        .video-container:hover .player-controls-overlay {
            opacity: 1;
        }
        .text-film-red {
            color: #E50914;
        }
        .hover\:text-film-red:hover {
            color: #E50914;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col">
    <!-- Header/Navigation -->
    <header class="bg-[#141414] shadow-md">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <a href="{{ route('home') }}" class="text-red-600 font-bold text-2xl">FilmWave</a>
            <nav class="flex items-center space-x-6">
                <a href="{{ route('home') }}" class="text-gray-300 hover:text-white transition">Accueil</a>
                <a href="{{ route('movies') }}" class="text-gray-300 hover:text-white transition">Films</a>
                <a href="{{ route('tvshows') }}" class="text-gray-300 hover:text-white transition">Séries</a>
                <a href="{{ route('my-list') }}" class="text-gray-300 hover:text-white transition">Ma Liste</a>
                <button class="text-gray-300 hover:text-white">
                    <i class="fas fa-search"></i>
                </button>
                <a href="{{ route('profile') }}" class="flex items-center text-gray-300 hover:text-white">
                    <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}" alt="Profile" class="w-8 h-8 rounded-full">
                </a>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow">
        <!-- Notification -->
        @if(session('info'))
        <div class="bg-blue-500 text-white p-4 fixed top-20 right-4 rounded shadow-lg z-50 notification-toast">
            {{ session('info') }}
            <button class="ml-2 font-bold" onclick="this.parentElement.remove()">&times;</button>
        </div>
        @endif
        
        <!-- Video Player Section -->
        <section class="bg-black">
            <div class="container mx-auto">
                <div class="video-container relative">
                    <!-- Remplacer par l'URL vidéo réelle du film -->
                    <video controls autoplay poster="{{ $movie->poster ?? 'https://via.placeholder.com/1280x720' }}" class="w-full">
                        <source src="{{ $movie->video_url ?? 'https://example.com/placeholder.mp4' }}" type="video/mp4">
                        Votre navigateur ne supporte pas la lecture de vidéos.
                    </video>
                    
                    <!-- Overlay controls that appear on hover -->
                    <div class="player-controls-overlay">
                        <div class="flex justify-between items-center">
                            <div class="text-sm text-gray-300">
                                <span class="movie-duration">{{ $movie->duration ?? '120' }} min</span>
                            </div>
                            <div class="flex space-x-3">
                                <a href="{{ route('download.movie', ['movieId' => $movie->id]) }}" class="text-white hover:text-film-red transition">
                                    <i class="fas fa-download"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Movie Information and Controls -->
        <section class="bg-[#141414] py-6">
            <div class="container mx-auto px-4">
                <div class="flex flex-col lg:flex-row">
                    <!-- Movie Info -->
                    <div class="lg:w-2/3">
                        <h1 class="text-3xl font-bold mb-2">{{ $movie->title }}</h1>
                        <div class="flex items-center space-x-4 text-sm text-gray-400 mb-4">
                            <span>{{ $movie->release_year ?? date('Y') }}</span>
                            <span>{{ $movie->duration ?? '120' }} min</span>
                            <span>{{ $movie->age_rating ?? 'PG-13' }}</span>
                            <div class="flex items-center">
                                <i class="fas fa-star text-yellow-500 mr-1"></i>
                                <span>{{ $movie->rating ?? '8.5' }}/10</span>
                            </div>
                        </div>
                        
                        <p class="text-gray-300 mb-6">{{ $movie->description ?? 'Description du film non disponible.' }}</p>
                        
                        <!-- Movie Controls -->
                        <div class="flex space-x-4 mb-8">
                            <button onclick="restartMovie()" class="bg-white text-black px-4 py-2 rounded-md flex items-center control-button">
                                <i class="fas fa-redo mr-2"></i> Recommencer
                            </button>
                            <button class="bg-transparent border border-gray-600 text-white px-4 py-2 rounded-md flex items-center control-button">
                                <i class="fas fa-plus mr-2"></i> Ma liste
                            </button>
                            <button class="bg-transparent border border-gray-600 text-white px-4 py-2 rounded-md flex items-center control-button">
                                <i class="fas fa-thumbs-up mr-2"></i> J'aime
                            </button>
                            <button class="bg-transparent border border-gray-600 text-white px-4 py-2 rounded-md flex items-center control-button">
                                <i class="fas fa-share mr-2"></i> Partager
                            </button>
                            <div class="relative group" x-data="{ open: false }">
                                <button 
                                    @click="open = !open" 
                                    class="bg-transparent border border-gray-600 text-white px-4 py-2 rounded-md flex items-center control-button"
                                >
                                    <i class="fas fa-download mr-2"></i> Télécharger
                                    <i class="fas fa-chevron-down ml-2 text-xs transition-transform" :class="{ 'rotate-180': open }"></i>
                                </button>
                                <div 
                                    x-show="open" 
                                    @click.away="open = false"
                                    x-transition:enter="transition ease-out duration-200" 
                                    x-transition:enter-start="opacity-0 transform scale-95" 
                                    x-transition:enter-end="opacity-100 transform scale-100" 
                                    x-transition:leave="transition ease-in duration-150" 
                                    x-transition:leave-start="opacity-100 transform scale-100" 
                                    x-transition:leave-end="opacity-0 transform scale-95" 
                                    class="absolute right-0 mt-2 w-48 bg-[#242424] rounded-md shadow-lg py-1 z-50"
                                >
                                    @if(isset($movie->content) && isset($movie->content->contentFiles) && $movie->content->contentFiles->count() > 1)
                                        @foreach($movie->content->contentFiles as $file)
                                            <a 
                                                href="{{ route('download.movie', ['movieId' => $movie->id, 'quality' => $file->quality]) }}" 
                                                class="block px-4 py-2 text-sm text-gray-300 hover:bg-[#333] hover:text-white transition-colors"
                                            >
                                                Qualité {{ $file->quality }} ({{ $file->size_mb }} MB)
                                            </a>
                                        @endforeach
                                    @else
                                        <a 
                                            href="{{ route('download.movie', ['movieId' => $movie->id]) }}" 
                                            class="block px-4 py-2 text-sm text-gray-300 hover:bg-[#333] hover:text-white transition-colors"
                                        >
                                            Qualité standard
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <!-- Movie Details -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold mb-2">Détails du film</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-gray-400"><span class="text-white">Réalisateur:</span> {{ $movie->director ?? 'Non spécifié' }}</p>
                                    <p class="text-gray-400"><span class="text-white">Scénariste:</span> {{ $movie->writer ?? 'Non spécifié' }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-400"><span class="text-white">Genres:</span> 
                                        @if(isset($movie->categories) && $movie->categories->count() > 0)
                                            {{ $movie->categories->pluck('name')->join(', ') }}
                                        @else
                                            Action, Aventure
                                        @endif
                                    </p>
                                    <p class="text-gray-400"><span class="text-white">Langues:</span> Français, Anglais</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Cast Information -->
                    <div class="lg:w-1/3 lg:pl-8">
                        <h3 class="text-lg font-semibold mb-4">Distribution</h3>
                        <div class="grid grid-cols-2 gap-4">
                            @if(isset($movie->actors) && $movie->actors->count() > 0)
                                @foreach($movie->actors as $actor)
                                <div class="flex items-center">
                                    <img src="{{ $actor->photo ?? 'https://via.placeholder.com/50x50' }}" alt="{{ $actor->name }}" class="w-10 h-10 rounded-full object-cover">
                                    <div class="ml-3">
                                        <p class="text-white text-sm">{{ $actor->name }}</p>
                                        <p class="text-gray-400 text-xs">{{ $actor->pivot->character_name ?? 'Personnage' }}</p>
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <!-- Dummy data if no actors are available -->
                                <div class="flex items-center">
                                    <img src="https://via.placeholder.com/50x50" alt="Actor 1" class="w-10 h-10 rounded-full object-cover">
                                    <div class="ml-3">
                                        <p class="text-white text-sm">John Doe</p>
                                        <p class="text-gray-400 text-xs">Personnage principal</p>
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <img src="https://via.placeholder.com/50x50" alt="Actor 2" class="w-10 h-10 rounded-full object-cover">
                                    <div class="ml-3">
                                        <p class="text-white text-sm">Jane Smith</p>
                                        <p class="text-gray-400 text-xs">Personnage secondaire</p>
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <img src="https://via.placeholder.com/50x50" alt="Actor 3" class="w-10 h-10 rounded-full object-cover">
                                    <div class="ml-3">
                                        <p class="text-white text-sm">Robert Brown</p>
                                        <p class="text-gray-400 text-xs">Antagoniste</p>
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <img src="https://via.placeholder.com/50x50" alt="Actor 4" class="w-10 h-10 rounded-full object-cover">
                                    <div class="ml-3">
                                        <p class="text-white text-sm">Emily Clark</p>
                                        <p class="text-gray-400 text-xs">Personnage de soutien</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Similar Movies -->
        <section class="bg-[#0F0F0F] py-8">
            <div class="container mx-auto px-4">
                <h2 class="text-2xl font-bold mb-6">Films similaires</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                    @foreach($similarMovies as $similarMovie)
                    <div class="movie-card bg-[#1A1A1A] rounded-lg overflow-hidden shadow-lg">
                        <a href="{{ route('watch.movie', ['movieId' => $similarMovie->id]) }}">
                            <div class="relative">
                                <img src="{{ $similarMovie->poster ?? 'https://via.placeholder.com/300x450' }}" alt="{{ $similarMovie->title }}" class="w-full h-48 object-cover">
                                <div class="absolute inset-0 bg-black bg-opacity-20 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity">
                                    <div class="bg-red-600 rounded-full w-12 h-12 flex items-center justify-center">
                                        <i class="fas fa-play text-white"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <div class="p-3">
                            <h3 class="text-sm font-semibold truncate">{{ $similarMovie->title }}</h3>
                            <div class="flex justify-between items-center mt-1 text-xs text-gray-400">
                                <span>{{ $similarMovie->release_year ?? date('Y') }}</span>
                                <span>{{ $similarMovie->duration ?? '120' }} min</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-[#141414] py-6">
        <div class="container mx-auto px-4">
            <div class="text-gray-500 text-sm text-center">
                &copy; {{ date('Y') }} FilmWave. Tous droits réservés.
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const video = document.querySelector('video');
            
            // Enregistrer la progression de visionnage
            video.addEventListener('timeupdate', function() {
                if (video.currentTime > 0) {
                    localStorage.setItem('watchProgress_movie_{{ $movie->id }}', video.currentTime);
                }
            });
            
            // Reprendre la lecture là où l'utilisateur s'était arrêté
            const savedTime = localStorage.getItem('watchProgress_movie_{{ $movie->id }}');
            if (savedTime && savedTime > 0) {
                // Ne pas reprendre si on est presque à la fin du film
                if (savedTime < video.duration - 120) { // 2 minutes de la fin
                    video.currentTime = savedTime;
                }
            }
            
            // Fonction pour redémarrer le film
            window.restartMovie = function() {
                video.currentTime = 0;
                video.play();
            };
            
            // Gérer l'affichage des notifications toast
            function showToast(message, type = 'info') {
                const toast = document.createElement('div');
                toast.className = `${type === 'error' ? 'bg-red-500' : 'bg-blue-500'} text-white p-4 fixed top-20 right-4 rounded shadow-lg z-50 notification-toast`;
                toast.innerHTML = `
                    ${message}
                    <button class="ml-2 font-bold" onclick="this.parentElement.remove()">&times;</button>
                `;
                document.body.appendChild(toast);
                
                // Supprimer automatiquement après 5 secondes
                setTimeout(() => {
                    toast.remove();
                }, 5000);
            }
            
            // Ajouter des événements pour les boutons de téléchargement
            document.querySelectorAll('a[href^="/download/"]').forEach(link => {
                link.addEventListener('click', function(e) {
                    // Ne pas annuler l'événement - laissez le téléchargement se produire
                    // mais montrez une notification
                    showToast('Votre téléchargement va commencer dans quelques instants...', 'info');
                });
            });
        });
    </script>
</body>
</html> 