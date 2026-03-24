/**
 * Main JavaScript entry point
 */

// Import bootstrap (third-party libraries initialization)
import './bootstrap';

// Import components
import './components/slider';
import './components/faq-accordion';
import './components/mobile-menu';
import './components/modal';
import './components/phone-mask';
import './components/tabs';
import './components/particles';
import './components/lightbox';
import './components/product-options';
import './components/filter-tabs';
import './components/load-more';
import './components/faq-search';
import './components/request-form';
import './components/landing-particles';

// Import page-specific scripts based on body class or data attribute
document.addEventListener('DOMContentLoaded', function() {
    const pageBody = document.body;
    
    // Initialize common components
    initCommonComponents();
    
    // Initialize page-specific components
    if (pageBody.classList.contains('page-home')) {
        import('./pages/home');
    }
    if (pageBody.classList.contains('page-about')) {
        import('./pages/about');
    }
    if (pageBody.classList.contains('page-blog')) {
        import('./pages/blog');
    }
    if (pageBody.classList.contains('page-blog-article')) {
        import('./pages/blog-article');
    }
    if (pageBody.classList.contains('page-catalog')) {
        import('./pages/catalog');
    }
    if (pageBody.classList.contains('page-catalog-category')) {
        import('./pages/catalog-category');
    }
    if (pageBody.classList.contains('page-contacts')) {
        import('./pages/contacts');
    }
    if (pageBody.classList.contains('page-equipment')) {
        import('./pages/equipment');
    }
    if (pageBody.classList.contains('page-faq')) {
        import('./pages/faq');
    }
    if (pageBody.classList.contains('page-landing-laser')) {
        import('./pages/landing-laser');
    }
    if (pageBody.classList.contains('page-portfolio')) {
        import('./pages/portfolio');
    }
    if (pageBody.classList.contains('page-portfolio-project')) {
        import('./pages/portfolio-project');
    }
    if (pageBody.classList.contains('page-product')) {
        import('./pages/product');
    }
    if (pageBody.classList.contains('page-privacy')) {
        import('./pages/privacy');
    }
    if (pageBody.classList.contains('page-request')) {
        import('./pages/request');
    }
    if (pageBody.classList.contains('page-search')) {
        import('./pages/search');
    }
    if (pageBody.classList.contains('page-service')) {
        import('./pages/service');
    }
    if (pageBody.classList.contains('page-uslugi')) {
        import('./pages/uslugi');
    }
    if (pageBody.classList.contains('page-404')) {
        import('./pages/404');
    }
});

function initCommonComponents() {
    // Initialize components that should run on every page
    console.log('Common components initialized');
}
