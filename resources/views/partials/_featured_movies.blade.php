<!-- Featured Movies Partial -->
<div id="hero-carousel" class="relative h-full">
    @foreach($featuredMovies as $index => $movie)
    <div class="absolute inset-0 bg-cover bg-center transition-opacity duration-1000 {{ $index > 0 ? 'opacity-0' : '' }}" 
         style="background-image: url('{{ $movie['background'] }}')"></div>
    @endforeach
    
    <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/50 to-transparent"></div>
    
    <div class="relative h-full flex items-end">
        <div class="container mx-auto px-4 pb-8">
            <div class="text-white max-w-2xl">
                <h2 class="text-3xl md:text-4xl font-bold mb-3 featured-title">{{ $featuredMovies[0]['title'] }}</h2>
                <p class="text-gray-300 mb-4 featured-desc">{{ $featuredMovies[0]['description'] }}</p>
                <div class="flex flex-wrap gap-4 mb-6">
                    <span class="flex items-center"><i class="fas fa-star text-yellow-500 mr-2"></i> {{ $featuredMovies[0]['rating'] }}</span>
                    <span class="flex items-center"><i class="fas fa-calendar text-gray-400 mr-2"></i> {{ $featuredMovies[0]['year'] }}</span>
                    @foreach($featuredMovies[0]['genres'] as $genre)
                    <span class="px-2 py-1 bg-blue-600 text-sm rounded-full">{{ $genre }}</span>
                    @endforeach
                </div>
                <div class="flex space-x-4">
                    <button class="bg-red-600 hover:bg-red-700 px-6 py-2 rounded flex items-center">
                        <i class="fas fa-play mr-2"></i> Watch Now
                    </button>
                    <button class="bg-gray-700 hover:bg-gray-600 px-6 py-2 rounded flex items-center">
                        <i class="fas fa-plus mr-2"></i> Add to List
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Navigation indicators -->
    <div class="absolute bottom-4 right-4 flex space-x-2">
        @foreach($featuredMovies as $index => $movie)
        <button class="w-3 h-3 rounded-full {{ $index === 0 ? 'bg-blue-500' : 'bg-gray-600' }}" 
                onclick="changeSlide({{ $index }})"></button>
        @endforeach
    </div>
</div>