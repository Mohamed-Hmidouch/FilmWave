<!DOCTYPE html>
<html lang="en">

<head>
    <title>FilmWave - Streaming Movies</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <style>
        body {
            font-family: 'Open Sans', Arial, sans-serif;
            background-color: #0F0F0F;
            color: #E5E5E5;
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
    </style>
</head>

<body class="bg-film-dark text-film-light">
    <!-- Fixed Navbar -->
    @include('partials.navbar')

    <!-- Content with Sidebar -->
    <div class="flex flex-row pt-16"> <!-- Add padding-top to account for navbar height -->
        <!-- Sidebar Component -->
        @include('partials.sidebar')

        @include('partials.footer')


        <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-20 hidden md:hidden"></div>
    </div>

    @include('partials.scripts')
</body>

</html>
