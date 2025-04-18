<div class="container mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-8">
        <h2 class="text-3xl font-bold text-white relative">
            <span class="relative z-10">Séries</span>
            <span class="absolute -bottom-2 left-0 w-1/3 h-1 bg-film-red rounded-full"></span>
        </h2>
        <a href="" class="text-gray-300 hover:text-white transition-colors duration-300 flex items-center group">
            <span>Voir tout</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1 transform group-hover:translate-x-1 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </a>
    </div>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
        @forelse ($series as $seriesItem)
            <div 
                x-data="{ 
                    showDetails: false,
                    isHovered: false,
                    playAnimation: false
                }" 
                x-init="$nextTick(() => { playAnimation = true })"
                @mouseenter="isHovered = true" 
                @mouseleave="isHovered = false"
                class="movie-card bg-[#0A0A0A] rounded-lg overflow-hidden shadow-lg transition-all duration-300 hover:shadow-2xl relative transform hover:-translate-y-1"
                :class="{ 'ring-2 ring-film-red': isHovered }"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform scale-95"
                x-transition:enter-end="opacity-100 transform scale-100"
            >
                <!-- Image with overlay -->
                <div class="relative overflow-hidden group">
                    <div class="aspect-[16/9] overflow-hidden">
                        <img 
                            src="{{ asset('storage/' . $seriesItem->content->cover_image) }}" 
                            alt="{{ $seriesItem->content->title ?? 'Movie poster' }}"
                            onerror="this.onerror=null; this.src='https://via.placeholder.com/300x450?text=No+Image';" 
                            class="w-full h-full object-cover transition-transform duration-500"
                            :class="isHovered ? 'scale-110' : 'scale-100'"
                        >
                    </div>
                    
                    <!-- Shine effect div -->
                    <div 
                        class="absolute inset-0 bg-gradient-to-tr from-transparent via-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"
                        style="transform: translateX(-100%); pointer-events: none;"
                        x-effect="if (isHovered) { anime({ targets: $el, translateX: '200%', easing: 'easeInOutSine', duration: 800, delay: 200 }) }"
                    ></div>
                    
                    <!-- Dark gradient overlay for better text readability -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black via-black/70 to-transparent opacity-80 group-hover:opacity-90 transition-opacity duration-300"></div>
                    
                    <!-- Top info overlay (always visible) -->
                    <div class="absolute top-3 left-3 right-3 flex justify-between">
                        <!-- Categories badges -->
                        @if(isset($seriesItem->content->categories) && $seriesItem->content->categories->isNotEmpty())
                            <div class="flex flex-wrap gap-1">
                                @foreach($seriesItem->content->categories->take(1) as $category)
                                    <span class="bg-film-red text-xs font-bold text-white px-3 py-1 rounded-full shadow-md backdrop-blur-sm">
                                        {{ $category->name }}
                                    </span>
                                @endforeach
                            </div>
                        @endif
                        
                        <!-- Rating badge if available -->
                        <div class="flex items-center bg-yellow-500 text-black font-bold text-xs px-2 py-1 rounded-full shadow-md backdrop-blur-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <span x-text="'8.' + Math.floor(Math.random() * 10)">8.5</span>
                        </div>
                    </div>
                    
                    <!-- Play button overlay (visible on hover) -->
                    <div 
                        class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300"
                        x-show="isHovered"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 transform scale-90"
                        x-transition:enter-end="opacity-100 transform scale-100"
                    >
                        <button 
                            @click="window.location.href='{{ route('watch.episode', ['seriesId' => $seriesItem->id]) }}'"
                            class="bg-film-red/90 hover:bg-film-red text-white rounded-full p-3 transform transition-transform duration-300 hover:scale-110 shadow-lg"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </button>
                    </div>
                </div>
                
                <!-- Card content -->
                <div class="p-4">
                    <h3 class="text-lg font-bold text-white mb-2 line-clamp-1 group-hover:text-film-red transition-colors duration-300">
                        {{ $seriesItem->content->title ?? '' }}
                    </h3>
                    
                    <!-- Description - always visible but limited to 2 lines -->
                    <p class="text-gray-300 text-sm mb-3 line-clamp-2 leading-relaxed">
                        {{ $seriesItem->content->description ?? '' }}
                    </p>
                    
                    <!-- Tags - always visible -->
                    @if(isset($seriesItem->content->tags) && $seriesItem->content->tags->isNotEmpty())
                        <div class="flex flex-wrap gap-1 mb-3">
                            @foreach($seriesItem->content->tags->take(2) as $tag)
                                <span class="bg-[#1A1A1A] text-xs text-gray-300 px-2 py-1 rounded-full">
                                    {{ $tag->name }}
                                </span>
                            @endforeach
                        </div>
                    @endif
                    
                    <!-- Action buttons -->
                    <div class="flex items-center justify-between gap-2">
                        <!-- Watch Now button -->
                        <a 
                            href="{{ route('watch.episode', ['seriesId' => $seriesItem->id]) }}"
                            class="bg-film-red text-white flex-1 px-4 py-2 rounded-md transform transition-all duration-300 hover:bg-red-700 flex items-center justify-center gap-2 text-sm font-medium"
                            :class="{ 'shadow-[0_0_15px_rgba(229,9,20,0.5)]': isHovered }"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                            </svg>
                            Regarder
                        </a>
                        
                        <!-- Add to watchlist button -->
                        <button 
                            @click="$dispatch('notify', {message: 'Ajouté à votre liste', type: 'success'})"
                            class="bg-[#1A1A1A] hover:bg-[#252525] text-white p-2 rounded-md transition-colors duration-300"
                            title="Ajouter à ma liste"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                        </button>
                        
                        <!-- Info button -->
                        <button 
                            @click="showDetails = !showDetails"
                            class="bg-[#1A1A1A] hover:bg-[#252525] text-white p-2 rounded-md transition-colors duration-300"
                            title="Plus d'informations"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </button>
                    </div>
                </div>
                
                <!-- Details panel (shown when info button is clicked) -->
                <div 
                    x-show="showDetails" 
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform translate-y-4"
                    x-transition:enter-end="opacity-100 transform translate-y-0"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 transform translate-y-0"
                    x-transition:leave-end="opacity-0 transform translate-y-4"
                    class="absolute inset-0 bg-black/95 z-10 p-4 overflow-y-auto"
                    @click.away="showDetails = false"
                >
                    <button @click="showDetails = false" class="absolute top-2 right-2 text-gray-400 hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                    
                    <h3 class="text-xl font-bold text-white mb-2">{{ $seriesItem->content->title ?? '' }}</h3>
                    
                    <div class="flex items-center gap-2 mb-3">
                        <span class="text-sm text-gray-400">2023</span>
                        <span class="w-1 h-1 bg-gray-500 rounded-full"></span>
                        <span class="text-sm text-gray-400">{{ rand(1, 5) }} saison(s)</span>
                        <span class="w-1 h-1 bg-gray-500 rounded-full"></span>
                        <span class="text-sm text-gray-400">HD</span>
                    </div>
                    
                    <p class="text-gray-300 text-sm mb-4">{{ $seriesItem->content->description ?? '' }}</p>
                    
                    <!-- All categories -->
                    @if(isset($seriesItem->content->categories) && $seriesItem->content->categories->isNotEmpty())
                        <div class="mb-3">
                            <h4 class="text-sm font-semibold text-gray-400 mb-1">Catégories:</h4>
                            <div class="flex flex-wrap gap-1">
                                @foreach($seriesItem->content->categories as $category)
                                    <span class="bg-[#1A1A1A] text-xs text-gray-300 px-2 py-1 rounded-full">
                                        {{ $category->name }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    
                    <!-- All tags -->
                    @if(isset($seriesItem->content->tags) && $seriesItem->content->tags->isNotEmpty())
                        <div class="mb-4">
                            <h4 class="text-sm font-semibold text-gray-400 mb-1">Tags:</h4>
                            <div class="flex flex-wrap gap-1">
                                @foreach($seriesItem->content->tags as $tag)
                                    <span class="bg-[#1A1A1A] text-xs text-gray-300 px-2 py-1 rounded-full">
                                        {{ $tag->name }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    
                    <a 
                        href="{{ route('watch.episode', ['seriesId' => $seriesItem->id]) }}"
                        class="bg-film-red text-white w-full py-2 rounded-md transform transition-all duration-300 hover:bg-red-700 flex items-center justify-center gap-2 text-sm font-medium"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Regarder maintenant
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12 bg-[#0A0A0A] rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-700 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h18M3 16h18" />
                </svg>
                <p class="text-gray-400 text-lg">Aucune série disponible</p>
                <p class="text-gray-500 mt-2">Revenez plus tard pour découvrir nos nouvelles séries</p>
            </div>
        @endforelse
    </div>
</div>

<!-- Notification component with Alpine.js -->
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

<!-- Include anime.js library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>

<!-- Include external CSS and JS files -->
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<link rel="stylesheet" href="{{ asset('css/movies.css') }}">
<script src="{{ asset('js/movie-cards.js') }}"></script>
<script src="{{ asset('js/notifications.js') }}"></script>
