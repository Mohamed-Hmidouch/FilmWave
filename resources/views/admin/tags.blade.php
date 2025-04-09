<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Gestion des Tags en Lot - FilmWave Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="flex min-h-screen">
        <!-- Sidebar placeholder -->
        <div class="w-64 bg-gray-800 text-white p-4 hidden md:block">
            <div class="text-2xl font-bold mb-8 pl-2">FilmWave Admin</div>
            <nav>
                <ul>
                    <li class="mb-2">
                        <a href="#" class="flex items-center p-2 rounded hover:bg-gray-700">
                            <i class="fas fa-home mr-3"></i> Dashboard
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="flex items-center p-2 rounded bg-blue-600">
                            <i class="fas fa-tags mr-3"></i> Gestion des Tags
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="flex items-center p-2 rounded hover:bg-gray-700">
                            <i class="fas fa-film mr-3"></i> Films
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="flex items-center p-2 rounded hover:bg-gray-700">
                            <i class="fas fa-users mr-3"></i> Utilisateurs
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="flex items-center p-2 rounded hover:bg-gray-700">
                            <i class="fas fa-cog mr-3"></i> Paramètres
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

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
                            <img class="h-8 w-8 rounded-full" src="https://ui-avatars.com/api/?name=Admin+User" alt="Admin User">
                            <span class="text-gray-700">Admin User</span>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main content area -->
            <main class="flex-1 p-6 bg-gray-100">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-semibold text-gray-800">Gestion des Tags</h1>
                    <button id="add-new-tags" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md flex items-center">
                        <i class="fas fa-plus mr-2"></i> Ajouter des Tags
                    </button>
                </div>

                <!-- Tag Batch Form (Hidden by default) -->
                <div id="tag-form-container" class="bg-white rounded-lg shadow-md p-6 mb-6 hidden">
                    <h2 class="text-lg font-medium text-gray-700 mb-4">Ajouter des Tags en Lot</h2>
                    <form id="tag-form" action="/admin/tags/batch" method="POST">
                        <!-- CSRF Token (for Laravel) -->
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        
                        <div class="mb-4">
                            <label for="tags-input" class="block text-sm font-medium text-gray-700 mb-1">Noms des Tags</label>
                            <div class="text-sm text-gray-500 mb-2">Saisissez plusieurs tags séparés par des virgules</div>
                            <textarea id="tags-input" name="tag_names" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Action, Drame, Comédie, Science-Fiction, etc."></textarea>
                            <div id="tag-error" class="text-red-500 text-sm mt-1 hidden"></div>
                        </div>
                        
                        <div class="mb-4">
                            <div class="flex flex-wrap gap-2 mt-3" id="tag-preview">
                                <!-- Tag preview will be displayed here -->
                            </div>
                        </div>
                        
                        <div class="flex justify-end space-x-3">
                            <button type="button" id="cancel-tag" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none">
                                Annuler
                            </button>
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none">
                                Enregistrer les Tags
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Import Tags (Hidden by default) -->
                <div id="import-container" class="bg-white rounded-lg shadow-md p-6 mb-6 hidden">
                    <h2 class="text-lg font-medium text-gray-700 mb-4">Importer des Tags</h2>
                    <form id="import-form" action="/admin/tags/import" method="POST" enctype="multipart/form-data">
                        <!-- CSRF Token (for Laravel) -->
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        
                        <div class="mb-4">
                            <label for="import-file" class="block text-sm font-medium text-gray-700 mb-1">Fichier CSV</label>
                            <div class="text-sm text-gray-500 mb-2">Le fichier doit contenir une colonne "name" pour les noms des tags</div>
                            <input type="file" id="import-file" name="tags_file" accept=".csv" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
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
                        <span class="mr-4" id="selected-count">0 tags sélectionnés</span>
                        <button id="batch-delete" class="text-red-500 hover:text-red-700 mr-4 disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                            <i class="fas fa-trash mr-1"></i> Supprimer
                        </button>
                        <button id="batch-export" class="text-green-500 hover:text-green-700 disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                            <i class="fas fa-file-export mr-1"></i> Exporter
                        </button>
                    </div>
                    <div>
                        <button id="import-tags" class="text-blue-500 hover:text-blue-700">
                            <i class="fas fa-file-import mr-1"></i> Importer
                        </button>
                    </div>
                </div>

                <!-- Tags List -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                        <div class="flex items-center">
                            <h2 class="font-bold text-gray-800 mr-4">Tous les Tags</h2>
                            <div class="flex items-center">
                                <input type="checkbox" id="select-all" class="mr-2 h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="select-all" class="text-sm text-gray-700">Tout sélectionner</label>
                            </div>
                        </div>
                        <div class="relative">
                            <input type="text" id="search-tags" placeholder="Rechercher des tags..." class="px-3 py-2 pl-10 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
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
                            <tbody class="bg-white divide-y divide-gray-200" id="tags-container">
                                <!-- Exemple de données - Serait remplacé par les données réelles de Laravel -->
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="checkbox" class="tag-checkbox h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" data-id="1">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">1</td>
                                    <td class="px-6 py-4 whitespace-nowrap">Action</td>
                                    <td class="px-6 py-4 whitespace-nowrap">42</td>
                                    <td class="px-6 py-4 whitespace-nowrap">15/03/2023</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <button class="text-blue-500 hover:text-blue-700 mr-3 edit-tag-btn" data-id="1" data-name="Action">
                                            <i class="fas fa-edit"></i> Modifier
                                        </button>
                                        <button class="text-red-500 hover:text-red-700 delete-tag-btn" data-id="1">
                                            <i class="fas fa-trash"></i> Supprimer
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="checkbox" class="tag-checkbox h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" data-id="2">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">2</td>
                                    <td class="px-6 py-4 whitespace-nowrap">Drame</td>
                                    <td class="px-6 py-4 whitespace-nowrap">38</td>
                                    <td class="px-6 py-4 whitespace-nowrap">12/03/2023</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <button class="text-blue-500 hover:text-blue-700 mr-3 edit-tag-btn" data-id="2" data-name="Drame">
                                            <i class="fas fa-edit"></i> Modifier
                                        </button>
                                        <button class="text-red-500 hover:text-red-700 delete-tag-btn" data-id="2">
                                            <i class="fas fa-trash"></i> Supprimer
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="checkbox" class="tag-checkbox h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" data-id="3">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">3</td>
                                    <td class="px-6 py-4 whitespace-nowrap">Comédie</td>
                                    <td class="px-6 py-4 whitespace-nowrap">56</td>
                                    <td class="px-6 py-4 whitespace-nowrap">10/03/2023</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <button class="text-blue-500 hover:text-blue-700 mr-3 edit-tag-btn" data-id="3" data-name="Comédie">
                                            <i class="fas fa-edit"></i> Modifier
                                        </button>
                                        <button class="text-red-500 hover:text-red-700 delete-tag-btn" data-id="3">
                                            <i class="fas fa-trash"></i> Supprimer
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
                                Précédent
                            </a>
                            <a href="#" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Suivant
                            </a>
                        </div>
                        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                            <div>
                                <p class="text-sm text-gray-700">
                                    Affichage de <span class="font-medium">1</span> à <span class="font-medium">10</span> sur <span class="font-medium">20</span> résultats
                                </p>
                            </div>
                            <div>
                                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                                    <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                        <span class="sr-only">Précédent</span>
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
                                        <span class="sr-only">Suivant</span>
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
                            <h3 class="text-lg font-medium text-gray-900">Modifier le Tag</h3>
                            <button id="close-modal" class="text-gray-400 hover:text-gray-500">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <form id="edit-tag-form" action="/admin/tags/update" method="POST">
                            <!-- CSRF Token (for Laravel) -->
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="PUT">
                            <input type="hidden" id="edit-tag-id" name="id">
                            <div class="mb-4">
                                <label for="edit-tag-name" class="block text-sm font-medium text-gray-700 mb-1">Nom du Tag</label>
                                <input type="text" id="edit-tag-name" name="name" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
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
            const addNewTagsBtn = document.getElementById('add-new-tags');
            const tagFormContainer = document.getElementById('tag-form-container');
            const cancelTagBtn = document.getElementById('cancel-tag');
            const tagsInput = document.getElementById('tags-input');
            const tagPreview = document.getElementById('tag-preview');
            const importTagsBtn = document.getElementById('import-tags');
            const importContainer = document.getElementById('import-container');
            const cancelImportBtn = document.getElementById('cancel-import');
            const selectAllCheckbox = document.getElementById('select-all');
            const tagCheckboxes = document.querySelectorAll('.tag-checkbox');
            const batchActions = document.getElementById('batch-actions');
            const selectedCountElement = document.getElementById('selected-count');
            const batchDeleteBtn = document.getElementById('batch-delete');
            const batchExportBtn = document.getElementById('batch-export');
            const editModal = document.getElementById('edit-modal');
            const editTagForm = document.getElementById('edit-tag-form');
            const editTagIdInput = document.getElementById('edit-tag-id');
            const editTagNameInput = document.getElementById('edit-tag-name');
            const closeModalBtn = document.getElementById('close-modal');
            const cancelEditBtn = document.getElementById('cancel-edit');
            const searchInput = document.getElementById('search-tags');
            const toast = document.getElementById('toast');
            const toastMessage = document.getElementById('toast-message');

            // Show/hide tag form
            addNewTagsBtn.addEventListener('click', function() {
                tagFormContainer.classList.remove('hidden');
                importContainer.classList.add('hidden');
                tagsInput.focus();
            });

            cancelTagBtn.addEventListener('click', function() {
                tagFormContainer.classList.add('hidden');
                document.getElementById('tag-form').reset();
                tagPreview.innerHTML = '';
            });

            // Show import form
            importTagsBtn.addEventListener('click', function() {
                importContainer.classList.remove('hidden');
                tagFormContainer.classList.add('hidden');
            });

            cancelImportBtn.addEventListener('click', function() {
                importContainer.classList.add('hidden');
                document.getElementById('import-form').reset();
            });

            // Tag preview functionality
            tagsInput.addEventListener('input', function() {
                const tagNames = this.value.split(',').filter(tag => tag.trim() !== '');
                tagPreview.innerHTML = '';
                
                tagNames.forEach(tagName => {
                    const tagElement = document.createElement('span');
                    tagElement.classList.add('bg-blue-100', 'text-blue-700', 'px-2', 'py-1', 'rounded-md', 'text-sm');
                    tagElement.textContent = tagName.trim();
                    tagPreview.appendChild(tagElement);
                });
            });

            // Batch selection functionality
            selectAllCheckbox.addEventListener('change', function() {
                const isChecked = this.checked;
                
                tagCheckboxes.forEach(checkbox => {
                    checkbox.checked = isChecked;
                });
                
                updateBatchActions();
            });

            tagCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateBatchActions);
            });

            function updateBatchActions() {
                const checkedCount = document.querySelectorAll('.tag-checkbox:checked').length;
                
                if (checkedCount > 0) {
                    batchActions.classList.remove('hidden');
                    batchDeleteBtn.disabled = false;
                    batchExportBtn.disabled = false;
                    selectedCountElement.textContent = `${checkedCount} tag${checkedCount > 1 ? 's' : ''} sélectionné${checkedCount > 1 ? 's' : ''}`;
                } else {
                    batchActions.classList.add('hidden');
                    batchDeleteBtn.disabled = true;
                    batchExportBtn.disabled = true;
                }
            }

            // Edit tag functionality
            const editTagBtns = document.querySelectorAll('.edit-tag-btn');
            
            editTagBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const tagId = this.dataset.id;
                    const tagName = this.dataset.name;
                    
                    editTagIdInput.value = tagId;
                    editTagNameInput.value = tagName;
                    editModal.classList.remove('hidden');
                });
            });

            // Close edit modal
            function closeEditModal() {
                editModal.classList.add('hidden');
                editTagForm.reset();
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
                    const tagName = this.closest('tr').querySelector('td:nth-child(3)').textContent;
                    
                    if (confirm(`Êtes-vous sûr de vouloir supprimer le tag "${tagName}" ?`)) {
                        // Simulation - En production, ceci enverrait une requête AJAX à Laravel
                        console.log('Suppression du tag ID:', tagId);
                        this.closest('tr').remove();
                        showToast('Tag supprimé avec succès');
                    }
                });
            });

            // Batch delete
            batchDeleteBtn.addEventListener('click', function() {
                const selectedTags = document.querySelectorAll('.tag-checkbox:checked');
                const tagIds = Array.from(selectedTags).map(checkbox => checkbox.dataset.id);
                
                if (confirm(`Êtes-vous sûr de vouloir supprimer ${tagIds.length} tags ?`)) {
                    // Simulation - En production, ceci enverrait une requête AJAX à Laravel
                    console.log('Suppression des tags IDs:', tagIds);
                    
                    // Retirer les lignes du tableau
                    selectedTags.forEach(checkbox => {
                        checkbox.closest('tr').remove();
                    });
                    
                    // Mettre à jour l'interface
                    selectAllCheckbox.checked = false;
                    updateBatchActions();
                    showToast(`${tagIds.length} tags supprimés avec succès`);
                }
            });

            // Batch export
            batchExportBtn.addEventListener('click', function() {
                const selectedTags = document.querySelectorAll('.tag-checkbox:checked');
                const tagIds = Array.from(selectedTags).map(checkbox => checkbox.dataset.id);
                
                // Simulation - En production, ceci déclencherait l'export depuis Laravel
                console.log('Export des tags IDs:', tagIds);
                showToast(`Export des tags lancé`);
            });

            // Search functionality
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const tagRows = document.querySelectorAll('#tags-container tr');
                
                tagRows.forEach(row => {
                    const tagName = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
                    if (tagName.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });

            // Form submissions
            document.getElementById('tag-form').addEventListener('submit', function(e) {
                // Dans un environnement réel, le formulaire serait soumis directement à Laravel
                // Cette partie est pour la démonstration uniquement
                e.preventDefault();
                const tagNames = tagsInput.value.split(',').filter(tag => tag.trim() !== '');
                
                if (tagNames.length > 0) {
                    console.log('Tags à ajouter:', tagNames);
                    showToast(`${tagNames.length} tags ajoutés avec succès`);
                    tagFormContainer.classList.add('hidden');
                    this.reset();
                    tagPreview.innerHTML = '';
                } else {
                    document.getElementById('tag-error').textContent = 'Veuillez saisir au moins un tag';
                    document.getElementById('tag-error').classList.remove('hidden');
                }
            });

            document.getElementById('import-form').addEventListener('submit', function(e) {
                // Dans un environnement réel, le formulaire serait soumis directement à Laravel
                // Cette partie est pour la démonstration uniquement
                e.preventDefault();
                const fileInput = document.getElementById('import-file');
                
                if (fileInput.files.length > 0) {
                    console.log('Fichier à importer:', fileInput.files[0].name);
                    showToast('Tags importés avec succès');
                    importContainer.classList.add('hidden');
                    this.reset();
                } else {
                    document.getElementById('import-error').textContent = 'Veuillez sélectionner un fichier';
                    document.getElementById('import-error').classList.remove('hidden');
                }
            });

            editTagForm.addEventListener('submit', function(e) {
                // Dans un environnement réel, le formulaire serait soumis directement à Laravel
                // Cette partie est pour la démonstration uniquement
                e.preventDefault();
                const tagId = editTagIdInput.value;
                const tagName = editTagNameInput.value;
                
                console.log('Tag à modifier:', { id: tagId, name: tagName });
                closeEditModal();
                showToast('Tag modifié avec succès');
            });

            // Toast notification
            function showToast(message) {
                toastMessage.textContent = message;
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