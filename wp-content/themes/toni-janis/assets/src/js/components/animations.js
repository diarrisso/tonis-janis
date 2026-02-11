/**
 * Animations Component
 *
 * Intersection Observer for scroll-triggered animations.
 */

export function initAnimations() {
    const animatedElements = document.querySelectorAll('[data-animate]');
    if (!animatedElements.length) return;

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-in');
                    observer.unobserve(entry.target);
                }
            });
        },
        {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px',
        }
    );

    animatedElements.forEach(el => {
        el.classList.add('animate-prepare');
        observer.observe(el);
    });
}
