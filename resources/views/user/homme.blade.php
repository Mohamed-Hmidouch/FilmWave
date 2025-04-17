<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>FilmWave - Streaming de Films</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Tailwind CSS -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
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
        </style>
    </head>
<body class="min-h-screen flex flex-col bg-[#121212] text-[#e5e5e5]">
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
    <div class="transition-[margin-left] duration-300 ease-in-out bg-[#121212] lg:ml-64 md:ml-72">
        @include('partials.navbar')
        
        <!-- Main content area with dark background -->
        <div class="w-full py-6 bg-[#121212]">
            @include('partials._featured_movies')
        </div>
        <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-20 hidden md:hidden"></div>
    </div>
    
    <!-- Footer with automatic margin -->
    <footer class="mt-auto mb-0 bg-film-dark">
        @include('partials.footer')
    </footer>
    
    @include('partials.scripts')

    <!-- Script pour faire disparaître le message flash après 3 secondes -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const flashNotification = document.getElementById('flash-notification');
            if (flashNotification) {
                setTimeout(function() {
                    flashNotification.classList.remove('opacity-100');
                    flashNotification.classList.add('opacity-0');
                    setTimeout(function() {
                        flashNotification.style.display = 'none';
                    }, 500);
                }, 3000);
            }
        });
    </script>
</body>
</html>


