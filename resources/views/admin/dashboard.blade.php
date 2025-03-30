<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FilmWave Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="flex h-screen overflow-hidden">
        <!-- Include Sidebar -->
        @include('admin.sidebar')

        <!-- Main content -->
        <div class="flex flex-col flex-1 overflow-hidden">
            <!-- Top navigation -->
            <header class="bg-white shadow-sm">
                <div class="flex justify-between items-center px-6 py-3">
                    <button class="md:hidden">
                        <i class="fas fa-bars text-gray-500"></i>
                    </button>
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <i class="fas fa-bell text-gray-500"></i>
                            <span class="absolute top-0 right-0 h-2 w-2 rounded-full bg-red-500"></span>
                        </div>
                        <div class="flex items-center space-x-2">
                            @if(auth()->check())
                                <img class="h-8 w-8 rounded-full" src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}" alt="{{ auth()->user()->name }}">
                                <span class="text-gray-700">{{ auth()->user()->name }}</span>
                            @else
                                <span class="text-gray-700">Guest</span>
                            @endif
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main content area -->
            <main class="flex-1 overflow-y-auto p-6 bg-gray-100">
                <h1 class="text-2xl font-semibold text-gray-800 mb-6">Dashboard</h1>
                
                <!-- Stats cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-500 bg-opacity-10">
                                <i class="fas fa-film text-blue-500 text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-gray-500 text-sm">Total Movies</p>
                                <h3 class="text-xl font-bold text-gray-700">1,254</h3>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-500 bg-opacity-10">
                                <i class="fas fa-users text-green-500 text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-gray-500 text-sm">Total Users</p>
                                <h3 class="text-xl font-bold text-gray-700">12,845</h3>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-purple-500 bg-opacity-10">
                                <i class="fas fa-eye text-purple-500 text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-gray-500 text-sm">Total Views</p>
                                <h3 class="text-xl font-bold text-gray-700">45.2M</h3>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-yellow-500 bg-opacity-10">
                                <i class="fas fa-star text-yellow-500 text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-gray-500 text-sm">Avg. Rating</p>
                                <h3 class="text-xl font-bold text-gray-700">4.8</h3>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Recent uploads and Popular movies -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                    <!-- Recent uploads -->
                    <div class="bg-white rounded-lg shadow-md">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="font-bold text-gray-800">Recent Uploads</h2>
                        </div>
                        <div class="p-4">
                            <div class="overflow-x-auto">
                                <table class="min-w-full">
                                    <thead>
                                        <tr>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Movie</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        <tr>
                                            <td class="px-4 py-3">The Matrix Resurrections</td>
                                            <td class="px-4 py-3">Action</td>
                                            <td class="px-4 py-3">Today</td>
                                            <td class="px-4 py-3"><span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Active</span></td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3">Dune</td>
                                            <td class="px-4 py-3">Sci-Fi</td>
                                            <td class="px-4 py-3">Yesterday</td>
                                            <td class="px-4 py-3"><span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Active</span></td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3">No Time to Die</td>
                                            <td class="px-4 py-3">Action</td>
                                            <td class="px-4 py-3">2 days ago</td>
                                            <td class="px-4 py-3"><span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Pending</span></td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3">Black Widow</td>
                                            <td class="px-4 py-3">Action</td>
                                            <td class="px-4 py-3">3 days ago</td>
                                            <td class="px-4 py-3"><span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Active</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Popular movies -->
                    <div class="bg-white rounded-lg shadow-md">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="font-bold text-gray-800">Popular Movies</h2>
                        </div>
                        <div class="p-4">
                            <div class="space-y-4">
                                <div class="flex items-center p-2 hover:bg-gray-50 rounded-lg">
                                    <img src="https://via.placeholder.com/50" alt="Movie thumbnail" class="w-12 h-16 object-cover rounded">
                                    <div class="ml-4 flex-1">
                                        <h3 class="text-sm font-medium text-gray-900">Avengers: Endgame</h3>
                                        <p class="text-sm text-gray-500">Action, Adventure</p>
                                    </div>
                                    <div class="flex items-center text-sm text-gray-600">
                                        <i class="fas fa-eye mr-1"></i> 1.2M
                                    </div>
                                </div>
                                
                                <div class="flex items-center p-2 hover:bg-gray-50 rounded-lg">
                                    <img src="https://via.placeholder.com/50" alt="Movie thumbnail" class="w-12 h-16 object-cover rounded">
                                    <div class="ml-4 flex-1">
                                        <h3 class="text-sm font-medium text-gray-900">Joker</h3>
                                        <p class="text-sm text-gray-500">Crime, Drama</p>
                                    </div>
                                    <div class="flex items-center text-sm text-gray-600">
                                        <i class="fas fa-eye mr-1"></i> 980K
                                    </div>
                                </div>
                                
                                <div class="flex items-center p-2 hover:bg-gray-50 rounded-lg">
                                    <img src="https://via.placeholder.com/50" alt="Movie thumbnail" class="w-12 h-16 object-cover rounded">
                                    <div class="ml-4 flex-1">
                                        <h3 class="text-sm font-medium text-gray-900">Spider-Man: No Way Home</h3>
                                        <p class="text-sm text-gray-500">Action, Adventure</p>
                                    </div>
                                    <div class="flex items-center text-sm text-gray-600">
                                        <i class="fas fa-eye mr-1"></i> 850K
                                    </div>
                                </div>
                                
                                <div class="flex items-center p-2 hover:bg-gray-50 rounded-lg">
                                    <img src="https://via.placeholder.com/50" alt="Movie thumbnail" class="w-12 h-16 object-cover rounded">
                                    <div class="ml-4 flex-1">
                                        <h3 class="text-sm font-medium text-gray-900">The Batman</h3>
                                        <p class="text-sm text-gray-500">Action, Crime</p>
                                    </div>
                                    <div class="flex items-center text-sm text-gray-600">
                                        <i class="fas fa-eye mr-1"></i> 720K
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- User activity -->
                <div class="bg-white rounded-lg shadow-md mb-6">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="font-bold text-gray-800">Recent User Activity</h2>
                    </div>
                    <div class="p-4">
                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Activity</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Movie</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    <tr>
                                        <td class="px-4 py-3 flex items-center">
                                            <img class="h-8 w-8 rounded-full mr-2" src="https://ui-avatars.com/api/?name=John+Doe" alt="User">
                                            <span>John Doe</span>
                                        </td>
                                        <td class="px-4 py-3">Watched</td>
                                        <td class="px-4 py-3">Inception</td>
                                        <td class="px-4 py-3">2 hours ago</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-3 flex items-center">
                                            <img class="h-8 w-8 rounded-full mr-2" src="https://ui-avatars.com/api/?name=Sarah+Smith" alt="User">
                                            <span>Sarah Smith</span>
                                        </td>
                                        <td class="px-4 py-3">Reviewed</td>
                                        <td class="px-4 py-3">The Shawshank Redemption</td>
                                        <td class="px-4 py-3">3 hours ago</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-3 flex items-center">
                                            <img class="h-8 w-8 rounded-full mr-2" src="https://ui-avatars.com/api/?name=Mike+Johnson" alt="User">
                                            <span>Mike Johnson</span>
                                        </td>
                                        <td class="px-4 py-3">Subscribed</td>
                                        <td class="px-4 py-3">Premium Plan</td>
                                        <td class="px-4 py-3">5 hours ago</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-3 flex items-center">
                                            <img class="h-8 w-8 rounded-full mr-2" src="https://ui-avatars.com/api/?name=Emily+Williams" alt="User">
                                            <span>Emily Williams</span>
                                        </td>
                                        <td class="px-4 py-3">Added to Watchlist</td>
                                        <td class="px-4 py-3">The Godfather</td>
                                        <td class="px-4 py-3">6 hours ago</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        // You can add JavaScript for interactive features
    </script>
</body>
</html>