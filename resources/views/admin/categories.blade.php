<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Gestion des Catégories - FilmWave Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.0/css/all.min.css" rel="stylesheet">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="flex min-h-screen">
        <!-- Sidebar placeholder -->
         @include('admin.sidebar')

        <!-- Main content -->
        <div class="flex-1 flex flex-col">
            <!-- Top navigation -->
            <header class="bg-white shadow-sm">
                <div class="flex justify-between items-center px-6 py-3">
                    <button class="md:hidden text-gray-500">
                        <i class="fas fa-bars"></i>
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
            <main class="flex-1 p-6 bg-gray-100">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-semibold text-gray-800">Gestion des Catégories</h1>
                    <button id="add-new-categories" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md flex items-center">
                        <i class="fas fa-plus mr-2"></i> Ajouter des Catégories
                    </button>
                </div>

                <!-- Category Batch Form (Hidden by default) -->
                <div id="category-form-container" class="bg-white rounded-lg shadow-md p-6 mb-6 hidden">
                    <h2 class="text-lg font-medium text-gray-700 mb-4">Ajouter des Catégories en Lot</h2>
                    <form id="category-form" action="/admin/categories/batch" method="POST">
                        <!-- CSRF Token (for Laravel) -->
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        
                        <div class="mb-4">
                            <label for="categories-input" class="block text-sm font-medium text-gray-700 mb-1">Noms des Catégories</label>
                            <div class="text-sm text-gray-500 mb-2">Saisissez plusieurs catégories séparées par des virgules</div>
                            <textarea id="categories-input" name="category_names" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Action, Drame, Comédie, Science-Fiction, etc."></textarea>
                            <div id="category-error" class="text-red-500 text-sm mt-1 hidden"></div>
                        </div>
                        
                        <div class="mb-4">
                            <div class="flex flex-wrap gap-2 mt-3" id="category-preview">
                                <!-- Category preview will be displayed here -->
                            </div>
                        </div>
                        
                        <div class="flex justify-end space-x-3">
                            <button type="button" id="cancel-category" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none">
                                Annuler
                            </button>
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none">
                                Enregistrer les Catégories
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Import Categories (Hidden by default) -->
                <div id="import-container" class="bg-white rounded-lg shadow-md p-6 mb-6 hidden">
                    <h2 class="text-lg font-medium text-gray-700 mb-4">Importer des Catégories</h2>
                    <form id="import-form" action="/admin/categories/import" method="POST" enctype="multipart/form-data">
                        <!-- CSRF Token (for Laravel) -->
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        
                        <div class="mb-4">
                            <label for="import-file" class="block text-sm font-medium text-gray-700 mb-1">Fichier CSV</label>
                            <div class="text-sm text-gray-500 mb-2">Le fichier doit contenir une colonne "name" pour les noms des catégories</div>
                            <input type="file" id="import-file" name="categories_file" accept=".csv" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <div id="import-error" class="text-red-500 text-sm mt-1 hidden"></div>
                        </div>
                        
                        <div class="flex justify-end space-x-3">
                            <button type="button" id="cancel-import" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none">
                                Annuler
                            </button>
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none">
                                Importer
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Batch Actions Bar -->
                <div id="batch-actions" class="bg-white rounded-lg shadow-md p-4 mb-6 flex justify-between items-center hidden">
                    <div class="flex items-center">
                        <span class="mr-4" id="selected-count">0 catégories sélectionnées</span>
                        <button id="batch-delete" class="text-red-500 hover:text-red-700 mr-4 disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                            <i class="fas fa-trash mr-1"></i> Supprimer
                        </button>
                        <button id="batch-export" class="text-green-500 hover:text-green-700 disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                            <i class="fas fa-file-export mr-1"></i> Exporter
                        </button>
                    </div>
                    <div>
                        <button id="import-categories" class="text-blue-500 hover:text-blue-700">
                            <i class="fas fa-file-import mr-1"></i> Importer
                        </button>
                    </div>
                </div>

                <!-- Categories List -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                        <div class="flex items-center">
                            <h2 class="font-bold text-gray-800 mr-4">Toutes les Catégories</h2>
                            <div class="flex items-center">
                                <input type="checkbox" id="select-all" class="mr-2 h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="select-all" class="text-sm text-gray-700">Tout sélectionner</label>
                            </div>
                        </div>
                        <div class="relative">
                            <input type="text" id="search-categories" placeholder="Rechercher des catégories..." class="px-3 py-2 pl-10 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-10">
                                        <span class="sr-only">Sélectionner</span>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Films Associés</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Créé le</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200" id="categories-container">
                                @forelse ($categories as $category)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="checkbox" class="category-checkbox h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" data-id="{{ $category->id }}">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $category->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $category->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $category->contents_count ?? 0 }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $category->created_at ? $category->created_at->format('d/m/Y') : '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <button class="text-blue-500 hover:text-blue-700 mr-3 edit-category-btn" data-id="{{ $category->id }}" data-name="{{ $category->name }}">
                                            <i class="fas fa-edit"></i> Modifier
                                        </button>
                                        <button class="text-red-500 hover:text-red-700 delete-category-btn" data-id="{{ $category->id }}">
                                            <i class="fas fa-trash"></i> Supprimer
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                        Aucune catégorie trouvée
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!-- Pagination -->
                    <div class="px-6 py-3 bg-gray-50 border-t border-gray-200 flex items-center justify-between">
                        @if($categories->hasPages())
                        <div class="flex-1 flex justify-between sm:hidden">
                            @if($categories->onFirstPage())
                                <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-500 bg-gray-50 cursor-not-allowed">
                                    Précédent
                                </span>
                            @else
                                <a href="{{ $categories->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                    Précédent
                                </a>
                            @endif
                            
                            @if($categories->hasMorePages())
                                <a href="{{ $categories->nextPageUrl() }}" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                    Suivant
                                </a>
                            @else
                                <span class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-500 bg-gray-50 cursor-not-allowed">
                                    Suivant
                                </span>
                            @endif
                        </div>
                        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                            <div>
                                <p class="text-sm text-gray-700">
                                    Affichage de <span class="font-medium">{{ $categories->firstItem() ?? 0 }}</span> à <span class="font-medium">{{ $categories->lastItem() ?? 0 }}</span> sur <span class="font-medium">{{ $categories->total() }}</span> résultats
                                </p>
                            </div>
                            <div>
                                {{ $categories->links() }}
                            </div>
                        </div>
                        @else
                        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                            <div>
                                <p class="text-sm text-gray-700">
                                    Affichage de <span class="font-medium">{{ $categories->count() }}</span> résultats
                                </p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Edit Category Modal -->
                <div id="edit-modal" class="fixed inset-0 flex items-center justify-center z-50 hidden" style="background-color: rgba(0,0,0,0.5);">
                    <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Modifier la Catégorie</h3>
                            <button id="close-modal" class="text-gray-400 hover:text-gray-500">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <form id="edit-category-form" action="/admin/categories/update" method="POST">
                            <!-- CSRF Token (for Laravel) -->
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="PUT">
                            <input type="hidden" id="edit-category-id" name="id">
                            <div class="mb-4">
                                <label for="edit-category-name" class="block text-sm font-medium text-gray-700 mb-1">Nom de la Catégorie</label>
                                <input type="text" id="edit-category-name" name="name" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <div id="edit-error" class="text-red-500 text-sm mt-1 hidden"></div>
                            </div>
                            <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                                <button type="button" id="cancel-edit" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none">
                                    Annuler
                                </button>
                                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none">
                                    Enregistrer
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Notification Toast -->
                <div id="toast" class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-md shadow-lg hidden transform transition-transform duration-300 ease-in-out">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        <span id="toast-message">Opération réussie</span>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // DOM Elements
            const addNewCategoriesBtn = document.getElementById('add-new-categories');
            const categoryFormContainer = document.getElementById('category-form-container');
            const cancelCategoryBtn = document.getElementById('cancel-category');
            const categoriesInput = document.getElementById('categories-input');
            const categoryPreview = document.getElementById('category-preview');
            const importCategoriesBtn = document.getElementById('import-categories');
            const importContainer = document.getElementById('import-container');
            const cancelImportBtn = document.getElementById('cancel-import');
            const selectAllCheckbox = document.getElementById('select-all');
            const categoryCheckboxes = document.querySelectorAll('.category-checkbox');
            const batchActions = document.getElementById('batch-actions');
            const selectedCountElement = document.getElementById('selected-count');
            const batchDeleteBtn = document.getElementById('batch-delete');
            const batchExportBtn = document.getElementById('batch-export');
            const editModal = document.getElementById('edit-modal');
            const editCategoryForm = document.getElementById('edit-category-form');
            const editCategoryIdInput = document.getElementById('edit-category-id');
            const editCategoryNameInput = document.getElementById('edit-category-name');
            const closeModalBtn = document.getElementById('close-modal');
            const cancelEditBtn = document.getElementById('cancel-edit');
            const searchInput = document.getElementById('search-categories');
            const toast = document.getElementById('toast');
            const toastMessage = document.getElementById('toast-message');

            // Show/hide category form
            addNewCategoriesBtn.addEventListener('click', function() {
                categoryFormContainer.classList.remove('hidden');
                importContainer.classList.add('hidden');
                categoriesInput.focus();
            });

            cancelCategoryBtn.addEventListener('click', function() {
                categoryFormContainer.classList.add('hidden');
                document.getElementById('category-form').reset();
                categoryPreview.innerHTML = '';
            });

            // Show import form
            importCategoriesBtn.addEventListener('click', function() {
                importContainer.classList.remove('hidden');
                categoryFormContainer.classList.add('hidden');
            });

            cancelImportBtn.addEventListener('click', function() {
                importContainer.classList.add('hidden');
                document.getElementById('import-form').reset();
            });

            // Category preview functionality
            categoriesInput.addEventListener('input', function() {
                const categoryNames = this.value.split(',').filter(category => category.trim() !== '');
                categoryPreview.innerHTML = '';
                
                categoryNames.forEach(categoryName => {
                    const categoryElement = document.createElement('span');
                    categoryElement.classList.add('bg-blue-100', 'text-blue-700', 'px-2', 'py-1', 'rounded-md', 'text-sm');
                    categoryElement.textContent = categoryName.trim();
                    categoryPreview.appendChild(categoryElement);
                });
            });

            // Batch selection functionality
            selectAllCheckbox.addEventListener('change', function() {
                const isChecked = this.checked;
                
                categoryCheckboxes.forEach(checkbox => {
                    checkbox.checked = isChecked;
                });
                
                updateBatchActions();
            });

            categoryCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateBatchActions);
            });

            function updateBatchActions() {
                const checkedCount = document.querySelectorAll('.category-checkbox:checked').length;
                
                if (checkedCount > 0) {
                    batchActions.classList.remove('hidden');
                    batchDeleteBtn.disabled = false;
                    batchExportBtn.disabled = false;
                    selectedCountElement.textContent = `${checkedCount} catégorie${checkedCount > 1 ? 's' : ''} sélectionné${checkedCount > 1 ? 's' : ''}`;
                } else {
                    batchActions.classList.add('hidden');
                    batchDeleteBtn.disabled = true;
                    batchExportBtn.disabled = true;
                }
            }

            // Edit category functionality
            const editCategoryBtns = document.querySelectorAll('.edit-category-btn');
            
            editCategoryBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const categoryId = this.dataset.id;
                    const categoryName = this.dataset.name;
                    
                    editCategoryIdInput.value = categoryId;
                    editCategoryNameInput.value = categoryName;
                    editModal.classList.remove('hidden');
                });
            });

            // Close edit modal
            function closeEditModal() {
                editModal.classList.add('hidden');
                editCategoryForm.reset();
            }

            closeModalBtn.addEventListener('click', closeEditModal);
            cancelEditBtn.addEventListener('click', closeEditModal);

            // Close modal when clicking outside
            editModal.addEventListener('click', function(e) {
                if (e.target === editModal) {
                    closeEditModal();
                }
            });

            // Delete category confirmation
            const deleteCategoryBtns = document.querySelectorAll('.delete-category-btn');
            
            deleteCategoryBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const categoryId = this.dataset.id;
                    const categoryName = this.closest('tr').querySelector('td:nth-child(3)').textContent;
                    const deleteButton = this;
                    
                    Swal.fire({
                        title: 'Êtes-vous sûr ?',
                        text: `Voulez-vous vraiment supprimer la catégorie "${categoryName}" ?`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Oui, supprimer',
                        cancelButtonText: 'Annuler',
                        focusCancel: true,
                        width: '25em'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Envoyer une requête AJAX pour supprimer la catégorie
                            fetch(`/admin/categories/${categoryId}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    // Animation de suppression
                                    const row = deleteButton.closest('tr');
                                    row.style.transition = 'opacity 0.5s, transform 0.5s';
                                    row.style.opacity = '0';
                                    row.style.transform = 'translateX(20px)';
                                    
                                    setTimeout(() => {
                                        row.remove();
                                        Swal.fire({
                                            title: 'Supprimé !',
                                            text: data.message,
                                            icon: 'success',
                                            timer: 1500,
                                            showConfirmButton: false
                                        });
                                    }, 500);
                                } else {
                                    Swal.fire({
                                        title: 'Erreur !',
                                        text: data.error || 'Une erreur est survenue',
                                        icon: 'error'
                                    });
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                Swal.fire({
                                    title: 'Erreur !',
                                    text: 'Une erreur est survenue. Veuillez réessayer.',
                                    icon: 'error'
                                });
                            });
                        }
                    });
                });
            });

            // Batch delete
            batchDeleteBtn.addEventListener('click', function() {
                const selectedCategories = document.querySelectorAll('.category-checkbox:checked');
                const categoryIds = Array.from(selectedCategories).map(checkbox => checkbox.dataset.id);
                
                Swal.fire({
                    title: 'Suppression multiple',
                    text: `Êtes-vous sûr de vouloir supprimer ${categoryIds.length} catégorie(s) ?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: `Oui, supprimer ${categoryIds.length} catégorie(s)`,
                    cancelButtonText: 'Annuler',
                    focusCancel: true,
                    width: '30em'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Afficher l'indicateur de chargement
                        Swal.fire({
                            title: 'Suppression en cours...',
                            text: 'Veuillez patienter',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            showConfirmButton: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        
                        // Envoyer une requête AJAX pour supprimer les catégories en lot
                        fetch('/admin/categories/batch', {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                ids: categoryIds
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Animation de suppression
                                selectedCategories.forEach(checkbox => {
                                    const row = checkbox.closest('tr');
                                    row.style.transition = 'opacity 0.5s, transform 0.5s';
                                    row.style.opacity = '0';
                                    row.style.transform = 'translateX(20px)';
                                    setTimeout(() => {
                                        row.remove();
                                    }, 500);
                                });
                                
                                // Mettre à jour l'interface
                                selectAllCheckbox.checked = false;
                                updateBatchActions();
                                
                                setTimeout(() => {
                                    Swal.fire({
                                        title: 'Supprimé !',
                                        text: data.message,
                                        icon: 'success',
                                        timer: 2000,
                                        showConfirmButton: false
                                    });
                                }, 600);
                                
                                // Si des erreurs sont présentes
                                if (data.errors && data.errors.length > 0) {
                                    setTimeout(() => {
                                        Swal.fire({
                                            title: 'Avertissement',
                                            html: `<p>Certaines opérations ont échoué :</p><ul class="text-left mt-2">${data.errors.map(error => `<li>- ${error}</li>`).join('')}</ul>`,
                                            icon: 'warning'
                                        });
                                    }, 2500);
                                }
                            } else {
                                Swal.fire({
                                    title: 'Erreur !',
                                    text: data.error || 'Une erreur est survenue',
                                    icon: 'error'
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                title: 'Erreur !',
                                text: 'Une erreur est survenue. Veuillez réessayer.',
                                icon: 'error'
                            });
                        });
                    }
                });
            });

            // Batch export
            batchExportBtn.addEventListener('click', function() {
                const selectedCategories = document.querySelectorAll('.category-checkbox:checked');
                const categoryIds = Array.from(selectedCategories).map(checkbox => checkbox.dataset.id);
                
                // Rediriger vers la route d'export avec les IDs sélectionnés
                window.location.href = '/admin/categories/export?ids=' + categoryIds.join(',');
            });

            // Search functionality
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const categoryRows = document.querySelectorAll('#categories-container tr');
                
                categoryRows.forEach(row => {
                    const categoryName = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
                    if (categoryName.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });

            // Form submissions
            document.getElementById('category-form').addEventListener('submit', function(e) {
                e.preventDefault();
                const categoryNames = categoriesInput.value;
                
                if (categoryNames.trim() !== '') {
                    // Envoyer une requête AJAX pour créer les catégories
                    fetch('/admin/categories/batch', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            category_names: categoryNames
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showToast(data.message);
                            categoryFormContainer.classList.add('hidden');
                            document.getElementById('category-form').reset();
                            categoryPreview.innerHTML = '';
                            // Recharger la page pour afficher les nouvelles catégories
                            setTimeout(() => {
                                window.location.reload();
                            }, 1000);
                        } else {
                            document.getElementById('category-error').textContent = data.error || 'Une erreur est survenue';
                            document.getElementById('category-error').classList.remove('hidden');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        document.getElementById('category-error').textContent = 'Une erreur est survenue. Veuillez réessayer.';
                        document.getElementById('category-error').classList.remove('hidden');
                    });
                } else {
                    document.getElementById('category-error').textContent = 'Veuillez saisir au moins une catégorie';
                    document.getElementById('category-error').classList.remove('hidden');
                }
            });

            document.getElementById('import-form').addEventListener('submit', function(e) {
                e.preventDefault();
                const fileInput = document.getElementById('import-file');
                
                if (fileInput.files.length > 0) {
                    const formData = new FormData();
                    formData.append('categories_file', fileInput.files[0]);
                    formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
                    
                    // Envoyer une requête AJAX pour importer les catégories
                    fetch('/admin/categories/import', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showToast(data.message);
                            importContainer.classList.add('hidden');
                            document.getElementById('import-form').reset();
                            // Recharger la page pour afficher les nouvelles catégories
                            setTimeout(() => {
                                window.location.reload();
                            }, 1000);
                        } else {
                            document.getElementById('import-error').textContent = data.error || 'Une erreur est survenue';
                            document.getElementById('import-error').classList.remove('hidden');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        document.getElementById('import-error').textContent = 'Une erreur est survenue. Veuillez réessayer.';
                        document.getElementById('import-error').classList.remove('hidden');
                    });
                } else {
                    document.getElementById('import-error').textContent = 'Veuillez sélectionner un fichier';
                    document.getElementById('import-error').classList.remove('hidden');
                }
            });

            editCategoryForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const categoryId = editCategoryIdInput.value;
                const categoryName = editCategoryNameInput.value;
                
                // Envoyer une requête AJAX pour mettre à jour la catégorie
                fetch(`/admin/categories/${categoryId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        id: categoryId,
                        name: categoryName
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        closeEditModal();
                        showToast(data.message);
                        // Recharger la page pour afficher les modifications
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    } else {
                        document.getElementById('edit-error').textContent = data.error;
                        document.getElementById('edit-error').classList.remove('hidden');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('edit-error').textContent = 'Une erreur est survenue. Veuillez réessayer.';
                    document.getElementById('edit-error').classList.remove('hidden');
                });
            });

            // Toast notification
            function showToast(message, type = 'success') {
                toastMessage.textContent = message;
                toast.className = `fixed bottom-4 right-4 bg-${type === 'success' ? 'green' : 'red'}-500 text-white px-6 py-3 rounded-md shadow-lg hidden transform transition-transform duration-300 ease-in-out`;
                toast.classList.remove('hidden');
                toast.classList.add('translate-y-0');
                
                setTimeout(() => {
                    toast.classList.add('translate-y-full');
                    setTimeout(() => {
                        toast.classList.add('hidden');
                        toast.classList.remove('translate-y-full');
                    }, 300);
                }, 3000);
            }
        });
    </script>
</body>
</html>