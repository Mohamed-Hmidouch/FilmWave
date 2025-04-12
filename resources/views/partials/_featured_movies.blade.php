<div class="container mx-auto py-8">
    <h2 class="text-2xl md:text-4xl font-bold mb-6 lg:mb-8 text-white flex items-center">
        <span class="border-l-4 border-film-red pl-3 transform skew-x-6">Séries Populaires</span>
        <span class="ml-3 text-sm bg-film-red px-2 py-1 rounded-md transform rotate-2">TOP</span>
    </h2>
    
    <!-- Grille responsive pour affichage horizontal des cartes -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-4 sm:gap-5 lg:gap-6 w-full">
        <!-- Carte 1 -->
        <div class="movie-card bg-film-gray rounded-lg overflow-hidden shadow-xl">
            <div class="relative overflow-hidden group">
                <img src="https://image.tmdb.org/t/p/w500/56v2KjBlU4XaOv9rVYEQypROD7P.jpg" 
                     alt="Stranger Things" 
                     class="card-img w-full h-64 object-cover transition-all duration-700">
                
                <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-90"></div>
                
                <div class="card-badge absolute top-3 right-3 bg-film-red text-white text-xs font-bold px-2 py-1 rounded-md shadow-lg flex items-center">
                    <i class="fas fa-tv mr-1"></i> Épisode 8
                </div>
                
                <div class="absolute bottom-0 left-0 p-4 w-full transform transition-all duration-300">
                    <h3 class="card-title text-white font-bold text-xl leading-tight">Stranger Things</h3>
                    <div class="flex space-x-2 mt-2">
                        <span class="genre-tag">Science Fiction</span>
                        <span class="genre-tag">Horreur</span>
                    </div>
                </div>
                
                <div class="play-icon-circle">
                    <i class="fas fa-play text-white text-xl"></i>
                </div>
                
                <div class="absolute top-0 left-0 p-3">
                    <div class="flex items-center bg-black bg-opacity-60 px-2 py-1 rounded-md">
                        <div class="rating-stars mr-1">
                            <i class="fas fa-star"></i>
                        </div>
                        <span class="text-white text-xs font-bold">8.7</span>
                    </div>
                </div>
            </div>
            
            <div class="p-4">
                <div class="flex justify-between items-center mb-3">
                    <div class="flex items-center">
                        <span class="text-gray-400 text-sm mr-2">Saison 4</span>
                        <div class="w-1 h-1 bg-gray-500 rounded-full"></div>
                        <span class="text-gray-500 text-xs ml-2">2023</span>
                    </div>
                    <div class="text-yellow-500 flex items-center">
                        <i class="fas fa-clock text-xs mr-1"></i>
                        <span class="text-xs">45min</span>
                    </div>
                </div>
                
                <div class="flex space-x-2 mt-3">
                    <button class="watch-button flex-1 text-white py-2 px-3 rounded-md text-sm font-medium flex items-center justify-center transition-all">
                        <i class="fas fa-play mr-2"></i> Regarder
                    </button>
                    <button class="add-to-list-button bg-transparent hover:bg-gray-700 text-white py-2 px-3 rounded-md border border-gray-600 text-sm flex items-center justify-center transition-all">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Carte 2 -->
        <div class="movie-card bg-film-gray rounded-lg overflow-hidden shadow-xl">
            <div class="relative overflow-hidden group">
                <img src="https://image.tmdb.org/t/p/w500/7RyHsO4yDXtBv1zUU3mTpHeQ0d5.jpg" 
                     alt="The Witcher" 
                     class="card-img w-full h-64 object-cover transition-all duration-700">
                
                <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-90"></div>
                
                <div class="card-badge absolute top-3 right-3 bg-film-red text-white text-xs font-bold px-2 py-1 rounded-md shadow-lg flex items-center">
                    <i class="fas fa-tv mr-1"></i> Épisode 5
                </div>
                
                <div class="absolute bottom-0 left-0 p-4 w-full transform transition-all duration-300">
                    <h3 class="card-title text-white font-bold text-xl leading-tight">The Witcher</h3>
                    <div class="flex space-x-2 mt-2">
                        <span class="genre-tag">Fantasy</span>
                        <span class="genre-tag">Action</span>
                    </div>
                </div>
                
                <div class="play-icon-circle">
                    <i class="fas fa-play text-white text-xl"></i>
                </div>
                
                <div class="absolute top-0 left-0 p-3">
                    <div class="flex items-center bg-black bg-opacity-60 px-2 py-1 rounded-md">
                        <div class="rating-stars mr-1">
                            <i class="fas fa-star"></i>
                        </div>
                        <span class="text-white text-xs font-bold">8.2</span>
                    </div>
                </div>
            </div>
            
            <div class="p-4">
                <div class="flex justify-between items-center mb-3">
                    <div class="flex items-center">
                        <span class="text-gray-400 text-sm mr-2">Saison 2</span>
                        <div class="w-1 h-1 bg-gray-500 rounded-full"></div>
                        <span class="text-gray-500 text-xs ml-2">2023</span>
                    </div>
                    <div class="text-yellow-500 flex items-center">
                        <i class="fas fa-clock text-xs mr-1"></i>
                        <span class="text-xs">55min</span>
                    </div>
                </div>
                
                <div class="flex space-x-2 mt-3">
                    <button class="watch-button flex-1 text-white py-2 px-3 rounded-md text-sm font-medium flex items-center justify-center transition-all">
                        <i class="fas fa-play mr-2"></i> Regarder
                    </button>
                    <button class="add-to-list-button bg-transparent hover:bg-gray-700 text-white py-2 px-3 rounded-md border border-gray-600 text-sm flex items-center justify-center transition-all">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Carte 3 -->
        <div class="movie-card bg-film-gray rounded-lg overflow-hidden shadow-xl">
            <div class="relative overflow-hidden group">
                <img src="https://image.tmdb.org/t/p/w500/qW4crfED8mpNDadSmMdi7ZDzhXF.jpg" 
                     alt="Breaking Bad" 
                     class="card-img w-full h-64 object-cover transition-all duration-700">
                
                <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-90"></div>
                
                <div class="card-badge absolute top-3 right-3 bg-film-red text-white text-xs font-bold px-2 py-1 rounded-md shadow-lg flex items-center">
                    <i class="fas fa-tv mr-1"></i> Épisode 10
                </div>
                
                <div class="absolute bottom-0 left-0 p-4 w-full transform transition-all duration-300">
                    <h3 class="card-title text-white font-bold text-xl leading-tight">Breaking Bad</h3>
                    <div class="flex space-x-2 mt-2">
                        <span class="genre-tag">Crime</span>
                        <span class="genre-tag">Drame</span>
                    </div>
                </div>
                
                <div class="play-icon-circle">
                    <i class="fas fa-play text-white text-xl"></i>
                </div>
                
                <div class="absolute top-0 left-0 p-3">
                    <div class="flex items-center bg-black bg-opacity-60 px-2 py-1 rounded-md">
                        <div class="rating-stars mr-1">
                            <i class="fas fa-star"></i>
                        </div>
                        <span class="text-white text-xs font-bold">9.5</span>
                    </div>
                </div>
            </div>
            
            <div class="p-4">
                <div class="flex justify-between items-center mb-3">
                    <div class="flex items-center">
                        <span class="text-gray-400 text-sm mr-2">Saison 5</span>
                        <div class="w-1 h-1 bg-gray-500 rounded-full"></div>
                        <span class="text-gray-500 text-xs ml-2">2023</span>
                    </div>
                    <div class="text-yellow-500 flex items-center">
                        <i class="fas fa-clock text-xs mr-1"></i>
                        <span class="text-xs">50min</span>
                    </div>
                </div>
                
                <div class="flex space-x-2 mt-3">
                    <button class="watch-button flex-1 text-white py-2 px-3 rounded-md text-sm font-medium flex items-center justify-center transition-all">
                        <i class="fas fa-play mr-2"></i> Regarder
                    </button>
                    <button class="add-to-list-button bg-transparent hover:bg-gray-700 text-white py-2 px-3 rounded-md border border-gray-600 text-sm flex items-center justify-center transition-all">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Carte 4 -->
        <div class="movie-card bg-film-gray rounded-lg overflow-hidden shadow-xl">
            <div class="relative overflow-hidden group">
                <img src="https://image.tmdb.org/t/p/w500/reEMJA1uzscCbkpeRJeTT2bjqUp.jpg" 
                     alt="Game of Thrones" 
                     class="card-img w-full h-64 object-cover transition-all duration-700">
                
                <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-90"></div>
                
                <div class="card-badge absolute top-3 right-3 bg-film-red text-white text-xs font-bold px-2 py-1 rounded-md shadow-lg flex items-center">
                    <i class="fas fa-tv mr-1"></i> Épisode 6
                </div>
                
                <div class="absolute bottom-0 left-0 p-4 w-full transform transition-all duration-300">
                    <h3 class="card-title text-white font-bold text-xl leading-tight">Game of Thrones</h3>
                    <div class="flex space-x-2 mt-2">
                        <span class="genre-tag">Fantasy</span>
                        <span class="genre-tag">Aventure</span>
                    </div>
                </div>
                
                <div class="play-icon-circle">
                    <i class="fas fa-play text-white text-xl"></i>
                </div>
                
                <div class="absolute top-0 left-0 p-3">
                    <div class="flex items-center bg-black bg-opacity-60 px-2 py-1 rounded-md">
                        <div class="rating-stars mr-1">
                            <i class="fas fa-star"></i>
                        </div>
                        <span class="text-white text-xs font-bold">9.2</span>
                    </div>
                </div>
            </div>
            
            <div class="p-4">
                <div class="flex justify-between items-center mb-3">
                    <div class="flex items-center">
                        <span class="text-gray-400 text-sm mr-2">Saison 8</span>
                        <div class="w-1 h-1 bg-gray-500 rounded-full"></div>
                        <span class="text-gray-500 text-xs ml-2">2023</span>
                    </div>
                    <div class="text-yellow-500 flex items-center">
                        <i class="fas fa-clock text-xs mr-1"></i>
                        <span class="text-xs">60min</span>
                    </div>
                </div>
                
                <div class="flex space-x-2 mt-3">
                    <button class="watch-button flex-1 text-white py-2 px-3 rounded-md text-sm font-medium flex items-center justify-center transition-all">
                        <i class="fas fa-play mr-2"></i> Regarder
                    </button>
                    <button class="add-to-list-button bg-transparent hover:bg-gray-700 text-white py-2 px-3 rounded-md border border-gray-600 text-sm flex items-center justify-center transition-all">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Carte 5 -->
        <div class="movie-card bg-film-gray rounded-lg overflow-hidden shadow-xl">
            <div class="relative overflow-hidden group">
                <img src="https://image.tmdb.org/t/p/w500/gKG5QGz5Ngf8fgWpBsWtlg5L2SF.jpg" 
                     alt="Money Heist" 
                     class="card-img w-full h-64 object-cover transition-all duration-700">
                
                <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-90"></div>
                
                <div class="card-badge absolute top-3 right-3 bg-film-red text-white text-xs font-bold px-2 py-1 rounded-md shadow-lg flex items-center">
                    <i class="fas fa-tv mr-1"></i> Épisode 3
                </div>
                
                <div class="absolute bottom-0 left-0 p-4 w-full transform transition-all duration-300">
                    <h3 class="card-title text-white font-bold text-xl leading-tight">Money Heist</h3>
                    <div class="flex space-x-2 mt-2">
                        <span class="genre-tag">Crime</span>
                        <span class="genre-tag">Action</span>
                    </div>
                </div>
                
                <div class="play-icon-circle">
                    <i class="fas fa-play text-white text-xl"></i>
                </div>
                
                <div class="absolute top-0 left-0 p-3">
                    <div class="flex items-center bg-black bg-opacity-60 px-2 py-1 rounded-md">
                        <div class="rating-stars mr-1">
                            <i class="fas fa-star"></i>
                        </div>
                        <span class="text-white text-xs font-bold">8.3</span>
                    </div>
                </div>
            </div>
            
            <div class="p-4">
                <div class="flex justify-between items-center mb-3">
                    <div class="flex items-center">
                        <span class="text-gray-400 text-sm mr-2">Saison 5</span>
                        <div class="w-1 h-1 bg-gray-500 rounded-full"></div>
                        <span class="text-gray-500 text-xs ml-2">2023</span>
                    </div>
                    <div class="text-yellow-500 flex items-center">
                        <i class="fas fa-clock text-xs mr-1"></i>
                        <span class="text-xs">50min</span>
                    </div>
                </div>
                
                <div class="flex space-x-2 mt-3">
                    <button class="watch-button flex-1 text-white py-2 px-3 rounded-md text-sm font-medium flex items-center justify-center transition-all">
                        <i class="fas fa-play mr-2"></i> Regarder
                    </button>
                    <button class="add-to-list-button bg-transparent hover:bg-gray-700 text-white py-2 px-3 rounded-md border border-gray-600 text-sm flex items-center justify-center transition-all">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Sélectionner tous les éléments nécessaires
        const movieCards = document.querySelectorAll('.movie-card');
        const watchButtons = document.querySelectorAll('.watch-button');
        const addToListButtons = document.querySelectorAll('.add-to-list-button');
        const notification = document.getElementById('notification');
        const notificationMessage = document.getElementById('notification-message');
        
        // Fonction pour afficher une notification
        function showNotification(message, type = 'success') {
            notificationMessage.textContent = message;
            
            // Définir la couleur en fonction du type
            if (type === 'success') {
                notification.style.backgroundColor = '#2ecc71';
            } else if (type === 'error') {
                notification.style.backgroundColor = '#e74c3c';
            } else if (type === 'info') {
                notification.style.backgroundColor = '#3498db';
            }
            
            notification.classList.add('show');
            
            // Masquer après 3 secondes
            setTimeout(() => {
                notification.classList.remove('show');
            }, 3000);
        }
        
        // Ajouter des interactions pour les cartes
        movieCards.forEach(card => {
            // Animation au survol de l'image
            const cardImg = card.querySelector('.card-img');
            cardImg.addEventListener('mouseenter', function() {
                this.classList.add('scale-105');
            });
            
            // Effet de clic sur la carte
            card.addEventListener('click', function() {
                const playCircle = this.querySelector('.play-icon-circle');
                playCircle.classList.add('pulse-animation');
                
                setTimeout(() => {
                    const watchBtn = this.querySelector('.watch-button');
                    // Simuler un clic sur le bouton de lecture
                    watchBtn.click();
                    playCircle.classList.remove('pulse-animation');
                }, 500);
            });
        });
        
        // Ajouter des effets pour les boutons "Regarder"
        watchButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.stopPropagation(); // Empêcher la propagation au parent
                
                // Récupérer le titre de la série
                const card = this.closest('.movie-card');
                const seriesTitle = card.querySelector('.card-title').textContent;
                
                // Effet visuel amélioré
                this.classList.add('scale-95', 'pulse-animation');
                setTimeout(() => {
                    this.classList.remove('scale-95', 'pulse-animation');
                    
                    // Animation de chargement améliorée
                    const originalText = this.innerHTML;
                    this.innerHTML = '<div class="flex items-center"><i class="fas fa-spinner fa-spin mr-2"></i><span>Chargement...</span></div>';
                    this.disabled = true;
                    
                    // Simuler un chargement avec progression
                    setTimeout(() => {
                        this.innerHTML = '<div class="flex items-center"><i class="fas fa-circle-notch fa-spin mr-2"></i><span>Préparation...</span></div>';
                        
                        setTimeout(() => {
                            this.innerHTML = originalText;
                            this.disabled = false;
                            
                            // Afficher une notification
                            showNotification(`Lecture de ${seriesTitle} lancée`, 'info');
                        }, 1000);
                    }, 800);
                }, 200);
            });
        });
        
        // Ajouter des effets pour les boutons "Ajouter à la liste"
        addToListButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.stopPropagation(); // Empêcher la propagation au parent
                
                // Récupérer le titre de la série
                const card = this.closest('.movie-card');
                const seriesTitle = card.querySelector('.card-title').textContent;
                
                // Effet visuel amélioré
                this.classList.add('scale-95');
                
                // Animation plus fluide
                setTimeout(() => {
                    this.classList.remove('scale-95');
                    
                    // Basculer l'état (ajouté/non ajouté) avec animation
                    const isAdded = this.classList.contains('added');
                    
                    if (!isAdded) {
                        // Animation d'ajout
                        this.classList.add('animate-pulse');
                        setTimeout(() => {
                            this.classList.remove('animate-pulse');
                            // Ajouter à la liste
                            this.classList.add('added');
                            this.style.backgroundColor = '#2ecc71';
                            this.style.borderColor = '#2ecc71';
                            this.innerHTML = '<i class="fas fa-check"></i>';
                            showNotification(`${seriesTitle} ajouté à votre liste`);
                        }, 300);
                    } else {
                        // Animation de retrait
                        this.classList.add('animate-pulse');
                        setTimeout(() => {
                            this.classList.remove('animate-pulse');
                            // Retirer de la liste
                            this.classList.remove('added');
                            this.style.backgroundColor = '';
                            this.style.borderColor = '';
                            this.innerHTML = '<i class="fas fa-plus"></i>';
                            showNotification(`${seriesTitle} retiré de votre liste`, 'info');
                        }, 300);
                    }
                }, 150);
            });
        });
        
        // Ajouter une animation au chargement de la page
        window.addEventListener('load', function() {
            movieCards.forEach((card, index) => {
                setTimeout(() => {
                    card.classList.add('opacity-100');
                    card.classList.remove('opacity-0', 'translate-y-10');
                }, 100 * index);
            });
        });
        
        // Animation au survol des badges d'épisode
        const episodeBadges = document.querySelectorAll('.card-badge');
        episodeBadges.forEach(badge => {
            badge.addEventListener('mouseenter', function() {
                this.classList.add('scale-110');
            });
            
            badge.addEventListener('mouseleave', function() {
                this.classList.remove('scale-110');
            });
        });
    });
</script>
<style>
    :root {
        --film-red: #e50914;
        --film-dark: #141414;
        --film-gray: #1f1f1f;
    }
    
    body {
        background-color: var(--film-dark);
        color: #ffffff;
        font-family: 'Arial', sans-serif;
    }
    
    .bg-film-red {
        background-color: var(--film-red);
    }
    
    .bg-film-gray {
        background-color: var(--film-gray);
    }
    
    .movie-card {
        position: relative;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    
    .movie-card:hover {
        transform: translateY(-10px) scale(1.03);
        box-shadow: 0 30px 60px rgba(0, 0, 0, 0.5);
        z-index: 10;
    }
    
    .movie-card:hover .card-overlay {
        opacity: 1;
    }
    
    .movie-card:hover .card-img {
        transform: scale(1.1);
        filter: brightness(0.7);
    }
    
    .card-img {
        transition: all 0.8s ease;
        height: 100%;
        object-fit: cover;
    }
    
    .card-badge {
        background-color: var(--film-red);
        transition: all 0.3s ease;
    }
    
    .movie-card:hover .card-badge {
        transform: translateX(-5px) scale(1.1);
        box-shadow: 0 5px 15px rgba(229, 9, 20, 0.4);
    }
    
    .card-title {
        transition: all 0.3s ease;
    }
    
    .movie-card:hover .card-title {
        transform: translateY(-5px);
    }
    
    .rating-stars {
        color: #ffc107;
    }
    
    .watch-button {
        background-color: var(--film-red);
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px rgba(229, 9, 20, 0.2);
    }
    
    .watch-button:hover {
        background-color: #f11722;
        box-shadow: 0 7px 14px rgba(229, 9, 20, 0.4);
    }
    
    .add-to-list-button {
        transition: all 0.3s ease;
    }
    
    .add-to-list-button.added {
        background-color: #2ecc71;
        border-color: #2ecc71;
    }
    
    .pulse-animation {
        animation: pulse 1.5s infinite;
    }
    
    @keyframes pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(229, 9, 20, 0.7);
        }
        70% {
            box-shadow: 0 0 0 10px rgba(229, 9, 20, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(229, 9, 20, 0);
        }
    }
    
    .notification {
        position: fixed;
        top: 20px;
        right: 20px;
        background-color: #2ecc71;
        color: white;
        padding: 12px 24px;
        border-radius: 4px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        z-index: 100;
        transform: translateX(200%);
        transition: transform 0.4s cubic-bezier(0.68, -0.55, 0.27, 1.55);
    }
    
    .notification.show {
        transform: translateX(0);
    }
    
    .genre-tag {
        background-color: rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        padding: 3px 8px;
        font-size: 10px;
        transition: all 0.3s ease;
    }
    
    .movie-card:hover .genre-tag {
        background-color: rgba(229, 9, 20, 0.3);
    }
    
    .play-icon-circle {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) scale(0);
        background-color: rgba(229, 9, 20, 0.8);
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    
    .movie-card:hover .play-icon-circle {
        transform: translate(-50%, -50%) scale(1);
        opacity: 1;
    }

    /* Responsive fixes for movie cards */
    @media (max-width: 640px) {
        .card-img {
            height: 220px;
        }
    }

    @media (min-width: 641px) and (max-width: 1023px) {
        .card-img {
            height: 240px;
        }
    }

    @media (min-width: 1024px) {
        .card-img {
            height: 260px;
        }
    }
</style>