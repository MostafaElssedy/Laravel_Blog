/**
 * SawaBlog — search.js
 * Search modal and live filtering
 */

(function() {
  'use strict';

  /* ==========================================
     SEARCH MODAL
     ========================================== */
  const searchModal = document.getElementById('search-modal');
  const searchInput = document.getElementById('search-modal-input');
  const searchResults = document.getElementById('search-modal-results');

  // All content for search (populated from data or DOM)
  let allArticles = [];

  function openSearch() {
    searchModal?.classList.add('open');
    document.body.style.overflow = 'hidden';
    setTimeout(() => searchInput?.focus(), 150);
  }

  function closeSearch() {
    searchModal?.classList.remove('open');
    document.body.style.overflow = '';
    if (searchInput) searchInput.value = '';
    if (searchResults) searchResults.innerHTML = '';
  }

  // Open triggers
  document.querySelectorAll('[data-search-open]').forEach(btn => {
    btn.addEventListener('click', openSearch);
  });

  // Close on overlay click
  searchModal?.addEventListener('click', function(e) {
    if (e.target === searchModal) closeSearch();
  });

  // Close on Escape key
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeSearch();
    // Shortcut: Ctrl/Cmd + K
    if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
      e.preventDefault();
      searchModal?.classList.contains('open') ? closeSearch() : openSearch();
    }
  });

  // Close button
  document.getElementById('search-close')?.addEventListener('click', closeSearch);

  /* ==========================================
     SEARCH ARTICLES
     ========================================== */
  function loadArticlesFromDOM() {
    // Pull article data from data attributes on article cards in DOM
    document.querySelectorAll('[data-article-title]').forEach(el => {
      allArticles.push({
        title: el.dataset.articleTitle || '',
        excerpt: el.dataset.articleExcerpt || '',
        category: el.dataset.articleCategory || '',
        url: el.dataset.articleUrl || '#',
        image: el.dataset.articleImage || '',
        author: el.dataset.articleAuthor || '',
        readTime: el.dataset.articleReadTime || '5 min'
      });
    });
  }

  async function loadArticlesFromJSON() {
    // Legacy mock function - no longer needed as we use live backend API
  }

  let searchTimeout = null;

  function performSearch(query) {
    if (!query.trim()) {
      renderDefaultResults();
      return;
    }

    if (searchTimeout) clearTimeout(searchTimeout);
    
    searchTimeout = setTimeout(async () => {
      try {
        const response = await fetch('/api/search?q=' + encodeURIComponent(query));
        const results = await response.json();
        renderSearchResults(results, query);
      } catch (error) {
        console.error('Error fetching search results:', error);
      }
    }, 300); // 300ms debounce
  }

  let trendingTopics = ['Technology', 'Design', 'Programming', 'Business', 'AI'];

  async function fetchTrendingTopics() {
    try {
      const res = await fetch('/api/trending-topics');
      const data = await res.json();
      if (data && data.length > 0) {
        trendingTopics = data;
      }
    } catch (e) {
      console.error('Error fetching trending topics:', e);
    }
  }

  function renderDefaultResults() {
    if (!searchResults) return;
    searchResults.innerHTML = `
      <div class="px-4 pb-4">
        <p class="text-xs font-semibold uppercase tracking-wider mb-3" style="color:var(--color-text-muted)">Trending Topics</p>
        <div class="flex flex-wrap gap-2">
          ${trendingTopics.map(t =>
            `<button type="button" class="px-3 py-1.5 rounded-lg text-sm font-medium bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-primary hover:text-white dark:hover:bg-primary transition-colors cursor-pointer border border-transparent hover:border-primary/20" onclick="document.getElementById('search-modal-input').value='${t}';document.getElementById('search-modal-input').dispatchEvent(new Event('input'));">${t}</button>`
          ).join('')}
        </div>
      </div>
    `;
  }

  function renderSearchResults(results, query) {
    if (!searchResults) return;

    if (!results.length) {
      searchResults.innerHTML = `
        <div class="px-4 py-8 text-center" style="color:var(--color-text-muted)">
          <div class="text-4xl mb-3">🔍</div>
          <p class="font-semibold" style="color:var(--color-text-primary)">No results for "<span>${escapeHtml(query)}</span>"</p>
          <p class="text-sm mt-1">Try different keywords or browse categories</p>
        </div>
      `;
      return;
    }

    searchResults.innerHTML = `
      <div class="px-2 py-2">
        <p class="text-xs font-semibold uppercase tracking-wider px-3 mb-3" style="color:var(--color-text-muted)">${results.length} result${results.length !== 1 ? 's' : ''}</p>
        ${results.slice(0, 6).map(article => `
          <a href="${article.url || '../pages/single-post.html'}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-opacity-10 transition-all" style="hover-bg:var(--color-primary)" onmouseover="this.style.background='rgba(91,75,219,0.06)'" onmouseout="this.style.background=''">
            ${article.image ? `<img src="${article.image}" alt="${escapeHtml(article.title)}" class="w-12 h-10 rounded-lg object-cover flex-shrink-0">` : '<div class="w-12 h-10 rounded-lg flex-shrink-0" style="background:var(--color-bg-tertiary)"></div>'}
            <div class="min-w-0 flex-1">
              <p class="text-sm font-semibold line-clamp-1" style="color:var(--color-text-primary)">${highlight(escapeHtml(article.title), query)}</p>
              <p class="text-xs mt-0.5" style="color:var(--color-text-muted)">${escapeHtml(article.category)} · ${escapeHtml(article.readTime)} read</p>
            </div>
            <i class="fas fa-arrow-right text-xs" style="color:var(--color-text-muted)"></i>
          </a>
        `).join('')}
        ${results.length > 6 ? `<div class="px-3 pt-2 pb-1 border-t mt-1" style="border-color:var(--color-border)"><a href="search.html?q=${encodeURIComponent(query)}" class="text-sm font-semibold" style="color:var(--color-primary)">See all ${results.length} results →</a></div>` : ''}
      </div>
    `;
  }

  function highlight(text, query) {
    if (!query.trim()) return text;
    const re = new RegExp(`(${escapeRegex(query)})`, 'gi');
    return text.replace(re, '<mark style="background:rgba(91,75,219,0.15);color:var(--color-primary);border-radius:3px;padding:0 2px">$1</mark>');
  }

  function escapeHtml(str) {
    return String(str).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
  }

  function escapeRegex(str) {
    return str.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
  }

  /* ==========================================
     BLOG PAGE FILTERING
     ========================================== */
  window.initBlogFilter = function() {
    const searchBar = document.getElementById('blog-search');
    const categoryBtns = document.querySelectorAll('[data-filter-cat]');
    const sortSelect = document.getElementById('sort-select');
    const articlesContainer = document.getElementById('articles-container');
    const allCards = articlesContainer ? Array.from(articlesContainer.querySelectorAll('[data-article-card]')) : [];
    let activeCategory = 'all';

    function filterArticles() {
      const query = (searchBar?.value || '').toLowerCase();

      allCards.forEach(card => {
        const title = (card.dataset.articleTitle || '').toLowerCase();
        const category = (card.dataset.articleCategory || '').toLowerCase();
        const excerpt = (card.dataset.articleExcerpt || '').toLowerCase();

        const matchSearch = !query || title.includes(query) || excerpt.includes(query);
        const matchCategory = activeCategory === 'all' || category === activeCategory.toLowerCase();

        card.style.display = (matchSearch && matchCategory) ? '' : 'none';
      });

      // Empty state
      const visible = allCards.filter(c => c.style.display !== 'none').length;
      const emptyState = document.getElementById('empty-state');
      if (emptyState) emptyState.style.display = visible ? 'none' : 'flex';
    }

    searchBar?.addEventListener('input', filterArticles);

    categoryBtns.forEach(btn => {
      btn.addEventListener('click', function() {
        categoryBtns.forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        activeCategory = this.dataset.filterCat;
        filterArticles();
      });
    });

    sortSelect?.addEventListener('change', function() {
      const val = this.value;
      const cards = Array.from(articlesContainer?.querySelectorAll('[data-article-card]') || []);
      const sorted = cards.sort((a, b) => {
        if (val === 'latest') return (b.dataset.date || '') > (a.dataset.date || '') ? 1 : -1;
        if (val === 'popular') return (parseInt(b.dataset.views) || 0) - (parseInt(a.dataset.views) || 0);
        return 0;
      });
      sorted.forEach(card => articlesContainer.appendChild(card));
    });
  };

  /* ==========================================
     INIT
     ========================================== */
  document.addEventListener('DOMContentLoaded', () => {
    fetchTrendingTopics().then(() => {
      renderDefaultResults();
    });

    searchInput?.addEventListener('input', function() {
      performSearch(this.value);
    });

    window.initBlogFilter?.();
  });

})();
