<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FilmWave Admin - Modifier une série</title>
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
                    <h1 class="text-3xl font-bold text-gray-900">Modifier une série</h1>
                </div>
            </header>

            <!-- Notification container -->
            <div id="notification-container" class="fixed top-4 right-4 z-50 hidden">
                <div id="notification" class="p-4 rounded-md shadow-lg max-w-md">
                    <div class="flex items-center">
                        <div id="notification-icon" class="flex-shrink-0 mr-3"></div>
                        <div class="flex-1">
                            <p id="notification-message" class="text-sm font-medium"></p>
                        </div>
                        <div class="ml-3">
                            <button type="button" id="close-notification" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                                <span class="sr-only">Close</span>
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <main class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- Breadcrumbs -->
                <div class="mb-6">
                    <nav class="flex" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 md:space-x-3">
                            <li class="inline-flex items-center">
                                <a href="{{ route('admin.series.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-indigo-600">
                                    <i class="mr-2 fas fa-tv"></i>
                                    Séries
                                </a>
                            </li>
                            <li>
                                <div class="flex items-center">
                                    <i class="text-gray-400 fas fa-chevron-right"></i>
                                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Modifier "{{ $series->content->title }}"</span>
                                </div>
                            </li>
                        </ol>
                    </nav>
                </div>

                <!-- Edit Series Form -->
                <div class="p-6 bg-white rounded-lg shadow">
                    <h2 class="mb-6 text-xl font-semibold text-gray-900">Modifier la série</h2>
                    
                    <!-- Display existing series image if available -->
                    @if($series->content->cover_image)
                    <div class="mb-6">
                        <p class="block text-sm font-medium text-gray-700 mb-2">Image de couverture actuelle</p>
                        <img src="{{ asset('storage/' . $series->content->cover_image) }}" alt="{{ $series->content->title }}" class="w-40 h-auto border rounded">
                    </div>
                    @endif

                    <form action="{{ route('admin.series.update', $series->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 gap-6 mb-6 md:grid-cols-2">
                            <!-- Series Title -->
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700">Titre</label>
                                <input type="text" name="title" id="title" class="block w-full px-4 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Entrez le titre de la série" value="{{ $series->content->title }}">
                            </div>

                            <!-- Release Year -->
                            <div>
                                <label for="release_year" class="block text-sm font-medium text-gray-700">Année de sortie</label>
                                <input type="number" name="release_year" id="release_year" class="block w-full px-4 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="2023" min="1900" max="2099" value="{{ $series->content->release_year }}">
                            </div>
                        </div>

                        <!-- Category -->
                        <div class="mb-6">
                            <label for="category" class="block text-sm font-medium text-gray-700">Catégorie</label>
                            <select id="category" name="category" class="block w-full px-4 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="">Sélectionner une catégorie</option>
                                <option value="action" {{ $selectedCategory && $selectedCategory->slug == 'action' ? 'selected' : '' }}>Action</option>
                                <option value="adventure" {{ $selectedCategory && $selectedCategory->slug == 'adventure' ? 'selected' : '' }}>Adventure</option>
                                <option value="comedy" {{ $selectedCategory && $selectedCategory->slug == 'comedy' ? 'selected' : '' }}>Comedy</option>
                                <option value="drama" {{ $selectedCategory && $selectedCategory->slug == 'drama' ? 'selected' : '' }}>Drama</option>
                                <option value="fantasy" {{ $selectedCategory && $selectedCategory->slug == 'fantasy' ? 'selected' : '' }}>Fantasy</option>
                                <option value="horror" {{ $selectedCategory && $selectedCategory->slug == 'horror' ? 'selected' : '' }}>Horror</option>
                                <option value="mystery" {{ $selectedCategory && $selectedCategory->slug == 'mystery' ? 'selected' : '' }}>Mystery</option>
                                <option value="romance" {{ $selectedCategory && $selectedCategory->slug == 'romance' ? 'selected' : '' }}>Romance</option>
                                <option value="sci-fi" {{ $selectedCategory && $selectedCategory->slug == 'sci-fi' ? 'selected' : '' }}>Sci-Fi</option>
                                <option value="thriller" {{ $selectedCategory && $selectedCategory->slug == 'thriller' ? 'selected' : '' }}>Thriller</option>
                            </select>
                        </div>

                        <!-- Tags -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tags</label>
                            <div class="flex flex-wrap gap-2">
                                <label class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-full text-sm cursor-pointer hover:bg-gray-50">
                                    <input type="checkbox" name="tags[]" value="popular" class="h-4 w-4 text-indigo-600 mr-2" {{ in_array('popular', $selectedTags) ? 'checked' : '' }}>
                                    Popular
                                </label>
                                <label class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-full text-sm cursor-pointer hover:bg-gray-50">
                                    <input type="checkbox" name="tags[]" value="trending" class="h-4 w-4 text-indigo-600 mr-2" {{ in_array('trending', $selectedTags) ? 'checked' : '' }}>
                                    Trending
                                </label>
                                <label class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-full text-sm cursor-pointer hover:bg-gray-50">
                                    <input type="checkbox" name="tags[]" value="new" class="h-4 w-4 text-indigo-600 mr-2" {{ in_array('new', $selectedTags) ? 'checked' : '' }}>
                                    New Release
                                </label>
                                <label class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-full text-sm cursor-pointer hover:bg-gray-50">
                                    <input type="checkbox" name="tags[]" value="award-winning" class="h-4 w-4 text-indigo-600 mr-2" {{ in_array('award-winning', $selectedTags) ? 'checked' : '' }}>
                                    Award Winning
                                </label>
                                <label class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-full text-sm cursor-pointer hover:bg-gray-50">
                                    <input type="checkbox" name="tags[]" value="classic" class="h-4 w-4 text-indigo-600 mr-2" {{ in_array('classic', $selectedTags) ? 'checked' : '' }}>
                                    Classic
                                </label>
                                <label class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-full text-sm cursor-pointer hover:bg-gray-50">
                                    <input type="checkbox" name="tags[]" value="family-friendly" class="h-4 w-4 text-indigo-600 mr-2" {{ in_array('family-friendly', $selectedTags) ? 'checked' : '' }}>
                                    Family Friendly
                                </label>
                                <label class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-full text-sm cursor-pointer hover:bg-gray-50">
                                    <input type="checkbox" name="tags[]" value="mature" class="h-4 w-4 text-indigo-600 mr-2" {{ in_array('mature', $selectedTags) ? 'checked' : '' }}>
                                    Mature
                                </label>
                            </div>
                            <p class="mt-2 text-xs text-gray-500">Sélectionnez tous les tags applicables</p>
                        </div>

                        <!-- Actors -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Acteurs</label>
                            <div class="flex flex-wrap gap-2">
                                <label class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-full text-sm cursor-pointer hover:bg-gray-50">
                                    <input type="checkbox" name="actors[]" value="tom-hanks" class="h-4 w-4 text-indigo-600 mr-2" {{ in_array('tom-hanks', $selectedActors) ? 'checked' : '' }}>
                                    Tom Hanks
                                </label>
                                <label class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-full text-sm cursor-pointer hover:bg-gray-50">
                                    <input type="checkbox" name="actors[]" value="scarlett-johansson" class="h-4 w-4 text-indigo-600 mr-2" {{ in_array('scarlett-johansson', $selectedActors) ? 'checked' : '' }}>
                                    Scarlett Johansson
                                </label>
                                <label class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-full text-sm cursor-pointer hover:bg-gray-50">
                                    <input type="checkbox" name="actors[]" value="robert-downey-jr" class="h-4 w-4 text-indigo-600 mr-2" {{ in_array('robert-downey-jr', $selectedActors) ? 'checked' : '' }}>
                                    Robert Downey Jr.
                                </label>
                                <label class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-full text-sm cursor-pointer hover:bg-gray-50">
                                    <input type="checkbox" name="actors[]" value="jennifer-lawrence" class="h-4 w-4 text-indigo-600 mr-2" {{ in_array('jennifer-lawrence', $selectedActors) ? 'checked' : '' }}>
                                    Jennifer Lawrence
                                </label>
                                <label class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-full text-sm cursor-pointer hover:bg-gray-50">
                                    <input type="checkbox" name="actors[]" value="leonardo-dicaprio" class="h-4 w-4 text-indigo-600 mr-2" {{ in_array('leonardo-dicaprio', $selectedActors) ? 'checked' : '' }}>
                                    Leonardo DiCaprio
                                </label>
                                <label class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-full text-sm cursor-pointer hover:bg-gray-50">
                                    <input type="checkbox" name="actors[]" value="meryl-streep" class="h-4 w-4 text-indigo-600 mr-2" {{ in_array('meryl-streep', $selectedActors) ? 'checked' : '' }}>
                                    Meryl Streep
                                </label>
                                <label class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-full text-sm cursor-pointer hover:bg-gray-50">
                                    <input type="checkbox" name="actors[]" value="denzel-washington" class="h-4 w-4 text-indigo-600 mr-2" {{ in_array('denzel-washington', $selectedActors) ? 'checked' : '' }}>
                                    Denzel Washington
                                </label>
                            </div>
                            <p class="mt-2 text-xs text-gray-500">Sélectionnez tous les acteurs qui apparaissent dans la série</p>
                        </div>

                        <!-- Description -->
                        <div class="mb-6">
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea id="description" name="description" rows="4" class="block w-full px-4 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Entrez la description de la série">{{ $series->content->description }}</textarea>
                        </div>

                        <!-- Upload Cover Image -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nouvelle image de couverture (optionnel)</label>
                            <div class="flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                <div class="space-y-1 text-center">
                                    <svg class="w-12 h-12 mx-auto text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4h-12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="cover_image" class="relative font-medium text-indigo-600 bg-white rounded-md cursor-pointer hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                            <span>Téléverser un fichier</span>
                                            <input id="cover_image" name="cover_image" type="file" class="sr-only" accept="image/*">
                                        </label>
                                        <p class="pl-1">ou glisser-déposer</p>
                                    </div>
                                    <p class="text-xs text-gray-500">
                                        PNG, JPG, GIF jusqu'à 50MB
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Episodes -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Épisodes</label>
                            <div id="episodes-container">
                                @foreach($series->episodes as $index => $episode)
                                <div class="episode-entry border rounded-md p-4 mb-4">
                                    <div class="grid grid-cols-2 gap-4 mb-3">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Titre de l'épisode</label>
                                            <input type="text" name="episodes[{{ $index }}][title]" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Titre de l'épisode" value="{{ $episode->title }}">
                                            <input type="hidden" name="episodes[{{ $index }}][id]" value="{{ $episode->id }}">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Numéro d'épisode</label>
                                            <input type="number" name="episodes[{{ $index }}][number]" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ $episode->episode_number }}" min="1">
                                        </div>
                                    </div>
                                    
                                    <!-- Sélection de série pour l'épisode -->
                                    <div class="mb-3">
                                        <label class="block text-sm font-medium text-gray-700">Série d'appartenance</label>
                                        <select name="episodes[{{ $index }}][series_id]" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                            <option value="">-- Aucune série --</option>
                                            @foreach($allSeries as $seriesOption)
                                                <option value="{{ $seriesOption->id }}" {{ $episode->series_id == $seriesOption->id ? 'selected' : '' }}>
                                                    {{ $seriesOption->content->title ?? 'Série #'.$seriesOption->id }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if(!$episode->series_id)
                                            <p class="mt-1 text-xs text-red-500">Cet épisode n'appartient actuellement à aucune série</p>
                                        @endif
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="block text-sm font-medium text-gray-700">Vidéo actuelle</label>
                                        <div class="mt-1 bg-gray-100 p-2 rounded text-sm">
                                            {{ $episode->file_path ? basename($episode->file_path) : 'Aucun fichier' }}
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="block text-sm font-medium text-gray-700">Nouvelle vidéo (optionnel)</label>
                                        <input type="file" name="episodes[{{ $index }}][video]" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" accept="video/mp4">
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            
                            <button type="button" id="add-episode" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <i class="mr-2 fas fa-plus"></i> Ajouter un épisode
                            </button>
                        </div>

                        <!-- Buttons -->
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('admin.series.index') }}" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Annuler
                            </a>
                            <button type="submit" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Mettre à jour la série
                            </button>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>

    <script>
        // Gestion des notifications
        function showNotification(message, type) {
            const container = document.getElementById('notification-container');
            const notification = document.getElementById('notification');
            const notificationMessage = document.getElementById('notification-message');
            const notificationIcon = document.getElementById('notification-icon');
            
            // Définir le message
            notificationMessage.textContent = message;
            
            // Définir le style basé sur le type
            if (type === 'success') {
                notification.className = 'p-4 bg-green-50 rounded-md shadow-lg max-w-md';
                notificationMessage.className = 'text-sm font-medium text-green-800';
                notificationIcon.innerHTML = '<i class="fas fa-check-circle text-green-400 text-xl"></i>';
            } else if (type === 'error') {
                notification.className = 'p-4 bg-red-50 rounded-md shadow-lg max-w-md';
                notificationMessage.className = 'text-sm font-medium text-red-800';
                notificationIcon.innerHTML = '<i class="fas fa-exclamation-circle text-red-400 text-xl"></i>';
            }
            
            // Afficher la notification
            container.classList.remove('hidden');
            
            // Masquer après 5 secondes
            setTimeout(() => {
                container.classList.add('hidden');
            }, 5000);
        }
        
        // Gérer le bouton de fermeture
        document.getElementById('close-notification').addEventListener('click', () => {
            document.getElementById('notification-container').classList.add('hidden');
        });
        
        // Afficher les notifications de session s'il y en a
        @if(session('success'))
            showNotification("{{ session('success') }}", 'success');
        @endif
        
        @if(session('error'))
            showNotification("{{ session('error') }}", 'error');
        @endif
        
        // Gestion de l'ajout dynamique d'épisodes
        document.getElementById('add-episode').addEventListener('click', function() {
            const episodesContainer = document.getElementById('episodes-container');
            const episodeCount = episodesContainer.querySelectorAll('.episode-entry').length;
            
            const newEpisode = document.createElement('div');
            newEpisode.className = 'episode-entry border rounded-md p-4 mb-4';
            newEpisode.innerHTML = `
                <div class="grid grid-cols-2 gap-4 mb-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Titre de l'épisode</label>
                        <input type="text" name="episodes[${episodeCount}][title]" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Titre de l'épisode">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Numéro d'épisode</label>
                        <input type="number" name="episodes[${episodeCount}][number]" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="${episodeCount + 1}" min="1">
                    </div>
                </div>
                
                <!-- Sélection de série pour le nouvel épisode -->
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700">Série d'appartenance</label>
                    <select name="episodes[${episodeCount}][series_id]" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="">-- Aucune série --</option>
                        @foreach($allSeries as $seriesOption)
                            <option value="{{ $seriesOption->id }}" {{ $series->id == $seriesOption->id ? 'selected' : '' }}>
                                {{ $seriesOption->content->title ?? 'Série #'.$seriesOption->id }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700">Fichier vidéo (MP4)</label>
                    <input type="file" name="episodes[${episodeCount}][video]" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" accept="video/mp4">
                </div>
                
                <button type="button" class="remove-episode text-sm text-red-600 hover:text-red-900">
                    <i class="fas fa-trash mr-1"></i> Supprimer cet épisode
                </button>
            `;
            
            episodesContainer.appendChild(newEpisode);
            
            // Ajouter un événement de suppression pour le nouvel épisode
            newEpisode.querySelector('.remove-episode').addEventListener('click', function() {
                episodesContainer.removeChild(newEpisode);
            });
        });
        
        // Ajouter des événements de suppression pour les épisodes existants
        document.querySelectorAll('.remove-episode').forEach(button => {
            button.addEventListener('click', function() {
                const episodeEntry = this.closest('.episode-entry');
                episodeEntry.parentNode.removeChild(episodeEntry);
            });
        });
    </script>
</body>
</html> 