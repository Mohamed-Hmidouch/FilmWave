<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Streaming Service Login</title>
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
                            Sign In
                        </h2>
                        <p class="text-gray-300 text-sm opacity-80">
                            Welcome back to your streaming experience
                        </p>
                    </div>
                    
                    <form id="login-form" action="{{ route('login') }}" method="POST" class="space-y-6">
                        @csrf
                        
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
                        
                        <!-- Remember me and forgot password -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <input
                                    type="checkbox"
                                    id="remember"
                                    name="remember"
                                    class="h-4 w-4 rounded border-gray-700 bg-gray-800 text-film-red focus:ring-film-red"
                                />
                                <label for="remember" class="ml-2 text-sm text-gray-300">
                                    Remember me
                                </label>
                            </div>
                            <a href="" class="text-sm text-film-red hover:text-red-400">
                                Forgot password?
                            </a>
                        </div>
                        
                        <button
                            type="submit"
                            class="w-full py-3 px-4 bg-film-red hover:bg-red-700 text-white font-medium rounded-lg shadow-lg shadow-red-600/30 transition-all duration-300 transform hover:-translate-y-0.5"
                        >
                            Sign In
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
                        Don't have an account?
                        <a href="{{ route('register') }}" class="text-film-red hover:text-red-400 font-medium ml-1">
                            Sign Up
                        </a>
                    </p>
                </div>
                
                <!-- Right side: Image -->
                <div class="hidden md:block md:w-1/2 relative">
                    <img
                        src="https://images.unsplash.com/photo-1577495508048-b635879837f1?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1171&q=80"
                        alt="Streaming Content"
                        class="w-full h-full object-cover"
                    />
                    <div class="absolute inset-0 bg-gradient-to-l from-transparent via-black/50 to-black backdrop-blur-sm flex items-center justify-center">
                        <div class="text-center p-8">
                            <h3 class="text-3xl font-bold text-white mb-4">
                                Welcome Back
                            </h3>
                            <p class="text-lg text-gray-200 mb-6">
                                Your entertainment journey continues here.
                            </p>
                            <div class="flex items-center justify-center space-x-4 mb-6">
                                <span class="bg-white/20 backdrop-blur-md px-4 py-2 rounded-full text-white text-sm">Movies</span>
                                <span class="bg-white/20 backdrop-blur-md px-4 py-2 rounded-full text-white text-sm">TV Shows</span>
                                <span class="bg-white/20 backdrop-blur-md px-4 py-2 rounded-full text-white text-sm">Originals</span>
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
        
        // Initialize everything when the DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            createStars();
            setupPasswordToggle();
        });
    </script>
</body>
</html>