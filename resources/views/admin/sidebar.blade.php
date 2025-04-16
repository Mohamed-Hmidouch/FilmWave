<!-- Sidebar -->
<div class="hidden md:flex md:flex-shrink-0">
    <div class="flex flex-col w-64 bg-gray-900">
        <div class="flex items-center justify-center h-16 px-4 bg-gray-800">
            <h1 class="text-xl font-bold text-white">FilmWave Admin</h1>
        </div>
        <div class="flex flex-col flex-1 overflow-y-auto">
            <nav class="flex-1 px-2 py-4 space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 text-sm font-medium text-white rounded-md {{ Request::routeIs('admin.dashboard') ? 'bg-gray-700' : '' }}">
                    <i class="fas fa-tachometer-alt mr-3"></i>
                    Dashboard
                </a>
                <a href="{{ route('admin.series.index') }}" class="flex items-center px-4 py-2 text-sm font-medium text-gray-300 rounded-md hover:bg-gray-700 hover:text-white {{ Request::routeIs('admin.series.*') ? 'bg-gray-700' : '' }}">
                    <i class="fas fa-film mr-3"></i>
                    Series
                </a>
                <a href="{{ route('admin.tags.index') }}" class="flex items-center px-4 py-2 text-sm font-medium text-gray-300 rounded-md hover:bg-gray-700 hover:text-white {{ Request::routeIs('admin.tags.*') ? 'bg-gray-700' : '' }}">
                    <i class="fas fa-tags mr-3"></i>
                    Tags
                </a>
                <a href="{{ route('admin.categories.index') }}" class="flex items-center px-4 py-2 text-sm font-medium text-gray-300 rounded-md hover:bg-gray-700 hover:text-white {{ Request::routeIs('admin.categories.*') ? 'bg-gray-700' : '' }}">
                    <i class="fas fa-folder mr-3"></i>
                    Categories
                </a>
                <a href="#" class="flex items-center px-4 py-2 text-sm font-medium text-gray-300 rounded-md hover:bg-gray-700 hover:text-white">
                    <i class="fas fa-users mr-3"></i>
                    Users
                </a>
                <a href="#" class="flex items-center px-4 py-2 text-sm font-medium text-gray-300 rounded-md hover:bg-gray-700 hover:text-white">
                    <i class="fas fa-comments mr-3"></i>
                    Reviews
                </a>
                <button type="button" onclick="document.getElementById('logout-form').submit();" class="flex items-center px-4 py-2 text-sm font-medium text-gray-300 rounded-md hover:bg-gray-700 hover:text-white w-full text-left">
                    <i class="fas fa-sign-out-alt mr-3"></i>
                    Logout
                </button>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </nav>
        </div>
    </div>
</div>