/**
 * Scroll handling utilities
 */

// Smooth scroll to element
export const smoothScroll = (target, duration = 1000) => {
    const targetElement = typeof target === 'string' 
        ? document.querySelector(target) 
        : target;
    
    if (!targetElement) return;
    
    const targetPosition = targetElement.getBoundingClientRect().top + window.pageYOffset;
    const startPosition = window.pageYOffset;
    const distance = targetPosition - startPosition;
    let startTime = null;

    const animation = (currentTime) => {
        if (startTime === null) startTime = currentTime;
        const timeElapsed = currentTime - startTime;
        const progress = Math.min(timeElapsed / duration, 1);
        
        // Easing function (easeInOutQuad)
        const ease = progress < 0.5 
            ? 2 * progress * progress 
            : 1 - Math.pow(-2 * progress + 2, 2) / 2;
        
        window.scrollTo(0, startPosition + distance * ease);
        
        if (timeElapsed < duration) {
            requestAnimationFrame(animation);
        }
    };

    requestAnimationFrame(animation);
};

// Header scroll effect
export const initHeaderScroll = () => {
    const header = document.querySelector('.header');
    if (!header) return;
    
    let lastScroll = 0;
    const scrollThreshold = 100;

    window.addEventListener('scroll', () => {
        const currentScroll = window.pageYOffset;
        
        if (currentScroll > scrollThreshold) {
            header.classList.add('header--scrolled');
        } else {
            header.classList.remove('header--scrolled');
        }
        
        // Hide/show header on scroll direction
        if (currentScroll > lastScroll && currentScroll > scrollThreshold) {
            header.classList.add('header--hidden');
        } else {
            header.classList.remove('header--hidden');
        }
        
        lastScroll = currentScroll;
    });
};
