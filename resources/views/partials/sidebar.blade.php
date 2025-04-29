<!-- Enhanced Sidebar with Alpine.js -->
<div id="sidebar" 
     x-data="{ 
        isOpen: false,
        showPromoModal: false,
        recentlyViewed: [],
        activeTab: 'browse',
        generatedPromo: ''
     }" 
     @keydown.escape.window="isOpen = false"
     class="fixed top-0 left-0 h-full bg-film-dark border-r border-gray-800 transform transition-all duration-300 ease-in-out z-50 shadow-2xl"
     :class="isOpen ? 'translate-x-0' : '-translate-x-full lg:-translate-x-[calc(100%-10px)] lg:hover:-translate-x-[calc(100%-30px)]'">
    
    <!-- Toggle Tab -->
    <div class="absolute right-0 top-1/2 transform -translate-y-1/2 translate-x-10 bg-film-dark border-r border-t border-b border-gray-800 p-2 rounded-r-lg cursor-pointer shadow-md hover:shadow-film-red/20 transition-shadow duration-300" 
         @click="isOpen = !isOpen">
        <i class="fas" :class="isOpen ? 'fa-chevron-left' : 'fa-chevron-right'"></i>
    </div>
    
    <!-- Sidebar Content -->
    <div class="w-80 h-full flex flex-col">
        <!-- Header with logo -->
        <div class="p-6 flex items-center border-b border-gray-800">
            <div class="w-10 h-10 bg-film-red rounded flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M2 6a2 2 0 012-2h12a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"></path>
                </svg>
            </div>
            <span class="ml-3 text-film-red font-bold text-2xl">FilmWave</span>
            
            <!-- Close button (mobile only) -->
            <button @click="isOpen = false" class="ml-auto lg:hidden text-gray-400 hover:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        
        <!-- Tab Navigation -->
        <div class="flex border-b border-gray-800">
            <button 
                @click="activeTab = 'browse'" 
                class="flex-1 py-3 text-center transition-colors duration-200 relative overflow-hidden"
                :class="activeTab === 'browse' ? 'text-film-red' : 'text-gray-400 hover:text-white'"
            >
                <i class="fas fa-compass"></i>
                <span class="ml-2">Browse</span>
                <div x-show="activeTab === 'browse'" class="absolute bottom-0 left-0 w-full h-0.5 bg-film-red"></div>
            </button>
            <button 
                @click="activeTab = 'favorites'" 
                class="flex-1 py-3 text-center transition-colors duration-200 relative overflow-hidden"
                :class="activeTab === 'favorites' ? 'text-film-red' : 'text-gray-400 hover:text-white'"
            >
                <i class="fas fa-heart"></i>
                <span class="ml-2">Favorites</span>
                <div x-show="activeTab === 'favorites'" class="absolute bottom-0 left-0 w-full h-0.5 bg-film-red"></div>
            </button>
        </div>
        
        <!-- Browse Tab Content -->
        <div x-show="activeTab === 'browse'" class="flex-1 overflow-y-auto scrollbar-hide">
            <div class="p-6">
                <!-- Search Input -->
                <div class="relative mb-8 group">
                    <input 
                        type="text" 
                        placeholder="Search in FilmWave" 
                        class="w-full bg-film-gray text-gray-200 rounded-lg py-3 px-4 pr-10 focus:outline-none focus:ring-2 focus:ring-film-red transition-all duration-300"
                    >
                    <i class="fas fa-search absolute right-3 top-3 text-gray-400 group-hover:text-film-red transition-colors duration-200"></i>
                </div>
                
                <!-- Main Navigation -->
                <div class="mb-8">
                    <ul class="space-y-1">
                        <li><a href="#" class="flex items-center text-film-accent py-2 px-3 rounded bg-film-gray"><i class="fas fa-home mr-3"></i> Home Page</a></li>
                        <li><a href="#" class="flex items-center text-gray-300 hover:text-film-accent py-2 px-3 rounded hover:bg-film-gray transition-all duration-200"><i class="fas fa-film mr-3"></i> Movies</a></li>
                        <li><a href="#" class="flex items-center text-gray-300 hover:text-film-accent py-2 px-3 rounded hover:bg-film-gray transition-all duration-200"><i class="fas fa-dragon mr-3"></i> Anime & Cartoons</a></li>
                        <li><a href="#" class="flex items-center text-gray-300 hover:text-film-accent py-2 px-3 rounded hover:bg-film-gray transition-all duration-200"><i class="fas fa-video mr-3"></i> TV Programs</a></li>
                        <li>
                            <a href="#" class="flex items-center justify-between text-gray-300 hover:text-film-accent py-2 px-3 rounded hover:bg-film-gray transition-all duration-200">
                                <span><i class="fas fa-tags mr-3"></i> Promotions</span>
                                <span class="bg-film-red text-white text-xs px-2 py-1 rounded-full">NEW</span>
                            </a>
                        </li>
                    </ul>
                </div>
                
                <!-- Promo Banner -->
                <div class="mb-8 p-4 rounded-lg bg-gradient-to-r from-film-dark to-film-gray border border-gray-800 relative overflow-hidden group cursor-pointer"
                    @click="generatedPromo = voucher_codes.generate({
                        length: 8,
                        count: 1,
                        charset: '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'
                    })[0]; 
                    showPromoModal = true">
                    
                    <!-- Animated background spark -->
                    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,_var(--tw-gradient-stops))] from-film-red/20 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
                    
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-sm font-bold text-film-red">SPECIAL OFFER</h3>
                            <span class="bg-film-red text-white text-xs px-2 py-0.5 rounded-full">Limited</span>
                        </div>
                        <p class="text-white text-sm mb-3">Get 25% off your first premium month!</p>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400 text-xs">Click to generate code</span>
                            <i class="fas fa-gift text-film-red group-hover:animate-pulse"></i>
                        </div>
                    </div>
                </div>
                
                <!-- Social Media Links -->
                <div class="mb-8 border-t border-gray-800 pt-6">
                    <h3 class="text-sm uppercase font-semibold text-gray-400 mb-4">Follow us on FilmWave</h3>
                    <div class="flex space-x-5">
                        <a href="#" class="text-gray-400 hover:text-film-accent transition-colors group">
                            <i class="fab fa-twitter text-xl group-hover:animate-bounce"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-film-accent transition-colors group">
                            <i class="fab fa-telegram text-xl group-hover:animate-bounce"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-film-accent transition-colors group">
                            <i class="fab fa-facebook text-xl group-hover:animate-bounce"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-film-accent transition-colors group">
                            <i class="fab fa-instagram text-xl group-hover:animate-bounce"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Premium Access Button -->
                <div class="mt-8">
                    @if(Auth::check() && Auth::user()->lifetime_access)
                        <div class="w-full py-3 px-6 bg-green-600 text-white rounded-lg font-medium text-center mb-2">
                            You have Premium Access
                        </div>
                        <p class="text-sm text-gray-400 text-center">Enjoy unlimited access to all premium content</p>
                    @else
                        <a href="{{ route('subscribe.checkout') }}" id="checkout-button" class="block w-full py-3 px-6 bg-film-red text-white rounded-lg font-medium hover:bg-red-700 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-film-red focus:ring-offset-film-dark text-center group">
                            <span class="group-hover:hidden">Get Premium</span>
                            <span class="hidden group-hover:inline">Unlock All Content</span>
                        </a>
                        <div id="checkout-container" class="mt-4"></div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Favorites Tab Content -->
        <div x-show="activeTab === 'favorites'" class="flex-1 overflow-y-auto scrollbar-hide" style="display: none">
            <div class="p-6">
                <h3 class="text-sm uppercase font-semibold text-gray-400 mb-4">My Favorites</h3>
                
                <template x-if="localStorage.getItem('favorites') && JSON.parse(localStorage.getItem('favorites')).length > 0">
                    <div class="space-y-4">
                        <template x-for="(item, index) in JSON.parse(localStorage.getItem('favorites') || '[]')" :key="index">
                            <div class="flex items-center space-x-3 bg-film-gray/50 p-2 rounded-lg">
                                <img :src="item.img || 'https://via.placeholder.com/60x90?text=Movie'" class="w-14 h-20 object-cover rounded">
                                <div class="flex-1">
                                    <h4 class="text-sm font-medium text-gray-300" x-text="item.title"></h4>
                                    <p class="text-xs text-gray-500" x-text="item.year || '2025'"></p>
                                </div>
                                <button class="text-gray-400 hover:text-film-red">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </template>
                    </div>
                </template>
                
                <template x-if="!localStorage.getItem('favorites') || JSON.parse(localStorage.getItem('favorites')).length === 0">
                    <div class="text-center py-8">
                        <i class="fas fa-heart text-gray-700 text-4xl mb-3"></i>
                        <p class="text-gray-400">No favorites yet</p>
                        <p class="text-gray-500 text-sm mt-1">Add movies or series to your favorites</p>
                    </div>
                </template>
            </div>
        </div>
    </div>
    
    <!-- Promo Code Modal -->
    <div 
        x-show="showPromoModal" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform scale-90"
        x-transition:enter-end="opacity-100 transform scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-90"
        class="fixed inset-0 flex items-center justify-center z-[60] bg-black/70 backdrop-blur-sm"
        style="display: none;"
    >
        <div class="relative w-full max-w-sm mx-4">
            <!-- Close button -->
            <button @click="showPromoModal = false" class="absolute -top-4 -right-4 bg-film-gray text-white rounded-full p-2 shadow-lg hover:bg-film-red transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            
            <!-- Coupon content -->
            <div class="bg-gradient-to-br from-film-dark to-film-gray p-1 rounded-xl shadow-2xl">
                <div class="bg-film-gray/80 p-6 rounded-lg flex flex-col items-center">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=120x120&data=FILMWAVE25" alt="QR Code" class="mb-4 rounded-lg">
                    
                    <div class="mb-4 text-center">
                        <h2 class="text-2xl font-bold text-white mb-1">Your Special Code</h2>
                        <p class="text-gray-400">Use this code at checkout</p>
                    </div>
                    
                    <div class="w-full bg-black/30 py-4 px-4 rounded-lg text-center mb-6">
                        <div class="font-mono text-xl sm:text-2xl font-bold py-2 text-film-red">
                            <span x-text="generatedPromo || 'FILMWAVE25'"></span>
                        </div>
                    </div>
                    
                    <div class="w-full space-y-2">
                        <button 
                            @click="navigator.clipboard.writeText(generatedPromo || 'FILMWAVE25'); $dispatch('notify', {message: 'Code copied to clipboard!', type: 'success'})" 
                            class="w-full bg-film-red hover:bg-red-700 text-white py-2 px-4 rounded-lg transition-colors flex items-center justify-center gap-2"
                        >
                            <i class="fas fa-copy"></i> Copy Code
                        </button>
                        <button 
                            @click="showPromoModal = false" 
                            class="w-full bg-film-gray hover:bg-gray-700 text-white py-2 px-4 rounded-lg border border-gray-700 transition-colors"
                        >
                            Use Later
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Overlay to capture clicks outside sidebar when fully expanded -->
<div 
    x-data="{ isOpen: false }"
    x-bind:class="{ 'block': isOpen, 'hidden': !isOpen }"
    @click="isOpen = false"
    class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm z-40 hidden"
    id="sidebar-overlay">
</div>