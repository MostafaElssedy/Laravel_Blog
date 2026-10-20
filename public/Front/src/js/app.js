/**
 * SawaBlog — app.js
 * Main application entry point + Alpine.js stores + shared utilities
 */

document.addEventListener('DOMContentLoaded', () => {
  // Initialize all modules
  initPageLoader();
  initScrollEffects();
  initBackToTop();
  initCookieBanner();
  initNavScroll();
  initRippleButtons();
  initCounters();
  initLazyImages();
  initTooltips();
});

/* ==========================================
   PAGE LOADER
   ========================================== */
function initPageLoader() {
  const loader = document.getElementById('page-loader');
  if (!loader) return;

  window.addEventListener('load', () => {
    setTimeout(() => {
      loader.classList.add('hidden');
      setTimeout(() => loader.remove(), 500);
    }, 400);
  });
}

/* ==========================================
   SCROLL EFFECTS
   ========================================== */
function initScrollEffects() {
  // Reading progress bar
  const progressBar = document.getElementById('reading-progress');
  if (progressBar) {
    window.addEventListener('scroll', () => {
      const scrollTop = window.scrollY;
      const docHeight = document.documentElement.scrollHeight - window.innerHeight;
      const progress = docHeight > 0 ? (scrollTop / docHeight) * 100 : 0;
      progressBar.style.width = `${Math.min(progress, 100)}%`;
    }, { passive: true });
  }

  // TOC active highlight
  const tocItems = document.querySelectorAll('.toc-item');
  const headings = document.querySelectorAll('.prose-sawa h2, .prose-sawa h3');

  if (tocItems.length && headings.length) {
    const observeTOC = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          const id = entry.target.id;
          tocItems.forEach(item => {
            const link = item.querySelector('a');
            if (link && link.getAttribute('href') === `#${id}`) {
              tocItems.forEach(i => i.classList.remove('active'));
              item.classList.add('active');
            }
          });
        }
      });
    }, { rootMargin: '-20% 0px -60% 0px' });

    headings.forEach(h => observeTOC.observe(h));
  }
}

/* ==========================================
   BACK TO TOP
   ========================================== */
function initBackToTop() {
  const btn = document.getElementById('back-to-top');
  if (!btn) return;

  window.addEventListener('scroll', () => {
    if (window.scrollY > 400) {
      btn.classList.add('show');
    } else {
      btn.classList.remove('show');
    }
  }, { passive: true });

  btn.addEventListener('click', () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });
}

/* ==========================================
   COOKIE BANNER
   ========================================== */
function initCookieBanner() {
  const banner = document.getElementById('cookie-banner');
  if (!banner) return;

  const accepted = localStorage.getItem('sawa_cookies_accepted');
  if (!accepted) {
    banner.style.display = 'flex';
  } else {
    banner.remove();
  }

  const acceptBtn = document.getElementById('cookie-accept');
  const declineBtn = document.getElementById('cookie-decline');

  if (acceptBtn) {
    acceptBtn.addEventListener('click', () => {
      localStorage.setItem('sawa_cookies_accepted', 'true');
      banner.style.transform = 'translateY(100%)';
      setTimeout(() => banner.remove(), 400);
    });
  }

  if (declineBtn) {
    declineBtn.addEventListener('click', () => {
      banner.style.transform = 'translateY(100%)';
      setTimeout(() => banner.remove(), 400);
    });
  }
}

/* ==========================================
   NAV SCROLL CLASS
   ========================================== */
function initNavScroll() {
  const nav = document.querySelector('.sawa-nav');
  if (!nav) return;

  window.addEventListener('scroll', () => {
    if (window.scrollY > 20) {
      nav.classList.add('scrolled');
    } else {
      nav.classList.remove('scrolled');
    }
  }, { passive: true });
}

/* ==========================================
   RIPPLE BUTTONS
   ========================================== */
function initRippleButtons() {
  document.querySelectorAll('.ripple-btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
      const rect = this.getBoundingClientRect();
      const ripple = document.createElement('span');
      ripple.className = 'ripple-circle';
      ripple.style.left = `${e.clientX - rect.left - 5}px`;
      ripple.style.top = `${e.clientY - rect.top - 5}px`;
      this.appendChild(ripple);
      ripple.addEventListener('animationend', () => ripple.remove());
    });
  });
}

/* ==========================================
   COUNTERS (ANIMATED STATS)
   ========================================== */
function initCounters() {
  const counters = document.querySelectorAll('[data-counter]');
  if (!counters.length) return;

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const el = entry.target;
        const target = parseInt(el.dataset.counter);
        const duration = 1800;
        const step = target / (duration / 16);
        let current = 0;

        const update = () => {
          current += step;
          if (current < target) {
            el.textContent = Math.floor(current).toLocaleString();
            requestAnimationFrame(update);
          } else {
            el.textContent = target.toLocaleString();
          }
        };

        requestAnimationFrame(update);
        observer.unobserve(el);
      }
    });
  }, { threshold: 0.5 });

  counters.forEach(c => observer.observe(c));
}

/* ==========================================
   LAZY IMAGES
   ========================================== */
function initLazyImages() {
  const images = document.querySelectorAll('img[data-src]');
  if (!images.length) return;

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const img = entry.target;
        img.src = img.dataset.src;
        img.removeAttribute('data-src');
        img.classList.add('animate-fade-in');
        observer.unobserve(img);
      }
    });
  });

  images.forEach(img => observer.observe(img));
}

/* ==========================================
   TOOLTIPS
   ========================================== */
function initTooltips() {
  document.querySelectorAll('[data-tooltip]').forEach(el => {
    const tip = document.createElement('div');
    tip.className = 'absolute bg-gray-900 text-white text-xs px-2 py-1 rounded whitespace-nowrap opacity-0 pointer-events-none transition-opacity z-50 -top-8 left-1/2 -translate-x-1/2';
    tip.textContent = el.dataset.tooltip;
    el.style.position = 'relative';
    el.appendChild(tip);

    el.addEventListener('mouseenter', () => tip.style.opacity = '1');
    el.addEventListener('mouseleave', () => tip.style.opacity = '0');
  });
}

/* ==========================================
   TOAST NOTIFICATION
   ========================================== */
window.showToast = function(message, duration = 3000) {
  const existing = document.querySelector('.sawa-toast');
  if (existing) existing.remove();

  const toast = document.createElement('div');
  toast.className = 'sawa-toast';
  toast.textContent = message;
  document.body.appendChild(toast);

  requestAnimationFrame(() => {
    requestAnimationFrame(() => {
      toast.classList.add('show');
    });
  });

  setTimeout(() => {
    toast.classList.remove('show');
    setTimeout(() => toast.remove(), 400);
  }, duration);
};

/* ==========================================
   ACCORDION
   ========================================== */
window.initAccordion = function() {
  document.querySelectorAll('.accordion-trigger').forEach(trigger => {
    trigger.addEventListener('click', function() {
      const item = this.closest('.accordion-item');
      const content = item.querySelector('.accordion-content');
      const inner = item.querySelector('.accordion-inner');
      const isOpen = item.classList.contains('open');

      // Close all
      document.querySelectorAll('.accordion-item.open').forEach(open => {
        const c = open.querySelector('.accordion-content');
        open.classList.remove('open');
        c.style.maxHeight = '0';
      });

      // Open clicked
      if (!isOpen) {
        item.classList.add('open');
        content.style.maxHeight = inner.scrollHeight + 'px';
      }
    });
  });
};

document.addEventListener('DOMContentLoaded', () => {
  // Classic accordion (uses .accordion-content/.accordion-inner)
  document.querySelectorAll('.accordion-trigger').forEach(trigger => {
    trigger.addEventListener('click', function() {
      const item = this.closest('.accordion-item');

      // Handle .accordion-body style (simple show/hide)
      const body = item.querySelector('.accordion-body');
      if (body) {
        const isOpen = item.classList.contains('open');
        // Close all siblings
        document.querySelectorAll('.accordion-item.open').forEach(open => {
          open.classList.remove('open');
          const icon = open.querySelector('.accordion-icon');
          if(icon) icon.style.transform = '';
        });
        if (!isOpen) {
          item.classList.add('open');
          const icon = item.querySelector('.accordion-icon');
          if(icon) icon.style.transform = 'rotate(180deg)';
        }
        return;
      }

      // Handle .accordion-content style (height animation)
      const content = item.querySelector('.accordion-content');
      const inner = item.querySelector('.accordion-inner');
      if (!content || !inner) return;
      const isOpen = item.classList.contains('open');
      document.querySelectorAll('.accordion-item.open').forEach(open => {
        const c = open.querySelector('.accordion-content');
        open.classList.remove('open');
        if(c) c.style.maxHeight = '0';
      });
      if (!isOpen) {
        item.classList.add('open');
        content.style.maxHeight = inner.scrollHeight + 'px';
      }
    });
  });
});


/* ==========================================
   COPY TO CLIPBOARD
   ========================================== */
window.copyToClipboard = function(text, message = 'Link copied!') {
  navigator.clipboard.writeText(text).then(() => {
    showToast(message);
  }).catch(() => {
    // Fallback
    const ta = document.createElement('textarea');
    ta.value = text;
    ta.style.cssText = 'position:fixed;opacity:0;';
    document.body.appendChild(ta);
    ta.select();
    document.execCommand('copy');
    ta.remove();
    showToast(message);
  });
};

/* ==========================================
   NEWSLETTER FORM SUBMIT
   (Handled via Livewire component)
   ========================================== */

/* ==========================================
   MOBILE MENU
   ========================================== */
const menuToggle = document.getElementById('menu-toggle');
const mobileMenu = document.getElementById('mobile-menu');
const menuOverlay = document.getElementById('menu-overlay');

function openMenu() {
  mobileMenu?.classList.add('open');
  menuOverlay?.classList.add('open');
  document.body.style.overflow = 'hidden';
}

function closeMenu() {
  mobileMenu?.classList.remove('open');
  menuOverlay?.classList.remove('open');
  document.body.style.overflow = '';
}

menuToggle?.addEventListener('click', openMenu);
menuOverlay?.addEventListener('click', closeMenu);
document.getElementById('menu-close')?.addEventListener('click', closeMenu);

/* ==========================================
   LAYOUT TOGGLE (Grid/List)
   ========================================== */
window.initLayoutToggle = function() {
  const gridBtn = document.getElementById('view-grid');
  const listBtn = document.getElementById('view-list');
  const container = document.getElementById('articles-container');

  if (!gridBtn || !listBtn || !container) return;

  gridBtn.addEventListener('click', () => {
    container.dataset.view = 'grid';
    gridBtn.classList.add('active');
    listBtn.classList.remove('active');
    container.querySelectorAll('[data-grid-classes]').forEach(item => {
      item.className = item.dataset.gridClasses;
    });
  });

  listBtn.addEventListener('click', () => {
    container.dataset.view = 'list';
    listBtn.classList.add('active');
    gridBtn.classList.remove('active');
    container.querySelectorAll('[data-list-classes]').forEach(item => {
      item.className = item.dataset.listClasses;
    });
  });
};

document.addEventListener('DOMContentLoaded', window.initLayoutToggle);
