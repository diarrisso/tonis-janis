/**
 * Toni Janis - Main JavaScript
 *
 * @package ToniJanis
 */

import { initNavigation } from './components/navigation.js';
import { initAnimations } from './components/animations.js';
import { initSliders } from './components/slider.js';

document.addEventListener('DOMContentLoaded', () => {
    initNavigation();
    initAnimations();
    initSliders();
});
