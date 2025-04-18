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
                animation: {
                    'pulse-slow': 'pulse 3s infinite',
                },
            },
        },
    }
    </script>
    <style>
        /* Custom scrollbar styles */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #0F0F0F;
        }

        ::-webkit-scrollbar-thumb {
            background: #333;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #E50914;
        }
        
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
        
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        
        /* Video player styles */
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
        
        /* Shine effect */
        .shine-effect {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(
                90deg,
                rgba(255, 255, 255, 0) 0%,
                rgba(255, 255, 255, 0.05) 50%,
                rgba(255, 255, 255, 0) 100%
            );
            transform: translateX(-100%);
            pointer-events: none;
        }
        
        /* Progress bar animation */
        @keyframes progressAnimation {
            0% { width: 0%; }
            100% { width: 100%; }
        }
        
        .progress-animation {
            animation: progressAnimation 0.5s ease-out forwards;
        }
        
        /* Tooltip styles */
        .tooltip {
            position: relative;
        }
        
        .tooltip:hover::after {
            content: attr(data-tooltip);
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            padding: 5px 10px;
            background-color: rgba(0, 0, 0, 0.8);
            color: white;
            border-radius: 4px;
            font-size: 12px;
            white-space: nowrap;
            z-index: 10;
            margin-bottom: 5px;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col bg-[#0F0F0F] text-white">
    <!-- Global notification system -->
    <div 
        x-data="{ 
            show: false, 
            message: '', 
            type: 'success',
            timer: null 
        }"
        @notify.window="
            message = $event.detail.message; 
            type = $event.detail.type || 'success'; 
            show = true;
            clearTimeout(timer);
            timer = setTimeout(() => { show = false }, 3000);
        "
        x-show="show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform translate-y-2"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 transform translate-y-0"
        x-transition:leave-end="opacity-0 transform translate-y-2"
        class="fixed top-5 right-5 z-50 max-w-sm"
    >
        <div 
            class="flex items-center p-4 rounded-lg shadow-lg"
            :class="{
                'bg-green-500 text-white': type === 'success',
                'bg-red-500 text-white': type === 'error',
                'bg-blue-500 text-white': type === 'info',
                'bg-yellow-500 text-white': type === 'warning'
            }"
        >
            <!-- Icon based on type -->
            <div class="mr-3">
                <template x-if="type === 'success'">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </template>
                <template x-if="type === 'error'">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </template>
                <template x-if="type === 'info'">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </template>
                <template x-if="type === 'warning'">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </template>
            </div>
            
            <!-- Message -->
            <span x-text="message"></span>
            
            <!-- Close button -->
            <button @click="show = false" class="ml-auto text-white hover:text-gray-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Flash message notification -->
    @if (session('success'))
    <div id="flash-notification" class="fixed top-5 left-1/2 transform -translate-x-1/2 z-50 px-6 py-3 rounded-lg flex items-center justify-center shadow-lg max-w-[80%] text-center bg-green-500 text-white opacity-100 transition-opacity duration-500">
        <span>{{ session('success') }}</span>
    </div>
    @endif
    
    @if (session('error'))
    <div id="flash-notification" class="fixed top-5 left-1/2 transform -translate-x-1/2 z-50 px-6 py-3 rounded-lg flex items-center justify-center shadow-lg max-w-[80%] text-center bg-red-500 text-white opacity-100 transition-opacity duration-500">
        <span>{{ session('error') }}</span>
    </div>
    @endif

    <!-- Include Navbar -->
    @include('partials.navbar')

    <!-- Main Content -->
    <main class="flex-grow pt-16 bg-gradient-to-b from-[#0F0F0F] to-[#121212]">
        <!-- Hero section with series info -->
        <div class="relative w-full h-[200px] md:h-[300px] overflow-hidden">
            <!-- Background image with gradient overlay -->
            <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ asset('storage/' . ($series->backdrop_image ?? $series->poster)) }}');">
                <div class="absolute inset-0 bg-gradient-to-t from-[#0F0F0F] via-[#0F0F0F]/80 to-transparent"></div>
            </div>
            
            <!-- Series info -->
            <div class="absolute bottom-0 left-0 w-full p-6">
                <div class="container mx-auto flex items-end">
                    <div class="hidden md:block w-24 h-36 rounded-md overflow-hidden shadow-lg mr-6">
                        <img src="{{ asset('storage/' . $series->poster) }}" alt="{{ $series->title }}" class="w-full h-full object-cover">
                    </div>
                    <div>
                        <h1 class="text-3xl md:text-4xl font-bold text-white mb-2">{{ $series->title }}</h1>
                        <div class="flex items-center text-sm text-gray-300 mb-1">
                            <span class="mr-2">{{ $series->release_year ?? date('Y') }}</span>
                            <span class="w-1 h-1 bg-gray-500 rounded-full mr-2"></span>
                            <span class="mr-2">{{ $series->age_rating ?? '12+' }}</span>
                            <span class="w-1 h-1 bg-gray-500 rounded-full mr-2"></span>
                            <span>{{ $series->seasons->count() }} saison(s)</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content container -->
        <div class="container mx-auto px-4 py-6">
            <!-- Video player and episodes section -->
            <div class="flex flex-col lg:flex-row gap-6">
                <!-- Left column - Video Player and details -->
                <div class="lg:w-2/3">
                    <!-- Video player section -->
                    <div x-data="{ isPlaying: false, showControls: false, progress: 0, volume: 100, isMuted: false, isFullscreen: false }" class="mb-8">
                        <div class="relative rounded-xl overflow-hidden shadow-2xl bg-black">
                            <!-- Video title bar -->
                            <div class="flex items-center justify-between bg-[#1A1A1A] px-4 py-3">
                                <div class="flex items-center">
                                    <div class="bg-film-red text-white text-xs font-bold px-2 py-1 rounded mr-3">HD</div>
                                    <h2 class="text-sm md:text-base font-medium">S{{ $episode->season_number }} | E{{ $episode->episode_number }} - {{ $episode->title }}</h2>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <button 
                                        @click="$dispatch('notify', {message: 'Ajouté à votre liste', type: 'success'})"
                                        class="text-gray-400 hover:text-white transition-colors"
                                        data-tooltip="Ajouter à ma liste"
                                    >
                                        <i class="fas fa-plus text-sm"></i>
                                    </button>
                                    <button 
                                        @click="$dispatch('notify', {message: 'Vous aimez cet épisode', type: 'success'})"
                                        class="text-gray-400 hover:text-white transition-colors"
                                        data-tooltip="J'aime"
                                    >
                                        <i class="fas fa-thumbs-up text-sm"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Video container -->
                            <div 
                                class="video-container" 
                                @mouseenter="showControls = true" 
                                @mouseleave="showControls = false"
                            >
                                <video 
                                    id="videoPlayer"
                                    @play="isPlaying = true" 
                                    @pause="isPlaying = false"
                                    @timeupdate="progress = ($event.target.currentTime / $event.target.duration) * 100"
                                    controls 
                                    autoplay 
                                    poster="{{ asset('storage/' . ($series->content->cover_image ?? '')) }}" 
                                    class="w-full"
                                >
                                    @if(isset($episode->file_path) && $episode->file_path)
                                        <source src="{{ asset('storage/' . $episode->file_path) }}" type="video/mp4">
                                    @elseif(isset($episode->video_url))
                                        <source src="{{ $episode->video_url }}" type="video/mp4">
                                    @endif
                                    Votre navigateur ne supporte pas la lecture de vidéos.
                                </video>
                                
                                <!-- Custom video controls overlay -->
                                <div 
                                    class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 transition-opacity duration-300 flex flex-col justify-end p-4"
                                    :class="{ 'opacity-100': showControls }"
                                >
                                    <!-- Progress bar -->
                                    <div class="w-full h-1 bg-gray-600 rounded-full mb-4 relative cursor-pointer" @click="document.getElementById('videoPlayer').currentTime = ($event.offsetX / $event.target.offsetWidth) * document.getElementById('videoPlayer').duration">
                                        <div class="absolute top-0 left-0 h-full bg-film-red rounded-full" :style="`width: ${progress}%`"></div>
                                    </div>
                                    
                                    <!-- Controls -->
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-4">
                                            <!-- Play/Pause button -->
                                            <button @click="isPlaying ? document.getElementById('videoPlayer').pause() : document.getElementById('videoPlayer').play()" class="text-white hover:text-film-red transition-colors">
                                                <i class="fas" :class="isPlaying ? 'fa-pause' : 'fa-play'"></i>
                                            </button>
                                            
                                            <!-- Volume control -->
                                            <div class="flex items-center space-x-2">
                                                <button @click="isMuted = !isMuted; document.getElementById('videoPlayer').muted = isMuted" class="text-white hover:text-film-red transition-colors">
                                                    <i class="fas" :class="isMuted ? 'fa-volume-mute' : (volume > 50 ? 'fa-volume-up' : 'fa-volume-down')"></i>
                                                </button>
                                                <input 
                                                    type="range" 
                                                    min="0" 
                                                    max="100" 
                                                    x-model="volume" 
                                                    @input="document.getElementById('videoPlayer').volume = volume / 100"
                                                    class="w-20 h-1 bg-gray-600 rounded-full appearance-none cursor-pointer"
                                                >
                                            </div>
                                            
                                            <!-- Time display -->
                                            <div class="text-sm text-gray-300">
                                                <span x-text="Math.floor(document.getElementById('videoPlayer')?.currentTime / 60).toString().padStart(2, '0') + ':' + Math.floor(document.getElementById('videoPlayer')?.currentTime % 60).toString().padStart(2, '0')">00:00</span>
                                                <span>/</span>
                                                <span x-text="Math.floor(document.getElementById('videoPlayer')?.duration / 60).toString().padStart(2, '0') + ':' + Math.floor(document.getElementById('videoPlayer')?.duration % 60).toString().padStart(2, '0')">00:00</span>
                                            </div>
                                        </div>
                                        
                                        <div class="flex items-center space-x-4">
                                            <!-- Next episode button -->
                                            @if($nextEpisode)
                                            <a href="{{ route('watch.episode', ['seriesId' => $series->id, 'episodeId' => $nextEpisode->id]) }}" class="text-white hover:text-film-red transition-colors" data-tooltip="Épisode suivant">
                                                <i class="fas fa-step-forward"></i>
                                            </a>
                                            @endif
                                            
                                            <!-- Download dropdown -->
                                            <div class="relative" x-data="{ open: false }">
                                                <button @click="open = !open" class="text-white hover:text-film-red transition-colors" data-tooltip="Télécharger">
                                                    <i class="fas fa-download"></i>
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
                                                    class="absolute right-0 bottom-full mb-2 w-48 bg-[#242424] rounded-md shadow-lg py-1 z-50"
                                                >
                                                    @if(isset($episode->content) && isset($episode->content->contentFiles) && $episode->content->contentFiles->count() > 1)
                                                        @foreach($episode->content->contentFiles as $file)
                                                            <a 
                                                                href="{{ route('download.episode', ['seriesId' => $series->id, 'episodeId' => $episode->id, 'quality' => $file->quality]) }}" 
                                                                class="block px-4 py-2 text-sm text-gray-300 hover:bg-[#333] hover:text-white transition-colors"
                                                            >
                                                                Qualité {{ $file->quality }} ({{ $file->size_mb }} MB)
                                                            </a>
                                                        @endforeach
                                                    @else
                                                        <a 
                                                            href="{{ route('download.episode', ['seriesId' => $series->id, 'episodeId' => $episode->id]) }}" 
                                                            class="block px-4 py-2 text-sm text-gray-300 hover:bg-[#333] hover:text-white transition-colors"
                                                        >
                                                            Qualité standard
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                            
                                            <!-- Fullscreen button -->
                                            <button 
                                                @click="
                                                    isFullscreen = !isFullscreen;
                                                    if (isFullscreen) {
                                                        if (document.getElementById('videoPlayer').requestFullscreen) {
                                                            document.getElementById('videoPlayer').requestFullscreen();
                                                        } else if (document.getElementById('videoPlayer').webkitRequestFullscreen) {
                                                            document.getElementById('videoPlayer').webkitRequestFullscreen();
                                                        } else if (document.getElementById('videoPlayer').msRequestFullscreen) {
                                                            document.getElementById('videoPlayer').msRequestFullscreen();
                                                        }
                                                    } else {
                                                        if (document.exitFullscreen) {
                                                            document.exitFullscreen();
                                                        } else if (document.webkitExitFullscreen) {
                                                            document.webkitExitFullscreen();
                                                        } else if (document.msExitFullscreen) {
                                                            document.msExitFullscreen();
                                                        }
                                                    }
                                                " 
                                                class="text-white hover:text-film-red transition-colors"
                                                data-tooltip="Plein écran"
                                            >
                                                <i class="fas" :class="isFullscreen ? 'fa-compress' : 'fa-expand'"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Episode details card -->
                    <div class="bg-[#1A1A1A] rounded-xl overflow-hidden shadow-lg mb-8">
                        <div class="p-6">
                            <h1 class="text-2xl font-bold mb-2">{{ $episode->title }}</h1>
                            
                            <!-- Episode metadata -->
                            <div class="flex items-center text-sm text-gray-400 mb-4">
                                <span>Saison {{ $episode->season_number }}</span>
                                <span class="mx-2">•</span>
                                <span>Épisode {{ $episode->episode_number }}</span>
                                @if(isset($episode->duration))
                                <span class="mx-2">•</span>
                                <span>{{ $episode->duration }} min</span>
                                @endif
                                @if(isset($episode->release_date))
                                <span class="mx-2">•</span>
                                <span>{{ $episode->release_date }}</span>
                                @endif
                            </div>
                            
                            <!-- Episode description -->
                            <p class="text-gray-300 mb-6 leading-relaxed">{{ $episode->description }}</p>
                            
                            <!-- Action buttons -->
                            <div class="flex flex-wrap gap-3">
                                @if($nextEpisode)
                                <a href="{{ route('watch.episode', ['seriesId' => $series->id, 'episodeId' => $nextEpisode->id]) }}" 
                                   class="bg-film-red hover:bg-red-700 text-white px-5 py-2.5 rounded-md flex items-center transition-all duration-300 hover:shadow-[0_0_15px_rgba(229,9,20,0.3)]">
                                    <i class="fas fa-step-forward mr-2"></i> Épisode suivant
                                </a>
                                @endif
                                
                                @if(isset($episode->file_path) && $episode->file_path)
                                <a href="{{ route('download.episode', ['seriesId' => $series->id, 'episodeId' => $episode->id]) }}"
                                   class="bg-[#333] hover:bg-[#444] text-white px-5 py-2.5 rounded-md flex items-center transition-all duration-300">
                                    <i class="fas fa-download mr-2"></i> Télécharger
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Comments section -->
                    <div class="bg-[#1A1A1A] rounded-xl overflow-hidden shadow-lg mb-8" x-data="{ newComment: '', comments: [] }">
                        <div class="p-6">
                            <h2 class="text-xl font-bold mb-6 flex items-center">
                                <i class="fas fa-comments text-film-red mr-2"></i>
                                Commentaires
                            </h2>
                            
                            <!-- Comment form -->
                            <form @submit.prevent="
                                comments.unshift({
                                    id: Date.now(),
                                    user: 'Utilisateur',
                                    avatar: 'https://ui-avatars.com/api/?name=U&background=E50914&color=fff',
                                    content: newComment,
                                    date: 'À l\'instant',
                                    likes: 0,
                                    isLiked: false
                                });
                                newComment = '';
                                $dispatch('notify', {message: 'Commentaire ajouté !', type: 'success'});
                            " class="mb-6">
                                <div class="flex items-start gap-3">
                                    <div class="w-10 h-10 rounded-full overflow-hidden flex-shrink-0">
                                        <img src="https://ui-avatars.com/api/?name=U&background=E50914&color=fff" alt="Avatar" class="w-full h-full object-cover">
                                    </div>
                                    <div class="flex-grow">
                                        <textarea 
                                            x-model="newComment"
                                            placeholder="Ajouter un commentaire..."
                                            class="w-full bg-[#242424] border border-[#333] rounded-md p-3 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-film-red resize-none"
                                            rows="3"
                                        ></textarea>
                                        <div class="flex justify-end mt-2">
                                            <button 
                                                type="submit" 
                                                class="bg-film-red hover:bg-red-700 text-white px-4 py-2 rounded-md transition-colors duration-300"
                                                :disabled="!newComment.trim()"
                                                :class="{ 'opacity-50 cursor-not-allowed': !newComment.trim() }"
                                            >
                                                Publier
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            
                            <!-- Comments list -->
                            <template x-if="comments.length === 0">
                                <div class="text-center py-8 text-gray-400">
                                    <i class="fas fa-comments text-4xl mb-3 opacity-30"></i>
                                    <p>Soyez le premier à commenter cet épisode</p>
                                </div>
                            </template>
                            
                            <template x-for="comment in comments" :key="comment.id">
                                <div class="border-t border-[#333] py-4">
                                    <div class="flex items-start gap-3">
                                        <div class="w-10 h-10 rounded-full overflow-hidden flex-shrink-0">
                                            <img :src="comment.avatar" alt="Avatar" class="w-full h-full object-cover">
                                        </div>
                                        <div class="flex-grow">
                                            <div class="flex items-center justify-between">
                                                <div>
                                                    <span class="font-medium" x-text="comment.user"></span>
                                                    <span class="text-gray-500 text-sm ml-2" x-text="comment.date"></span>
                                                </div>
                                                <div class="text-gray-500 text-sm">
                                                    <button 
                                                        @click="comment.isLiked = !comment.isLiked; comment.likes += comment.isLiked ? 1 : -1"
                                                        class="flex items-center gap-1 hover:text-white transition-colors"
                                                        :class="{ 'text-film-red': comment.isLiked }"
                                                    >
                                                        <i class="fas fa-thumbs-up"></i>
                                                        <span x-text="comment.likes"></span>
                                                    </button>
                                                </div>
                                            </div>
                                            <p class="text-gray-300 mt-1" x-text="comment.content"></p>
                                            <div class="mt-2 text-sm">
                                                <button class="text-gray-500 hover:text-white transition-colors mr-4">Répondre</button>
                                                <button class="text-gray-500 hover:text-white transition-colors">Signaler</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
                
                <!-- Right column - Episodes list and download options -->
                <div class="lg:w-1/3">
                    <!-- Episodes panel -->
                    <div class="bg-[#1A1A1A] rounded-xl overflow-hidden shadow-lg mb-6" x-data="{ isOpen: true }">
                        <div class="bg-[#242424] p-4 flex justify-between items-center">
                            <h3 class="font-bold flex items-center">
                                <i class="fas fa-film text-film-red mr-2"></i>
                                Épisodes
                            </h3>
                            <div class="flex items-center gap-2">
                                <select 
                                    class="bg-[#333] text-white text-sm rounded px-2 py-1 border border-gray-700 focus:outline-none focus:ring-1 focus:ring-film-red" 
                                    onchange="window.location.href=this.value"
                                >
                                    @foreach($seasons as $season)
                                    <option value="#season{{ $season }}" {{ $episode->season_number == $season ? 'selected' : '' }}>
                                        Saison {{ $season }}
                                    </option>
                                    @endforeach
                                </select>
                                <button @click="isOpen = !isOpen" class="text-gray-400 hover:text-white">
                                    <i class="fas" :class="isOpen ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Episodes list -->
                        <div x-show="isOpen" class="max-h-[600px] overflow-y-auto">
                            @foreach($seasonEpisodes as $ep)
                            <div 
                                x-data="{ showOptions: false }"
                                @mouseenter="showOptions = true"
                                @mouseleave="showOptions = false"
                                class="relative border-b border-[#333] last:border-b-0 {{ $episode->id == $ep->id ? 'bg-[#242424]' : 'hover:bg-[#242424]' }} transition-colors"
                            >
                                <a href="{{ route('watch.episode', ['seriesId' => $series->id, 'episodeId' => $ep->id]) }}" 
                                   class="flex p-4 {{ $episode->id == $ep->id ? 'border-l-4 border-film-red pl-3' : 'pl-4' }}">
                                    <div class="w-16 h-9 bg-[#333] rounded overflow-hidden flex-shrink-0 mr-3">
                                        <img 
                                            src="{{ asset('storage/' . ($ep->thumbnail ?? '')) }}" 
                                            alt="Thumbnail" 
                                            class="w-full h-full object-cover"
                                        >
                                    </div>
                                    <div class="flex-grow">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <span class="text-sm text-gray-400">E{{ $ep->episode_number }}</span>
                                                <h4 class="font-medium truncate">{{ $ep->title }}</h4>
                                            </div>
                                            @if(isset($ep->duration))
                                            <span class="text-xs text-gray-500">{{ $ep->duration }} min</span>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                                
                                <!-- Episode options overlay -->
                                <div 
                                    x-show="showOptions"
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0"
                                    x-transition:enter-end="opacity-100"
                                    x-transition:leave="transition ease-in duration-150"
                                    x-transition:leave-start="opacity-100"
                                    x-transition:leave-end="opacity-0"
                                    class="absolute inset-0 bg-black/70 flex items-center justify-center gap-3"
                                >
                                    <a 
                                        href="{{ route('watch.episode', ['seriesId' => $series->id, 'episodeId' => $ep->id]) }}" 
                                        class="w-10 h-10 bg-film-red rounded-full flex items-center justify-center text-white hover:bg-red-700 transition-colors"
                                    >
                                        <i class="fas fa-play"></i>
                                    </a>
                                    <a 
                                        href="{{ route('download.episode', ['seriesId' => $series->id, 'episodeId' => $ep->id]) }}" 
                                        class="w-10 h-10 bg-[#333] rounded-full flex items-center justify-center text-white hover:bg-[#444] transition-colors"
                                    >
                                        <i class="fas fa-download"></i>
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Series info card -->
                    <div class="bg-[#1A1A1A] rounded-xl overflow-hidden shadow-lg mb-6">
                        <div class="p-6">
                            <h3 class="text-lg font-bold mb-4 flex items-center">
                                <i class="fas fa-info-circle text-film-red mr-2"></i>
                                Informations sur la série
                            </h3>
                            
                            <div class="flex flex-wrap gap-2 mb-4">
                                @if(isset($series->categories) && $series->categories->isNotEmpty())
                                    @foreach($series->categories as $category)
                                        <span class="bg-[#242424] text-sm text-gray-300 px-3 py-1 rounded-full">
                                            {{ $category->name }}
                                        </span>
                                    @endforeach
                                @endif
                            </div>
                            
                            <div class="text-gray-300 text-sm space-y-2">
                                <div class="flex">
                                    <span class="w-24 text-gray-500">Titre:</span>
                                    <span>{{ $series->title }}</span>
                                </div>
                                @if(isset($series->release_year))
                                <div class="flex">
                                    <span class="w-24 text-gray-500">Année:</span>
                                    <span>{{ $series->release_year }}</span>
                                </div>
                                @endif
                                <div class="flex">
                                    <span class="w-24 text-gray-500">Saisons:</span>
                                    <span>{{ $series->seasons->count() }}</span>
                                </div>
                                <div class="flex">
                                    <span class="w-24 text-gray-500">Épisodes:</span>
                                    <span>{{ $series->episodes ? $series->episodes->count() : ($seasonEpisodes ? $seasonEpisodes->count() : 'N/A') }}</span>
                                </div>
                                @if(isset($series->status))
                                <div class="flex">
                                    <span class="w-24 text-gray-500">Statut:</span>
                                    <span>{{ $series->status }}</span>
                                </div>
                                @endif
                                @if(isset($series->rating))
                                <div class="flex">
                                    <span class="w-24 text-gray-500">Note:</span>
                                    <span class="flex items-center">
                                        <i class="fas fa-star text-yellow-500 mr-1"></i>
                                        {{ $series->rating }}/10
                                    </span>
                                </div>
                                @endif
                            </div>
                            
                            @if(isset($series->content) && isset($series->content->description))
                            <div class="mt-4 pt-4 border-t border-[#333]">
                                <p class="text-gray-300 text-sm leading-relaxed">{{ $series->content->description }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Include Footer -->
    @include('partials.footer')

    <!-- Next episode notification -->
    <div 
        x-data="{ show: false }" 
        x-init="
            document.getElementById('videoPlayer').addEventListener('ended', () => {
                show = true;
                setTimeout(() => { show = false }, 10000);
            });
        "
        x-show="show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform translate-y-10"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 transform translate-y-0"
        x-transition:leave-end="opacity-0 transform translate-y-10"
        class="fixed bottom-10 right-10 bg-[#242424] rounded-lg shadow-2xl overflow-hidden z-50 max-w-sm"
    >
        @if($nextEpisode)
        <div class="p-4">
            <div class="flex items-start">
                <div class="w-16 h-9 bg-[#333] rounded overflow-hidden flex-shrink-0 mr-3">
                    <img 
                        src="{{ asset('storage/' . ($nextEpisode->thumbnail ?? '')) }}" 
                        alt="Next episode" 
                        class="w-full h-full object-cover"
                    >
                </div>
                <div class="flex-grow">
                    <h4 class="font-medium">Épisode suivant</h4>
                    <p class="text-sm text-gray-400 truncate">{{ $nextEpisode->title }}</p>
                </div>
                <button @click="show = false" class="text-gray-500 hover:text-white">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="mt-3 flex gap-2">
                <a 
                    href="{{ route('watch.episode', ['seriesId' => $series->id, 'episodeId' => $nextEpisode->id]) }}" 
                    class="flex-grow bg-film-red hover:bg-red-700 text-white py-2 rounded text-center transition-colors"
                >
                    Regarder
                </a>
                <button 
                    @click="show = false" 
                    class="bg-[#333] hover:bg-[#444] text-white py-2 px-4 rounded transition-colors"
                >
                    Plus tard
                </button>
            </div>
        </div>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const video = document.getElementById('videoPlayer');
            
            // Save watch progress
            if (video) {
                video.addEventListener('timeupdate', function() {
                    if (video.currentTime > 0) {
                        const progress = (video.currentTime / video.duration) * 100;
                        localStorage.setItem('watchProgress_{{ $episode->id }}', video.currentTime);
                        
                        // Update progress bar in UI
                        const activeEpisode = document.querySelector('.episode-item.active');
                        if (activeEpisode) {
                            const progressBar = activeEpisode.querySelector('.bg-film-red');
                            if (progressBar) {
                                progressBar.style.width = progress + '%';
                            }
                        }
                    }
                });
                
                // Resume playback from saved position
                const savedTime = localStorage.getItem('watchProgress_{{ $episode->id }}');
                if (savedTime && savedTime > 0) {
                    video.currentTime = savedTime;
                }
            }
            
            // Auto-hide flash notification
            const flashNotification = document.getElementById('flash-notification');
            if (flashNotification) {
                setTimeout(() => {
                    flashNotification.classList.add('opacity-0');
                    setTimeout(() => {
                        flashNotification.style.display = 'none';
                    }, 500);
                }, 3000);
            }
            
            // Add shine effect to buttons
            document.querySelectorAll('.bg-film-red').forEach(button => {
                const shine = document.createElement('div');
                shine.classList.add('shine-effect');
                
                button.addEventListener('mouseenter', () => {
                    anime({
                        targets: shine,
                        translateX: ['0%', '200%'],
                        easing: 'easeInOutSine',
                        duration: 800,
                        delay: 200
                    });
                });
            });
        });
    </script>
    
    <!-- Add anime.js for animations -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
</body>
</html>
