<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FilmWave - Login</title>
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
        .bg-image-slider {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }
        
        .bg-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            opacity: 0;
            transition: opacity 1.5s ease-in-out;
        }
        
        .active {
            opacity: 1;
        }
        
        .glass-effect {
            background: rgba(20, 20, 20, 0.75);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .login-container {
            animation: fadeIn 0.8s ease-in-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .logo-pulse {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4 overflow-hidden bg-black">
    <!-- Background Image Slider -->
    <div class="bg-image-slider" id="bg-slider">
        <!-- Images will be added with JavaScript -->
    </div>
    
    <!-- Dark Overlay -->
    <div class="absolute inset-0 bg-gradient-to-t from-black via-black/70 to-black/40 z-0"></div>
    
    <!-- Main Content -->
    <div class="container mx-auto max-w-5xl z-10 login-container px-4">
        <!-- Logo -->
        <div class="text-center mb-8">
            <h1 class="text-film-red text-5xl font-bold logo-pulse">FilmWave</h1>
            <p class="text-gray-300 mt-2">Your premium streaming experience</p>
        </div>
        
        <div class="flex flex-col md:flex-row rounded-xl overflow-hidden shadow-2xl">
            <!-- Left side: Login Form -->
            <div class="w-full md:w-1/2 glass-effect p-8 rounded-l-xl">
                <div class="mb-8">
                    <h2 class="text-3xl font-bold text-white mb-2">
                        Sign In
                    </h2>
                    <p class="text-gray-300 text-sm opacity-80">
                        Continue your streaming journey
                    </p>
                </div>
                
                <form id="login-form" action="{{ route('login') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <!-- Champ caché pour l'URL de redirection -->
                    <input type="hidden" name="redirect_to" id="redirect_to" value="">
                    
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
                            class="w-full pl-10 pr-3 py-3 bg-gray-800/70 border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-film-red transition-all duration-300 @error('email') border-red-500 @enderror"
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
                            class="w-full pl-10 pr-10 py-3 bg-gray-800/70 border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-film-red transition-all duration-300 @error('password') border-red-500 @enderror"
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
                        <button class="flex-1 py-3 px-4 rounded-lg border border-gray-700 bg-gray-800/70 text-white hover:bg-gray-700 transition-all duration-300 flex items-center justify-center gap-2">
                            <i class="fab fa-google text-red-400"></i>
                            <span>Google</span>
                        </button>
                        <button class="flex-1 py-3 px-4 rounded-lg border border-gray-700 bg-gray-800/70 text-white hover:bg-gray-700 transition-all duration-300 flex items-center justify-center gap-2">
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
            
            <!-- Right side: Featured Content -->
            <div class="hidden md:block md:w-1/2 glass-effect rounded-r-xl p-8">
                <div class="h-full flex flex-col items-center justify-center">
                    <div class="mb-6">
                        <span class="inline-block px-3 py-1 bg-film-red text-white text-xs uppercase tracking-wide rounded-full mb-4">Featured</span>
                        <h3 class="text-3xl font-bold text-white mb-2">Unlimited Entertainment</h3>
                        <p class="text-gray-300 mb-6">Access thousands of movies, TV shows and series</p>
                    </div>
                    
                    <!-- Content Highlights -->
                    <div class="w-full grid grid-cols-2 gap-4 mb-8">
                        <div class="flex flex-col items-center p-4 rounded-lg bg-black/30 backdrop-blur-sm">
                            <i class="fas fa-film text-film-red text-xl mb-2"></i>
                            <h4 class="text-white font-medium mb-1">Movies</h4>
                            <p class="text-gray-400 text-xs text-center">Blockbusters to classics</p>
                        </div>
                        <div class="flex flex-col items-center p-4 rounded-lg bg-black/30 backdrop-blur-sm">
                            <i class="fas fa-tv text-film-red text-xl mb-2"></i>
                            <h4 class="text-white font-medium mb-1">TV Shows</h4>
                            <p class="text-gray-400 text-xs text-center">Binge-worthy series</p>
                        </div>
                        <div class="flex flex-col items-center p-4 rounded-lg bg-black/30 backdrop-blur-sm">
                            <i class="fas fa-crown text-film-red text-xl mb-2"></i>
                            <h4 class="text-white font-medium mb-1">Originals</h4>
                            <p class="text-gray-400 text-xs text-center">Exclusive content</p>
                        </div>
                        <div class="flex flex-col items-center p-4 rounded-lg bg-black/30 backdrop-blur-sm">
                            <i class="fas fa-mobile-alt text-film-red text-xl mb-2"></i>
                            <h4 class="text-white font-medium mb-1">Watch Anywhere</h4>
                            <p class="text-gray-400 text-xs text-center">On all your devices</p>
                        </div>
                    </div>
                    
                    <!-- Content Caption -->
                    <div class="text-center">
                        <div class="inline-block mb-4">
                            <div class="flex items-center justify-center">
                                <div class="h-2 w-2 rounded-full bg-film-red mr-1"></div>
                                <div class="h-2 w-2 rounded-full bg-white/50 mr-1"></div>
                                <div class="h-2 w-2 rounded-full bg-white/50 mr-1"></div>
                                <div class="h-2 w-2 rounded-full bg-white/50 mr-1"></div>
                                <div class="h-2 w-2 rounded-full bg-white/50"></div>
                            </div>
                        </div>
                        <p class="text-sm text-gray-300">
                            Join millions of viewers already enjoying FilmWave
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Fonction pour récupérer les paramètres de l'URL
        function getUrlParameter(name) {
            name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
            var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
            var results = regex.exec(location.search);
            return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Récupérer l'URL de redirection depuis les paramètres de l'URL ou du localStorage
            var redirectUrl = getUrlParameter('redirect') || localStorage.getItem('redirectAfterLogin') || '';
            
            // Si on a une URL de redirection, on la met dans le champ caché
            if (redirectUrl) {
                document.getElementById('redirect_to').value = redirectUrl;
                console.log('URL de redirection après login:', redirectUrl);
            }
            
            // Toggle password visibility
            document.getElementById('toggle-password').addEventListener('click', function() {
                var passwordField = document.getElementById('password');
                var passwordIcon = document.getElementById('password-icon');
                
                if (passwordField.type === 'password') {
                    passwordField.type = 'text';
                    passwordIcon.classList.remove('fa-eye');
                    passwordIcon.classList.add('fa-eye-slash');
                } else {
                    passwordField.type = 'password';
                    passwordIcon.classList.remove('fa-eye-slash');
                    passwordIcon.classList.add('fa-eye');
                }
            });
            
            // Background image slider
            const backgroundImages = [
                'https://assets.nflxext.com/ffe/siteui/vlv3/c38a2d52-138e-48a3-ab68-36787ece0b57/ebd97322-14fd-4a46-9bda-ab40bbf2ba83/FR-fr-20240101-popsignuptwoweeks-perspective_alpha_website_large.jpg',
                'https://img.freepik.com/premium-photo/woman-using-streaming-service-watch-movies-series-living-room-generative-ai_162350-1299.jpg',
                'https://cdn.mos.cms.futurecdn.net/Qay3UT9Xq35pgKbK5qbJWm.jpg',
                'https://www.xtrafondos.com/wallpapers/vertical/peaky-blinders-temporada-final-9454.jpg'
            ];
            
            const slider = document.getElementById('bg-slider');
            
            // Create the initial slides
            backgroundImages.forEach((url, index) => {
                const slide = document.createElement('div');
                slide.className = 'bg-image';
                slide.style.backgroundImage = `url(${url})`;
                
                // Make the first slide active
                if (index === 0) {
                    slide.classList.add('active');
                }
                
                slider.appendChild(slide);
            });
            
            // Set up the slideshow
            let currentSlide = 0;
            
            setInterval(() => {
                // Get all slides
                const slides = document.querySelectorAll('.bg-image');
                
                // Remove active class from current slide
                slides[currentSlide].classList.remove('active');
                
                // Move to the next slide
                currentSlide = (currentSlide + 1) % slides.length;
                
                // Add active class to the new current slide
                slides[currentSlide].classList.add('active');
            }, 5000);
        });
    </script>
</body>
</html>