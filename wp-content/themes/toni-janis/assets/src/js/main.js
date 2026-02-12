/**
 * Toni Janis - Main JavaScript
 *
 * @package ToniJanis
 */

import { initNavigation } from './components/navigation.js';
import { initAnimations } from './components/animations.js';
import { initSliders } from './components/slider.js';

// Dark Mode Store
document.addEventListener('alpine:init', () => {
    Alpine.store('darkMode', {
        on: localStorage.getItem('toja-dark-mode') === 'true',
        toggle() {
            this.on = !this.on;
            localStorage.setItem('toja-dark-mode', this.on);
            document.documentElement.classList.toggle('dark', this.on);
        },
        init() {
            document.documentElement.classList.toggle('dark', this.on);
        }
    });
});

document.addEventListener('DOMContentLoaded', () => {
    initNavigation();
    initAnimations();
    initSliders();
});
