<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>FilmWave Admin</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    </head>
<body>
    <div class="flex h-screen overflow-hidden">
        <!-- Include Sidebar -->
        @include('admin.sidebar')


        <!-- Main Content -->
<div class="flex-1 overflow-auto bg-gray-100">
    <!-- Top Header -->
    <header class="bg-white shadow">
        <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
        </div>
    </header>

    <!-- Main Dashboard Content -->
    <main class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <!-- Stats Overview -->
        <div class="grid grid-cols-1 gap-5 mb-8 md:grid-cols-4">
            <!-- Stats Card 1 -->
            <div class="p-5 bg-white rounded-lg shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-sm font-medium text-gray-500">Total Movies</h2>
                        <p class="text-3xl font-bold text-gray-900">125</p>
                    </div>
                    <div class="p-3 bg-indigo-100 rounded-full">
                        <i class="text-2xl text-indigo-600 fas fa-film"></i>
                    </div>
                </div>
                <p class="mt-2 text-sm text-green-600">
                    <span class="font-medium">+12%</span> from last month
                </p>
            </div>

            <!-- Stats Card 2 -->
            <div class="p-5 bg-white rounded-lg shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-sm font-medium text-gray-500">Total Series</h2>
                        <p class="text-3xl font-bold text-gray-900">87</p>
                    </div>
                    <div class="p-3 bg-red-100 rounded-full">
                        <i class="text-2xl text-red-600 fas fa-tv"></i>
                    </div>
                </div>
                <p class="mt-2 text-sm text-green-600">
                    <span class="font-medium">+5%</span> from last month
                </p>
            </div>

            <!-- Stats Card 3 -->
            <div class="p-5 bg-white rounded-lg shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-sm font-medium text-gray-500">Total Users</h2>
                        <p class="text-3xl font-bold text-gray-900">3,521</p>
                    </div>
                    <div class="p-3 bg-yellow-100 rounded-full">
                        <i class="text-2xl text-yellow-600 fas fa-users"></i>
                    </div>
                </div>
                <p class="mt-2 text-sm text-green-600">
                    <span class="font-medium">+18%</span> from last month
                </p>
            </div>

            <!-- Stats Card 4 -->
            <div class="p-5 bg-white rounded-lg shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-sm font-medium text-gray-500">Reviews</h2>
                        <p class="text-3xl font-bold text-gray-900">1,243</p>
                    </div>
                    <div class="p-3 bg-green-100 rounded-full">
                        <i class="text-2xl text-green-600 fas fa-comments"></i>
                    </div>
                </div>
                <p class="mt-2 text-sm text-green-600">
                    <span class="font-medium">+7%</span> from last month
                </p>
            </div>
        </div>

        <!-- Recent Activity and Create Series Form -->
        <div class="grid grid-cols-1 gap-5 lg:grid-cols-3">
            <!-- Create Series Form -->
            <div class="p-6 bg-white rounded-lg shadow lg:col-span-2">
                <h2 class="mb-6 text-xl font-semibold text-gray-900">Create New Series</h2>
                <form action="{{ route('admin.series.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 gap-6 mb-6 md:grid-cols-2">
                        <!-- Series Title -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                            <input type="text" name="title" id="title" class="block w-full px-4 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Enter series title">
                        </div>

                        <!-- Release Year -->
                        <div>
                            <label for="release_year" class="block text-sm font-medium text-gray-700">Release Year</label>
                            <input type="number" name="release_year" id="release_year" class="block w-full px-4 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="2023" min="1900" max="2099">
                        </div>
                    </div>

                    <!-- Category -->
                    <div class="mb-6">
                        <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                        <select id="category" name="category" class="block w-full px-4 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="">Select a category</option>
                            <option value="action">Action</option>
                            <option value="adventure">Adventure</option>
                            <option value="comedy">Comedy</option>
                            <option value="drama">Drama</option>
                            <option value="fantasy">Fantasy</option>
                            <option value="horror">Horror</option>
                            <option value="mystery">Mystery</option>
                            <option value="romance">Romance</option>
                            <option value="sci-fi">Sci-Fi</option>
                            <option value="thriller">Thriller</option>
                        </select>
                    </div>

                    <!-- Tags -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tags</label>
                        <div class="flex flex-wrap gap-2">
                            <label class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-full text-sm cursor-pointer hover:bg-gray-50">
                                <input type="checkbox" name="tags[]" value="popular" class="h-4 w-4 text-indigo-600 mr-2">
                                Popular
                            </label>
                            <label class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-full text-sm cursor-pointer hover:bg-gray-50">
                                <input type="checkbox" name="tags[]" value="trending" class="h-4 w-4 text-indigo-600 mr-2">
                                Trending
                            </label>
                            <label class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-full text-sm cursor-pointer hover:bg-gray-50">
                                <input type="checkbox" name="tags[]" value="new" class="h-4 w-4 text-indigo-600 mr-2">
                                New Release
                            </label>
                            <label class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-full text-sm cursor-pointer hover:bg-gray-50">
                                <input type="checkbox" name="tags[]" value="award-winning" class="h-4 w-4 text-indigo-600 mr-2">
                                Award Winning
                            </label>
                            <label class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-full text-sm cursor-pointer hover:bg-gray-50">
                                <input type="checkbox" name="tags[]" value="classic" class="h-4 w-4 text-indigo-600 mr-2">
                                Classic
                            </label>
                            <label class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-full text-sm cursor-pointer hover:bg-gray-50">
                                <input type="checkbox" name="tags[]" value="family-friendly" class="h-4 w-4 text-indigo-600 mr-2">
                                Family Friendly
                            </label>
                            <label class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-full text-sm cursor-pointer hover:bg-gray-50">
                                <input type="checkbox" name="tags[]" value="mature" class="h-4 w-4 text-indigo-600 mr-2">
                                Mature
                            </label>
                        </div>
                        <p class="mt-2 text-xs text-gray-500">Select all tags that apply</p>
                    </div>

                    <!-- Actors -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Actors</label>
                        <div class="flex flex-wrap gap-2">
                            <label class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-full text-sm cursor-pointer hover:bg-gray-50">
                                <input type="checkbox" name="actors[]" value="tom-hanks" class="h-4 w-4 text-indigo-600 mr-2">
                                Tom Hanks
                            </label>
                            <label class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-full text-sm cursor-pointer hover:bg-gray-50">
                                <input type="checkbox" name="actors[]" value="scarlett-johansson" class="h-4 w-4 text-indigo-600 mr-2">
                                Scarlett Johansson
                            </label>
                            <label class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-full text-sm cursor-pointer hover:bg-gray-50">
                                <input type="checkbox" name="actors[]" value="robert-downey-jr" class="h-4 w-4 text-indigo-600 mr-2">
                                Robert Downey Jr.
                            </label>
                            <label class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-full text-sm cursor-pointer hover:bg-gray-50">
                                <input type="checkbox" name="actors[]" value="jennifer-lawrence" class="h-4 w-4 text-indigo-600 mr-2">
                                Jennifer Lawrence
                            </label>
                            <label class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-full text-sm cursor-pointer hover:bg-gray-50">
                                <input type="checkbox" name="actors[]" value="leonardo-dicaprio" class="h-4 w-4 text-indigo-600 mr-2">
                                Leonardo DiCaprio
                            </label>
                            <label class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-full text-sm cursor-pointer hover:bg-gray-50">
                                <input type="checkbox" name="actors[]" value="meryl-streep" class="h-4 w-4 text-indigo-600 mr-2">
                                Meryl Streep
                            </label>
                            <label class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-full text-sm cursor-pointer hover:bg-gray-50">
                                <input type="checkbox" name="actors[]" value="denzel-washington" class="h-4 w-4 text-indigo-600 mr-2">
                                Denzel Washington
                            </label>
                        </div>
                        <p class="mt-2 text-xs text-gray-500">Select all actors that appear in the series</p>
                    </div>

                    <!-- Description -->
                    <div class="mb-6">
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea id="description" name="description" rows="4" class="block w-full px-4 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Enter series description"></textarea>
                    </div>

                    <!-- Upload Areas -->
                    <div class="grid grid-cols-1 gap-6 mb-6 md:grid-cols-2">
                        <!-- MP4 File Upload -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Episodes</label>
                            <div id="episodes-container">
                                <!-- Initial Episode -->
                                <div class="episode-entry border rounded-md p-4 mb-4">
                                    <div class="grid grid-cols-2 gap-4 mb-3">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Episode Title</label>
                                            <input type="text" name="episodes[0][title]" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Episode Title">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Episode Number</label>
                                            <input type="number" name="episodes[0][number]" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="1" min="1">
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="block text-sm font-medium text-gray-700">Video File (MP4)</label>
                                        <div class="flex justify-center px-6 pt-5 pb-6 mt-1 border-2 border-gray-300 border-dashed rounded-md">
                                            <div class="space-y-1 text-center">
                                                <i class="mx-auto text-3xl text-gray-400 fas fa-file-video video-icon"></i>
                                                <div class="flex text-sm text-gray-600">
                                                    <label for="video-file-0" class="relative font-medium text-indigo-600 bg-white rounded-md cursor-pointer hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                                        <span>Upload video file</span>
                                                        <input id="video-file-0" name="episodes[0][video]" type="file" class="sr-only video-file" accept="video/mp4">
                                                    </label>
                                                    <p class="pl-1">or drag and drop</p>
                                                </div>
                                                <p class="video-file-name text-xs text-gray-500">MP4 up to 2GB</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <button type="button" id="add-episode" class="mt-2 px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                <i class="fas fa-plus mr-1"></i> Add Episode
                            </button>
                        </div>

                        <!-- Image Upload -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Cover Image</label>
                            <div class="flex justify-center px-6 pt-5 pb-6 mt-1 border-2 border-gray-300 border-dashed rounded-md">
                                <div class="space-y-1 text-center">
                                    <div id="cover-image-preview" class="hidden mx-auto mb-2">
                                        <img class="h-24 w-auto object-cover rounded" src="" alt="Preview">
                                    </div>
                                    <i id="cover-image-icon" class="mx-auto text-3xl text-gray-400 fas fa-image"></i>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="cover-image" class="relative font-medium text-indigo-600 bg-white rounded-md cursor-pointer hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                            <span>Upload image</span>
                                            <input id="cover-image" name="cover_image" type="file" class="sr-only" accept="image/*">
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p id="cover-image-name" class="text-xs text-gray-500">PNG, JPG, GIF up to 5MB</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end">
                        <button type="button" class="px-4 py-2 mr-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Create Series
                        </button>
                    </div>
                </form>
            </div>

            <!-- Recent Activity -->
            <div class="p-6 bg-white rounded-lg shadow">
                <h2 class="mb-4 text-xl font-semibold text-gray-900">Recent Activity</h2>
                <div class="space-y-4">
                    <!-- Activity Item 1 -->
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center w-8 h-8 text-white bg-indigo-600 rounded-full">
                                <i class="fas fa-plus text-xs"></i>
                            </div>
                        </div>
                        <div class="flex-1 ml-4">
                            <p class="text-sm font-medium text-gray-900">New series "Stranger Things Season 4" added</p>
                            <p class="text-sm text-gray-500">30 minutes ago</p>
                        </div>
                    </div>

                    <!-- Activity Item 2 -->
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center w-8 h-8 text-white bg-yellow-500 rounded-full">
                                <i class="fas fa-edit text-xs"></i>
                            </div>
                        </div>
                        <div class="flex-1 ml-4">
                            <p class="text-sm font-medium text-gray-900">Updated "Breaking Bad" description</p>
                            <p class="text-sm text-gray-500">2 hours ago</p>
                        </div>
                    </div>

                    <!-- Activity Item 3 -->
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center w-8 h-8 text-white bg-green-500 rounded-full">
                                <i class="fas fa-user text-xs"></i>
                            </div>
                        </div>
                        <div class="flex-1 ml-4">
                            <p class="text-sm font-medium text-gray-900">New user "john_doe" registered</p>
                            <p class="text-sm text-gray-500">5 hours ago</p>
                        </div>
                    </div>

                    <!-- Activity Item 4 -->
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center w-8 h-8 text-white bg-red-500 rounded-full">
                                <i class="fas fa-trash text-xs"></i>
                            </div>
                        </div>
                        <div class="flex-1 ml-4">
                            <p class="text-sm font-medium text-gray-900">Deleted "Game of Thrones" from series</p>
                            <p class="text-sm text-gray-500">1 day ago</p>
                        </div>
                    </div>

                    <!-- Activity Item 5 -->
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center w-8 h-8 text-white bg-purple-500 rounded-full">
                                <i class="fas fa-comment text-xs"></i>
                            </div>
                        </div>
                        <div class="flex-1 ml-4">
                            <p class="text-sm font-medium text-gray-900">New review on "The Witcher"</p>
                            <p class="text-sm text-gray-500">2 days ago</p>
                        </div>
                    </div>
                </div>
                <div class="mt-5 text-center">
                    <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">View all activity</a>
                </div>
            </div>
        </div>

        <!-- Recently Added Series -->
        <div class="mt-8">
            <h2 class="mb-4 text-xl font-semibold text-gray-900">Recently Added Series</h2>
            <div class="overflow-hidden bg-white shadow sm:rounded-md">
                <ul role="list" class="divide-y divide-gray-200">
                    <!-- Series Item 1 -->
                    <li>
                        <div class="flex items-center px-4 py-4 sm:px-6">
                            <div class="flex items-center flex-1 min-w-0">
                                <div class="flex-shrink-0">
                                    <img class="object-cover w-16 h-20 rounded" src="https://via.placeholder.com/150x200?text=Series+Cover" alt="Series cover">
                                </div>
                                <div class="flex-1 min-w-0 px-4">
                                    <div>
                                        <p class="text-sm font-medium text-indigo-600 truncate">The Witcher Season 2</p>
                                        <p class="mt-1 text-sm text-gray-500">
                                            <span class="mr-2">2021</span>
                                            <span class="px-2 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full">Fantasy</span>
                                            <span class="px-2 py-1 ml-1 text-xs font-medium text-blue-800 bg-blue-100 rounded-full">Adventure</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="flex space-x-2">
                                    <button type="button" class="p-2 text-gray-500 bg-white rounded-full hover:text-gray-700 focus:outline-none">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="p-2 text-gray-500 bg-white rounded-full hover:text-gray-700 focus:outline-none">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </li>

                    <!-- Series Item 2 -->
                    <li>
                        <div class="flex items-center px-4 py-4 sm:px-6">
                            <div class="flex items-center flex-1 min-w-0">
                                <div class="flex-shrink-0">
                                    <img class="object-cover w-16 h-20 rounded" src="https://via.placeholder.com/150x200?text=Series+Cover" alt="Series cover">
                                </div>
                                <div class="flex-1 min-w-0 px-4">
                                    <div>
                                        <p class="text-sm font-medium text-indigo-600 truncate">Squid Game</p>
                                        <p class="mt-1 text-sm text-gray-500">
                                            <span class="mr-2">2021</span>
                                            <span class="px-2 py-1 text-xs font-medium text-red-800 bg-red-100 rounded-full">Drama</span>
                                            <span class="px-2 py-1 ml-1 text-xs font-medium text-yellow-800 bg-yellow-100 rounded-full">Thriller</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="flex space-x-2">
                                    <button type="button" class="p-2 text-gray-500 bg-white rounded-full hover:text-gray-700 focus:outline-none">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="p-2 text-gray-500 bg-white rounded-full hover:text-gray-700 focus:outline-none">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </li>

                    <!-- Series Item 3 -->
                    <li>
                        <div class="flex items-center px-4 py-4 sm:px-6">
                            <div class="flex items-center flex-1 min-w-0">
                                <div class="flex-shrink-0">
                                    <img class="object-cover w-16 h-20 rounded" src="https://via.placeholder.com/150x200?text=Series+Cover" alt="Series cover">
                                </div>
                                <div class="flex-1 min-w-0 px-4">
                                    <div>
                                        <p class="text-sm font-medium text-indigo-600 truncate">Money Heist Final Season</p>
                                        <p class="mt-1 text-sm text-gray-500">
                                            <span class="mr-2">2021</span>
                                            <span class="px-2 py-1 text-xs font-medium text-purple-800 bg-purple-100 rounded-full">Crime</span>
                                            <span class="px-2 py-1 ml-1 text-xs font-medium text-indigo-800 bg-indigo-100 rounded-full">Thriller</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="flex space-x-2">
                                    <button type="button" class="p-2 text-gray-500 bg-white rounded-full hover:text-gray-700 focus:outline-none">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="p-2 text-gray-500 bg-white rounded-full hover:text-gray-700 focus:outline-none">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </main>
</div>

    </div>
</body>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const addButton = document.getElementById('add-episode');
        const container = document.getElementById('episodes-container');
        let episodeCount = 1;
        
        addButton.addEventListener('click', function() {
            const episodeTemplate = `
                <div class="episode-entry border rounded-md p-4 mb-4">
                    <div class="flex justify-between items-center mb-3">
                        <h3 class="font-medium">Episode ${episodeCount + 1}</h3>
                        <button type="button" class="remove-episode text-red-500 hover:text-red-700">
                            <i class="fas fa-times"></i> Remove
                        </button>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mb-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Episode Title</label>
                            <input type="text" name="episodes[${episodeCount}][title]" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Episode Title">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Episode Number</label>
                            <input type="number" name="episodes[${episodeCount}][number]" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="${episodeCount + 1}" min="1">
                        </div>
                    </div>
                        <div class="flex justify-center px-6 pt-5 pb-6 mt-1 border-2 border-gray-300 border-dashed rounded-md">
                            <div class="space-y-1 text-center">
                                <i class="mx-auto text-3xl text-gray-400 fas fa-file-video video-icon"></i>
                                <div class="flex text-sm text-gray-600">
                                    <label for="video-file-${episodeCount}" class="relative font-medium text-indigo-600 bg-white rounded-md cursor-pointer hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                        <span>Upload video file</span>
                                        <input id="video-file-${episodeCount}" name="episodes[${episodeCount}][video]" type="file" class="sr-only video-file" accept="video/mp4">
                                    <label for="video-file-${episodeCount}" class="relative font-medium text-indigo-600 bg-white rounded-md cursor-pointer hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                        <span>Upload video file</span>
                                        <input id="video-file-${episodeCount}" name="episodes[${episodeCount}][video]" type="file" class="sr-only" accept="video/mp4">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">MP4 up to 2GB</p>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = episodeTemplate;
            container.appendChild(tempDiv.firstElementChild);
            // Add event listeners to the remove buttons
            document.querySelectorAll('.remove-episode').forEach(button => {
                button.addEventListener('click', function() {
                    this.closest('.episode-entry').remove();
                });
            });
            
            // Add event listeners to the new video file input
            document.querySelectorAll('.episode-entry:last-child .video-file').forEach(input => {
                input.addEventListener('change', handleFileSelection);
            });
        });
        
        // Handle file selection for cover image
        document.getElementById('cover-image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const preview = document.getElementById('cover-image-preview');
                const previewImg = preview.querySelector('img');
                const icon = document.getElementById('cover-image-icon');
                const nameElement = document.getElementById('cover-image-name');
                
                // Show preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    preview.classList.remove('hidden');
                    icon.classList.add('hidden');
                };
                reader.readAsDataURL(file);
                
                // Show file name
                nameElement.textContent = file.name;
            }
        });
        
        // Handle file selection for video files
        function handleFileSelection(e) {
            const file = e.target.files[0];
            if (file) {
                const container = this.closest('.episode-entry');
                const nameElement = container.querySelector('.video-file-name');
                if (nameElement) {
                    nameElement.textContent = file.name;
                }
            }
        }
        
        // Add event listener to initial video file input
        document.querySelectorAll('.video-file').forEach(input => {
            input.addEventListener('change', handleFileSelection);
        });
    });
</script>
</html>