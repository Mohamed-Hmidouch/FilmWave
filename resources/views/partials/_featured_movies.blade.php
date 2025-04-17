<div class="container mx-auto px-4 py-8">
    <h2 class="text-2xl font-bold mb-6 text-white">Séries</h2>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-4 gap-6">
        @forelse ($series as $seriesItem)
            <div class="movie-card bg-[#0A0A0A] rounded-lg overflow-hidden shadow-lg transition-all duration-300 hover:shadow-xl relative">
                <!-- Image with overlay -->
                <div class="relative overflow-hidden aspect-square group">
                    <img src="{{ asset('storage/' . $seriesItem->content->cover_image) }}" 
                        alt="{{ $seriesItem->content->title ?? 'Movie poster' }}"
                        onerror="this.onerror=null; this.src='https://via.placeholder.com/400x400?text=No+Image';" 
                        class="w-full h-full object-cover transition-transform duration-500">
                    
                    <!-- Shine effect div -->
                    <div class="shine-effect absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    
                    <!-- Dark gradient overlay for better text readability -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black via-black/70 to-transparent"></div>
                    
                    <!-- Top info overlay (always visible) -->
                    <div class="absolute top-2 left-2 right-2 flex justify-between">
                        <!-- Categories badges -->
                        @if(isset($seriesItem->content->categories) && $seriesItem->content->categories->isNotEmpty())
                            <div class="flex flex-wrap gap-1">
                                @foreach($seriesItem->content->categories->take(1) as $category)
                                    <span class="bg-film-red text-xs font-bold text-white px-3 py-1 rounded-full shadow-md">{{ $category->name }}</span>
                                @endforeach
                            </div>
                        @endif
                        
                        <!-- Rating badge if available -->
                        <div class="flex items-center bg-yellow-500 text-black font-bold text-xs px-2 py-1 rounded-full shadow-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            8.5
                        </div>
                    </div>
                </div>
                
                <!-- Card content (always visible) -->
                <div class="p-4">
                    <h3 class="text-lg font-bold text-white mb-2 line-clamp-1">{{ $seriesItem->content->title ?? '' }}</h3>
                    
                    <!-- Description - always visible but limited to 2 lines -->
                    <p class="text-gray-200 text-sm mb-3 line-clamp-2">{{ $seriesItem->content->description ?? '' }}</p>
                    
                    <!-- Tags - always visible -->
                    @if(isset($seriesItem->content->tags) && $seriesItem->content->tags->isNotEmpty())
                        <div class="flex flex-wrap gap-1 mb-3">
                            @foreach($seriesItem->content->tags->take(2) as $tag)
                                <span class="bg-[#1A1A1A] text-xs text-gray-200 px-2 py-1 rounded-full">{{ $tag->name }}</span>
                            @endforeach
                        </div>
                    @endif
                    
                    <!-- Watch Now button -->
                    <button class="watch-btn bg-film-red text-white w-full px-6 py-2 rounded-md transform transition-transform duration-300 hover:scale-105 hover:bg-red-700 flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Regarder
                    </button>
                    
                    <!-- Hidden link for JS to use -->
                    <a href="{{ route('watch.episode', ['seriesId' => $seriesItem->id]) }}" class="hidden"></a>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12 bg-[#0A0A0A] rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-700 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h18M3 16h18" />
                </svg>
                <p class="text-gray-400 text-lg">Aucune série disponible</p>
            </div>
        @endforelse
    </div>
</div>

<!-- Add anime.js for animations -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
<!-- Include our custom JS file -->
<script src="{{ asset('js/movie-cards.js') }}"></script>