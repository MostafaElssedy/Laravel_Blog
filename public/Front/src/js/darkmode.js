/**
 * SawaBlog — darkmode.js
 * Dark mode toggle with localStorage persistence
 */

(function() {
  'use strict';

  const STORAGE_KEY = 'sawa_theme';
  const DARK_CLASS = 'dark';

  /* Apply theme immediately (before DOM render) to avoid flash */
  function applyTheme(theme) {
    if (theme === 'dark') {
      document.documentElement.classList.add(DARK_CLASS);
    } else {
      document.documentElement.classList.remove(DARK_CLASS);
    }
  }

  /* Get saved theme or fallback to system preference */
  function getInitialTheme() {
    const saved = localStorage.getItem(STORAGE_KEY);
    if (saved === 'dark' || saved === 'light') return saved;
    // System preference
    return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
  }

  /* Initialize theme on script load */
  const initialTheme = getInitialTheme();
  applyTheme(initialTheme);

  /* Update all toggle buttons UI */
  function updateToggles(theme) {
    const isDark = theme === 'dark';
    document.querySelectorAll('.dark-toggle-icon').forEach(icon => {
      if (isDark) {
        icon.innerHTML = '<i class="fas fa-sun"></i>';
        icon.setAttribute('title', 'Switch to light mode');
      } else {
        icon.innerHTML = '<i class="fas fa-moon"></i>';
        icon.setAttribute('title', 'Switch to dark mode');
      }
    });

    // Update aria labels
    document.querySelectorAll('[data-dark-toggle]').forEach(btn => {
      btn.setAttribute('aria-label', isDark ? 'Switch to light mode' : 'Switch to dark mode');
    });
  }

  /* Toggle */
  function toggleTheme() {
    const current = document.documentElement.classList.contains(DARK_CLASS) ? 'dark' : 'light';
    const next = current === 'dark' ? 'light' : 'dark';
    applyTheme(next);
    localStorage.setItem(STORAGE_KEY, next);
    updateToggles(next);
    // Dispatch event for other modules
    document.dispatchEvent(new CustomEvent('sawa:themechange', { detail: { theme: next } }));
  }

  /* Set specific theme */
  window.setTheme = function(theme) {
    applyTheme(theme);
    localStorage.setItem(STORAGE_KEY, theme);
    updateToggles(theme);
  };

  /* Get current theme */
  window.getTheme = function() {
    return document.documentElement.classList.contains(DARK_CLASS) ? 'dark' : 'light';
  };

  /* Expose toggle */
  window.toggleDarkMode = toggleTheme;

  /* Wire up toggle buttons after DOM load */
  document.addEventListener('DOMContentLoaded', () => {
    // Update icon on initial load
    updateToggles(getInitialTheme());

    // Bind all dark mode toggle buttons
    document.querySelectorAll('[data-dark-toggle]').forEach(btn => {
      btn.addEventListener('click', toggleTheme);
    });

    // Listen for system preference changes
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
      const saved = localStorage.getItem(STORAGE_KEY);
      if (!saved) {
        // Only auto-follow system if user hasn't manually set preference
        applyTheme(e.matches ? 'dark' : 'light');
        updateToggles(e.matches ? 'dark' : 'light');
      }
    });
  });

})();
