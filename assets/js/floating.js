// Pi Dentist — Floating CTA + Contact Widgets + Back to Top
// Vanilla JS, NO jQuery — scroll-driven show/hide

document.addEventListener('DOMContentLoaded', () => {
    const floatCta = document.getElementById('floatingCta');
    const widgets  = document.getElementById('contactWidgets');
    const backTop  = document.getElementById('backToTop');
    const hero     = document.getElementById('siteHeader');

    // Trigger point: header height + 200px buffer, fallback 800px
    const trigger = hero ? hero.offsetHeight + 200 : 800;

    /**
     * Toggle .show class on floating elements based on scroll position.
     * - floatingCta + contactWidgets: show after scrolling past header
     * - backToTop: show after 500px scroll
     */
    function update() {
        const y = window.scrollY;
        if (floatCta) floatCta.classList.toggle('show', y > trigger);
        if (widgets)  widgets.classList.toggle('show', y > trigger);
        if (backTop)  backTop.classList.toggle('show', y > 500);
    }

    // Passive scroll listener for performance
    window.addEventListener('scroll', update, { passive: true });

    // Initial check (in case page loads already scrolled)
    update();

    // Back to top: smooth scroll
    if (backTop) {
        backTop.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }
});
