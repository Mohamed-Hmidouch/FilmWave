<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FilmWave Admin - Créer un Tag</title>
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
                    <div class="flex items-center">
                        <a href="{{ route('admin.tags.index') }}" class="mr-2 text-gray-500 hover:text-gray-700">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                        <h1 class="text-3xl font-bold text-gray-900">Créer un Tag</h1>
                    </div>
                </div>
            </header>

            <!-- Main Content -->
            <main class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="p-6 bg-white rounded-lg shadow">
                    <form action="{{ route('admin.tags.store') }}" method="POST">
                        @csrf
                        
                        <!-- Afficher les erreurs -->
                        @if ($errors->any())
                            <div class="p-4 mb-6 text-red-700 bg-red-100 rounded-md">
                                <ul class="list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        
                        <!-- Tag Name -->
                        <div class="mb-6">
                            <label for="name" class="block text-sm font-medium text-gray-700">Nom du tag</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" class="block w-full px-4 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                            <p class="mt-1 text-xs text-gray-500">Le nom doit être unique et ne pas dépasser 50 caractères.</p>
                        </div>
                        
                        <div class="flex items-center justify-end">
                            <a href="{{ route('admin.tags.index') }}" class="px-4 py-2 mr-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Annuler
                            </a>
                            <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Créer le tag
                            </button>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>
</body>
</html> 