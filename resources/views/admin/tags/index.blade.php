<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FilmWave Admin - Tags</title>
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
                    <h1 class="text-3xl font-bold text-gray-900">Gestion des Tags</h1>
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
                
                <!-- Create button -->
                <div class="mb-6 flex justify-between items-center">
                    <h2 class="text-xl font-semibold text-gray-900">Liste des Tags</h2>
                    <a href="{{ route('admin.tags.create') }}" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <i class="fas fa-plus mr-1"></i> Ajouter un tag
                    </a>
                </div>

                <!-- Tags Table -->
                <div class="overflow-hidden bg-white shadow sm:rounded-md">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contenus associés</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($tags as $tag)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $tag->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $tag->name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $tag->contents_count ?? 0 }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('admin.tags.edit', $tag) }}" class="text-indigo-600 hover:text-indigo-900" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.tags.destroy', $tag) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" title="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce tag ?');">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                        Aucun tag trouvé
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $tags->links() }}
                </div>
            </main>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Message notification functions
            function showNotification(type, message) {
                const container = document.getElementById('notification-container');
                const notification = document.getElementById('notification');
                const notificationMessage = document.getElementById('notification-message');
                const notificationIcon = document.getElementById('notification-icon');
                
                // Set message
                notificationMessage.textContent = message;
                
                // Set notification type styles
                if (type === 'success') {
                    notification.classList.add('bg-green-50');
                    notificationMessage.classList.add('text-green-800');
                    notificationIcon.innerHTML = '<i class="fas fa-check-circle text-green-400 text-lg"></i>';
                } else if (type === 'error') {
                    notification.classList.add('bg-red-50');
                    notificationMessage.classList.add('text-red-800');
                    notificationIcon.innerHTML = '<i class="fas fa-exclamation-circle text-red-400 text-lg"></i>';
                }
                
                // Show notification
                container.classList.remove('hidden');
                
                // Auto hide after 3 seconds
                setTimeout(() => {
                    container.classList.add('hidden');
                    // Reset classes for future use
                    notification.classList.remove('bg-green-50', 'bg-red-50');
                    notificationMessage.classList.remove('text-green-800', 'text-red-800');
                }, 3000);
            }
            
            // Close notification manually
            document.getElementById('close-notification').addEventListener('click', function() {
                document.getElementById('notification-container').classList.add('hidden');
            });
            
            // Check for flash messages
            const successMessage = "{{ session('success') }}";
            const errorMessage = "{{ session('error') }}";
            
            if (successMessage) {
                showNotification('success', successMessage);
            } else if (errorMessage) {
                showNotification('error', errorMessage);
            }
        });
    </script>
</body>
</html> 