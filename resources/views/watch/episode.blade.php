<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $episode->title }} - {{ $series->title }} - FilmWave</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.0/css/all.min.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body {
            background-color: #0F0F0F;
            color: #FFFFFF;
        }
        
        /* Lecteur vidéo amélioré */
        .video-container {
            position: relative;
            padding-bottom: 56.25%; /* 16:9 aspect ratio */
            height: 0;
            overflow: hidden;
            background-color: #000;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.8);
            transition: all 0.3s ease;
        }
        
        .video-container:hover {
            box-shadow: 0 15px 40px rgba(229, 9, 20, 0.3);
        }
        
        .video-container iframe, 
        .video-container video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border-radius: 12px;
            outline: none;
        }
        
        /* Interface personnalisée autour du lecteur vidéo */
        .player-wrapper {
            position: relative;
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
        }
        
        .player-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.75rem;
        }
        
        .player-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #fff;
        }
        
        .player-quality-badge {
            background-color: #E50914;
            color: white;
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        
        .player-controls-overlay {
            position: absolute;
            bottom: -1px;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.9) 0%, rgba(0,0,0,0) 100%);
            padding: 30px 20px 10px;
            border-radius: 0 0 12px 12px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .video-container:hover .player-controls-overlay {
            opacity: 1;
        }
        
        /* Styles pour les contrôles après la vidéo */
        .episode-item {
            transition: all 0.3s ease;
        }
        
        .episode-item:hover {
            background-color: rgba(229, 9, 20, 0.1);
        }
        
        .episode-item.active {
            border-left: 4px solid #E50914;
            background-color: rgba(229, 9, 20, 0.2);
        }
        
        .control-button {
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }
        
        .control-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
            transition: all 0.6s ease;
            z-index: -1;
        }
        
        .control-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }
        
        .control-button:hover::before {
            left: 100%;
        }
        
        .notification-toast {
            transition: all 0.5s ease-out;
            box-shadow: 0 10px 25px rgba(0,0,0,0.5);
        }
        
        .notification-toast.fade-out {
            opacity: 0;
            transform: translateX(30px);
        }
        
        /* Info bars de l'épisode */
        .episode-info-bar {
            display: flex;
            align-items: center;
            margin-top: 8px;
            font-size: 0.875rem;
        }
        
        .info-dot {
            width: 4px;
            height: 4px;
            background-color: #555;
            border-radius: 50%;
            margin: 0 8px;
        }
        
        /* Panneau d'épisodes */
        .episodes-panel {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
            background-color: #1A1A1A;
            border: 1px solid #2a2a2a;
        }
        
        .episodes-header {
            background-color: #262626;
            border-bottom: 1px solid #333;
        }
        
        /* Different padding for the video container on larger screens */
        @media (min-width: 1024px) {
            .video-container {
                padding-bottom: 52%; /* Slightly shorter than 16:9 to give more space */
            }
        }
    </style>
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
                },
            },
        },
    }
    </script>
</head>
<body class="min-h-screen flex flex-col">
    <!-- Include Navbar -->
    @include('partials.navbar')

    <!-- Main Content -->
    <main class="flex-grow pt-16"> <!-- Ajout de padding-top pour compenser la navbar fixe -->
        <!-- Notification -->
        @if(session('info'))
        <div class="bg-blue-500 text-white p-4 fixed top-20 right-4 rounded shadow-lg z-50 notification-toast">
            {{ session('info') }}
            <button class="ml-2 font-bold" onclick="this.parentElement.remove()">&times;</button>
        </div>
        @endif
        
        <!-- Video Player Section with Episodes Side Panel -->
        <section class="bg-black min-h-screen">
            <div class="mx-auto px-4 py-6">
                <div class="flex flex-col lg:flex-row">
                    <!-- Left column - Video Player -->
                    <div class="lg:w-3/4 lg:pr-4 relative z-10">
                        <!-- Player header with title and quality badge -->
                        <div class="player-header">
                            <h2 class="player-title">{{ $series->title }} - S{{ $episode->season }}:E{{ $episode->episode_number }}</h2>
                            <div class="player-quality-badge">HD</div>
                        </div>
                        
                        <!-- Enhanced video player wrapper -->
                        <div class="player-wrapper">
                            <div class="video-container">
                                <video controls autoplay poster="{{ $episode->thumbnail ?? $series->poster }}" class="w-full">
                                    <source src="{{ $episode->video_url ?? 'https://example.com/placeholder.mp4' }}" type="video/mp4">
                                    Votre navigateur ne supporte pas la lecture de vidéos.
                                </video>
                                
                                <!-- Overlay controls that appear on hover -->
                                <div class="player-controls-overlay">
                                    <div class="flex justify-between items-center">
                                        <div class="text-sm text-gray-300">
                                            <span class="episode-duration">{{ $episode->duration ?? '45' }} min</span>
                                        </div>
                                        <div class="flex space-x-3">
                                            @if($nextEpisode)
                                            <a href="/watch/series/{{ $series->id }}/{{ $nextEpisode->id }}" class="text-white hover:text-film-red transition">
                                                <i class="fas fa-step-forward"></i>
                                            </a>
                                            @endif
                                            <a href="/download/series/{{ $series->id }}/{{ $episode->id }}" class="text-white hover:text-film-red transition">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Episode details and info with improved styling -->
                        <div class="bg-[#141414] p-5 rounded-xl shadow-lg">
                            <h1 class="text-2xl md:text-3xl font-bold mb-2">{{ $episode->title }}</h1>
                            
                            <!-- Info bars with relevant metadata -->
                            <div class="episode-info-bar text-gray-400 mb-4">
                                <span>Saison {{ $episode->season }}</span>
                                <span class="info-dot"></span>
                                <span>Épisode {{ $episode->episode_number }}</span>
                                <span class="info-dot"></span>
                                <span>{{ $episode->duration ?? '45' }} min</span>
                            </div>
                            
                            <p class="text-gray-300 mb-5 leading-relaxed">{{ $episode->description }}</p>
                            
                            <!-- Redesigned episode controls -->
                            <div class="flex flex-wrap gap-3 mb-6">
                                @if($nextEpisode)
                                <a href="/watch/series/{{ $series->id }}/{{ $nextEpisode->id }}" 
                                   class="bg-film-red hover:bg-red-700 text-white px-5 py-2.5 rounded-md flex items-center control-button">
                                    <i class="fas fa-step-forward mr-2"></i> Épisode suivant
                                </a>
                                @endif
                                <button class="bg-[#333] hover:bg-[#444] text-white px-5 py-2.5 rounded-md flex items-center control-button">
                                    <i class="fas fa-plus mr-2"></i> Ma liste
                                </button>
                                <button class="bg-[#333] hover:bg-[#444] text-white px-5 py-2.5 rounded-md flex items-center control-button">
                                    <i class="fas fa-thumbs-up mr-2"></i> J'aime
                                </button>
                                <a href="/download/series/{{ $series->id }}/{{ $episode->id }}" 
                                   class="bg-[#333] hover:bg-[#444] text-white px-5 py-2.5 rounded-md flex items-center control-button">
                                    <i class="fas fa-download mr-2"></i> Télécharger
                                </a>
                            </div>
                            
                            <!-- Series Details with better styling -->
                            <div class="mb-6 bg-[#1c1c1c] p-4 rounded-lg">
                                <h3 class="text-lg font-semibold mb-3 flex items-center">
                                    <i class="fas fa-info-circle mr-2 text-film-red"></i>
                                    À propos de {{ $series->title }}
                                </h3>
                                <div class="flex flex-wrap gap-3 text-sm text-gray-400 mb-3">
                                    <span class="px-2 py-1 bg-[#262626] rounded-md">{{ $series->release_year }}</span>
                                    <span class="px-2 py-1 bg-[#262626] rounded-md">{{ $series->age_rating }}</span>
                                    <span class="px-2 py-1 bg-[#262626] rounded-md">{{ $series->seasons->count() }} saison(s)</span>
                                    <span class="px-2 py-1 bg-[#262626] rounded-md"><i class="fas fa-closed-captioning mr-1"></i> CC</span>
                                </div>
                                <p class="text-gray-300 leading-relaxed">{{ $series->description }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Right column - Episodes List with improved styling -->
                    <div class="lg:w-1/4 mt-4 lg:mt-0 z-10">
                        <!-- Toggle button (visible on mobile only) with improved styling -->
                        <button id="toggleEpisodes" class="block lg:hidden w-full bg-film-red hover:bg-red-700 text-white py-3 px-4 rounded-md mb-2 flex items-center justify-between shadow-lg">
                            <span>Voir les épisodes</span>
                            <i class="fas fa-chevron-down transform transition-transform" id="toggleIcon"></i>
                        </button>
                        
                        <!-- Episodes panel with improved styling -->
                        <div id="episodesPanel" class="hidden lg:block episodes-panel">
                            <div class="episodes-header p-4 flex justify-between items-center">
                                <h3 class="font-bold">Épisodes</h3>
                                <select class="bg-[#333] text-white text-sm rounded px-2 py-1 border border-gray-700 focus:outline-none focus:ring-1 focus:ring-film-red" onchange="window.location.href=this.value">
                                    @foreach($seasons as $season)
                                    <option value="#season{{ $season }}" {{ $episode->season == $season ? 'selected' : '' }}>
                                        Saison {{ $season }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="max-h-[600px] overflow-y-auto">
                                @foreach($seasonEpisodes as $ep)
                                <a href="/watch/series/{{ $series->id }}/{{ $ep->id }}" 
                                   class="episode-item flex p-3 hover:bg-gray-800 {{ $episode->id == $ep->id ? 'active pl-2' : 'pl-3' }}">
                                    <div class="w-10 h-14 flex-shrink-0 flex items-center justify-center">
                                        <span class="text-gray-400">{{ $ep->episode_number }}</span>
                                    </div>
                                    <div class="ml-3 flex-grow">
                                        <h4 class="font-medium truncate">{{ $ep->title }}</h4>
                                        <div class="flex items-center text-xs text-gray-500 mt-1">
                                            <span>{{ $ep->duration }} min</span>
                                            @if($episode->id == $ep->id)
                                            <span class="ml-2 px-1.5 py-0.5 bg-film-red text-white text-xs rounded">En cours</span>
                                            @endif
                                        </div>
                                        <div class="mt-2 w-full bg-gray-700 h-1 rounded-full overflow-hidden">
                                            <div class="bg-film-red h-full rounded-full" style="width: {{ $episode->id == $ep->id ? '30%' : '0%' }}"></div>
                                        </div>
                                    </div>
                                </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Include Footer -->
    @include('partials.footer')

    <script>
        // Script pour gérer la lecture vidéo, les contrôles, etc.
        document.addEventListener('DOMContentLoaded', function() {
            const video = document.querySelector('video');
            
            // Enregistrer la progression de visionnage
            video.addEventListener('timeupdate', function() {
                if (video.currentTime > 0) {
                    const progress = (video.currentTime / video.duration) * 100;
                    localStorage.setItem('watchProgress_{{ $episode->id }}', video.currentTime);
                    
                    // Mettre à jour la barre de progression dans l'interface
                    const activeEpisode = document.querySelector('.episode-item.active');
                    if (activeEpisode) {
                        const progressBar = activeEpisode.querySelector('.bg-film-red');
                        if (progressBar) {
                            progressBar.style.width = progress + '%';
                        }
                    }
                }
            });
            
            // Reprendre la lecture là où l'utilisateur s'était arrêté
            const savedTime = localStorage.getItem('watchProgress_{{ $episode->id }}');
            if (savedTime && savedTime > 0) {
                video.currentTime = savedTime;
            }
            
            // Lorsque la vidéo se termine, proposer l'épisode suivant
            video.addEventListener('ended', function() {
                const nextEpisodeUrl = "{{ $nextEpisode ? '/watch/series/' . $series->id . '/' . $nextEpisode->id : '' }}";
                if (nextEpisodeUrl) {
                    // Afficher une notification stylisée pour passer à l'épisode suivant
                    const notification = document.createElement('div');
                    notification.className = 'fixed bottom-10 right-10 bg-film-red text-white p-4 rounded-md shadow-lg z-50 flex items-center';
                    notification.innerHTML = `
                        <div class="mr-4">
                            <p class="font-bold">Épisode suivant disponible</p>
                            <p class="text-sm">{{ $nextEpisode ? $nextEpisode->title : '' }}</p>
                        </div>
                        <a href="${nextEpisodeUrl}" class="bg-white text-film-red px-4 py-2 rounded-md hover:bg-gray-100 transition">
                            Regarder
                        </a>
                    `;
                    document.body.appendChild(notification);
                    
                    // Supprimer la notification après 10 secondes
                    setTimeout(() => {
                        notification.classList.add('fade-out');
                        setTimeout(() => {
                            notification.remove();
                        }, 500);
                    }, 10000);
                }
            });
            
            // Toggle episodes panel on mobile
            const toggleButton = document.getElementById('toggleEpisodes');
            const episodesPanel = document.getElementById('episodesPanel');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (toggleButton) {
                toggleButton.addEventListener('click', function() {
                    episodesPanel.classList.toggle('hidden');
                    toggleIcon.classList.toggle('rotate-180');
                    toggleButton.querySelector('span').textContent = 
                        episodesPanel.classList.contains('hidden') ? 'Voir les épisodes' : 'Masquer les épisodes';
                });
            }
        });
        
        // Auto-hide notification
        document.addEventListener('DOMContentLoaded', function() {
            const notification = document.querySelector('.notification-toast');
            if (notification) {
                setTimeout(() => {
                    notification.classList.add('fade-out');
                    setTimeout(() => {
                        notification.remove();
                    }, 500);
                }, 3000);
            }
        });
    </script>
</body>
</html> 