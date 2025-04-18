document.addEventListener('DOMContentLoaded', function() {
    const video = document.getElementById('videoPlayer');
    
    // Save watch progress
    if (video) {
        video.addEventListener('timeupdate', function() {
            if (video.currentTime > 0) {
                const progress = (video.currentTime / video.duration) * 100;
                localStorage.setItem('watchProgress_' + video.dataset.episodeId, video.currentTime);
                
                // Update progress bar in UI
                const activeEpisode = document.querySelector('.episode-item.active');
                if (activeEpisode) {
                    const progressBar = activeEpisode.querySelector('.bg-film-red');
                    if (progressBar) {
                        progressBar.style.width = progress + '%';
                    }
                }
            }
        });
        
        // Resume playback from saved position
        const savedTime = localStorage.getItem('watchProgress_' + video.dataset.episodeId);
        if (savedTime && savedTime > 0) {
            video.currentTime = savedTime;
        }
    }
    
    // Auto-hide flash notification
    const flashNotification = document.getElementById('flash-notification');
    if (flashNotification) {
        setTimeout(() => {
            flashNotification.classList.add('opacity-0');
            setTimeout(() => {
                flashNotification.style.display = 'none';
            }, 500);
        }, 3000);
    }
    
    // Add shine effect to buttons
    document.querySelectorAll('.bg-film-red').forEach(button => {
        const shine = document.createElement('div');
        shine.classList.add('shine-effect');
        
        button.addEventListener('mouseenter', () => {
            anime({
                targets: shine,
                translateX: ['0%', '200%'],
                easing: 'easeInOutSine',
                duration: 800,
                delay: 200
            });
        });
    });
});