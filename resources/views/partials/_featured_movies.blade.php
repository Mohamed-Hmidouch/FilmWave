<div class="container mx-auto px-4 py-8"
     x-data="{ 
        selectedCategory: 'all',
        hoverCardId: null,
        voucherModal: { 
            show: false, 
            code: '',
            title: ''
        }
     }">
    <div class="flex items-center justify-between mb-8">
        <h2 class="text-3xl font-bold text-white relative">
            <span class="relative z-10">Séries</span>
            <span class="absolute -bottom-2 left-0 w-1/3 h-1 bg-film-red rounded-full"></span>
        </h2>
        
        <!-- Category Filter Tabs -->
        <div class="hidden md:flex space-x-2 items-center">
            <span class="text-gray-400 mr-2">Filter:</span>
            <button 
                @click="selectedCategory = 'all'" 
                :class="{'bg-film-red text-white': selectedCategory === 'all', 'bg-film-gray/70 text-gray-300 hover:bg-film-gray/90': selectedCategory !== 'all'}"
                class="px-3 py-1 rounded-full text-sm transition-colors duration-200"
            >
                All
            </button>
            <button 
                @click="selectedCategory = 'action'" 
                :class="{'bg-film-red text-white': selectedCategory === 'action', 'bg-film-gray/70 text-gray-300 hover:bg-film-gray/90': selectedCategory !== 'action'}"
                class="px-3 py-1 rounded-full text-sm transition-colors duration-200"
            >
                Action
            </button>
            <button 
                @click="selectedCategory = 'drama'" 
                :class="{'bg-film-red text-white': selectedCategory === 'drama', 'bg-film-gray/70 text-gray-300 hover:bg-film-gray/90': selectedCategory !== 'drama'}"
                class="px-3 py-1 rounded-full text-sm transition-colors duration-200"
            >
                Drama
            </button>
            <button 
                @click="selectedCategory = 'comedy'" 
                :class="{'bg-film-red text-white': selectedCategory === 'comedy', 'bg-film-gray/70 text-gray-300 hover:bg-film-gray/90': selectedCategory !== 'comedy'}"
                class="px-3 py-1 rounded-full text-sm transition-colors duration-200"
            >
                Comedy
            </button>
        </div>
        
        <a href="" class="text-gray-300 hover:text-white transition-colors duration-300 flex items-center group">
            <span>Voir tout</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1 transform group-hover:translate-x-1 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </a>
    </div>
    
    <!-- Mobile Category Filter Dropdown -->
    <div class="md:hidden mb-6">
        <div x-data="{ open: false }" class="relative">
            <button 
                @click="open = !open" 
                class="w-full flex items-center justify-between bg-film-gray/70 text-white px-4 py-2 rounded-lg"
            >
                <span x-text="selectedCategory === 'all' ? 'All Categories' : selectedCategory.charAt(0).toUpperCase() + selectedCategory.slice(1)"></span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" :class="{'rotate-180': open}">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            
            <div 
                x-show="open" 
                @click.away="open = false"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 transform -translate-y-2"
                x-transition:enter-end="opacity-100 transform translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 transform translate-y-0"
                x-transition:leave-end="opacity-0 transform -translate-y-2"
                class="absolute z-10 mt-1 w-full bg-film-gray/90 backdrop-blur-sm rounded-lg shadow-lg py-1"
                style="display: none;"
            >
                <button 
                    @click="selectedCategory = 'all'; open = false" 
                    class="block w-full text-left px-4 py-2 text-white hover:bg-film-red/20"
                >
                    All Categories
                </button>
                <button 
                    @click="selectedCategory = 'action'; open = false" 
                    class="block w-full text-left px-4 py-2 text-white hover:bg-film-red/20"
                >
                    Action
                </button>
                <button 
                    @click="selectedCategory = 'drama'; open = false" 
                    class="block w-full text-left px-4 py-2 text-white hover:bg-film-red/20"
                >
                    Drama
                </button>
                <button 
                    @click="selectedCategory = 'comedy'; open = false" 
                    class="block w-full text-left px-4 py-2 text-white hover:bg-film-red/20"
                >
                    Comedy
                </button>
            </div>
        </div>
    </div>
    
    <!-- Flash deal banner with voucher code -->
    <div class="mb-8 p-5 rounded-lg bg-gradient-to-r from-film-dark via-film-gray to-film-dark border border-gray-800 relative overflow-hidden">
        <div class="absolute -right-16 -top-16 w-64 h-64 bg-film-red/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -left-16 -bottom-16 w-64 h-64 bg-film-red/10 rounded-full blur-3xl pointer-events-none"></div>
        
        <div class="relative flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="px-2 py-1 bg-film-red text-white text-xs font-bold rounded-full animate-pulse">LIMITED TIME</span>
                    <div class="h-1 w-1 bg-gray-500 rounded-full"></div>
                    <span class="text-gray-300 text-sm">Ends in 
                        <span x-data="{ 
                            countdown: { hours: 23, minutes: 59, seconds: 59 },
                            init() {
                                setInterval(() => {
                                    this.countdown.seconds--;
                                    if (this.countdown.seconds < 0) {
                                        this.countdown.seconds = 59;
                                        this.countdown.minutes--;
                                    }
                                    if (this.countdown.minutes < 0) {
                                        this.countdown.minutes = 59;
                                        this.countdown.hours--;
                                    }
                                    if (this.countdown.hours < 0) {
                                        this.countdown = { hours: 23, minutes: 59, seconds: 59 };
                                    }
                                }, 1000);
                            }
                        }" class="font-mono">
                            <span x-text="countdown.hours.toString().padStart(2, '0')"></span>:<span x-text="countdown.minutes.toString().padStart(2, '0')"></span>:<span x-text="countdown.seconds.toString().padStart(2, '0')"></span>
                        </span>
                    </span>
                </div>
                <h3 class="text-xl md:text-2xl font-bold text-white mb-1">Flash Deal: 50% Off Premium</h3>
                <p class="text-gray-300 mb-4 md:mb-0">Get unlimited access to all premium content with this special offer</p>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-3">
                <button 
                    @click="
                        voucherModal.code = new CouponJS().couponCode({
                            length: 8,
                            pattern: '###-###-##'
                        });
                        voucherModal.title = 'FLASH50';
                        voucherModal.show = true;
                    "
                    class="bg-film-red hover:bg-red-700 text-white px-6 py-3 rounded-lg font-medium transition-colors shadow-lg shadow-film-red/20 flex items-center justify-center gap-2"
                >
                    <i class="fas fa-ticket-alt"></i>
                    <span>Get Coupon</span>
                </button>
                <a href="#" class="bg-transparent border border-gray-600 hover:border-white text-white px-6 py-3 rounded-lg font-medium transition-colors flex items-center justify-center">
                    Learn More
                </a>
            </div>
        </div>
    </div>
    
    <!-- Movie Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
        @forelse ($series as $seriesItem)
            <div 
                x-data="{ 
                    showDetails: false,
                    isHovered: false,
                    playAnimation: false,
                    category: '{{ strtolower($seriesItem->content->categories->first()->name ?? 'none') }}',
                    addToFavorites() {
                        // Get current favorites from localStorage or initialize empty array
                        const currentFavorites = JSON.parse(localStorage.getItem('favorites') || '[]');
                        
                        // Add the current item
                        currentFavorites.push({
                            id: {{ $seriesItem->id }},
                            title: '{{ addslashes($seriesItem->content->title ?? 'Unknown') }}',
                            img: '{{ asset('storage/' . $seriesItem->content->cover_image) }}',
                            year: '2025'
                        });
                        
                        // Save back to localStorage
                        localStorage.setItem('favorites', JSON.stringify(currentFavorites));
                        
                        // Show notification
                        $dispatch('notify', {message: 'Added to favorites!', type: 'success'});
                    }
                }" 
                x-init="$nextTick(() => { playAnimation = true })"
                x-show="selectedCategory === 'all' || category.includes(selectedCategory)"
                @mouseenter="isHovered = true; hoverCardId = {{ $seriesItem->id }}" 
                @mouseleave="isHovered = false; hoverCardId = null"
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
                            Watch
                        </a>
                        
                        <!-- Add to watchlist button -->
                        <button 
                            @click="addToFavorites()"
                            class="bg-[#1A1A1A] hover:bg-[#252525] text-white p-2 rounded-md transition-colors duration-300"
                            title="Add to my list"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                        </button>
                        
                        <!-- Info button -->
                        <button 
                            @click="showDetails = !showDetails"
                            class="bg-[#1A1A1A] hover:bg-[#252525] text-white p-2 rounded-md transition-colors duration-300"
                            title="More information"
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
                    style="display: none;"
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
                    
                    <div class="grid grid-cols-2 gap-2 mb-4">
                        <a 
                            href="{{ route('watch.episode', ['seriesId' => $seriesItem->id]) }}"
                            class="bg-film-red text-white py-2 rounded-md transform transition-all duration-300 hover:bg-red-700 flex items-center justify-center gap-2 text-sm font-medium"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Watch Now
                        </a>
                        <button 
                            @click="addToFavorites(); showDetails = false"
                            class="bg-transparent border border-gray-600 text-white py-2 rounded-md flex items-center justify-center gap-2 text-sm font-medium hover:border-white transition-colors"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                            Add to Favorites
                        </button>
                    </div>
                    
                    <!-- Share options -->
                    <div>
                        <h4 class="text-sm font-semibold text-gray-400 mb-2">Share:</h4>
                        <div class="flex space-x-3">
                            <button class="text-gray-400 hover:text-blue-500 transition-colors">
                                <i class="fab fa-facebook text-lg"></i>
                            </button>
                            <button class="text-gray-400 hover:text-blue-400 transition-colors">
                                <i class="fab fa-twitter text-lg"></i>
                            </button>
                            <button class="text-gray-400 hover:text-pink-500 transition-colors">
                                <i class="fab fa-instagram text-lg"></i>
                            </button>
                            <button 
                                @click="navigator.clipboard.writeText(window.location.origin + '/watch/series/' + {{ $seriesItem->id }}); $dispatch('notify', {message: 'URL copied to clipboard!', type: 'success'})"
                                class="text-gray-400 hover:text-green-500 transition-colors"
                            >
                                <i class="fas fa-link text-lg"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12 bg-[#0A0A0A] rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-700 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h18M3 16h18" />
                </svg>
                <p class="text-gray-400 text-lg">No series available</p>
                <p class="text-gray-500 mt-2">Check back later to discover our new series</p>
            </div>
        @endforelse
    </div>
        <!-- Voucher Code Modal -->
    <div 
        x-show="voucherModal.show" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform scale-90"
        x-transition:enter-end="opacity-100 transform scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-90"
        class="fixed inset-0 flex items-center justify-center z-50 bg-black/70 backdrop-blur-sm"
        @click.away="voucherModal.show = false"
        style="display: none;"
    >
        <div class="relative w-full max-w-md">
            <!-- Close button -->
            <button @click="voucherModal.show = false" class="absolute -top-4 -right-4 bg-film-gray text-white rounded-full p-2 shadow-lg hover:bg-film-red transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            
            <!-- Coupon content -->
            <div class="bg-gradient-to-br from-film-dark to-film-gray p-1 rounded-xl shadow-2xl">
                <div class="coupon-clip bg-film-gray p-6 rounded-lg border-4 border-dashed border-film-red flex flex-col items-center">
                    <div class="mb-4 text-center">
                        <h2 class="text-2xl font-bold text-white mb-1" x-text="voucherModal.title || 'FLASH50'"></h2>
                        <p class="text-gray-400">Get 50% off your first month</p>
                    </div>
                    
                    <div class="w-full bg-black/30 py-6 px-4 rounded-lg text-center mb-6">
                        <p class="text-gray-400 text-sm mb-2">Your promo code</p>
                        <div class="relative">
                            <div class="promo-sparkle bg-gradient-to-r from-film-red via-yellow-500 to-film-red text-white font-mono text-xl sm:text-2xl font-bold py-3 rounded tracking-widest">
                                <span x-text="voucherModal.code">FILM50OFF</span>
                            </div>
                            <div class="absolute -top-1 -left-1 w-3 h-3 bg-white rounded-full"></div>
                            <div class="absolute -top-1 -right-1 w-3 h-3 bg-white rounded-full"></div>
                            <div class="absolute -bottom-1 -left-1 w-3 h-3 bg-white rounded-full"></div>
                            <div class="absolute -bottom-1 -right-1 w-3 h-3 bg-white rounded-full"></div>
                        </div>
                        <p class="text-gray-400 text-sm mt-2">
                            Valid until May 15, 2025
                        </p>
                    </div>
                    
                    <div class="text-center mb-6">
                        <h3 class="text-xl font-bold text-film-red mb-2">50% OFF</h3>
                        <p class="text-gray-300">Limited time offer for new subscriptions</p>
                    </div>
                    
                    <div class="w-full grid grid-cols-2 gap-3">
                        <button 
                            @click="navigator.clipboard.writeText(voucherModal.code); $dispatch('notify', {message: 'Code copied to clipboard!', type: 'success'})" 
                            class="bg-film-gray hover:bg-gray-800 text-white py-2 px-4 rounded-lg border border-gray-700 transition-colors"
                        >
                            Copy Code
                        </button>
                        <button 
                            @click="voucherModal.show = false; $dispatch('notify', {message: 'Redirecting to checkout!', type: 'info'}); setTimeout(() => window.location.href = '{{ route('subscribe.checkout') }}?code=' + voucherModal.code, 1500)" 
                            class="bg-film-red hover:bg-red-700 text-white py-2 px-4 rounded-lg transition-colors"
                        >
                            Use Now
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include anime.js library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
