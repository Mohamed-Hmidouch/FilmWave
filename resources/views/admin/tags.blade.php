<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tags Management - FilmWave Admin</title>
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
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-semibold text-gray-800">Tags Management</h1>
                    <button id="add-new-tag" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md flex items-center">
                        <i class="fas fa-plus mr-2"></i> Add New Tag
                    </button>
                </div>

                <!-- Add Tag Form (Hidden by default) -->
                <div id="tag-form-container" class="bg-white rounded-lg shadow-md p-6 mb-6 hidden">
                    <h2 class="text-lg font-medium text-gray-700 mb-4">Add New Tag</h2>
                    <form id="tag-form">
                        <div class="mb-4">
                            <label for="tag-name" class="block text-sm font-medium text-gray-700 mb-1">Tag Name</label>
                            <input type="text" id="tag-name" name="name" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <div id="tag-error" class="text-red-500 text-sm mt-1 hidden"></div>
                        </div>
                        <div class="flex justify-end space-x-3">
                            <button type="button" id="cancel-tag" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none">
                                Cancel
                            </button>
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none">
                                Save Tag
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Tags List -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                        <h2 class="font-bold text-gray-800">All Tags</h2>
                        <div class="relative">
                            <input type="text" id="search-tags" placeholder="Search tags..." class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <i class="fas fa-search absolute right-3 top-3 text-gray-400"></i>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Associated Movies</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created At</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200" id="tags-container">
                                <!-- Tag rows will be populated here -->
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">1</td>
                                    <td class="px-6 py-4 whitespace-nowrap">Action</td>
                                    <td class="px-6 py-4 whitespace-nowrap">42</td>
                                    <td class="px-6 py-4 whitespace-nowrap">Mar 15, 2025</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <button class="text-blue-500 hover:text-blue-700 mr-3 edit-tag-btn" data-id="1">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <button class="text-red-500 hover:text-red-700 delete-tag-btn" data-id="1">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">2</td>
                                    <td class="px-6 py-4 whitespace-nowrap">Drama</td>
                                    <td class="px-6 py-4 whitespace-nowrap">38</td>
                                    <td class="px-6 py-4 whitespace-nowrap">Mar 12, 2025</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <button class="text-blue-500 hover:text-blue-700 mr-3 edit-tag-btn" data-id="2">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <button class="text-red-500 hover:text-red-700 delete-tag-btn" data-id="2">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- Pagination -->
                    <div class="px-6 py-3 bg-gray-50 border-t border-gray-200 flex items-center justify-between">
                        <div class="flex-1 flex justify-between sm:hidden">
                            <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Previous
                            </a>
                            <a href="#" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Next
                            </a>
                        </div>
                        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                            <div>
                                <p class="text-sm text-gray-700">
                                    Showing <span class="font-medium">1</span> to <span class="font-medium">10</span> of <span class="font-medium">20</span> results
                                </p>
                            </div>
                            <div>
                                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                                    <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                        <span class="sr-only">Previous</span>
                                        <i class="fas fa-chevron-left"></i>
                                    </a>
                                    <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                                        1
                                    </a>
                                    <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                                        2
                                    </a>
                                    <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                                        3
                                    </a>
                                    <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                        <span class="sr-only">Next</span>
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Edit Tag Modal -->
                <div id="edit-modal" class="fixed inset-0 flex items-center justify-center z-50 hidden" style="background-color: rgba(0,0,0,0.5);">
                    <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Edit Tag</h3>
                            <button id="close-modal" class="text-gray-400 hover:text-gray-500">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <form id="edit-tag-form">
                            <input type="hidden" id="edit-tag-id">
                            <div class="mb-4">
                                <label for="edit-tag-name" class="block text-sm font-medium text-gray-700 mb-1">Tag Name</label>
                                <input type="text" id="edit-tag-name" name="name" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <div id="edit-error" class="text-red-500 text-sm mt-1 hidden"></div>
                            </div>
                            <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                                <button type="button" id="cancel-edit" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none">
                                    Cancel
                                </button>
                                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none">
                                    Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Show/hide tag form
            const addNewTagBtn = document.getElementById('add-new-tag');
            const tagFormContainer = document.getElementById('tag-form-container');
            const cancelTagBtn = document.getElementById('cancel-tag');

            addNewTagBtn.addEventListener('click', function() {
                tagFormContainer.classList.remove('hidden');
                document.getElementById('tag-name').focus();
            });

            cancelTagBtn.addEventListener('click', function() {
                tagFormContainer.classList.add('hidden');
                document.getElementById('tag-form').reset();
            });

            // Edit tag modal
            const editModal = document.getElementById('edit-modal');
            const closeModalBtn = document.getElementById('close-modal');
            const cancelEditBtn = document.getElementById('cancel-edit');
            const editTagBtns = document.querySelectorAll('.edit-tag-btn');

            // Show edit modal
            editTagBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const tagId = this.dataset.id;
                    // In a real application, you'd fetch the tag data here
                    document.getElementById('edit-tag-id').value = tagId;
                    document.getElementById('edit-tag-name').value = this.closest('tr').querySelector('td:nth-child(2)').textContent;
                    editModal.classList.remove('hidden');
                });
            });

            // Close edit modal
            function closeEditModal() {
                editModal.classList.add('hidden');
                document.getElementById('edit-tag-form').reset();
            }

            closeModalBtn.addEventListener('click', closeEditModal);
            cancelEditBtn.addEventListener('click', closeEditModal);

            // Close modal when clicking outside
            editModal.addEventListener('click', function(e) {
                if (e.target === editModal) {
                    closeEditModal();
                }
            });

            // Delete tag confirmation
            const deleteTagBtns = document.querySelectorAll('.delete-tag-btn');
            deleteTagBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const tagId = this.dataset.id;
                    const tagName = this.closest('tr').querySelector('td:nth-child(2)').textContent;
                    
                    if (confirm(`Are you sure you want to delete the tag "${tagName}"?`)) {
                        // In a real application, you'd send a delete request here
                        console.log('Deleting tag ID:', tagId);
                        // Then remove the row from the table
                        this.closest('tr').remove();
                    }
                });
            });

            // Search functionality
            const searchInput = document.getElementById('search-tags');
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const tagRows = document.querySelectorAll('#tags-container tr');
                
                tagRows.forEach(row => {
                    const tagName = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                    if (tagName.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });

            // Form submissions would be handled here in a real application
            document.getElementById('tag-form').addEventListener('submit', function(e) {
                e.preventDefault();
                // In a real application, you'd send the form data to the server
                alert('New tag submitted: ' + document.getElementById('tag-name').value);
                tagFormContainer.classList.add('hidden');
                this.reset();
            });

            document.getElementById('edit-tag-form').addEventListener('submit', function(e) {
                e.preventDefault();
                // In a real application, you'd send the form data to the server
                alert('Tag updated: ' + document.getElementById('edit-tag-name').value);
                closeEditModal();
            });
        });
    </script>
</body>
</html>