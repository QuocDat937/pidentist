// Pi Dentist — Header (sticky scroll, mobile menu toggle)
// Vanilla JS — NO jQuery

document.addEventListener('DOMContentLoaded', () => {
  const header    = document.getElementById('siteHeader');
  const hamburger = document.getElementById('hamburger');
  const body      = document.body;

  // ─── 1. Sticky Header — add/remove .scrolled ───
  const SCROLL_THRESHOLD = 50;
  let lastScrollY = 0;
  let ticking = false;

  function updateHeader() {
    const scrollY = window.scrollY;
    if (header) {
      header.classList.toggle('scrolled', scrollY > SCROLL_THRESHOLD);
    }
    lastScrollY = scrollY;
    ticking = false;
  }

  window.addEventListener('scroll', () => {
    if (!ticking) {
      window.requestAnimationFrame(updateHeader);
      ticking = true;
    }
  }, { passive: true });

  // Initial check (page might load scrolled)
  updateHeader();

  // ─── 2. Mobile Menu Toggle ───
  if (hamburger) {
    hamburger.addEventListener('click', () => {
      const isOpen = body.classList.toggle('mobile-nav-open');
      hamburger.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    });
  }

  // ─── 3. Close mobile nav on link click ───
  const mobileNav = document.getElementById('mobileNav');
  if (mobileNav) {
    mobileNav.addEventListener('click', (e) => {
      const target = e.target;

      // Close if clicked on a link
      if (target.tagName === 'A') {
        closeMobileNav();
      }

      // Close if clicked on overlay background (not inner content)
      if (target === mobileNav) {
        closeMobileNav();
      }
    });
  }

  // ─── 4. Close mobile nav on resize beyond breakpoint ───
  const MOBILE_BREAKPOINT = 991;

  function handleResize() {
    if (window.innerWidth > MOBILE_BREAKPOINT && body.classList.contains('mobile-nav-open')) {
      closeMobileNav();
    }
  }

  window.addEventListener('resize', handleResize, { passive: true });

  // ─── 5. Close mobile nav on Escape key ───
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && body.classList.contains('mobile-nav-open')) {
      closeMobileNav();
      hamburger?.focus();
    }
  });

  // ─── Helper: Close mobile nav ───
  function closeMobileNav() {
    body.classList.remove('mobile-nav-open');
    if (hamburger) {
      hamburger.setAttribute('aria-expanded', 'false');
    }
  }
});
