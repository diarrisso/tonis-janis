/**
 * Navigation Component
 *
 * Handles scroll behavior and active menu items.
 */

export function initNavigation() {
    const header = document.getElementById('site-header');
    if (!header) return;

    // Highlight active menu item based on current URL
    const currentPath = window.location.pathname;
    const menuLinks = header.querySelectorAll('.main-navigation a');

    menuLinks.forEach(link => {
        const href = new URL(link.href).pathname;
        if (href === currentPath) {
            link.classList.add('text-kiwi-green', 'font-semibold');
        }
    });

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', (e) => {
            const targetId = anchor.getAttribute('href');
            if (targetId === '#') return;

            const target = document.querySelector(targetId);
            if (target) {
                e.preventDefault();
                const headerHeight = header.offsetHeight;
                const targetPosition = target.getBoundingClientRect().top + window.scrollY - headerHeight;

                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });
}
