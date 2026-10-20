/**
 * SawaBlog — animations.js
 * AOS initialization + scroll-based animations
 */

document.addEventListener('DOMContentLoaded', () => {
  initAOS();
  initParallax();
  initStaggeredReveal();
  initNumberAnimations();
  initTypingEffect();
});

/* ==========================================
   AOS (Animate On Scroll) INIT
   ========================================== */
function initAOS() {
  if (typeof AOS === 'undefined') return;

  AOS.init({
    duration: 700,
    easing: 'cubic-bezier(0.4, 0, 0.2, 1)',
    once: true,
    offset: 80,
    delay: 0,
    anchorPlacement: 'top-bottom',
    disable: window.matchMedia('(prefers-reduced-motion: reduce)').matches,
  });

  // Refresh AOS after images load (prevent miscalculation)
  window.addEventListener('load', () => {
    AOS.refresh();
  });
}

/* ==========================================
   PARALLAX EFFECT (Subtle)
   ========================================== */
function initParallax() {
  const parallaxEls = document.querySelectorAll('[data-parallax]');
  if (!parallaxEls.length) return;

  window.addEventListener('scroll', () => {
    const scrollY = window.scrollY;

    parallaxEls.forEach(el => {
      const speed = parseFloat(el.dataset.parallax) || 0.3;
      const offset = scrollY * speed;
      el.style.transform = `translateY(${offset}px)`;
    });
  }, { passive: true });
}

/* ==========================================
   STAGGERED REVEAL (Children animate in sequence)
   ========================================== */
function initStaggeredReveal() {
  const containers = document.querySelectorAll('[data-stagger]');
  if (!containers.length) return;

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const delay = parseInt(entry.target.dataset.staggerDelay) || 80;
        const children = entry.target.querySelectorAll('[data-stagger-child]');

        children.forEach((child, index) => {
          setTimeout(() => {
            child.style.opacity = '1';
            child.style.transform = 'translateY(0)';
          }, index * delay);
        });

        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.1 });

  containers.forEach(container => {
    // Set initial state for children
    container.querySelectorAll('[data-stagger-child]').forEach(child => {
      child.style.opacity = '0';
      child.style.transform = 'translateY(24px)';
      child.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
    });
    observer.observe(container);
  });
}

/* ==========================================
   ANIMATED NUMBERS
   ========================================== */
function initNumberAnimations() {
  const numberEls = document.querySelectorAll('[data-animate-number]');
  if (!numberEls.length) return;

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (!entry.isIntersecting) return;

      const el = entry.target;
      const target = parseFloat(el.dataset.animateNumber);
      const suffix = el.dataset.suffix || '';
      const prefix = el.dataset.prefix || '';
      const decimals = el.dataset.decimals ? parseInt(el.dataset.decimals) : 0;
      const duration = 2000;
      const start = performance.now();

      function update(now) {
        const elapsed = now - start;
        const progress = Math.min(elapsed / duration, 1);
        // Ease out cubic
        const eased = 1 - Math.pow(1 - progress, 3);
        const value = target * eased;
        el.textContent = prefix + value.toFixed(decimals) + suffix;
        if (progress < 1) requestAnimationFrame(update);
      }

      requestAnimationFrame(update);
      observer.unobserve(el);
    });
  }, { threshold: 0.5 });

  numberEls.forEach(el => observer.observe(el));
}

/* ==========================================
   TYPING EFFECT
   ========================================== */
function initTypingEffect() {
  const typeEls = document.querySelectorAll('[data-typing]');
  if (!typeEls.length) return;

  typeEls.forEach(el => {
    const words = (el.dataset.typing || '').split('|').map(w => w.trim()).filter(Boolean);
    if (!words.length) return;

    let wordIndex = 0;
    let charIndex = 0;
    let isDeleting = false;
    let isPausing = false;

    const typeSpeed = parseInt(el.dataset.typeSpeed) || 80;
    const deleteSpeed = parseInt(el.dataset.deleteSpeed) || 50;
    const pauseTime = parseInt(el.dataset.pauseTime) || 2000;

    function type() {
      if (isPausing) return;

      const current = words[wordIndex];

      if (isDeleting) {
        el.textContent = current.substring(0, charIndex - 1);
        charIndex--;
      } else {
        el.textContent = current.substring(0, charIndex + 1);
        charIndex++;
      }

      if (!isDeleting && charIndex === current.length) {
        isPausing = true;
        setTimeout(() => {
          isDeleting = true;
          isPausing = false;
          setTimeout(type, deleteSpeed);
        }, pauseTime);
        return;
      }

      if (isDeleting && charIndex === 0) {
        isDeleting = false;
        wordIndex = (wordIndex + 1) % words.length;
      }

      setTimeout(type, isDeleting ? deleteSpeed : typeSpeed);
    }

    type();
  });
}

/* ==========================================
   SCROLL TRIGGERED CLASSES
   ========================================== */
document.addEventListener('scroll', () => {
  document.querySelectorAll('[data-scroll-class]').forEach(el => {
    const rect = el.getBoundingClientRect();
    const threshold = parseInt(el.dataset.scrollThreshold) || 100;
    if (rect.top < window.innerHeight - threshold) {
      el.classList.add(el.dataset.scrollClass);
    }
  });
}, { passive: true });

/* ==========================================
   SMOOTH ANCHOR LINKS
   ========================================== */
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
  anchor.addEventListener('click', function(e) {
    const href = this.getAttribute('href');
    if (href === '#') return;

    const target = document.querySelector(href);
    if (!target) return;

    e.preventDefault();
    const headerOffset = 80;
    const top = target.getBoundingClientRect().top + window.scrollY - headerOffset;
    window.scrollTo({ top, behavior: 'smooth' });
  });
});

/* ==========================================
   SCROLL PROGRESS INDICATOR
   ========================================== */
(function initCircularProgress() {
  const el = document.getElementById('scroll-progress-circle');
  if (!el) return;

  const circle = el.querySelector('circle');
  const circumference = 2 * Math.PI * 18;
  if (circle) {
    circle.style.strokeDasharray = circumference;
    circle.style.strokeDashoffset = circumference;
  }

  window.addEventListener('scroll', () => {
    const scrollTop = window.scrollY;
    const docHeight = document.documentElement.scrollHeight - window.innerHeight;
    const progress = docHeight > 0 ? scrollTop / docHeight : 0;

    if (circle) {
      circle.style.strokeDashoffset = circumference * (1 - progress);
    }

    const pct = document.getElementById('scroll-pct');
    if (pct) pct.textContent = Math.round(progress * 100) + '%';
  }, { passive: true });
})();
