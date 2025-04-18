document.addEventListener('DOMContentLoaded', function() {
    // Get all movie cards
    const movieCards = document.querySelectorAll('.movie-card');
    
    // Detect system preference for dark mode
    const prefersDarkMode = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
    
    // Modify shine effect based on color mode
    const shineOpacity = prefersDarkMode ? '0.15' : '0.3';
    
    // Add animations and interactions to each card
    movieCards.forEach(card => {
        const watchBtn = card.querySelector('.watch-btn');
        const link = card.querySelector('a[href*="watch.episode"]');
        const image = card.querySelector('img');
        
        // Add shadow effect on hover
        card.addEventListener('mouseenter', () => {
            // Add highlight border and shadow based on mode
            if (prefersDarkMode) {
                card.style.boxShadow = '0 0 20px rgba(229, 9, 20, 0.3)';
                card.style.borderColor = 'rgba(229, 9, 20, 0.5)';
            } else {
                card.style.boxShadow = '0 10px 25px rgba(0, 0, 0, 0.2)';
            }
        });
        
        // Add subtle tilt effect on mousemove (lighter than before)
        card.addEventListener('mousemove', (e) => {
            const cardRect = card.getBoundingClientRect();
            const cardCenterX = cardRect.left + cardRect.width / 2;
            const cardCenterY = cardRect.top + cardRect.height / 2;
            const mouseX = e.clientX - cardCenterX;
            const mouseY = e.clientY - cardCenterY;
            
            // Calculate rotation based on mouse position (more subtle now)
            const rotateY = mouseX * 0.03;
            const rotateX = -mouseY * 0.03;
            
            // Apply the transform (milder effect)
            card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale3d(1.01, 1.01, 1.01)`;
            
            // Add shine effect to the image section
            const shine = card.querySelector('.shine-effect');
            if (shine) {
                // Calculate position for shine effect
                const x = (e.clientX - cardRect.left) / cardRect.width * 100;
                const y = (e.clientY - cardRect.top) / cardRect.height * 100;
                shine.style.background = `radial-gradient(circle at ${x}% ${y}%, rgba(255,255,255,${shineOpacity}) 0%, rgba(255,255,255,0) 60%)`;
                shine.style.opacity = '1';
            }
            
            // Add subtle parallax effect to image
            if (image) {
                // Make this effect even more subtle
                const xPos = (mouseX / cardRect.width) * 5;
                const yPos = (mouseY / cardRect.height) * 5;
                image.style.transform = `translateX(${xPos}px) translateY(${yPos}px)`;
            }
        });
        
        // Reset all effects on mouse leave
        card.addEventListener('mouseleave', () => {
            card.style.transform = '';
            card.style.boxShadow = '';
            card.style.borderColor = '';
            
            const shine = card.querySelector('.shine-effect');
            if (shine) {
                shine.style.opacity = '0';
            }
            
            if (image) {
                image.style.transform = '';
            }
        });
        
        // Handle click on watch button
        if (watchBtn && link) {
            watchBtn.addEventListener('click', () => {
                // Add click animation
                watchBtn.classList.add('animate-pulse');
                watchBtn.style.backgroundColor = '#b91c1c'; // darker red on click
                
                // Navigate after small delay for animation
                setTimeout(() => {
                    window.location.href = link.getAttribute('href');
                }, 200);
            });
        }
    });
    
    // Check if anime.js is loaded for entrance animation
    if (typeof anime !== 'undefined') {
        // Add staggered entrance animation on page load
        anime({
            targets: '.movie-card',
            opacity: [0, 1],
            translateY: [20, 0], // reduced movement
            delay: anime.stagger(80, {start: 300}), // shorter delay between cards
            easing: 'easeOutQuad',
            duration: 600
        });
    }
});

document.addEventListener('alpine:init', () => {
    // Initialize staggered animation for cards
    const cards = document.querySelectorAll('.movie-card');
    anime({
        targets: cards,
        opacity: [0, 1],
        translateY: [20, 0],
        scale: [0.9, 1],
        delay: anime.stagger(100, {start: 300}),
        easing: 'easeOutQuad',
        duration: 500
    });
    
    // Add event listeners for card interactions
    cards.forEach(card => {
        // Shine effect on hover
        card.addEventListener('mouseenter', () => {
            const shineEffect = card.querySelector('.shine-effect');
            if (shineEffect) {
                anime({
                    targets: shineEffect,
                    translateX: ['0%', '200%'],
                    easing: 'easeInOutSine',
                    duration: 800,
                    delay: 200
                });
            }
        });
        
        // Handle watch button click
        const watchBtn = card.querySelector('.watch-btn');
        if (watchBtn) {
            watchBtn.addEventListener('click', (e) => {
                e.preventDefault();
                const link = card.querySelector('a').href;
                window.location.href = link;
            });
        }
    });
});