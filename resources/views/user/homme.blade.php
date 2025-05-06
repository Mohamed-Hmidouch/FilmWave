<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>FilmWave - Streaming de Films</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Tailwind CSS -->
        <script src="https://cdn.tailwindcss.com"></script>
        <!-- Alpine.js -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.2/dist/cdn.min.js"></script>
        <!-- Voucher Code Generator -->
        <script src="https://cdn.jsdelivr.net/npm/voucher-code-generator@1.3.0/dist/voucher_generator.min.js"></script>
        <!-- CouponJS -->
        <script src="https://cdn.jsdelivr.net/npm/couponjs@0.1.3/dist/couponjs.min.js"></script>
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
        <!-- Custom JS for Navbar Search -->
        <script src="{{ asset('js/navbar-search.js') }}"></script>
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
            /* Custom scrollbar styles that can't be done with Tailwind */
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
            
            /* Promo code animation */
            @keyframes sparkle {
                0%, 100% { opacity: 0.8; }
                50% { opacity: 1; }
            }
            
            .promo-sparkle {
                animation: sparkle 2s infinite;
            }
            
            /* Coupon clipping path */
            .coupon-clip {
                clip-path: polygon(
                    0% 10%, 5% 0%, 10% 10%, 15% 0%, 20% 10%, 25% 0%, 30% 10%, 
                    35% 0%, 40% 10%, 45% 0%, 50% 10%, 55% 0%, 60% 10%, 65% 0%, 
                    70% 10%, 75% 0%, 80% 10%, 85% 0%, 90% 10%, 95% 0%, 100% 10%,
                    100% 90%, 95% 100%, 90% 90%, 85% 100%, 80% 90%, 75% 100%, 70% 90%, 
                    65% 100%, 60% 90%, 55% 100%, 50% 90%, 45% 100%, 40% 90%, 35% 100%, 
                    30% 90%, 25% 100%, 20% 90%, 15% 100%, 10% 90%, 5% 100%, 0% 90%
                );
            }
        </style>
    </head>
<body class="min-h-screen flex flex-col bg-[#121212] text-[#e5e5e5]" 
      x-data="{ showPromoPopup: false, promoCode: '', promoExpiry: '', hasRedeemed: localStorage.getItem('hasRedeemedPromo') === 'true' }">
        <!-- Notification element for movies -->
        <div id="notification" class="fixed top-5 left-1/2 transform -translate-x-1/2 z-50 hidden">
            <span id="notification-message" class="px-4 py-2 rounded-lg shadow-lg"></span>
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
        
    <!-- Include sidebar -->
    @include('partials.sidebar')

    <!-- Main content wrapper -->
    <div class="transition-[margin-left] duration-300 ease-in-out bg-[#121212] lg:ml-0 md:ml-0">
        @include('partials.navbar')
        
        <!-- Main content area with dark background -->
        <div class="w-full py-6 bg-[#121212]">
            @include('partials._featured_movies')
            
            <!-- Pagination Links - Nouvelle version avec Tailwind CSS -->
            <div class="flex flex-col items-center my-8 space-y-4" aria-label="Pagination">
                <!-- Compteurs de résultats -->
                @if($series->count() > 0)
                <div class="text-sm text-film-light">
                    @if(method_exists($series, 'hasPages'))
                        <span>Showing {{ $series->firstItem() }} to {{ $series->lastItem() }} of {{ $series->total() }} results</span>
                    @else
                        <span>Showing {{ count($series) }} result(s)</span>
                    @endif
                </div>
                @endif
                
                <!-- Contrôleurs de pagination -->
                <div class="inline-flex shadow-xl rounded-md bg-film-dark">
                    <!-- Bouton Précédent -->
                    @if(method_exists($series, 'onFirstPage') && $series->onFirstPage())
                        <span class="px-4 py-2.5 text-gray-500 bg-film-gray rounded-l-md border-r border-neutral-700 cursor-not-allowed" aria-disabled="true">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </span>
                    @elseif(method_exists($series, 'previousPageUrl'))
                        <a href="{{ $series->previousPageUrl() }}" 
                           class="px-4 py-2.5 text-film-light bg-film-gray hover:bg-neutral-700 rounded-l-md border-r border-neutral-700 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-film-red focus:ring-opacity-50"
                           aria-label="Page précédente">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </a>
                    @endif
                    
                    <!-- Pages numériques -->
                    @if(method_exists($series, 'getUrlRange') && method_exists($series, 'lastPage'))
                        @foreach($series->getUrlRange(1, $series->lastPage()) as $page => $url)
                            <a href="{{ $url }}" 
                               class="{{ $page == $series->currentPage() 
                                   ? 'bg-film-red text-white font-medium' 
                                   : 'bg-film-gray text-film-light hover:bg-neutral-700' }} 
                                   px-4 py-2.5 text-sm border-r border-neutral-700 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-film-red focus:ring-opacity-50"
                               aria-label="Page {{ $page }}"
                               aria-current="{{ $page == $series->currentPage() ? 'page' : 'false' }}">
                                {{ $page }}
                            </a>
                        @endforeach
                    @endif
                    
                    <!-- Bouton Suivant -->
                    @if(method_exists($series, 'hasMorePages') && $series->hasMorePages())
                        <a href="{{ $series->nextPageUrl() }}" 
                           class="px-4 py-2.5 text-film-light bg-film-gray hover:bg-neutral-700 rounded-r-md transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-film-red focus:ring-opacity-50"
                           aria-label="Page suivante">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    @elseif(method_exists($series, 'hasMorePages'))
                        <span class="px-4 py-2.5 text-gray-500 bg-film-gray rounded-r-md cursor-not-allowed" aria-disabled="true">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </span>
                    @endif
                </div>
            </div>
        </div>
        <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-20 hidden md:hidden"></div>
    </div>
    
    <!-- Promo Code Popup -->
    <div x-show="showPromoPopup && !hasRedeemed" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform scale-90"
         x-transition:enter-end="opacity-100 transform scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform scale-100"
         x-transition:leave-end="opacity-0 transform scale-90"
         class="fixed inset-0 flex items-center justify-center z-50 bg-black/70 backdrop-blur-sm"
         style="display: none;">
        <div class="relative w-full max-w-md">
            <!-- Close button -->
            <button @click="showPromoPopup = false" class="absolute -top-4 -right-4 bg-film-gray text-white rounded-full p-2 shadow-lg hover:bg-film-red transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            
            <!-- Coupon content -->
            <div class="bg-gradient-to-br from-film-dark to-film-gray p-1 rounded-xl shadow-2xl">
                <div class="coupon-clip bg-film-gray p-6 rounded-lg border-4 border-dashed border-film-red flex flex-col items-center">
                    <div class="mb-4 text-center">
                        <h2 class="text-2xl font-bold text-white mb-1">Welcome Offer</h2>
                        <p class="text-gray-400">Exclusive discount for new members</p>
                    </div>
                    
                    <div class="w-full bg-black/30 py-6 px-4 rounded-lg text-center mb-6">
                        <p class="text-gray-400 text-sm mb-2">Your promo code</p>
                        <div class="relative">
                            <div class="promo-sparkle bg-gradient-to-r from-film-red via-yellow-500 to-film-red text-white font-mono text-xl sm:text-2xl font-bold py-3 rounded tracking-widest">
                                <span x-text="promoCode">FILMWAVE25</span>
                            </div>
                            <div class="absolute -top-1 -left-1 w-3 h-3 bg-white rounded-full"></div>
                            <div class="absolute -top-1 -right-1 w-3 h-3 bg-white rounded-full"></div>
                            <div class="absolute -bottom-1 -left-1 w-3 h-3 bg-white rounded-full"></div>
                            <div class="absolute -bottom-1 -right-1 w-3 h-3 bg-white rounded-full"></div>
                        </div>
                        <p class="text-gray-400 text-sm mt-2">
                            Valid until <span x-text="promoExpiry"></span>
                        </p>
                    </div>
                    
                    <div class="text-center mb-6">
                        <h3 class="text-xl font-bold text-film-red mb-2">25% OFF</h3>
                        <p class="text-gray-300">On your first month premium subscription</p>
                    </div>
                    
                    <div class="w-full grid grid-cols-2 gap-3">
                        <button @click="navigator.clipboard.writeText(promoCode); $dispatch('notify', {message: 'Code copied to clipboard!', type: 'success'})" 
                                class="bg-film-gray hover:bg-gray-800 text-white py-2 px-4 rounded-lg border border-gray-700 transition-colors">
                            Copy Code
                        </button>
                        <button @click="localStorage.setItem('hasRedeemedPromo', 'true'); hasRedeemed = true; showPromoPopup = false; $dispatch('notify', {message: 'Promo code redeemed!', type: 'success'})" 
                                class="bg-film-red hover:bg-red-700 text-white py-2 px-4 rounded-lg transition-colors">
                            Redeem Now
                        </button>
                    </div>
                </div>
            </div>
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
        style="display: none;"
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
    
    <!-- Footer with automatic margin -->
    <footer class="mt-auto mb-0 bg-film-dark">
        @include('partials.footer')
    </footer>
    
    @include('partials.scripts')

</body>
</html>


