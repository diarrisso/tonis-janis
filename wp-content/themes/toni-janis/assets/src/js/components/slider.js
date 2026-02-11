/**
 * Slider Component - Swiper.js Integration
 *
 * Initialisiert alle Swiper Slider auf der Seite.
 * Verwendet data-Attribute für die Konfiguration.
 */

import Swiper from 'swiper';
import { Navigation, Pagination, Autoplay, EffectFade } from 'swiper/modules';

/**
 * Standard Slider Konfigurationen
 */
const SLIDER_PRESETS = {
    // Standard Slider mit Navigation und Pagination
    default: {
        modules: [Navigation, Pagination],
        slidesPerView: 1,
        spaceBetween: 24,
        loop: true,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
    },

    // Testimonials / Referenzen Slider
    testimonials: {
        modules: [Navigation, Pagination, Autoplay],
        slidesPerView: 1,
        spaceBetween: 32,
        loop: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        breakpoints: {
            768: { slidesPerView: 2 },
            1024: { slidesPerView: 3 },
        },
    },

    // Galerie / Projekte Slider
    gallery: {
        modules: [Navigation, Pagination],
        slidesPerView: 1,
        spaceBetween: 16,
        loop: true,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        breakpoints: {
            640: { slidesPerView: 2 },
            1024: { slidesPerView: 3 },
        },
    },

    // Partner / Logo Slider
    logos: {
        modules: [Autoplay],
        slidesPerView: 2,
        spaceBetween: 32,
        loop: true,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
        breakpoints: {
            640: { slidesPerView: 3 },
            768: { slidesPerView: 4 },
            1024: { slidesPerView: 5 },
        },
    },

    // Hero / Fullscreen Slider mit Fade
    hero: {
        modules: [Autoplay, EffectFade, Pagination],
        slidesPerView: 1,
        effect: 'fade',
        loop: true,
        autoplay: {
            delay: 6000,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
    },
};

/**
 * Alle Swiper Slider initialisieren
 */
export function initSliders() {
    const sliderElements = document.querySelectorAll('[data-swiper]');

    sliderElements.forEach((el) => {
        const preset = el.dataset.swiper || 'default';
        const config = SLIDER_PRESETS[preset] || SLIDER_PRESETS.default;

        new Swiper(el, config);
    });
}
