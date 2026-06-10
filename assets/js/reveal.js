// Pi Dentist — Scroll Reveal
// IntersectionObserver-based reveal animation for .reveal elements.
// Adds .revealed class on viewport entry, then unobserves for performance.
// Fallback: if IntersectionObserver is not supported, reveal all immediately.

document.addEventListener('DOMContentLoaded', function () {
  var revealElements = document.querySelectorAll(
    '.reveal, .reveal-left, .reveal-right, .reveal-scale'
  );

  if (!revealElements.length) {
    return;
  }

  // Fallback cho browser cũ không hỗ trợ IntersectionObserver
  if (!('IntersectionObserver' in window)) {
    revealElements.forEach(function (el) {
      el.classList.add('revealed');
    });
    return;
  }

  var observer = new IntersectionObserver(
    function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('revealed');
          observer.unobserve(entry.target);
        }
      });
    },
    {
      threshold: 0,
      rootMargin: '0px 0px -50px 0px',
    }
  );

  revealElements.forEach(function (el) {
    observer.observe(el);
  });
});
