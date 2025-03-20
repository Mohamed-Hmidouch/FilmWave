<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Streaming Service Registration</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'film-red': '#E50914',
                        'film-gray': '#141414',
                        'film-accent': '#E50914'
                    }
                }
            }
        }
    </script>
    <style>
        .stars-container {
            position: absolute;
            width: 100%;
            height: 100%;
        }
        
        .star {
            position: absolute;
            background-color: white;
            border-radius: 50%;
            opacity: 0;
            animation: twinkle ease-in-out infinite;
        }
        
        @keyframes twinkle {
            0% {
                opacity: 0;
                transform: scale(0.5);
            }
            50% {
                opacity: 0.8;
                transform: scale(1.2);
            }
            100% {
                opacity: 0;
                transform: scale(0.5);
            }
        }
        
        .backdrop-blur-md {
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
        
        .backdrop-blur-sm {
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
        }
    </style>
</head>
<body>
    <div class="min-h-screen bg-black flex items-center justify-center p-4 md:p-6">
        <!-- Animated background particles -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="stars-container" id="stars-container">
                <!-- Stars will be added with JavaScript -->
            </div>
        </div>
        
        <!-- Main content container -->
        <div class="container mx-auto max-w-5xl z-10">
            <div class="flex flex-col md:flex-row rounded-xl overflow-hidden shadow-2xl">
                
                <!-- Left side: Form -->
                <div class="w-full md:w-1/2 bg-film-gray bg-opacity-90 backdrop-blur-md p-8 rounded-l-xl">
                    <div class="mb-8">
                        <h2 class="text-3xl font-bold text-white mb-2">
                            Create Your Account
                        </h2>
                        <p class="text-gray-300 text-sm opacity-80">
                            Start your streaming journey today
                        </p>
                    </div>
                    
                    <form id="registration-form" action="{{ route('register') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <!-- Name field -->
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                                <i class="fas fa-user"></i>
                            </div>
                            <input
                                type="text"
                                name="name"
                                id="name"
                                placeholder="Full Name"
                                required
                                value="{{ old('name') }}"
                                class="w-full pl-10 pr-3 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-film-red transition-all duration-300 @error('name') border-red-500 @enderror"
                            />
                            @error('name')
                                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <!-- Email field -->
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <input
                                type="email"
                                name="email"
                                id="email"
                                placeholder="Email Address"
                                required
                                value="{{ old('email') }}"
                                class="w-full pl-10 pr-3 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-film-red transition-all duration-300 @error('email') border-red-500 @enderror"
                            />
                            @error('email')
                                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <!-- Password field -->
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                                <i class="fas fa-lock"></i>
                            </div>
                            <input
                                type="password"
                                name="password"
                                id="password"
                                placeholder="Password"
                                required
                                class="w-full pl-10 pr-10 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-film-red transition-all duration-300 @error('password') border-red-500 @enderror"
                            />
                            <button
                                type="button"
                                id="toggle-password"
                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-white"
                            >
                                <i class="fas fa-eye" id="password-icon"></i>
                            </button>
                            @error('password')
                                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Plan selection -->
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Choose Your Plan
                            </label>
                            <div class="mt-2">
                                <div class="flex items-center">
                                    <input id="plan-free" name="plan" type="radio" value="free" checked
                                           class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                    <label for="plan-free" class="ml-3 block text-sm font-medium text-gray-700">
                                        Free Plan
                                    </label>
                                </div>
                                <div class="flex items-center mt-2">
                                    <input id="plan-premium" name="plan" type="radio" value="premium"
                                           class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                    <label for="plan-premium" class="ml-3 block text-sm font-medium text-gray-700">
                                        Premium Plan
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <button
                            type="submit"
                            class="w-full py-3 px-4 bg-film-red hover:bg-red-700 text-white font-medium rounded-lg shadow-lg shadow-red-600/30 transition-all duration-300 transform hover:-translate-y-0.5"
                        >
                            Sign Up
                        </button>
                    </form>
                    
                    <div class="mt-6">
                        <div class="flex items-center">
                            <div class="flex-grow h-px bg-gray-700"></div>
                            <span class="px-3 text-sm text-gray-400">or continue with</span>
                            <div class="flex-grow h-px bg-gray-700"></div>
                        </div>
                        
                        <div class="flex gap-4 mt-6">
                            <button class="flex-1 py-3 px-4 rounded-lg border border-gray-700 bg-gray-800 text-white hover:bg-gray-700 transition-all duration-300 flex items-center justify-center gap-2">
                                <i class="fab fa-google text-red-400"></i>
                                <span>Google</span>
                            </button>
                            <button class="flex-1 py-3 px-4 rounded-lg border border-gray-700 bg-gray-800 text-white hover:bg-gray-700 transition-all duration-300 flex items-center justify-center gap-2">
                                <i class="fab fa-facebook text-blue-400"></i>
                                <span>Facebook</span>
                            </button>
                        </div>
                    </div>
                    
                    <p class="mt-8 text-sm text-center text-gray-300">
                        Already have an account?
                        <a href="#" class="text-film-red hover:text-red-400 font-medium ml-1">
                            Sign In
                        </a>
                    </p>
                </div>
                
                <!-- Right side: Image -->
                <div class="hidden md:block md:w-1/2 relative">
                    <img
                        src="https://images.unsplash.com/photo-1626814026160-2237a95fc5a0?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80"
                        alt="Streaming Content"
                        class="w-full h-full object-cover"
                    />
                    <div class="absolute inset-0 bg-gradient-to-l from-transparent via-black/50 to-black backdrop-blur-sm flex items-center justify-center">
                        <div class="text-center p-8">
                            <h3 class="text-3xl font-bold text-white mb-4">
                                Unlimited Entertainment
                            </h3>
                            <p class="text-lg text-gray-200 mb-6">
                                Stream thousands of movies and TV shows anytime, anywhere.
                            </p>
                            <div class="inline-flex items-center justify-center">
                                <div class="flex -space-x-2">
                                    <img class="w-10 h-10 rounded-full border-2 border-white" src="https://randomuser.me/api/portraits/women/11.jpg" alt="" />
                                    <img class="w-10 h-10 rounded-full border-2 border-white" src="https://randomuser.me/api/portraits/men/32.jpg" alt="" />
                                    <img class="w-10 h-10 rounded-full border-2 border-white" src="https://randomuser.me/api/portraits/women/31.jpg" alt="" />
                                </div>
                                <span class="text-sm text-white ml-2">
                                    Join millions of viewers today
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Create stars for the background animation
        function createStars() {
            const starsContainer = document.getElementById('stars-container');
            const starCount = 20;
            
            for (let i = 0; i < starCount; i++) {
                const star = document.createElement('div');
                star.className = 'star';
                
                // Random position
                star.style.top = `${Math.random() * 100}%`;
                star.style.left = `${Math.random() * 100}%`;
                
                // Random size
                const size = Math.random() * 2 + 1;
                star.style.width = `${size}px`;
                star.style.height = `${size}px`;
                
                // Random animation duration and delay
                star.style.animationDuration = `${Math.random() * 3 + 2}s`;
                star.style.animationDelay = `${Math.random() * 2}s`;
                
                starsContainer.appendChild(star);
            }
        }
        
        // Toggle password visibility
        function setupPasswordToggle() {
            const passwordInput = document.getElementById('password');
            const toggleButton = document.getElementById('toggle-password');
            const passwordIcon = document.getElementById('password-icon');
            
            toggleButton.addEventListener('click', function() {
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    passwordIcon.classList.remove('fa-eye');
                    passwordIcon.classList.add('fa-eye-slash');
                } else {
                    passwordInput.type = 'password';
                    passwordIcon.classList.remove('fa-eye-slash');
                    passwordIcon.classList.add('fa-eye');
                }
            });
        }
        
        // Form submission
        // function setupFormSubmission() {
            const form = document.getElementById('registration-form');
            
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const nameInput = document.getElementById('name');
                const emailInput = document.getElementById('email');
                const passwordInput = document.getElementById('password');
                
                const formData = {
                    name: nameInput.value,
                    email: emailInput.value,
                    password: passwordInput.value
                };
                
                console.log('Form submitted:', formData);
                // Here you would typically send the data to your server
                
                alert('Registration successful!');
                form.reset();
            });
        }
        
        // Initialize everything when the DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            createStars();
            setupPasswordToggle();
            setupFormSubmission();
        });
    </script>
</body>
</html>