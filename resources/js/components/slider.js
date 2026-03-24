/**
 * Slider component
 * Handles both main slider and products slider
 */

class Slider {
    constructor(container, options = {}) {
        this.container = container;
        this.options = {
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplay: false,
            autoplaySpeed: 3000,
            arrows: true,
            dots: true,
            infinite: true,
            ...options
        };
        
        this.init();
    }
    
    init() {
        console.log('Slider initialized:', this.container);
        // Здесь будет логика инициализации слайдера
    }
}

// Initialize sliders on page load
document.addEventListener('DOMContentLoaded', () => {
    const mainSliders = document.querySelectorAll('.slider--main');
    const productSliders = document.querySelectorAll('.slider--products');
    
    mainSliders.forEach(slider => new Slider(slider));
    productSliders.forEach(slider => new Slider(slider, {
        slidesToShow: 4,
        autoplay: true
    }));
});

export default Slider;
