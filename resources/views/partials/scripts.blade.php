<script>
    // Sample data for featured movies
    const featuredMovies = [
        {
            title: "The Last Kingdom: Seven Kings Must Die",
            year: "2025",
            duration: "120 min",
            description: "In the wake of King Edward's death, Uhtred of Bebbanburg and his comrades adventure across a fractured kingdom in the hopes of uniting England at last.",
            background: "https://source.unsplash.com/random/1200x600/?movie,action"
        },
        {
            title: "Interstellar: Beyond the Stars",
            year: "2024",
            duration: "145 min",
            description: "A team of explorers travel through a wormhole in space in an attempt to ensure humanity's survival on a distant planet.",
            background: "https://source.unsplash.com/random/1200x600/?space,scifi"
        },
        {
            title: "The Shadow Protocol",
            year: "2025",
            duration: "132 min",
            description: "An elite spy must uncover a global conspiracy while dealing with threats from unknown enemies lurking in the shadows.",
            background: "https://source.unsplash.com/random/1200x600/?spy,thriller"
        }
    ];

    document.addEventListener('DOMContentLoaded', () => {
        // Sidebar functionality
        const sidebar = document.getElementById('sidebar');
        const sidebarTab = document.getElementById('sidebar-tab');
        const overlay = document.getElementById('sidebar-overlay');
        let isExpanded = false;
        
        // Function to fully expand the sidebar
        function expandSidebar() {
            sidebar.classList.remove('-translate-x-[calc(100%-10px)]');
            sidebar.classList.remove('-translate-x-[calc(100%-30px)]');
            sidebar.classList.remove('hover:-translate-x-[calc(100%-30px)]');
            sidebar.classList.add('translate-x-0');
            overlay.classList.remove('hidden');
            isExpanded = true;
        }
        
        // Function to collapse the sidebar
        function collapseSidebar() {
            sidebar.classList.remove('translate-x-0');
            sidebar.classList.add('-translate-x-[calc(100%-10px)]');
            sidebar.classList.add('hover:-translate-x-[calc(100%-30px)]');
            overlay.classList.add('hidden');
            isExpanded = false;
        }
        
        // Toggle sidebar on tab click
        sidebarTab.addEventListener('click', () => {
            if (isExpanded) {
                collapseSidebar();
            } else {
                expandSidebar();
            }
        });
        
        // Close sidebar when clicking on overlay
        overlay.addEventListener('click', collapseSidebar);
        
        // Close sidebar on ESC key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && isExpanded) {
                collapseSidebar();
            }
        });
        
        // Listen for clicks on any icon in the document
        document.addEventListener('click', (e) => {
            // Find if the clicked element or any of its parents is an icon
            const icon = e.target.closest('.fas, .fab');
            
            // If icon is clicked and not within the sidebar or sidebar tab, expand sidebar
            if (icon && !icon.closest('#sidebar') && !icon.closest('#sidebar-tab')) {
                e.preventDefault();
                expandSidebar();
            }
        });
        
        // Carousel functionality
        const heroCarousel = document.getElementById('hero-carousel');
        const featuredTitle = document.getElementById('featured-title');
        const featuredYear = document.getElementById('featured-year');
        const featuredDuration = document.getElementById('featured-duration');
        const featuredDescription = document.getElementById('featured-description');
        
        // Initialize variables
        let currentSlide = 0;
        
        // Update featured movie
        function updateFeaturedMovie() {
            if (!heroCarousel) return;
            
            if (featuredTitle) featuredTitle.textContent = featuredMovies[currentSlide].title;
            if (featuredYear) featuredYear.textContent = featuredMovies[currentSlide].year;
            if (featuredDuration) featuredDuration.textContent = featuredMovies[currentSlide].duration;
            if (featuredDescription) featuredDescription.textContent = featuredMovies[currentSlide].description;
            
            heroCarousel.style.backgroundImage = `url(${featuredMovies[currentSlide].background})`;
            heroCarousel.style.backgroundSize = 'cover';
            heroCarousel.style.backgroundPosition = 'center';
        }
        
        // Initialize carousel
        updateFeaturedMovie();
        
        // Auto-rotate carousel
        setInterval(() => {
            currentSlide = (currentSlide + 1) % featuredMovies.length;
            updateFeaturedMovie();
        }, 8000);
        
        // Navbar scroll effect
        window.addEventListener('scroll', () => {
            const navbar = document.getElementById('navbar');
            if (navbar) {
                if (window.scrollY > 50) {
                    navbar.classList.add('bg-film-dark/95', 'backdrop-blur-md', 'shadow-lg');
                } else {
                    navbar.classList.remove('bg-film-dark/95', 'backdrop-blur-md', 'shadow-lg');
                }
            }
        });
    });
</script>