// ==========================================
// Cover Blocks Arrow Click Handler
// ==========================================
document.addEventListener('DOMContentLoaded', () => {
    const coverArrows = document.querySelectorAll('.t-cover__arrow-wrapper');

    coverArrows.forEach(arrow => {
        arrow.addEventListener('click', () => {
            const currentCover = arrow.closest('.t-cover');
            const nextSection = currentCover.nextElementSibling;

            if (nextSection) {
                const headerHeight = document.getElementById('header').offsetHeight;
                const targetPosition = nextSection.getBoundingClientRect().top + window.pageYOffset - headerHeight;

                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });
});

// ==========================================
// Image Slider
// ==========================================
let currentSlide = 0;
const sliderTrack = document.getElementById('sliderTrack');
const slides = document.querySelectorAll('.slide');
const sliderDots = document.getElementById('sliderDots');

// Create dots
slides.forEach((_, index) => {
    const dot = document.createElement('div');
    dot.classList.add('slider-dot');
    if (index === 0) dot.classList.add('active');
    dot.addEventListener('click', () => goToSlide(index));
    sliderDots.appendChild(dot);
});

const dots = document.querySelectorAll('.slider-dot');

function updateSlider() {
    if (sliderTrack) {
        sliderTrack.style.transform = `translateX(-${currentSlide * 100}%)`;
    }

    dots.forEach((dot, index) => {
        dot.classList.toggle('active', index === currentSlide);
    });
}

function moveSlider(direction) {
    currentSlide += direction;

    if (currentSlide < 0) {
        currentSlide = slides.length - 1;
    } else if (currentSlide >= slides.length) {
        currentSlide = 0;
    }

    updateSlider();
}

function goToSlide(index) {
    currentSlide = index;
    updateSlider();
}

// Auto-play slider
let sliderInterval = setInterval(() => {
    moveSlider(1);
}, 5000);

// Pause on hover
const sliderContainer = document.querySelector('.slider-container');
if (sliderContainer) {
    sliderContainer.addEventListener('mouseenter', () => {
        clearInterval(sliderInterval);
    });

    sliderContainer.addEventListener('mouseleave', () => {
        sliderInterval = setInterval(() => {
            moveSlider(1);
        }, 5000);
    });
}

// ==========================================
// Products Slider
// ==========================================
let currentProductSlide = 0;
const productsTrack = document.getElementById('productsTrack');
const productCards = document.querySelectorAll('.product-card');

function updateProductsSlider() {
    if (productsTrack) {
        const slideWidth = productCards[0].offsetWidth + 30; // card width + gap
        productsTrack.style.transform = `translateX(-${currentProductSlide * slideWidth}px)`;
    }
}

function moveProductsSlider(direction) {
    const maxSlide = productCards.length - 3; // Show 3 cards at a time

    currentProductSlide += direction;

    if (currentProductSlide < 0) {
        currentProductSlide = 0;
    } else if (currentProductSlide > maxSlide) {
        currentProductSlide = maxSlide;
    }

    updateProductsSlider();
}

// Update on window resize
window.addEventListener('resize', () => {
    updateProductsSlider();
});

// ==========================================
// FAQ Accordion
// ==========================================
function toggleFaq(button) {
    const faqItem = button.closest('.faq-item');
    const isActive = faqItem.classList.contains('active');

    // Close all FAQ items
    document.querySelectorAll('.faq-item').forEach(item => {
        item.classList.remove('active');
    });

    // Open clicked item if it wasn't active
    if (!isActive) {
        faqItem.classList.add('active');
    }
}

// ==========================================
// Mobile Menu
// ==========================================
function toggleMobileMenu() {
    const mobileMenu = document.getElementById('mobileMenu');
    const burger = document.getElementById('burger');

    mobileMenu.classList.toggle('active');
    burger.classList.toggle('active');

    // Prevent body scroll when menu is open
    if (mobileMenu.classList.contains('active')) {
        document.body.style.overflow = 'hidden';
    } else {
        document.body.style.overflow = '';
    }
}

// ==========================================
// Modal Functions
// ==========================================
function openCallbackModal() {
    const modal = document.getElementById('callbackModal');
    modal.classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeCallbackModal() {
    const modal = document.getElementById('callbackModal');
    modal.classList.remove('active');
    document.body.style.overflow = '';
}

// Close modal on ESC key
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        closeCallbackModal();
    }
});

// ==========================================
// Form Submissions
// ==========================================
function submitForm(event) {
    event.preventDefault();

    // Here you would normally send the form data to a server
    alert('Спасибо за заявку! Мы свяжемся с вами в ближайшее время.');

    // Reset form
    event.target.reset();
}

function submitCallback(event) {
    event.preventDefault();

    // Here you would normally send the form data to a server
    alert('Спасибо! Мы перезвоним вам в течение 15 минут.');

    // Close modal and reset form
    closeCallbackModal();
    event.target.reset();
}

// ==========================================
// Phone Number Mask
// ==========================================
document.addEventListener('DOMContentLoaded', () => {
    const phoneInputs = document.querySelectorAll('input[type="tel"]');

    phoneInputs.forEach(input => {
        input.addEventListener('input', (e) => {
            let value = e.target.value.replace(/\D/g, '');

            if (value.length > 0) {
                if (value[0] === '7' || value[0] === '8') {
                    value = value.substring(1);
                }

                let formattedValue = '+7';

                if (value.length > 0) {
                    formattedValue += ' (' + value.substring(0, 3);
                }
                if (value.length >= 4) {
                    formattedValue += ') ' + value.substring(3, 6);
                }
                if (value.length >= 7) {
                    formattedValue += '-' + value.substring(6, 8);
                }
                if (value.length >= 9) {
                    formattedValue += '-' + value.substring(8, 10);
                }

                e.target.value = formattedValue;
            }
        });

        input.addEventListener('focus', (e) => {
            if (e.target.value === '') {
                e.target.value = '+7 (';
            }
        });

        input.addEventListener('blur', (e) => {
            if (e.target.value === '+7 (' || e.target.value === '+7') {
                e.target.value = '';
            }
        });
    });
});

// ==========================================
// Header Scroll Effect
// ==========================================
let lastScroll = 0;
const header = document.getElementById('header');

window.addEventListener('scroll', () => {
    const currentScroll = window.pageYOffset;

    if (currentScroll > 100) {
        header.style.background = 'rgba(0, 0, 0, 0.98)';
        header.style.boxShadow = '0 4px 20px rgba(0, 0, 0, 0.5)';
    } else {
        header.style.background = 'rgba(0, 0, 0, 0.95)';
        header.style.boxShadow = 'none';
    }

    lastScroll = currentScroll;
});

// ==========================================
// Smooth Scroll for Anchor Links
// ==========================================
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        const href = this.getAttribute('href');

        if (href !== '#' && href.length > 1) {
            e.preventDefault();
            const target = document.querySelector(href);

            if (target) {
                const headerHeight = header.offsetHeight;
                const targetPosition = target.getBoundingClientRect().top + window.pageYOffset - headerHeight;

                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });

                // Close mobile menu if open
                const mobileMenu = document.getElementById('mobileMenu');
                if (mobileMenu.classList.contains('active')) {
                    toggleMobileMenu();
                }
            }
        }
    });
});

// ==========================================
// Lazy Loading Animation
// ==========================================
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
        }
    });
}, observerOptions);

// Observe elements for fade-in animation
document.addEventListener('DOMContentLoaded', () => {
    const elementsToAnimate = document.querySelectorAll('.service-card, .product-card, .blog-card, .portfolio-item, .faq-item');

    elementsToAnimate.forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(el);
    });
});

// ==========================================
// Scroll to Top Function
// ==========================================
function scrollToTop() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
}

// ==========================================
// Service Worker Registration (for PWA)
// ==========================================
if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        // Uncomment when you have a service worker file
        // navigator.serviceWorker.register('/sw.js')
        //     .then(registration => console.log('SW registered:', registration))
        //     .catch(error => console.log('SW registration failed:', error));
    });
}

// ==========================================
// Performance Optimization
// ==========================================
// Debounce function for resize events
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Optimized resize handler
const handleResize = debounce(() => {
    updateProductsSlider();
}, 250);

window.addEventListener('resize', handleResize);
