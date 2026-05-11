// Pi Dentist — Service TOC (Table of Contents)
// Highlights active TOC link based on scroll position.
// Uses IntersectionObserver — no jQuery.

document.addEventListener('DOMContentLoaded', function () {
  var toc = document.querySelector('.service-toc');
  if (!toc) return;

  var links = toc.querySelectorAll('.service-toc__link');
  var sections = [];

  links.forEach(function (link) {
    var href = link.getAttribute('href');
    if (href && href.startsWith('#')) {
      var section = document.getElementById(href.substring(1));
      if (section) {
        sections.push({ el: section, link: link });
      }
    }
  });

  if (sections.length === 0) return;

  // IntersectionObserver for scroll-spy
  var observer = new IntersectionObserver(
    function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          // Remove active from all
          links.forEach(function (l) {
            l.classList.remove('active');
          });
          // Find matching link
          sections.forEach(function (s) {
            if (s.el === entry.target) {
              s.link.classList.add('active');
            }
          });
        }
      });
    },
    {
      rootMargin: '-80px 0px -60% 0px',
      threshold: 0
    }
  );

  sections.forEach(function (s) {
    observer.observe(s.el);
  });

  // Smooth scroll on TOC link click
  links.forEach(function (link) {
    link.addEventListener('click', function (e) {
      var href = this.getAttribute('href');
      if (href && href.startsWith('#')) {
        e.preventDefault();
        var target = document.getElementById(href.substring(1));
        if (target) {
          target.scrollIntoView({ behavior: 'smooth', block: 'start' });
          // Update URL hash without jump
          history.replaceState(null, null, href);
        }
      }
    });
  });
});
