// Pi Dentist — Smooth Scroll
// Intercept anchor links (href starting with #) and scroll smoothly
// with offset for sticky header. Updates URL hash via pushState.

document.addEventListener('DOMContentLoaded', function () {
  var HEADER_OFFSET = 80;

  document.addEventListener('click', function (e) {
    var link = e.target.closest('a[href^="#"]');
    if (!link) {
      return;
    }

    var hash = link.getAttribute('href');

    // Skip empty hash or just "#"
    if (!hash || hash === '#') {
      return;
    }

    var target = document.querySelector(hash);
    if (!target) {
      return;
    }

    e.preventDefault();

    var targetTop =
      target.getBoundingClientRect().top + window.pageYOffset - HEADER_OFFSET;

    window.scrollTo({
      top: targetTop,
      behavior: 'smooth',
    });

    // Update URL hash without jumping
    if (history.pushState) {
      history.pushState(null, null, hash);
    }
  });
});
