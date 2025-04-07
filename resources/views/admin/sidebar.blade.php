<!-- Sidebar -->
<div class="hidden md:flex md:flex-shrink-0">
    <div class="flex flex-col w-64 bg-gray-900">
        <div class="flex items-center justify-center h-16 px-4 bg-gray-800">
            <h1 class="text-xl font-bold text-white">FilmWave Admin</h1>
        </div>
        <div class="flex flex-col flex-1 overflow-y-auto">
            <nav class="flex-1 px-2 py-4 space-y-1">
                <a href="#" class="flex items-center px-4 py-2 text-sm font-medium text-white bg-gray-700 rounded-md">
                    <i class="fas fa-home mr-3"></i>
                    Dashboard
                </a>
                <a href="#" class="flex items-center px-4 py-2 text-sm font-medium text-gray-300 rounded-md hover:bg-gray-700 hover:text-white">
                    <i class="fas fa-film mr-3"></i>
                    Movies
                </a>
                <a href="#" class="flex items-center px-4 py-2 text-sm font-medium text-gray-300 rounded-md hover:bg-gray-700 hover:text-white">
                    <i class="fas fa-tv mr-3"></i>
                    TV Shows
                </a>
                <a href="#" class="flex items-center px-4 py-2 text-sm font-medium text-gray-300 rounded-md hover:bg-gray-700 hover:text-white">
                    <i class="fas fa-users mr-3"></i>
                    Users
                </a>
                <a href="{{ route('admin.tags.index') }}" class="flex items-center px-4 py-2 text-sm font-medium text-gray-300 rounded-md hover:bg-gray-700 hover:text-white">
                    <i class="fas fa-tags mr-3"></i>
                    Tags
                </a>
                <a href="#" class="flex items-center px-4 py-2 text-sm font-medium text-gray-300 rounded-md hover:bg-gray-700 hover:text-white">
                    <i class="fas fa-comments mr-3"></i>
                    Reviews
                </a>
                <a href="{{ route('logout') }}" class="flex items-center px-4 py-2 text-sm font-medium text-gray-300 rounded-md hover:bg-gray-700 hover:text-white"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt mr-3"></i>
                    Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </nav>
        </div>
    </div>
</div>