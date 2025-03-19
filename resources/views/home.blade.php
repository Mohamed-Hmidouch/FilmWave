@extends('app')

@section('content')
<!-- Hero Section with Featured Movies -->
<section class="relative pt-20 md:pt-24 lg:pt-28 pb-10">
    <div class="container mx-auto px-4">
        <!-- Featured Movies Carousel -->
        <div class="relative overflow-hidden rounded-xl" style="height: 500px;">
            <!-- Will be populated by JavaScript -->
            <div id="hero-carousel" class="w-full h-full bg-film-gray">
                <!-- Featured movie background will go here -->
            </div>
            
            <!-- Content Overlay -->
            <div class="absolute inset-0 bg-gradient-to-r from-black/80 to-transparent flex items-center">
                <div class="container mx-auto px-4 md:px-10">
                    <div class="max-w-lg">
                        <h1 class="text-3xl md:text-4xl font-bold mb-3" id="featured-title">Loading...</h1>
                        <div class="flex items-center space-x-3 mb-3">
                            <span class="text-film-accent font-semibold" id="featured-year">2025</span>
                            <span class="bg-film-accent text-white text-xs px-2 py-0.5 rounded">HD</span>
                            <span class="text-white" id="featured-duration">120 min</span>
                        </div>
                        <p class="text-gray-300 mb-6" id="featured-description">Loading movie description...</p>
                        <div class="flex items-center space-x-4">
                            <button class="bg-film-red hover:bg-red-700 text-white py-2 px-6 md:px-8 rounded-md flex items-center transition">
                                <i class="fas fa-play mr-2"></i> Watch Now
                            </button>
                            <button class="bg-gray-700 hover:bg-gray-600 text-white py-2 px-6 rounded-md flex items-center transition">
                                <i class="fas fa-plus mr-2"></i> My List
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Navigation Controls -->
            <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
                <button class="w-2 h-2 rounded-full bg-white opacity-50"></button>
                <button class="w-2 h-2 rounded-full bg-white opacity-100"></button>
                <button class="w-2 h-2 rounded-full bg-white opacity-50"></button>
            </div>
        </div>
    </div>
</section>

<!-- Content Tabs Section -->
<section class="py-8">
    <div class="container mx-auto px-4">
        <div class="flex items-center border-b border-gray-800 pb-4 mb-6 overflow-x-auto scrollbar-hide">
            <button class="text-film-red border-b-2 border-film-red px-4 py-2 font-medium whitespace-nowrap">Latest Movies</button>
            <button class="text-gray-400 hover:text-white px-4 py-2 font-medium whitespace-nowrap">Latest Series</button>
            <button class="text-gray-400 hover:text-white px-4 py-2 font-medium whitespace-nowrap">Latest Episodes</button>
            <button class="text-gray-400 hover:text-white px-4 py-2 font-medium whitespace-nowrap">Trending Now</button>
            
            <div class="ml-auto flex items-center">
                <div class="relative">
                    <button class="flex items-center text-white bg-film-gray px-3 py-1 rounded">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/7/7a/Logonetflix.png" alt="Netflix" class="w-5 h-5 mr-2">
                        <span>Netflix</span>
                        <i class="fas fa-chevron-down ml-2 text-xs"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Latest Movies Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 mb-10">
            <!-- Movie Card 1 -->
            <div class="movie-card rounded-lg overflow-hidden bg-film-gray shadow-lg">
                <div class="relative">
                    <img src="https://picsum.photos/id/872/300/450" alt="Movie" class="w-full h-64 object-cover">
                    <div class="absolute top-2 right-2 bg-film-red text-white text-xs font-bold px-2 py-1 rounded">9.0</div>
                </div>
                <div class="p-3">
                    <h3 class="font-bold text-white mb-1 truncate">The Dark Knight</h3>
                    <p class="text-gray-400 text-sm">2008</p>
                </div>
            </div>
            
            <!-- Movie Card 2 -->
            <div class="movie-card rounded-lg overflow-hidden bg-film-gray shadow-lg">
                <div class="relative">
                    <img src="https://picsum.photos/id/873/300/450" alt="Movie" class="w-full h-64 object-cover">
                    <div class="absolute top-2 right-2 bg-film-red text-white text-xs font-bold px-2 py-1 rounded">8.6</div>
                </div>
                <div class="p-3">
                    <h3 class="font-bold text-white mb-1 truncate">Interstellar</h3>
                    <p class="text-gray-400 text-sm">2014</p>
                </div>
            </div>
            
            <!-- Movie Card 3 -->
            <div class="movie-card rounded-lg overflow-hidden bg-film-gray shadow-lg">
                <div class="relative">
                    <img src="https://picsum.photos/id/874/300/450" alt="Movie" class="w-full h-64 object-cover">
                    <div class="absolute top-2 right-2 bg-film-red text-white text-xs font-bold px-2 py-1 rounded">8.1</div>
                </div>
                <div class="p-3">
                    <h3 class="font-bold text-white mb-1 truncate">Blade Runner 2049</h3>
                    <p class="text-gray-400 text-sm">2017</p>
                </div>
            </div>
            
            <!-- Movie Card 4 -->
            <div class="movie-card rounded-lg overflow-hidden bg-film-gray shadow-lg">
                <div class="relative">
                    <img src="https://picsum.photos/id/875/300/450" alt="Movie" class="w-full h-64 object-cover">
                    <div class="absolute top-2 right-2 bg-film-red text-white text-xs font-bold px-2 py-1 rounded">9.3</div>
                </div>
                <div class="p-3">
                    <h3 class="font-bold text-white mb-1 truncate">The Shawshank Redemption</h3>
                    <p class="text-gray-400 text-sm">1994</p>
                </div>
            </div>
            
            <!-- Movie Card 5 -->
            <div class="movie-card rounded-lg overflow-hidden bg-film-gray shadow-lg">
                <div class="relative">
                    <img src="https://picsum.photos/id/876/300/450" alt="Movie" class="w-full h-64 object-cover">
                    <div class="absolute top-2 right-2 bg-film-red text-white text-xs font-bold px-2 py-1 rounded">8.5</div>
                </div>
                <div class="p-3">
                    <h3 class="font-bold text-white mb-1 truncate">Parasite</h3>
                    <p class="text-gray-400 text-sm">2019</p>
                </div>
            </div>
            
            <!-- Movie Card 6 -->
            <div class="movie-card rounded-lg overflow-hidden bg-film-gray shadow-lg">
                <div class="relative">
                    <img src="https://picsum.photos/id/877/300/450" alt="Movie" class="w-full h-64 object-cover">
                    <div class="absolute top-2 right-2 bg-film-red text-white text-xs font-bold px-2 py-1 rounded">8.7</div>
                </div>
                <div class="p-3">
                    <h3 class="font-bold text-white mb-1 truncate">The Matrix</h3>
                    <p class="text-gray-400 text-sm">1999</p>
                </div>
            </div>
            
            <!-- Movie Card 7 -->
            <div class="movie-card rounded-lg overflow-hidden bg-film-gray shadow-lg">
                <div class="relative">
                    <img src="https://picsum.photos/id/878/300/450" alt="Movie" class="w-full h-64 object-cover">
                    <div class="absolute top-2 right-2 bg-film-red text-white text-xs font-bold px-2 py-1 rounded">8.3</div>
                </div>
                <div class="p-3">
                    <h3 class="font-bold text-white mb-1 truncate">Inception</h3>
                    <p class="text-gray-400 text-sm">2010</p>
                </div>
            </div>
            
            <!-- Movie Card 8 -->
            <div class="movie-card rounded-lg overflow-hidden bg-film-gray shadow-lg">
                <div class="relative">
                    <img src="https://picsum.photos/id/879/300/450" alt="Movie" class="w-full h-64 object-cover">
                    <div class="absolute top-2 right-2 bg-film-red text-white text-xs font-bold px-2 py-1 rounded">8.9</div>
                </div>
                <div class="p-3">
                    <h3 class="font-bold text-white mb-1 truncate">Pulp Fiction</h3>
                    <p class="text-gray-400 text-sm">1994</p>
                </div>
            </div>
            
            <!-- Movie Card 9 -->
            <div class="movie-card rounded-lg overflow-hidden bg-film-gray shadow-lg">
                <div class="relative">
                    <img src="https://picsum.photos/id/880/300/450" alt="Movie" class="w-full h-64 object-cover">
                    <div class="absolute top-2 right-2 bg-film-red text-white text-xs font-bold px-2 py-1 rounded">8.2</div>
                </div>
                <div class="p-3">
                    <h3 class="font-bold text-white mb-1 truncate">The Godfather</h3>
                    <p class="text-gray-400 text-sm">1972</p>
                </div>
            </div>
            
            <!-- Movie Card 10 -->
            <div class="movie-card rounded-lg overflow-hidden bg-film-gray shadow-lg">
                <div class="relative">
                    <img src="https://picsum.photos/id/881/300/450" alt="Movie" class="w-full h-64 object-cover">
                    <div class="absolute top-2 right-2 bg-film-red text-white text-xs font-bold px-2 py-1 rounded">8.4</div>
                </div>
                <div class="p-3">
                    <h3 class="font-bold text-white mb-1 truncate">Fight Club</h3>
                    <p class="text-gray-400 text-sm">1999</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Genre Filters Section -->
<section class="py-6 bg-film-gray">
    <div class="container mx-auto px-4">
        <h3 class="text-white mb-4 font-semibold">Browse by Genre</h3>
        <div class="flex flex-wrap gap-2">
            @foreach(['Action', 'Comedy', 'Crime', 'Drama', 'Fantasy', 'Horror', 'Romance', 'Sci-Fi', 'Thriller', 'Adventure'] as $genre)
            <a href="#" class="px-3 py-1 bg-gray-700 text-gray-300 rounded-full text-sm hover:bg-gray-600 transition">
                {{ $genre }}
            </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Popular TV Shows Section -->
<section class="py-8">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-white">Popular TV Shows</h2>
            <a href="#" class="text-film-red hover:underline text-sm">View All</a>
        </div>
        
        <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <!-- TV Show 1 -->
            <div class="bg-film-gray rounded-lg overflow-hidden shadow-lg">
                <div class="relative">
                    <img src="https://picsum.photos/id/882/400/225" alt="TV Show" class="w-full h-40 object-cover">
                    <div class="absolute bottom-0 left-0 right-0 p-3 bg-gradient-to-t from-black to-transparent">
                        <h3 class="font-bold text-white">Breaking Bad</h3>
                        <div class="flex items-center text-sm">
                            <span class="text-gray-400">5 Seasons</span>
                            <span class="mx-2 text-gray-600">•</span>
                            <span class="text-gray-400">2008-2013</span>
                        </div>
                    </div>
                </div>
                <div class="p-3">
                    <div class="flex items-center mb-2">
                        <div class="text-film-red mr-1"><i class="fas fa-star"></i></div>
                        <span class="text-white font-bold mr-1">9.5</span>
                        <span class="text-gray-400 text-sm">/10</span>
                    </div>
                    <p class="text-gray-400 text-sm line-clamp-2">A high school chemistry teacher turned methamphetamine producer partners with a former student.</p>
                </div>
            </div>
            
            <!-- TV Show 2 -->
            <div class="bg-film-gray rounded-lg overflow-hidden shadow-lg">
                <div class="relative">
                    <img src="https://picsum.photos/id/883/400/225" alt="TV Show" class="w-full h-40 object-cover">
                    <div class="absolute bottom-0 left-0 right-0 p-3 bg-gradient-to-t from-black to-transparent">
                        <h3 class="font-bold text-white">Stranger Things</h3>
                        <div class="flex items-center text-sm">
                            <span class="text-gray-400">4 Seasons</span>
                            <span class="mx-2 text-gray-600">•</span>
                            <span class="text-gray-400">2016-Present</span>
                        </div>
                    </div>
                </div>
                <div class="p-3">
                    <div class="flex items-center mb-2">
                        <div class="text-film-red mr-1"><i class="fas fa-star"></i></div>
                        <span class="text-white font-bold mr-1">8.7</span>
                        <span class="text-gray-400 text-sm">/10</span>
                    </div>
                    <p class="text-gray-400 text-sm line-clamp-2">When a young boy vanishes, a small town uncovers a mystery of supernatural forces and secret experiments.</p>
                </div>
            </div>
            
            <!-- TV Show 3 -->
            <div class="bg-film-gray rounded-lg overflow-hidden shadow-lg">
                <div class="relative">
                    <img src="https://picsum.photos/id/884/400/225" alt="TV Show" class="w-full h-40 object-cover">
                    <div class="absolute bottom-0 left-0 right-0 p-3 bg-gradient-to-t from-black to-transparent">
                        <h3 class="font-bold text-white">Game of Thrones</h3>
                        <div class="flex items-center text-sm">
                            <span class="text-gray-400">8 Seasons</span>
                            <span class="mx-2 text-gray-600">•</span>
                            <span class="text-gray-400">2011-2019</span>
                        </div>
                    </div>
                </div>
                <div class="p-3">
                    <div class="flex items-center mb-2">
                        <div class="text-film-red mr-1"><i class="fas fa-star"></i></div>
                        <span class="text-white font-bold mr-1">9.2</span>
                        <span class="text-gray-400 text-sm">/10</span>
                    </div>
                    <p class="text-gray-400 text-sm line-clamp-2">Noble families vie for control of the Seven Kingdoms of Westeros in this epic fantasy series.</p>
                </div>
            </div>
            
            <!-- TV Show 4 -->
            <div class="bg-film-gray rounded-lg overflow-hidden shadow-lg">
                <div class="relative">
                    <img src="https://picsum.photos/id/885/400/225" alt="TV Show" class="w-full h-40 object-cover">
                    <div class="absolute bottom-0 left-0 right-0 p-3 bg-gradient-to-t from-black to-transparent">
                        <h3 class="font-bold text-white">The Mandalorian</h3>
                        <div class="flex items-center text-sm">
                            <span class="text-gray-400">3 Seasons</span>
                            <span class="mx-2 text-gray-600">•</span>
                            <span class="text-gray-400">2019-Present</span>
                        </div>
                    </div>
                </div>
                <div class="p-3">
                    <div class="flex items-center mb-2">
                        <div class="text-film-red mr-1"><i class="fas fa-star"></i></div>
                        <span class="text-white font-bold mr-1">8.8</span>
                        <span class="text-gray-400 text-sm">/10</span>
                    </div>
                    <p class="text-gray-400 text-sm line-clamp-2">A lone bounty hunter makes his way through the outer reaches of the galaxy.</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection