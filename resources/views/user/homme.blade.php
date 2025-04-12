<!DOCTYPE html>
<html lang="en">
    <head>
        <title>FilmWave - Streaming Movies</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Tailwind CSS -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
        
<style>
body {
  min-height: 100vh;
  display: flex;
  flex-direction: column;
}

footer {
  margin-bottom: 0;
  margin-top: auto;
}
    
            .scrollbar-hide::-webkit-scrollbar {
                display: none;
            }
    
            .scrollbar-hide {
                -ms-overflow-style: none;
                scrollbar-width: none;
            }
    
            .movie-card {
                transition: transform 0.3s ease;
            }
    
            .movie-card:hover {
                transform: scale(1.05);
            }
    
            /* Sidebar specific styles */
            .sidebar-icon {
                width: 40px;
                height: 40px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 8px;
                transition: all 0.2s ease;
            }
    
            .sidebar-icon:hover {
                background-color: rgba(255, 255, 255, 0.1);
                transform: translateY(-2px);
            }

            /* Main content layout */
            .main-content {
                transition: margin-left 0.3s ease-in-out;
            }

            /* Responsive adjustments */
            @media (min-width: 1024px) {
                .main-content {
                    margin-left: 16rem; /* w-64 */
                }
            }

            @media (min-width: 768px) and (max-width: 1023px) {
                .main-content {
                    margin-left: 18rem; /* w-72 */
                }
            }
</style>
    </head>
<body>
        <!-- Notification element for movies -->
        <div id="notification" class="notification">
            <span id="notification-message"></span>
        </div>
    <!-- Include sidebar -->
    @include('partials.sidebar')

    <!-- Main content wrapper -->
    <div class="main-content">
        @include('partials.navbar')
        
        <!-- Main content area -->
        <div class="w-full py-6">
            @include('partials._featured_movies')
        </div>
        <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-20 hidden md:hidden"></div>

    </div>
     @include('partials.footer')
     @include('partials.scripts')

</body>
</html>


