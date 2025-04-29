<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comment Management - FilmWave Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
                },
            },
        }
    </script>
    <!-- CSRF Token for AJAX requests -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Audio for alert sound -->
    <audio id="alertSound" src="https://www.soundjay.com/buttons/sounds/button-4.mp3" preload="auto"></audio>
</head>
<body class="bg-white text-gray-800 min-h-screen flex">
    <!-- Include the admin sidebar -->
    @include('admin.sidebar')

    <!-- Main Content -->
    <main class="flex-1 ml-0 transition-all duration-300">
        <!-- Top Navigation Bar -->
        <nav class="bg-white border-b border-gray-200 py-4 px-6 flex items-center justify-between">
            <div class="flex items-center">
                <h1 class="text-xl font-bold">Comment Management</h1>
            </div>
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <button class="text-gray-600 hover:text-gray-800">
                        <i class="fas fa-bell"></i>
                        <span class="absolute -top-1 -right-1 bg-film-red text-white text-xs w-4 h-4 flex items-center justify-center rounded-full">3</span>
                    </button>
                </div>
                <div class="flex items-center space-x-2">
                    <div class="w-8 h-8 rounded-full bg-film-red flex items-center justify-center text-white font-bold">
                        A
                    </div>
                    <span class="text-sm font-medium">Admin</span>
                </div>
            </div>
        </nav>

        <!-- Content Area -->
        <div class="p-6">
            <!-- Page Header -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                <div>
                    <h2 class="text-2xl font-bold">Comments</h2>
                    <p class="text-gray-500">Manage user comments across the platform</p>
                </div>
                <div class="mt-4 md:mt-0 flex flex-col sm:flex-row gap-3">
                    <div class="relative">
                        <input 
                            type="text" 
                            id="searchInput"
                            placeholder="Search comments..." 
                            class="bg-gray-100 text-gray-800 rounded-lg py-2 px-4 pr-10 w-full focus:outline-none focus:ring-2 focus:ring-film-red"
                        >
                        <i class="fas fa-search absolute right-3 top-3 text-gray-400"></i>
                    </div>
                    <select id="filterSelect" class="bg-gray-100 text-gray-800 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-film-red">
                        <option value="all">All Comments</option>
                        <option value="flagged">Flagged</option>
                        <option value="recent">Recent</option>
                    </select>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white rounded-lg p-6 shadow-md border border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">Total Comments</p>
                            <h3 class="text-2xl font-bold mt-1">1,254</h3>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center text-blue-500">
                            <i class="fas fa-comments text-xl"></i>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm">
                        <span class="text-green-500 flex items-center">
                            <i class="fas fa-arrow-up mr-1"></i> 12%
                        </span>
                        <span class="text-gray-500 ml-2">from last month</span>
                    </div>
                </div>

                <div class="bg-white rounded-lg p-6 shadow-md border border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">Flagged Comments</p>
                            <h3 class="text-2xl font-bold mt-1">24</h3>
                        </div>
                        <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center text-yellow-500">
                            <i class="fas fa-flag text-xl"></i>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm">
                        <span class="text-red-500 flex items-center">
                            <i class="fas fa-arrow-up mr-1"></i> 8%
                        </span>
                        <span class="text-gray-500 ml-2">from last month</span>
                    </div>
                </div>

                <div class="bg-white rounded-lg p-6 shadow-md border border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">Deleted Comments</p>
                            <h3 class="text-2xl font-bold mt-1">85</h3>
                        </div>
                        <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center text-red-500">
                            <i class="fas fa-trash-alt text-xl"></i>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm">
                        <span class="text-green-500 flex items-center">
                            <i class="fas fa-arrow-down mr-1"></i> 5%
                        </span>
                        <span class="text-gray-500 ml-2">from last month</span>
                    </div>
                </div>
            </div>

            <!-- Comments List -->
            <div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
                <div class="p-4 bg-gray-50 border-b border-gray-200 flex items-center justify-between">
                    <h3 class="font-bold">Recent Comments</h3>
                    <div class="flex items-center space-x-2 text-sm">
                        <span class="text-gray-500">Showing</span>
                        <select class="bg-white text-gray-800 rounded px-2 py-1 focus:outline-none focus:ring-1 focus:ring-film-red border border-gray-200">
                            <option>10</option>
                            <option>25</option>
                            <option>50</option>
                        </select>
                        <span class="text-gray-500">per page</span>
                    </div>
                </div>

                <div id="comments-container" class="divide-y divide-gray-200">
                    <!-- Comments will be loaded from the backend -->
                    @foreach ($comments as $comment)
                    <div class="p-4 hover:bg-gray-50 transition-colors">
                        <div class="flex items-start">
                            <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 font-medium flex-shrink-0">
                                {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                            </div>
                            <div class="ml-4 flex-grow">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                                    <div>
                                        <h4 class="font-medium">{{ $comment->user->name }}</h4>
                                        <div class="flex items-center text-sm text-gray-500">
                                            <span class="mr-2">User ID: {{ $comment->user->id }}</span>
                                            <span class="mr-2">•</span>
                                            <span>{{ $comment->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                </div>
                                <p class="mt-2 text-gray-700">{{ $comment->body }}</p>
                                <div class="mt-2 text-xs text-gray-500">
                                    <span>Content: {{ $comment->content->title }}</span>
                                </div>
                                <div class="mt-3 flex items-center flex-wrap gap-2">
                                    <button 
                                        class="delete-comment-btn inline-flex items-center px-2 py-1 bg-red-500 hover:bg-red-600 text-white text-xs rounded"
                                        data-comment-id="{{ $comment->id }}"
                                    >
                                        <i class="fas fa-trash-alt mr-1"></i> Delete
                                    </button>
                                    <button 
                                        class="ban-user-btn inline-flex items-center px-2 py-1 bg-gray-500 hover:bg-gray-600 text-white text-xs rounded"
                                        data-user-id="{{ $comment->user->id }}"
                                    >
                                        <i class="fas fa-user-slash mr-1"></i> Ban User
                                    </button>
                                    <a href="#" class="inline-flex items-center px-2 py-1 bg-yellow-500 hover:bg-yellow-600 text-white text-xs rounded">
                                        <i class="fas fa-exclamation-triangle mr-1"></i> Alert
                                    </a>
                                    <a href="#" class="inline-flex items-center px-2 py-1 bg-blue-500 hover:bg-blue-600 text-white text-xs rounded">
                                        <i class="fas fa-reply mr-1"></i> Reply
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="p-4 bg-gray-50 border-t border-gray-200 flex flex-col sm:flex-row items-center justify-between">
                    <div class="text-sm text-gray-500 mb-4 sm:mb-0">
                        Showing <span class="font-medium">1</span> to <span class="font-medium">10</span> of <span class="font-medium">1,254</span> results
                    </div>
                    <div class="flex items-center space-x-2">
                        <button class="px-3 py-1 rounded bg-gray-200 text-gray-600 hover:bg-film-red hover:text-white transition-colors">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button class="px-3 py-1 rounded bg-film-red text-white">1</button>
                        <button class="px-3 py-1 rounded bg-gray-200 text-gray-600 hover:bg-film-red hover:text-white transition-colors">2</button>
                        <button class="px-3 py-1 rounded bg-gray-200 text-gray-600 hover:bg-film-red hover:text-white transition-colors">3</button>
                        <button class="px-3 py-1 rounded bg-gray-200 text-gray-600 hover:bg-film-red hover:text-white transition-colors">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Fixed Notification Toast -->
    <div id="notification" class="fixed top-4 right-4 bg-white px-4 py-3 rounded-lg shadow-lg border border-gray-200 transform transition-transform duration-300 translate-x-full flex items-center z-50" style="max-width: 300px;">
        <div id="notification-icon" class="mr-3 flex-shrink-0">
            <i class="fas fa-check-circle text-green-500 text-xl"></i>
        </div>
        <div class="flex-grow">
            <h4 id="notification-title" class="font-medium text-gray-800">Success</h4>
            <p id="notification-message" class="text-sm text-gray-600">Operation completed successfully.</p>
        </div>
        <button onclick="hideNotification()" class="ml-2 text-gray-400 hover:text-gray-600 focus:outline-none">
            <i class="fas fa-times"></i>
        </button>
    </div>
    
    <!-- Custom Alert Modal -->
    <div id="customAlert" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-xl p-6 max-w-md mx-4 transform transition-all scale-95 opacity-0" id="alertBox">
            <div class="flex items-center mb-4">
                <div class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center mr-4">
                    <i class="fas fa-exclamation-triangle text-yellow-500"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900">User Alert</h3>
            </div>
            <p id="alertMessage" class="text-gray-500 mb-5">A warning notification has been sent to the user about their content.</p>
            <div class="flex justify-end">
                <button type="button" id="closeAlert" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded text-gray-800 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    Close
                </button>
            </div>
        </div>
    </div>

    <script>
        // Notification system
        function showNotification(type, title, message) {
            const notification = document.getElementById('notification');
            const iconElement = document.getElementById('notification-icon');
            const titleElement = document.getElementById('notification-title');
            const messageElement = document.getElementById('notification-message');
            
            // Set content
            titleElement.textContent = title;
            messageElement.textContent = message;
            
            // Set icon based on type
            let iconHTML = '';
            if (type === 'success') {
                iconHTML = '<i class="fas fa-check-circle text-green-500 text-xl"></i>';
            } else if (type === 'error') {
                iconHTML = '<i class="fas fa-times-circle text-red-500 text-xl"></i>';
            } else if (type === 'warning') {
                iconHTML = '<i class="fas fa-exclamation-triangle text-yellow-500 text-xl"></i>';
            } else if (type === 'info') {
                iconHTML = '<i class="fas fa-info-circle text-blue-500 text-xl"></i>';
            }
            iconElement.innerHTML = iconHTML;
            
            // Show notification
            notification.classList.remove('translate-x-full');
            
            // Hide after 3 seconds
            setTimeout(() => {
                hideNotification();
            }, 3000);
        }
        
        function hideNotification() {
            const notification = document.getElementById('notification');
            notification.classList.add('translate-x-full');
        }

        // Custom alert functionality
        function showCustomAlert(message) {
            const customAlert = document.getElementById('customAlert');
            const alertBox = document.getElementById('alertBox');
            const alertMessage = document.getElementById('alertMessage');
            
            // Set message
            alertMessage.textContent = message;
            
            // Show alert
            customAlert.classList.remove('hidden');
            
            // Animate in
            setTimeout(() => {
                alertBox.classList.remove('scale-95', 'opacity-0');
                alertBox.classList.add('scale-100', 'opacity-100');
            }, 10);
            
            // Setup close button
            document.getElementById('closeAlert').onclick = function() {
                // Animate out
                alertBox.classList.remove('scale-100', 'opacity-100');
                alertBox.classList.add('scale-95', 'opacity-0');
                
                // Hide after animation
                setTimeout(() => {
                    customAlert.classList.add('hidden');
                }, 300);
            };
        }
        
        // Add event listeners to action buttons
        document.addEventListener('DOMContentLoaded', function() {
            // Setup CSRF token for all AJAX requests
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            // Delete comment functionality
            const deleteButtons = document.querySelectorAll('.delete-comment-btn');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (confirm('Are you sure you want to delete this comment?')) {
                        const commentId = this.getAttribute('data-comment-id');
                        const commentCard = this.closest('.p-4');
                        
                        fetch(`/admin/comments/${commentId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            // Remove the comment from the UI
                            commentCard.remove();
                            showNotification('success', 'Comment Deleted', 'Comment has been permanently removed.');
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showNotification('error', 'Error', 'Failed to delete comment. Please try again.');
                        });
                    }
                });
            });
            
            // Ban user functionality (deletes user and all their comments)
            const banButtons = document.querySelectorAll('.ban-user-btn');
            banButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (confirm('Are you sure you want to ban this user? This will delete the user and ALL their comments.')) {
                        const userId = this.getAttribute('data-user-id');
                        
                        fetch(`/admin/users/${userId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            // Remove all comments by this user from the UI
                            document.querySelectorAll(`.ban-user-btn[data-user-id="${userId}"]`).forEach(btn => {
                                const commentCard = btn.closest('.p-4');
                                if (commentCard) {
                                    commentCard.remove();
                                }
                            });
                            showNotification('success', 'User Banned', 'User and all their comments have been removed.');
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showNotification('error', 'Error', 'Failed to ban user. Please try again.');
                        });
                    }
                });
            });
            
            const alertButtons = document.querySelectorAll('a:has(.fa-exclamation-triangle)');
            alertButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    showCustomAlert('A warning notification has been sent to the user about their inappropriate content.');
                });
            });
            
            // Fallback for browsers that don't support :has
            document.querySelectorAll('.inline-flex').forEach(button => {
                if (button.classList.contains('delete-comment-btn') || button.classList.contains('ban-user-btn')) {
                    return; // Skip buttons we've already handled
                }
                
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (button.innerHTML.includes('exclamation')) {
                        showCustomAlert('A warning notification has been sent to the user about their inappropriate content.');
                    } else if (button.innerHTML.includes('reply')) {
                        showNotification('info', 'Reply Mode', 'You can now write a reply to this comment.');
                    }
                });
            });
        });
    </script>
</body>
</html>
