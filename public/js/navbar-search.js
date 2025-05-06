/**
 * FilmWave Navbar Search - Dynamic search functionality
 */

document.addEventListener('DOMContentLoaded', function() {
    // Get DOM elements when using Alpine.js
    const setupSearch = () => {
        // Get the Alpine.js component for navbar
        const navbarEl = document.querySelector('#navbar');
        if (!navbarEl) return;
        
        // Access Alpine.js data
        const navbar = Alpine.store('navbar') || Alpine.$data(navbarEl);
        if (!navbar) return;

        // Store for search results
        let searchResults = [];
        let searchTimeout;
        let isSearchBarJustOpened = false; // Flag to track if search bar was just opened
        
        // Function to handle search input changes
        const handleSearchInput = (query) => {
            // Clear previous timeout
            if (searchTimeout) {
                clearTimeout(searchTimeout);
            }
            
            // Debounce search input to prevent too many requests
            searchTimeout = setTimeout(() => {
                if (query.length < 2) {
                    // Don't search for very short queries
                    updateSearchResults([]);
                    return;
                }
                
                // Perform the search
                performSearch(query);
            }, 300);
        };
        
        // Function to perform search
        const performSearch = (query) => {
            // Show loading indicator
            showLoadingIndicator();
            
            // Fetch search results from API
            fetch(`/api/search?q=${encodeURIComponent(query)}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    // Update results
                    updateSearchResults(data);
                    hideLoadingIndicator();
                })
                .catch(error => {
                    console.error('Error searching:', error);
                    // In case of error, use dummy results
                    updateSearchResults(getDummyResults(query));
                    hideLoadingIndicator();
                });
        };
        
        // Function to update search results in the UI
        const updateSearchResults = (results) => {
            searchResults = results;
            const resultsContainer = document.querySelector('#search-results');
            
            if (!resultsContainer) return;
            
            // Clear previous results
            resultsContainer.innerHTML = '';
            
            if (results.length === 0) {
                resultsContainer.innerHTML = `
                    <div class="p-4 text-center text-gray-400">
                        <p>Aucun résultat trouvé</p>
                    </div>
                `;
                return;
            }
            
            // Group results by type
            const groupedResults = {
                films: results.filter(r => r.type === 'film'),
                series: results.filter(r => r.type === 'series'),
                actors: results.filter(r => r.type === 'actor'),
                categories: results.filter(r => r.type === 'category')
            };
            
            // Create HTML for results
            let html = '';
            
            // Films
            if (groupedResults.films.length > 0) {
                html += `<div class="p-2"><h4 class="text-film-red font-medium">Films</h4>`;
                groupedResults.films.slice(0, 3).forEach(film => {
                    html += `
                        <a href="/films/${film.id}" class="flex items-center p-2 hover:bg-film-red/10 rounded transition">
                            <div class="w-10 h-14 bg-gray-800 rounded overflow-hidden">
                                ${film.image ? `<img src="${film.image}" class="w-full h-full object-cover" alt="${film.title}">` : ''}
                            </div>
                            <div class="ml-3">
                                <p class="text-white font-medium">${film.title}</p>
                                <p class="text-xs text-gray-400">${film.year || ''}</p>
                            </div>
                        </a>
                    `;
                });
                html += `</div>`;
            }
            
            // Series
            if (groupedResults.series.length > 0) {
                html += `<div class="p-2"><h4 class="text-film-red font-medium">Séries</h4>`;
                groupedResults.series.slice(0, 3).forEach(series => {
                    html += `
                        <a href="/series/${series.id}" class="flex items-center p-2 hover:bg-film-red/10 rounded transition">
                            <div class="w-10 h-14 bg-gray-800 rounded overflow-hidden">
                                ${series.image ? `<img src="${series.image}" class="w-full h-full object-cover" alt="${series.title}">` : ''}
                            </div>
                            <div class="ml-3">
                                <p class="text-white font-medium">${series.title}</p>
                                <p class="text-xs text-gray-400">${series.seasons ? series.seasons + ' saisons' : ''}</p>
                            </div>
                        </a>
                    `;
                });
                html += `</div>`;
            }
            
            // Actors
            if (groupedResults.actors.length > 0) {
                html += `<div class="p-2"><h4 class="text-film-red font-medium">Acteurs</h4>`;
                groupedResults.actors.slice(0, 3).forEach(actor => {
                    html += `
                        <a href="/actors/${actor.id}" class="flex items-center p-2 hover:bg-film-red/10 rounded transition">
                            <div class="w-10 h-10 bg-gray-800 rounded-full overflow-hidden">
                                ${actor.image ? `<img src="${actor.image}" class="w-full h-full object-cover" alt="${actor.name}">` : 
                                `<div class="w-full h-full flex items-center justify-center text-white">${actor.name.charAt(0)}</div>`}
                            </div>
                            <div class="ml-3">
                                <p class="text-white font-medium">${actor.name}</p>
                            </div>
                        </a>
                    `;
                });
                html += `</div>`;
            }
            
            // Categories
            if (groupedResults.categories.length > 0) {
                html += `<div class="p-2"><h4 class="text-film-red font-medium">Catégories</h4><div class="flex flex-wrap gap-2 mt-1">`;
                groupedResults.categories.forEach(category => {
                    html += `
                        <a href="/category/${category.id}" 
                           class="bg-film-gray px-3 py-1 rounded-full text-sm text-white hover:bg-film-red/30 transition">
                            ${category.name}
                        </a>
                    `;
                });
                html += `</div></div>`;
            }
            
            // View all results link
            html += `
                <div class="p-2 border-t border-gray-800 mt-2">
                    <a href="/search?q=${encodeURIComponent(navbar.searchQuery)}" 
                       class="block py-2 text-center text-film-red hover:underline">
                        Voir tous les résultats
                    </a>
                </div>
            `;
            
            resultsContainer.innerHTML = html;
        };
        
        // Show loading indicator in search results
        const showLoadingIndicator = () => {
            const resultsContainer = document.querySelector('#search-results');
            if (!resultsContainer) return;
            
            resultsContainer.innerHTML = `
                <div class="p-4 text-center text-gray-400">
                    <div class="inline-block animate-spin rounded-full h-5 w-5 border-t-2 border-film-red border-r-2 mr-2"></div>
                    <span>Recherche en cours...</span>
                </div>
            `;
        };
        
        // Hide loading indicator
        const hideLoadingIndicator = () => {
            // This is automatically handled by updateSearchResults
        };
        
        // Fallback function to get dummy results for testing or when API fails
        const getDummyResults = (query) => {
            return [
                { id: 1, type: 'film', title: 'Inception', year: 2010 },
                { id: 2, type: 'film', title: 'Interstellar', year: 2014 },
                { id: 3, type: 'series', title: 'Stranger Things', seasons: 4 },
                { id: 4, type: 'actor', name: 'Leonardo DiCaprio' },
                { id: 5, type: 'category', name: 'Science Fiction' },
                { id: 6, type: 'category', name: 'Action' }
            ].filter(item => {
                if (item.title) {
                    return item.title.toLowerCase().includes(query.toLowerCase());
                } else if (item.name) {
                    return item.name.toLowerCase().includes(query.toLowerCase());
                }
                return false;
            });
        };
        
        // Watch for changes in the search query
        if (navbar.searchQuery !== undefined) {
            // Setup a watcher for search query changes
            // This can be done by checking the input field value periodically
            const searchInput = document.querySelector('#navSearchInput');
            if (searchInput) {
                searchInput.addEventListener('input', (e) => {
                    handleSearchInput(e.target.value);
                });
                
                // Handle search form submission
                const searchForm = searchInput.closest('form');
                if (searchForm) {
                    searchForm.addEventListener('submit', (e) => {
                        e.preventDefault();
                        window.location.href = `/search?q=${encodeURIComponent(searchInput.value)}`;
                    });
                }
            }
        }
        
        // Watch for search bar opening and set the flag
        document.addEventListener('click', (e) => {
            const searchButton = e.target.closest('button[aria-label="Toggle search"]');
            if (searchButton) {
                isSearchBarJustOpened = true;
                setTimeout(() => {
                    isSearchBarJustOpened = false;
                }, 1000); // 1 second delay before allowing close on outside click
            }
        });
        
        // Close search results when clicking outside
        document.addEventListener('click', (e) => {
            const searchContainer = document.querySelector('#searchContainer');
            const searchResults = document.querySelector('#search-results');
            const searchToggle = e.target.closest('button[aria-label="Toggle search"]');
            
            // Skip if the search bar was just opened or if clicking the toggle button
            if (isSearchBarJustOpened || searchToggle) {
                return;
            }
            
            if (searchContainer && searchResults && 
                !searchContainer.contains(e.target) && 
                !searchResults.contains(e.target)) {
                // If Alpine.js is controlling the search visibility
                if (navbar.showSearchBar) {
                    navbar.showSearchBar = false;
                } else {
                    // If not using Alpine.js to control visibility
                    searchResults.style.display = 'none';
                }
            }
        });
        
        // Handle keyboard navigation
        document.addEventListener('keydown', (e) => {
            // Close search on Escape
            if (e.key === 'Escape') {
                if (navbar.showSearchBar) {
                    navbar.showSearchBar = false;
                }
            }
        });
    };
    
    // Initialize search functionality
    setupSearch();
});