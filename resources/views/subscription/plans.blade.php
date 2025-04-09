<head>
    <title>FilmWave - Streaming Movies</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700&family=Roboto:wght@300;400;500;700&display=swap"
        rel="stylesheet">
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
</head>
<div class="bg-film-dark min-h-screen py-12 px-4 sm:px-6">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-16">
            <h1 class="text-4xl md:text-5xl font-bold text-film-light mb-4">Choose Your FilmWave Experience</h1>
            <p class="text-xl text-gray-400 max-w-2xl mx-auto">Select the plan that's right for you and start enjoying unlimited entertainment.</p>
        </div>

        <!-- Plans Container -->
        <div class="flex flex-col md:flex-row space-y-8 md:space-y-0 md:space-x-8 justify-center">
            <!-- Free Plan -->
            <div class="w-full md:w-5/12 bg-gradient-to-b from-film-gray to-film-dark border border-gray-800 rounded-2xl overflow-hidden shadow-lg transform transition-all duration-300 hover:scale-105">
                <div class="p-8">
                    <div class="flex justify-between items-center mb-8">
                        <h2 class="text-2xl font-bold text-film-light">Free Plan</h2>
                        <span class="bg-gray-800 text-film-light py-1 px-4 rounded-full text-sm font-medium">Basic</span>
                    </div>
                    
                    <div class="mb-8">
                        <div class="flex items-baseline">
                            <span class="text-5xl font-bold text-film-light">$0</span>
                            <span class="text-gray-400 ml-2">/month</span>
                        </div>
                        <p class="text-gray-400 mt-2">Start watching without commitment</p>
                    </div>
                    
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-center text-gray-300">
                            <svg class="w-5 h-5 text-green-500 mr-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Watch on any device
                        </li>
                        <li class="flex items-center text-gray-300">
                            <svg class="w-5 h-5 text-green-500 mr-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Limited content library
                        </li>
                        <li class="flex items-center text-gray-300">
                            <svg class="w-5 h-5 text-green-500 mr-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Download episodes individually
                        </li>
                        <li class="flex items-center text-gray-400">
                            <svg class="w-5 h-5 text-gray-600 mr-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                            <span class="line-through">Create custom playlists</span>
                        </li>
                        <li class="flex items-center text-gray-400">
                            <svg class="w-5 h-5 text-gray-600 mr-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                            <span class="line-through">Download entire seasons</span>
                        </li>
                        <li class="flex items-center text-gray-400">
                            <svg class="w-5 h-5 text-gray-600 mr-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                            <span class="line-through">Rate and review content</span>
                        </li>
                    </ul>
                    
                    <button id="free-plan-btn" class="w-full py-3 px-6 border border-gray-600 text-film-light rounded-lg font-medium hover:bg-gray-800 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-film-gray focus:ring-offset-film-dark">
                        Keep Free
                    </button>
                </div>
            </div>

            <!-- Premium Plan -->
            <div class="w-full md:w-5/12 bg-gradient-to-b from-film-gray to-film-dark border border-film-red rounded-2xl overflow-hidden shadow-2xl transform transition-all duration-300 hover:scale-105 relative">
                <!-- Popular Badge -->
                <div class="absolute -top-4 -right-10 bg-film-red text-white px-12 py-1 transform rotate-45 text-sm font-bold shadow-lg">
                    POPULAR
                </div>

                <div class="p-8">
                    <div class="flex justify-between items-center mb-8">
                        <h2 class="text-2xl font-bold text-film-light">Premium Plan</h2>
                        <span class="bg-film-red text-white py-1 px-4 rounded-full text-sm font-medium">Unlimited</span>
                    </div>
                    
                    <div class="mb-8">
                        <div class="flex items-baseline">
                            <span class="text-3xl font-bold text-gray-400 line-through mr-2">$300</span>
                            <span class="text-5xl font-bold text-film-light">$199</span>
                            <span class="text-gray-400 ml-2">/year</span>
                        </div>
                        <p class="text-film-accent font-medium mt-2">Save $101 with our limited time offer!</p>
                    </div>
                    
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-center text-gray-300">
                            <svg class="w-5 h-5 text-film-accent mr-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Watch on any device in 4K UHD
                        </li>
                        <li class="flex items-center text-gray-300">
                            <svg class="w-5 h-5 text-film-accent mr-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Full content library access
                        </li>
                        <li class="flex items-center text-gray-300">
                            <svg class="w-5 h-5 text-film-accent mr-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Download episodes & full seasons
                        </li>
                        <li class="flex items-center text-gray-300">
                            <svg class="w-5 h-5 text-film-accent mr-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Create unlimited playlists
                        </li>
                        <li class="flex items-center text-gray-300">
                            <svg class="w-5 h-5 text-film-accent mr-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Rate and review all content
                        </li>
                        <li class="flex items-center text-gray-300">
                            <svg class="w-5 h-5 text-film-accent mr-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Early access to new releases
                        </li>
                    </ul>
                    <a href="{{ route('subscribe.checkout') }}" id="checkout-button" class="block w-full py-3 px-6 bg-film-red text-white rounded-lg font-medium hover:bg-red-700 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-film-red focus:ring-offset-film-dark pulse-animation text-center">
                        Get Premium
                    </a>
                    
                    <div id="checkout-container" class="mt-4"></div>    </div>
            </div>
        </div>

        <!-- Additional Information -->
        {{-- @if(!auth()->check() || (auth()->check() && !auth()->user()->isPremium()))
            <div class="mt-16 text-center">
                <p class="text-gray-500 text-sm">Already a member? <a href="#" class="text-film-accent hover:underline">Sign in</a></p>
            </div>
        @endif --}}

        <!-- Payment Modal (Hidden by Default) -->
        <div id="payment-modal" class="fixed inset-0  items-center justify-center z-50 hidden" style="background-color: rgba(15, 15, 15, 0.9);">
            <div class="bg-film-gray rounded-xl p-8 max-w-md w-full mx-4 relative transform transition-all">
                <button id="close-modal" class="absolute top-4 right-4 text-gray-400 hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
                
                <div id="modal-content">
                    <!-- Content will be dynamically updated by JavaScript -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('free-plan-btn').classList.add('hover:scale-105', 'transition-transform', 'duration-300', 'ease-in-out');
    document.addEventListener('DOMContentLoaded', function() {
        const freePlanBtn = document.getElementById('free-plan-btn');
        const premiumPlanBtn = document.getElementById('premium-plan-btn');
        const paymentModal = document.getElementById('payment-modal');
        const closeModalBtn = document.getElementById('close-modal');
        const modalContent = document.getElementById('modal-content');
        
        // Add pulse animation to premium button
        function startPulseAnimation() {
            premiumPlanBtn.classList.add('animate-pulse');
            setTimeout(() => {
                premiumPlanBtn.classList.remove('animate-pulse');
                setTimeout(startPulseAnimation, 5000);
            }, 1500);
        }
        
        startPulseAnimation();
        
        // Free Plan Modal
        freePlanBtn.addEventListener('click', function() {
            modalContent.innerHTML = `
                <div class="text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-film-light mb-2">Start Your Free Plan</h3>
                    <p class="text-gray-400 mb-6">Enjoy limited access to FilmWave content.</p>
                    
                    <form class="space-y-4">
                        <div class="text-left">
                            <label class="block text-sm font-medium text-gray-400 mb-1">Email Address</label>
                            <input type="email" class="w-full bg-film-dark border border-gray-700 rounded-lg py-2 px-3 text-film-light focus:outline-none focus:ring-1 focus:ring-film-accent focus:border-film-accent">
                        </div>
                        
                        <div class="text-left">
                            <label class="block text-sm font-medium text-gray-400 mb-1">Create Password</label>
                            <input type="password" class="w-full bg-film-dark border border-gray-700 rounded-lg py-2 px-3 text-film-light focus:outline-none focus:ring-1 focus:ring-film-accent focus:border-film-accent">
                        </div>
                        
                        <button type="button" class="w-full py-3 px-6 border border-gray-600 text-film-light bg-gray-800 rounded-lg font-medium hover:bg-gray-700 transition-colors">
                            Create Free Account
                        </button>
                    </form>
                </div>
            `;
            
            showModal();
        });
        
        // Premium Plan Modal
        premiumPlanBtn.addEventListener('click', function() {
            modalContent.innerHTML = `
                <div class="text-center">
                    <div class="mb-6">
                        <span class="inline-block bg-film-red text-white text-xs font-bold px-3 py-1 rounded-full mb-2">PREMIUM</span>
                        <h3 class="text-xl font-bold text-film-light">Complete Your Premium Purchase</h3>
                        <p class="text-gray-400">$199.00 for 1 year of unlimited access</p>
                    </div>
                    
                    <form class="space-y-4">
                        <div class="text-left">
                            <label class="block text-sm font-medium text-gray-400 mb-1">Card Information</label>
                            <div class="relative">
                                <input type="text" placeholder="1234 1234 1234 1234" class="w-full bg-film-dark border border-gray-700 rounded-lg py-2 px-3 text-film-light focus:outline-none focus:ring-1 focus:ring-film-accent focus:border-film-accent">
                                <div class="absolute right-3 top-2.5 flex space-x-1">
                                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect width="24" height="24" rx="4" fill="#1434CB"/>
                                        <path d="M12.4924 14.4275H11.1666L12.003 9.57245H13.3288L12.4924 14.4275Z" fill="white"/>
                                    </svg>
                                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect width="24" height="24" rx="4" fill="#FF5F00"/>
                                        <circle cx="8" cy="12" r="3" fill="#EB001B"/>
                                        <circle cx="16" cy="12" r="3" fill="#F79E1B"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-3 mt-2">
                                <input type="text" placeholder="MM/YY" class="bg-film-dark border border-gray-700 rounded-lg py-2 px-3 text-film-light focus:outline-none focus:ring-1 focus:ring-film-accent focus:border-film-accent">
                                <input type="text" placeholder="CVC" class="bg-film-dark border border-gray-700 rounded-lg py-2 px-3 text-film-light focus:outline-none focus:ring-1 focus:ring-film-accent focus:border-film-accent">
                            </div>
                        </div>
                        
                        <div class="text-left">
                            <label class="block text-sm font-medium text-gray-400 mb-1">Name on Card</label>
                            <input type="text" class="w-full bg-film-dark border border-gray-700 rounded-lg py-2 px-3 text-film-light focus:outline-none focus:ring-1 focus:ring-film-accent focus:border-film-accent">
                        </div>
                        
                        <div class="text-left">
                            <label class="block text-sm font-medium text-gray-400 mb-1">Email Address</label>
                            <input type="email" class="w-full bg-film-dark border border-gray-700 rounded-lg py-2 px-3 text-film-light focus:outline-none focus:ring-1 focus:ring-film-accent focus:border-film-accent">
                        </div>
                        
                        <div class="flex items-center space-x-2">
                            <input type="checkbox" id="terms" class="rounded text-film-accent focus:ring-film-accent focus:ring-offset-film-dark">
                            <label for="terms" class="text-sm text-gray-400">I agree to the <a href="#" class="text-film-accent hover:underline">Terms of Service</a></label>
                        </div>
                        
                        <button type="button" class="w-full py-3 px-6 bg-film-red text-white rounded-lg font-medium hover:bg-red-700 transition-colors">
                            Pay $199 Now
                        </button>
                        
                        <p class="text-xs text-gray-500">
                            Your subscription will automatically renew. You can cancel anytime.
                        </p>
                    </form>
                </div>
            `;
            
            showModal();
        });
        
        // Close modal when clicking the close button
        closeModalBtn.addEventListener('click', function() {
            hideModal();
        });
        
        // Close modal when clicking outside
        paymentModal.addEventListener('click', function(e) {
            if (e.target === paymentModal) {
                hideModal();
            }
        });
        
        function showModal() {
            paymentModal.classList.remove('hidden');
            setTimeout(() => {
                paymentModal.querySelector('.transform').classList.add('scale-100');
                paymentModal.querySelector('.transform').classList.remove('scale-95', 'opacity-0');
            }, 10);
        }
        
        function hideModal() {
            const modalInner = paymentModal.querySelector('.transform');
            modalInner.classList.add('scale-95', 'opacity-0');
            modalInner.classList.remove('scale-100');
            
            setTimeout(() => {
                paymentModal.classList.add('hidden');
            }, 300);
        }
    });
</script>

<style>
    .pulse-animation {
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(229, 9, 20, 0.7);
        }
        70% {
            box-shadow: 0 0 0 10px rgba(229, 9, 20, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(229, 9, 20, 0);
        }
    }
    
    /* Modal animation */
    #payment-modal .transform {
        transition: all 0.3s ease-out;
        transform: scale(0.95);
        opacity: 0;
    }
    
    #payment-modal .transform.scale-100 {
        transform: scale(1);
        opacity: 1;
    }
    
    /* Card hover effects */
    .hover\:scale-105:hover {
        transform: scale(1.05) translateY(-5px);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.9);
    }
</style>

<script src="https://js.stripe.com/v3/"></script>
{{-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkoutButton = document.getElementById('checkout-button');
        const checkoutContainer = document.getElementById('checkout-container');
        const stripe = Stripe('{{ env('STRIPE_KEY') }}');
        let checkout;

        checkoutButton.addEventListener('click', async () => {
            // Show loading state
            const originalText = checkoutButton.innerHTML;
            checkoutButton.innerHTML = '<span class="inline-block animate-spin mr-2">↻</span> Processing...';
            checkoutButton.disabled = true;
            
            try {
                // Get CSRF token from meta tag
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                if (!csrfToken) {
                    throw new Error('CSRF token not found');
                }
                // Call your backend to create the checkout session
                const response = await fetch('{{ route("checkout.create") }}', {
                    method: 'POST',
                    headers: { 
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                });
                
                

                if (!response.ok) {
                    const errorData = await response.json();
                    throw new Error(errorData.error || 'Network response was not ok');
                }
                
                const { clientSecret } = await response.json();
                
                // Show checkout container
                checkoutContainer.innerHTML = '<div class="bg-film-gray p-4 rounded-lg border border-film-red"></div>';
                
                // Initialize checkout
                checkout = stripe.initEmbeddedCheckout({
                    clientSecret
                });
                
                // Mount checkout
                checkout.mount(checkoutContainer.querySelector('div'));
                
            } catch (error) {
                console.error('Error:', error);
                alert('Payment processing failed. Please try again.');
                
                // Reset button
                checkoutButton.innerHTML = originalText;
                checkoutButton.disabled = false;
            }
        });
    });
</script> --}}