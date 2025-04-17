/**
 * FilmWave Video Preview Handler
 * 
 * This script handles video previews on hover for movie/series cards
 * throughout the FilmWave application.
 */

class VideoPreviewHandler {
    constructor(options = {}) {
        this.options = {
            cardSelector: '.movie-card',
            containerSelector: '.relative',
            videoSelector: '.video-preview',
            preloadDistance: 100, // pixels from viewport to start preloading
            playDelay: 300, // ms delay before playing video
            opacity: 0.6, // opacity value when visible
            ...options
        };
        
        this.init();
    }
    
    init() {
        // Store references to DOM elements
        this.videoContainers = document.querySelectorAll(
            `${this.options.cardSelector} ${this.options.containerSelector}`
        );
        
        // Initialize event listeners
        this.addEventListeners();
        
        // Set up lazy loading if IntersectionObserver is available
        if ('IntersectionObserver' in window) {
            this.setupLazyLoading();
        }
        
        console.log(`VideoPreviewHandler initialized with ${this.videoContainers.length} video containers`);
    }
    
    addEventListeners() {
        this.videoContainers.forEach(container => {
            // Mouse enter event - start playing video
            container.addEventListener('mouseenter', this.handleMouseEnter.bind(this));
            
            // Mouse leave event - pause video
            container.addEventListener('mouseleave', this.handleMouseLeave.bind(this));
            
            // Touch events for mobile devices
            container.addEventListener('touchstart', this.handleTouchStart.bind(this), { passive: true });
        });
    }
    
    handleMouseEnter(event) {
        const container = event.currentTarget;
        const video = container.querySelector(this.options.videoSelector);
        
        if (!video) return;
        
        const videoSrc = video.getAttribute('data-src');
        
        // Load video if not already loaded
        if (!video.src && videoSrc) {
            video.src = videoSrc;
            video.load();
        }
        
        // Delay playing the video slightly
        setTimeout(() => {
            this.playVideo(video);
        }, this.options.playDelay);
    }
    
    handleMouseLeave(event) {
        const container = event.currentTarget;
        const video = container.querySelector(this.options.videoSelector);
        
        if (!video) return;
        
        this.pauseVideo(video);
    }
    
    handleTouchStart(event) {
        const container = event.currentTarget;
        const video = container.querySelector(this.options.videoSelector);
        
        if (!video) return;
        
        // Toggle video playback on touch
        if (video.paused) {
            this.playVideo(video);
            
            // Pause all other videos
            this.pauseOtherVideos(video);
        } else {
            this.pauseVideo(video);
        }
    }
    
    playVideo(video) {
        video.play()
            .then(() => {
                video.classList.add('opacity-' + (this.options.opacity * 100));
            })
            .catch(err => {
                console.log('Video playback prevented:', err);
                // Fall back to showing the video without playing
                video.classList.add('opacity-' + (this.options.opacity * 100));
            });
    }
    
    pauseVideo(video) {
        video.pause();
        video.classList.remove('opacity-' + (this.options.opacity * 100));
    }
    
    pauseOtherVideos(currentVideo) {
        const allVideos = document.querySelectorAll(this.options.videoSelector);
        
        allVideos.forEach(video => {
            if (video !== currentVideo) {
                this.pauseVideo(video);
            }
        });
    }
    
    setupLazyLoading() {
        const options = {
            rootMargin: `${this.options.preloadDistance}px`,
            threshold: 0.1
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const container = entry.target;
                    const video = container.querySelector(this.options.videoSelector);
                    
                    if (video) {
                        const videoSrc = video.getAttribute('data-src');
                        
                        // Preload video when near viewport
                        if (!video.src && videoSrc) {
                            video.setAttribute('preload', 'metadata');
                            video.src = videoSrc;
                        }
                    }
                    
                    // Stop observing once loaded
                    observer.unobserve(container);
                }
            });
        }, options);
        
        // Start observing all video containers
        this.videoContainers.forEach(container => {
            observer.observe(container);
        });
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.videoPreviewHandler = new VideoPreviewHandler({
        // Custom options can be passed here
        opacity: 0.8,
        playDelay: 400
    });
});

// Export for module usage
if (typeof module !== 'undefined' && module.exports) {
    module.exports = VideoPreviewHandler;
} 