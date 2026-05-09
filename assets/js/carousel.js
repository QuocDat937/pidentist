// Pi Dentist — Doctors Carousel
// Vanilla JS carousel — NO Swiper/Slick/jQuery
// Features: horizontal scroll, drag/swipe, arrows, dots, auto-play, snap, responsive, a11y

(function () {
  'use strict';

  document.addEventListener('DOMContentLoaded', function () {
    const containers = document.querySelectorAll('.pi-carousel-container');
    containers.forEach(initCarousel);
  });

  /**
   * Initialize a single carousel instance.
   * @param {HTMLElement} container
   */
  function initCarousel(container) {
    const track = container.querySelector('.pi-carousel-track');
    const prevBtn = container.querySelector('.pi-carousel-prev');
    const nextBtn = container.querySelector('.pi-carousel-next');
    const dotsWrap = container.querySelector('.pi-carousel-dots');

    if (!track) return;

    const cards = Array.from(track.children);
    if (cards.length === 0) return;

    // ─── State ─────────────────────────────────────────
    let currentIndex = 0;
    let visibleCount = getVisibleCount();
    let totalPages = Math.max(1, cards.length - visibleCount + 1);
    let autoTimer = null;
    const AUTO_INTERVAL = 5000;
    const GAP = 24; // px — matches CSS gap

    // ─── Init ──────────────────────────────────────────
    buildDots();
    updateCarousel(false);
    startAutoPlay();

    // ─── Responsive recalc ─────────────────────────────
    let resizeTimer;
    window.addEventListener('resize', function () {
      clearTimeout(resizeTimer);
      resizeTimer = setTimeout(function () {
        const newVisible = getVisibleCount();
        if (newVisible !== visibleCount) {
          visibleCount = newVisible;
          totalPages = Math.max(1, cards.length - visibleCount + 1);
          if (currentIndex > totalPages - 1) {
            currentIndex = totalPages - 1;
          }
          buildDots();
          updateCarousel(false);
        }
      }, 150);
    }, { passive: true });

    // ─── Arrow Buttons ─────────────────────────────────
    if (prevBtn) {
      prevBtn.addEventListener('click', function () {
        goTo(currentIndex - 1);
        restartAutoPlay();
      });
    }

    if (nextBtn) {
      nextBtn.addEventListener('click', function () {
        goTo(currentIndex + 1);
        restartAutoPlay();
      });
    }

    // ─── Keyboard Navigation ───────────────────────────
    container.addEventListener('keydown', function (e) {
      if (e.key === 'ArrowLeft') {
        e.preventDefault();
        goTo(currentIndex - 1);
        restartAutoPlay();
      } else if (e.key === 'ArrowRight') {
        e.preventDefault();
        goTo(currentIndex + 1);
        restartAutoPlay();
      }
    });

    // ─── Auto-play: pause on hover / focus ─────────────
    container.addEventListener('mouseenter', stopAutoPlay);
    container.addEventListener('mouseleave', startAutoPlay);
    container.addEventListener('focusin', stopAutoPlay);
    container.addEventListener('focusout', startAutoPlay);

    // ─── Touch / Mouse Drag ────────────────────────────
    let isDragging = false;
    let hasDragged = false; // true when user actually moved beyond threshold
    let startX = 0;
    let startScrollLeft = 0;
    let dragDelta = 0;
    const DRAG_THRESHOLD = 40; // px min drag to change slide
    const CLICK_THRESHOLD = 15; // px — below this, treat as click, not drag

    // Touch events
    track.addEventListener('touchstart', onDragStart, { passive: true });
    track.addEventListener('touchmove', onDragMove, { passive: false });
    track.addEventListener('touchend', onDragEnd, { passive: true });

    // Mouse events — NOTE: no e.preventDefault() on mousedown
    // so that <a> tags can receive normal click events.
    track.addEventListener('mousedown', onMouseDown);

    // Capture click events AFTER drag to suppress link navigation.
    track.addEventListener('click', function (e) {
      if (hasDragged) {
        e.preventDefault();
        e.stopPropagation();
        hasDragged = false;
      }
    }, true); // use capture phase

    function onMouseDown(e) {
      // Ignore right-click
      if (e.button !== 0) return;
      // Do NOT call e.preventDefault() here — allows <a> clicks to work
      onDragStart(e);
      document.addEventListener('mousemove', onMouseMove);
      document.addEventListener('mouseup', onMouseUp);
    }

    function onMouseMove(e) {
      if (isDragging && Math.abs(dragDelta) > CLICK_THRESHOLD) {
        // Only once we know it is a real drag, prevent text selection
        e.preventDefault();
      }
      onDragMove(e);
    }

    function onMouseUp(e) {
      onDragEnd(e);
      document.removeEventListener('mousemove', onMouseMove);
      document.removeEventListener('mouseup', onMouseUp);
    }

    function onDragStart(e) {
      isDragging = true;
      hasDragged = false;
      dragDelta = 0;
      startX = getPointerX(e);
      startScrollLeft = getCurrentTranslateX();
      track.style.transition = 'none';
      // NOTE: do NOT add is-dragging here — wait until real drag detected
      // Adding it here triggers CSS pointer-events:none on all children,
      // which blocks normal <a> click events.
      stopAutoPlay();
    }

    function onDragMove(e) {
      if (!isDragging) return;
      const x = getPointerX(e);
      dragDelta = x - startX;

      // Mark as real drag once beyond click threshold
      if (Math.abs(dragDelta) > CLICK_THRESHOLD) {
        hasDragged = true;
      }

      // Only add is-dragging class (CSS pointer-events:none) once we are
      // sure user is performing a real carousel drag, not just a sloppy click.
      if (Math.abs(dragDelta) > DRAG_THRESHOLD) {
        track.classList.add('is-dragging');
      }

      // Prevent vertical scroll while swiping horizontally
      if (e.cancelable && Math.abs(dragDelta) > CLICK_THRESHOLD) {
        e.preventDefault();
      }

      track.style.transform = 'translateX(' + (startScrollLeft + dragDelta) + 'px)';
    }

    function onDragEnd() {
      if (!isDragging) return;
      isDragging = false;
      track.classList.remove('is-dragging');

      if (Math.abs(dragDelta) > DRAG_THRESHOLD) {
        if (dragDelta < 0) {
          goTo(currentIndex + 1);
        } else {
          goTo(currentIndex - 1);
        }
      } else {
        // Snap back
        updateCarousel(true);
      }
      startAutoPlay();
    }

    function getPointerX(e) {
      return e.touches ? e.touches[0].clientX : e.clientX;
    }

    function getCurrentTranslateX() {
      const style = window.getComputedStyle(track);
      const matrix = new DOMMatrix(style.transform);
      return matrix.m41;
    }

    // ─── Core: Go to Index ─────────────────────────────
    function goTo(index) {
      // Wrap around
      if (index < 0) {
        currentIndex = totalPages - 1;
      } else if (index >= totalPages) {
        currentIndex = 0;
      } else {
        currentIndex = index;
      }
      updateCarousel(true);
    }

    function updateCarousel(animate) {
      const containerWidth = track.parentElement.clientWidth;
      // Card width = (containerWidth - gaps) / visibleCount
      const cardWidth = (containerWidth - GAP * (visibleCount - 1)) / visibleCount;

      // Set card widths
      cards.forEach(function (card) {
        card.style.minWidth = cardWidth + 'px';
        card.style.maxWidth = cardWidth + 'px';
      });

      // Translate
      const offset = currentIndex * (cardWidth + GAP);
      track.style.transition = animate
        ? 'transform 0.5s cubic-bezier(0.22, 1, 0.36, 1)'
        : 'none';
      track.style.transform = 'translateX(-' + offset + 'px)';

      // Update dots
      updateDots();

      // Update arrow states
      updateArrows();

      // Update aria
      cards.forEach(function (card, i) {
        const isVisible = i >= currentIndex && i < currentIndex + visibleCount;
        card.setAttribute('aria-hidden', !isVisible);
        // Allow focus only for visible cards
        const links = card.querySelectorAll('a, button');
        links.forEach(function (link) {
          link.setAttribute('tabindex', isVisible ? '0' : '-1');
        });
      });
    }

    // ─── Arrows State ──────────────────────────────────
    function updateArrows() {
      // Always enabled for wrap-around, but add visual hints
      if (prevBtn) {
        prevBtn.classList.toggle('pi-carousel-btn-disabled', cards.length <= visibleCount);
      }
      if (nextBtn) {
        nextBtn.classList.toggle('pi-carousel-btn-disabled', cards.length <= visibleCount);
      }

      // Hide arrows entirely if not enough cards
      if (cards.length <= visibleCount) {
        if (prevBtn) prevBtn.style.display = 'none';
        if (nextBtn) nextBtn.style.display = 'none';
        if (dotsWrap) dotsWrap.style.display = 'none';
      } else {
        if (prevBtn) prevBtn.style.display = '';
        if (nextBtn) nextBtn.style.display = '';
        if (dotsWrap) dotsWrap.style.display = '';
      }
    }

    // ─── Dots ──────────────────────────────────────────
    function buildDots() {
      if (!dotsWrap) return;
      dotsWrap.innerHTML = '';

      if (totalPages <= 1 || cards.length <= visibleCount) return;

      for (var i = 0; i < totalPages; i++) {
        var dot = document.createElement('button');
        dot.className = 'pi-carousel-dot';
        dot.setAttribute('type', 'button');
        dot.setAttribute('role', 'tab');
        dot.setAttribute('aria-label', 'Trang ' + (i + 1));
        dot.setAttribute('aria-selected', i === currentIndex ? 'true' : 'false');
        dot.dataset.index = i;
        dot.addEventListener('click', onDotClick);
        dotsWrap.appendChild(dot);
      }
    }

    function onDotClick(e) {
      var idx = parseInt(e.currentTarget.dataset.index, 10);
      goTo(idx);
      restartAutoPlay();
    }

    function updateDots() {
      if (!dotsWrap) return;
      var dots = dotsWrap.querySelectorAll('.pi-carousel-dot');
      dots.forEach(function (dot, i) {
        var isActive = i === currentIndex;
        dot.classList.toggle('active', isActive);
        dot.setAttribute('aria-selected', isActive ? 'true' : 'false');
      });
    }

    // ─── Auto-Play ─────────────────────────────────────
    function startAutoPlay() {
      if (autoTimer) return;
      if (cards.length <= visibleCount) return;
      autoTimer = setInterval(function () {
        goTo(currentIndex + 1);
      }, AUTO_INTERVAL);
    }

    function stopAutoPlay() {
      if (autoTimer) {
        clearInterval(autoTimer);
        autoTimer = null;
      }
    }

    function restartAutoPlay() {
      stopAutoPlay();
      startAutoPlay();
    }

    // ─── Helpers ───────────────────────────────────────
    function getVisibleCount() {
      var w = window.innerWidth;
      if (w >= 1200) return 3;
      if (w >= 768) return 2;
      return 1;
    }
  }
})();
