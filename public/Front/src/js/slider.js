/**
 * SawaBlog — slider.js
 * Swiper.js configurations for all sliders
 */

document.addEventListener('DOMContentLoaded', () => {
  initFeaturedSlider();
  initTestimonialsSlider();
  initRelatedSlider();
  initHeroSlider();
  initLogoBrandSlider();
});

/* ==========================================
   FEATURED ARTICLES SLIDER (Home page)
   ========================================== */
function initFeaturedSlider() {
  const el = document.querySelector('.featured-swiper');
  if (!el || typeof Swiper === 'undefined') return;

  new Swiper('.featured-swiper', {
    loop: true,
    spaceBetween: 24,
    slidesPerView: 1,
    centeredSlides: false,
    autoplay: {
      delay: 5000,
      disableOnInteraction: false,
      pauseOnMouseEnter: true,
    },
    pagination: {
      el: '.featured-swiper .swiper-pagination',
      clickable: true,
    },
    navigation: {
      nextEl: '#featured-next',
      prevEl: '#featured-prev',
    },
    breakpoints: {
      640: {
        slidesPerView: 1.2,
        spaceBetween: 20,
      },
      768: {
        slidesPerView: 1.5,
        spaceBetween: 24,
      },
      1024: {
        slidesPerView: 2,
        spaceBetween: 28,
      },
      1280: {
        slidesPerView: 2.2,
        spaceBetween: 28,
      },
    },
    effect: 'slide',
    speed: 700,
    grabCursor: true,
  });
}

/* ==========================================
   TESTIMONIALS SLIDER
   ========================================== */
function initTestimonialsSlider() {
  const el = document.querySelector('.testimonials-swiper');
  if (!el || typeof Swiper === 'undefined') return;

  new Swiper('.testimonials-swiper', {
    loop: true,
    spaceBetween: 24,
    slidesPerView: 1,
    autoplay: {
      delay: 6000,
      pauseOnMouseEnter: true,
    },
    pagination: {
      el: '.testimonials-swiper .swiper-pagination',
      clickable: true,
    },
    navigation: {
      nextEl: '#testimonials-next',
      prevEl: '#testimonials-prev',
    },
    breakpoints: {
      640: {
        slidesPerView: 1.2,
      },
      768: {
        slidesPerView: 2,
      },
      1024: {
        slidesPerView: 3,
        spaceBetween: 28,
      },
    },
    speed: 600,
    grabCursor: true,
  });
}

/* ==========================================
   RELATED ARTICLES SLIDER (Single post)
   ========================================== */
function initRelatedSlider() {
  const el = document.querySelector('.related-swiper');
  if (!el || typeof Swiper === 'undefined') return;

  new Swiper('.related-swiper', {
    spaceBetween: 24,
    slidesPerView: 1,
    navigation: {
      nextEl: '#related-next',
      prevEl: '#related-prev',
    },
    breakpoints: {
      640: { slidesPerView: 1.5 },
      768: { slidesPerView: 2 },
      1024: { slidesPerView: 3 },
    },
    speed: 500,
    grabCursor: true,
  });
}

/* ==========================================
   HERO BACKGROUND SLIDER
   ========================================== */
function initHeroSlider() {
  const el = document.querySelector('.hero-swiper');
  if (!el || typeof Swiper === 'undefined') return;

  new Swiper('.hero-swiper', {
    loop: true,
    effect: 'fade',
    fadeEffect: { crossFade: true },
    autoplay: {
      delay: 7000,
      disableOnInteraction: false,
    },
    speed: 1200,
    allowTouchMove: false,
  });
}

/* ==========================================
   LOGO / BRAND MARQUEE SLIDER
   ========================================== */
function initLogoBrandSlider() {
  const el = document.querySelector('.brands-swiper');
  if (!el || typeof Swiper === 'undefined') return;

  new Swiper('.brands-swiper', {
    loop: true,
    slidesPerView: 'auto',
    spaceBetween: 32,
    freeMode: true,
    autoplay: {
      delay: 0,
      disableOnInteraction: false,
    },
    speed: 4000,
    allowTouchMove: false,
  });
}

/* ==========================================
   AUTHOR ARTICLES SLIDER (Author profile)
   ========================================== */
window.initAuthorSlider = function() {
  const el = document.querySelector('.author-articles-swiper');
  if (!el || typeof Swiper === 'undefined') return;

  new Swiper('.author-articles-swiper', {
    spaceBetween: 24,
    slidesPerView: 1,
    navigation: {
      nextEl: '#author-articles-next',
      prevEl: '#author-articles-prev',
    },
    breakpoints: {
      640: { slidesPerView: 1.5 },
      768: { slidesPerView: 2 },
      1200: { slidesPerView: 3 },
    },
    grabCursor: true,
    speed: 500,
  });
};

document.addEventListener('DOMContentLoaded', window.initAuthorSlider);
