<!-- Left sidebar with tab -->
<div id="sidebar" class="fixed top-0 left-0 h-full bg-film-dark border-r border-gray-800 transform -translate-x-[calc(100%-10px)] hover:-translate-x-[calc(100%-30px)] transition-transform duration-300 ease-in-out z-50 shadow-lg group">
    <!-- Visible tab -->
    <div class="absolute right-0 top-1/2 transform -translate-y-1/2 translate-x-10 bg-film-dark border-r border-t border-b border-gray-800 p-2 rounded-r-lg cursor-pointer" id="sidebar-tab">
        <i class="fas fa-chevron-right text-gray-400 group-hover:text-film-red transition-colors duration-300"></i>
    </div>
    
    <!-- Sidebar Content -->
    <div class="w-80 h-full overflow-y-auto scrollbar-hide">
        <div class="p-6">
            <div class="relative mb-8">
                <input type="text" placeholder="Search in FilmWave" class="w-full bg-film-gray text-gray-200 rounded-lg py-3 px-4 pr-10 focus:outline-none focus:ring-2 focus:ring-film-red">
                <i class="fas fa-search absolute right-3 top-3 text-gray-400"></i>
            </div>
            
            <div class="mb-8">
                <ul class="space-y-3">
                    <li><a href="#" class="flex items-center text-film-accent py-2 px-3 rounded bg-film-gray"><i class="fas fa-home mr-3"></i> Home Page</a></li>
                    <li><a href="#" class="flex items-center text-gray-300 hover:text-film-accent py-2 px-3 rounded hover:bg-film-gray"><i class="fas fa-film mr-3"></i> Movies</a></li>
                    <li><a href="#" class="flex items-center text-gray-300 hover:text-film-accent py-2 px-3 rounded hover:bg-film-gray"><i class="fas fa-dragon mr-3"></i> Anime & Cartoons</a></li>
                    <li><a href="#" class="flex items-center text-gray-300 hover:text-film-accent py-2 px-3 rounded hover:bg-film-gray"><i class="fas fa-video mr-3"></i> TV Programs</a></li>
                </ul>
            </div>
            
            <!-- Social Media Links -->
            <div class="mb-8 border-t border-gray-800 pt-6">
                <h3 class="text-sm uppercase font-semibold text-gray-400 mb-4">Follow us on FilmWave</h3>
                <div class="flex space-x-5">
                    <a href="#" class="text-gray-400 hover:text-film-accent transition-colors"><i class="fab fa-twitter text-xl"></i></a>
                    <a href="#" class="text-gray-400 hover:text-film-accent transition-colors"><i class="fab fa-telegram text-xl"></i></a>
                    <a href="#" class="text-gray-400 hover:text-film-accent transition-colors"><i class="fab fa-facebook text-xl"></i></a>
                    <a href="#" class="text-gray-400 hover:text-film-accent transition-colors"><i class="fab fa-instagram text-xl"></i></a>
                </div>
            </div>
            
            <!-- Recently Watched Section -->
            <div class="mb-8 border-t border-gray-800 pt-6">
                <h3 class="text-sm uppercase font-semibold text-gray-400 mb-4">Recently Watched</h3>
                <div class="space-y-4">
                    <div class="flex items-center space-x-3">
                        <img src="https://via.placeholder.com/60x90?text=Movie" class="w-14 h-20 object-cover rounded">
                        <div>
                            <h4 class="text-sm font-medium text-gray-300">The Last Kingdom</h4>
                            <p class="text-xs text-gray-500">2025</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <img src="https://via.placeholder.com/60x90?text=Movie" class="w-14 h-20 object-cover rounded">
                        <div>
                            <h4 class="text-sm font-medium text-gray-300">Dune</h4>
                            <p class="text-xs text-gray-500">2024</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-8">
                @if(Auth::check() && Auth::user()->lifetime_access)
                    <div class="w-full py-3 px-6 bg-green-600 text-white rounded-lg font-medium text-center mb-2">
                        You have Premium Access
                    </div>
                    <p class="text-sm text-gray-400 text-center">Enjoy unlimited access to all premium content</p>
                @else
                    <a href="{{ route('subscribe.checkout') }}" id="checkout-button" class="block w-full py-3 px-6 bg-film-red text-white rounded-lg font-medium hover:bg-red-700 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-film-red focus:ring-offset-film-dark pulse-animation text-center">
                        Get Premium
                    </a>
                    <div id="checkout-container" class="mt-4"></div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Overlay to capture clicks outside sidebar when fully expanded -->
<div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 backdrop-filter backdrop-blur-sm z-40 hidden"></div>