<footer class="bg-[#0F0F0F] text-gray-400 py-10 border-t border-gray-800"
        x-data="{
            emailSubscription: '',
            subscribeStatus: '',
            showSubscribeModal: false,
            promoCode: '',
            generateNewPromoCode() {
                this.promoCode = voucher_codes.generate({
                    length: 10,
                    count: 1,
                    charset: 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'
                })[0];
            }
        }">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Logo and About -->
            <div>
                <div class="flex items-center mb-4">
                    <div class="w-8 h-8 bg-film-red rounded flex items-center justify-center overflow-hidden">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 6a2 2 0 012-2h12a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"></path>
                        </svg>
                    </div>
                    <span class="ml-2 text-film-red font-bold text-xl tracking-tighter">FilmWave</span>
                </div>
                <p class="text-sm mb-4">Your ultimate destination for movies, TV series and more. Unlimited streaming anytime, anywhere.</p>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-film-red transition-colors">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-film-red transition-colors">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-film-red transition-colors">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-film-red transition-colors">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
                
                <!-- App badges -->
                <div class="mt-6 flex space-x-3">
                    <a href="#" class="bg-black hover:bg-gray-900 transition-colors rounded overflow-hidden flex items-center px-3 py-1.5 border border-gray-700">
                        <i class="fab fa-apple text-lg mr-2"></i>
                        <div class="text-left">
                            <div class="text-[0.6rem] text-gray-400">Download on the</div>
                            <div class="text-xs font-semibold text-white">App Store</div>
                        </div>
                    </a>
                    <a href="#" class="bg-black hover:bg-gray-900 transition-colors rounded overflow-hidden flex items-center px-3 py-1.5 border border-gray-700">
                        <i class="fab fa-google-play text-lg mr-2"></i>
                        <div class="text-left">
                            <div class="text-[0.6rem] text-gray-400">GET IT ON</div>
                            <div class="text-xs font-semibold text-white">Google Play</div>
                        </div>
                    </a>
                </div>
            </div>
            
            <!-- Quick Links -->
            <div>
                <h3 class="text-white font-semibold mb-4">Explore</h3>
                <ul class="space-y-2">
                    <li><a href="#" class="hover:text-film-red transition-colors">Films</a></li>
                    <li><a href="#" class="hover:text-film-red transition-colors">TV Series</a></li>
                    <li><a href="#" class="hover:text-film-red transition-colors">Anime</a></li>
                    <li>
                        <a href="#" class="flex items-center justify-between hover:text-film-red transition-colors">
                            <span>New Releases</span>
                            <span class="bg-film-red text-white text-xs px-2 py-0.5 rounded-full">NEW</span>
                        </a>
                    </li>
                    <li><a href="#" class="hover:text-film-red transition-colors">Top Rated</a></li>
                    <li>
                        <a 
                            href="#"
                            @click.prevent="generateNewPromoCode(); showSubscribeModal = true" 
                            class="hover:text-film-red transition-colors flex items-center"
                        >
                            <span>Promotions</span>
                            <i class="fas fa-ticket-alt ml-2 text-xs text-film-red"></i>
                        </a>
                    </li>
                </ul>
            </div>
            
            <!-- Support -->
            <div>
                <h3 class="text-white font-semibold mb-4">Support</h3>
                <ul class="space-y-2">
                    <li><a href="#" class="hover:text-film-red transition-colors">Help Center</a></li>
                    <li><a href="#" class="hover:text-film-red transition-colors">Terms of Use</a></li>
                    <li><a href="#" class="hover:text-film-red transition-colors">Privacy Policy</a></li>
                    <li><a href="#" class="hover:text-film-red transition-colors">Contact Us</a></li>
                    <li><a href="#" class="hover:text-film-red transition-colors">FAQ</a></li>
                </ul>
                
                <!-- Device compatibility info -->
                <div class="mt-6 p-3 bg-black/30 rounded-lg border border-gray-800">
                    <h4 class="text-sm font-medium text-white mb-2">Compatible Devices</h4>
                    <div class="flex flex-wrap gap-3">
                        <i class="fas fa-tv text-gray-400 hover:text-film-red transition-colors"></i>
                        <i class="fas fa-laptop text-gray-400 hover:text-film-red transition-colors"></i>
                        <i class="fas fa-tablet-alt text-gray-400 hover:text-film-red transition-colors"></i>
                        <i class="fas fa-mobile-alt text-gray-400 hover:text-film-red transition-colors"></i>
                        <i class="fab fa-apple text-gray-400 hover:text-film-red transition-colors"></i>
                        <i class="fab fa-android text-gray-400 hover:text-film-red transition-colors"></i>
                    </div>
                </div>
            </div>
            
            <!-- Newsletter -->
            <div>
                <h3 class="text-white font-semibold mb-4">Newsletter</h3>
                <p class="text-sm mb-4">Subscribe to our newsletter to receive updates on new releases.</p>
                <form @submit.prevent="
                    if(emailSubscription) {
                        subscribeStatus = 'success';
                        $dispatch('notify', {message: 'Successfully subscribed to newsletter!', type: 'success'});
                        generateNewPromoCode();
                        showSubscribeModal = true;
                    } else {
                        subscribeStatus = 'error';
                        $dispatch('notify', {message: 'Please enter a valid email', type: 'error'});
                    }
                ">
                    <div class="relative">
                        <input 
                            type="email" 
                            x-model="emailSubscription"
                            placeholder="Your email address" 
                            class="bg-[#1A1A1A] text-white rounded-md py-2 px-4 w-full focus:outline-none focus:ring-1 focus:ring-film-red mb-2"
                            :class="{'border border-red-500': subscribeStatus === 'error'}"
                        >
                        <button 
                            type="submit"
                            class="bg-film-red hover:bg-red-700 text-white rounded-md py-2 px-4 w-full transition-colors"
                        >
                            Subscribe
                        </button>
                    </div>
                </form>
                
                <!-- Payment methods -->
                <div class="mt-6">
                    <h4 class="text-sm text-white mb-2">Secure Payment Methods</h4>
                    <div class="flex flex-wrap gap-2">
                        <i class="fab fa-cc-visa text-xl text-gray-400"></i>
                        <i class="fab fa-cc-mastercard text-xl text-gray-400"></i>
                        <i class="fab fa-cc-amex text-xl text-gray-400"></i>
                        <i class="fab fa-cc-paypal text-xl text-gray-400"></i>
                        <i class="fab fa-apple-pay text-xl text-gray-400"></i>
                        <i class="fab fa-google-pay text-xl text-gray-400"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="border-t border-gray-800 mt-8 pt-6 text-sm text-center">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <p>&copy; 2025 FilmWave. All rights reserved.</p>
                <div class="flex space-x-4 mt-4 md:mt-0">
                    <a href="#" class="hover:text-film-red transition-colors">Careers</a>
                    <a href="#" class="hover:text-film-red transition-colors">Affiliate Program</a>
                    <a href="#" class="hover:text-film-red transition-colors">Advertise</a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Newsletter Success Modal with Promo -->
    <div 
        x-show="showSubscribeModal" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform scale-90"
        x-transition:enter-end="opacity-100 transform scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-90"
        class="fixed inset-0 flex items-center justify-center z-50 bg-black/80 backdrop-blur-sm"
        @click.away="showSubscribeModal = false"
        style="display: none;"
    >
        <div class="bg-gradient-to-br from-film-dark to-film-gray p-8 rounded-xl max-w-md w-full relative">
            <!-- Close button -->
            <button @click="showSubscribeModal = false" class="absolute top-3 right-3 text-gray-400 hover:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            
            <div class="text-center">
                <div class="inline-block mb-6 p-4 bg-green-500/20 rounded-full">
                    <svg class="w-12 h-12 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                
                <h3 class="text-2xl font-bold text-white mb-3">Thank You for Subscribing!</h3>
                <p class="text-gray-300 mb-6">We're thrilled to have you join our community. Check your inbox for updates on the latest releases and exclusive offers.</p>
                
                <div class="bg-black/30 p-4 rounded-lg border border-gray-700 mb-6">
                    <p class="text-white text-sm mb-2">Here's your special welcome gift:</p>
                    <div class="bg-gradient-to-r from-film-red to-yellow-600 text-white font-mono font-bold py-2 px-2 rounded text-lg tracking-widest">
                        <span x-text="promoCode">WELCOME25</span>
                    </div>
                    <p class="text-gray-400 text-xs mt-2">Use this code at checkout for 25% off your first month</p>
                </div>
                
                <div class="flex space-x-4">
                    <button 
                        @click="navigator.clipboard.writeText(promoCode); $dispatch('notify', {message: 'Promo code copied!', type: 'success'})"
                        class="flex-1 bg-transparent border border-gray-600 hover:border-white text-white py-2 rounded-md transition-colors"
                    >
                        Copy Code
                    </button>
                    <button 
                        @click="showSubscribeModal = false" 
                        class="flex-1 bg-film-red hover:bg-red-700 text-white py-2 rounded-md transition-colors"
                    >
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</footer>