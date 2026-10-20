
<!DOCTYPE html>
<html lang="en" class="">
<head>
  <!-- Page Meta -->
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title') | {{ optional(\App\Models\GeneralSetting::getSettings())->blog_name ?? 'LaraTech' }}</title>

  <!-- SEO -->
  <meta name="description" content="{{ optional(\App\Models\GeneralSetting::getSettings())->blog_description ?? 'LaraTech is a premium platform for developers, designers, and tech enthusiasts. Discover insightful articles, tutorials, and stories from the world\'s best writers.' }}" />
  <meta name="keywords" content="{{ optional(\App\Models\GeneralSetting::getSettings())->blog_meta_keywords ?? 'blog, technology, design, web development, programming, tutorials' }}" />

  <!-- Open Graph -->
  <meta property="og:title" content="{{ optional(\App\Models\GeneralSetting::getSettings())->blog_name ?? 'LaraTech' }} — Ideas Worth Reading" />
  <meta property="og:description" content="{{ optional(\App\Models\GeneralSetting::getSettings())->blog_description ?? 'Premium articles for developers and designers.' }}" />
  <meta property="og:type" content="website" />

  <!-- Favicon -->
  <link rel="icon" href="{{ optional(\App\Models\GeneralSetting::getSettings())->blog_favicon ? asset('images/settings/' . \App\Models\GeneralSetting::getSettings()->blog_favicon) : asset('Front/src/images/favicon.png') }}" />

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Merriweather:ital,wght@0,400;1,400&display=swap" rel="stylesheet" />

  <!-- Tailwind CSS Play CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      darkMode: 'class',
      theme: {
        extend: {
          colors: {
            primary: '#5B4BDB',
            'primary-dark': '#4338CA',
            secondary: '#4F8DFF',
            accent: '#FF6B35',
          }
        }
      }
    }
  </script>

  <!-- CSS -->
  <link rel="stylesheet" href="{{ asset('Front/src/css/app.css') }}" />
  <link rel="stylesheet" href="{{ asset('Front/src/css/components.css') }}" />
  <link rel="stylesheet" href="{{ asset('Front/src/css/animations.css') }}" />
  <link rel="stylesheet" href="{{ asset('Front/src/css/utilities.css') }}" />

  <link rel="stylesheet" href="{{ asset('extra-assets/ijabo/ijabo.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('extra-assets/ijabo/ijaboCropTool.min.css') }}" />

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

  <!-- AOS -->
  <link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css" />

  <!-- Swiper -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

  <!-- Dark Mode (inline, runs before render) -->
  <script src="{{ asset('Front/src/js/darkmode.js') }}"></script>

  <!-- Page-specific styles -->
  @stack('styles')
  @livewireStyles
</head>
<body class="page-transition">

  <!-- Page Loader -->
  <div id="page-loader" class="page-loader">
    <div class="loader-spinner"></div>
  </div>

  <!-- Reading Progress -->
  <div id="reading-progress"></div>

  <!-- ==========================================
       NAVBAR
       ========================================== -->
  <nav class="sawa-nav" role="navigation" aria-label="Main navigation">
    <div class="sawa-container sawa-nav-inner">
      <!-- Logo -->
      <a href="/" class="sawa-logo" aria-label="Blog Home">
        <img src="{{ optional(\App\Models\GeneralSetting::getSettings())->blog_logo ? asset('images/settings/' . \App\Models\GeneralSetting::getSettings()->blog_logo) : asset('Front/src/images/logo.png') }}" alt="{{ optional(\App\Models\GeneralSetting::getSettings())->blog_name ?? 'LaraTech' }}" style="height:40px;width:auto;object-fit:contain;">
      </a>

      <!-- Desktop Nav Links -->
      <ul class="sawa-nav-links" role="list">
        <li class="sawa-nav-item">
          <a href="{{route('home')}}" class="sawa-nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
        </li>
        <li class="sawa-nav-item" style="position:relative;">
          <button id="categories-btn" class="sawa-nav-link {{ request()->routeIs('category.posts') ? 'active' : '' }}">
            Categories <i class="fas fa-chevron-down text-xs ml-1"></i>
          </button>
          
          {{-- Dropdown Container (Opens on Click) --}}
          <div id="categories-mega-menu" class="hidden absolute left-0 top-full mt-2 z-50">
            <div class="relative flex w-max" onmouseleave="hideAllSubmenus()">
              {{-- Scrollable Main List (Static to prevent clipping absolute children) --}}
              <div class="w-60 max-h-[60vh] overflow-y-auto custom-scrollbar bg-white dark:bg-[#1E293B] shadow-xl rounded-xl border border-gray-100 dark:border-gray-700 p-2 static">
                @php
                  $navCategories = nav_menu_categories();
                @endphp
                @foreach($navCategories as $parentCategory)
                  <div class="static px-3 py-2 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg cursor-pointer flex justify-between items-center transition-colors mb-1 last:mb-0" onmouseenter="showSubmenu('submenu-{{ $parentCategory->id }}', this)">
                    <span class="text-sm font-medium"><i class="fas fa-folder w-4 text-center text-primary"></i> {{ $parentCategory->name }}</span>
                    @if($parentCategory->subcategories->count() > 0)
                      <i class="fas fa-chevron-right text-[10px] opacity-50"></i>
                      
                      {{-- Dynamic Side Flyout --}}
                      <div id="submenu-{{ $parentCategory->id }}" class="category-submenu absolute left-full ml-1 hidden z-50">
                        {{-- Box with invisible hover bridge using before pseudo-element --}}
                        <div class="w-56 max-h-[60vh] overflow-y-auto custom-scrollbar bg-white dark:bg-[#1E293B] shadow-xl rounded-xl border border-gray-100 dark:border-gray-700 p-3 before:content-[''] before:absolute before:-left-4 before:top-0 before:w-4 before:h-full before:bg-transparent">
                          <h4 class="text-xs font-bold text-gray-400 mb-3 uppercase tracking-wider border-b border-gray-100 dark:border-gray-700 pb-2">{{ $parentCategory->name }}</h4>
                          <div class="flex flex-col gap-1 mt-1">
                            @foreach($parentCategory->subcategories as $subCategory)
                              <a href="{{ route('category.posts', $subCategory->slug ?? '') }}" class="text-sm text-gray-700 dark:text-gray-300 hover:text-primary dark:hover:text-primary transition-colors flex items-center px-2 py-1.5 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-md">
                                <i class="fas fa-tag w-3 text-accent mr-2 text-center"></i> {{ $subCategory->name }}
                              </a>
                            @endforeach
                          </div>
                        </div>
                      </div>
                    @endif
                  </div>
                @endforeach
              </div>
            </div>
          </div>
        </li>
        <li class="sawa-nav-item">
          <a href="{{ route('authors') }}" class="sawa-nav-link {{ request()->routeIs('authors') ? 'active' : '' }}">Authors</a>
        </li>
        <li class="sawa-nav-item">
          <a href="{{ route('about') }}" class="sawa-nav-link {{ request()->routeIs('about') ? 'active' : '' }}">About</a>
        </li>
        <li class="sawa-nav-item">
          <a href="{{ route('contact') }}" class="sawa-nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">Contact</a>
        </li>
      </ul>

      <!-- Actions -->
      <div class="sawa-nav-actions">
        <!-- Search -->
        <button class="sawa-icon-btn" id="search-open-btn" data-search-open aria-label="Open search">
          <i class="fas fa-search"></i>
        </button>

        <!-- Dark Mode -->
        <button class="sawa-icon-btn dark-toggle-icon" data-dark-toggle aria-label="Toggle dark mode">
          <i class="fas fa-moon"></i>
        </button>

        @auth
        <!-- User Dropdown -->
        <div class="relative inline-block text-left">
            <button id="user-menu-btn" class="flex items-center gap-2 focus:outline-none p-1 pr-3 rounded-full border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors bg-white dark:bg-[#1E293B]">
                <img class="h-8 w-8 rounded-full object-cover" src="{{ auth()->user()->profile_image ? asset('images/users/' . auth()->user()->profile_image) : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=random' }}" alt="{{ auth()->user()->name }}">
                <span class="text-sm font-bold text-gray-700 dark:text-gray-200 hidden md:block max-w-[100px] truncate">{{ explode(' ', auth()->user()->name)[0] }}</span>
                <i class="fas fa-chevron-down text-[10px] text-gray-400"></i>
            </button>

            <!-- Dropdown menu -->
            <div id="user-dropdown-menu" class="hidden absolute right-0 z-50 mt-3 w-64 origin-top-right rounded-2xl bg-white dark:bg-[#1E293B] shadow-2xl border border-gray-100 dark:border-gray-700/80 focus:outline-none transition-all">
                <div class="py-2 px-2">
                    <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-700/50 mb-2 flex items-center gap-3">
                        <img class="h-10 w-10 rounded-full object-cover shadow-sm" src="{{ auth()->user()->profile_image ? asset('images/users/' . auth()->user()->profile_image) : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=random' }}" alt="Profile">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-bold text-gray-900 dark:text-white truncate">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ auth()->user()->email ?? '@'.(auth()->user()->username ?? 'user') }}</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 rounded-xl px-4 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800 hover:text-primary transition-colors">
                        <div class="w-7 h-7 rounded-lg bg-primary/10 text-primary flex items-center justify-center shrink-0"><i class="fas fa-chart-line text-xs"></i></div> Dashboard
                    </a>
                    <a href="{{ route('admin.profile') }}" class="flex items-center gap-3 rounded-xl px-4 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800 hover:text-blue-500 transition-colors">
                        <div class="w-7 h-7 rounded-lg bg-blue-500/10 text-blue-500 flex items-center justify-center shrink-0"><i class="fas fa-user text-xs"></i></div> Profile
                    </a>
                    <a href="{{ route('admin.settings') }}" class="flex items-center gap-3 rounded-xl px-4 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-white transition-colors">
                        <div class="w-7 h-7 rounded-lg bg-gray-500/10 text-gray-500 dark:text-gray-400 flex items-center justify-center shrink-0"><i class="fas fa-cog text-xs"></i></div> Settings
                    </a>
                    <div class="border-t border-gray-100 dark:border-gray-700/50 my-2"></div>
                    <form method="POST" action="{{ route('admin.logout') }}" class="m-0">
                        @csrf
                        <button type="submit" class="flex w-full items-center gap-3 rounded-xl px-4 py-2.5 text-sm font-medium text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors text-left">
                            <div class="w-7 h-7 rounded-lg bg-red-500/10 text-red-500 flex items-center justify-center shrink-0"><i class="fas fa-sign-out-alt text-xs"></i></div> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @else
        <!-- Login CTA -->
        <a href="{{ route('admin.login') }}" class="btn btn-primary btn-sm hidden lg:inline-flex rounded-full px-6">
          Login <i class="fas fa-sign-in-alt ml-1"></i>
        </a>
        @endauth

        <!-- Mobile Menu -->
        <button class="sawa-menu-toggle" id="menu-toggle" aria-label="Open menu">
          <i class="fas fa-bars"></i>
        </button>
      </div>
    </div>
  </nav>

  <!-- Mobile Menu Overlay -->
  <div class="sawa-mobile-overlay" id="menu-overlay"></div>

  <!-- Mobile Menu Drawer -->
  <div class="sawa-mobile-menu" id="mobile-menu" role="dialog" aria-label="Mobile navigation">
    <div class="flex items-center justify-between mb-8">
      <span class="sawa-logo text-xl">Lara</span>
      <button id="menu-close" class="sawa-icon-btn" aria-label="Close menu">
        <i class="fas fa-times"></i>
      </button>
    </div>
    <nav>
      <a href="{{ route('home') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold mb-1 {{ request()->routeIs('home') ? 'bg-primary/10 text-primary' : 'text-gray-600 dark:text-gray-400' }}"><i class="fas fa-home w-5"></i> Home</a>
      <a href="{{ route('articles') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium mb-1 {{ request()->routeIs('articles') ? 'bg-primary/10 text-primary' : 'text-gray-600 dark:text-gray-400' }}"><i class="fas fa-newspaper w-5"></i> Articles</a>
      <a href="{{ route('categories') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium mb-1 {{ request()->routeIs('categories') ? 'bg-primary/10 text-primary' : 'text-gray-600 dark:text-gray-400' }}"><i class="fas fa-tag w-5"></i> Categories</a>
      <a href="{{ route('authors') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium mb-1 {{ request()->routeIs('authors') ? 'bg-primary/10 text-primary' : 'text-gray-600 dark:text-gray-400' }}"><i class="fas fa-users w-5"></i> Authors</a>
      <a href="{{ route('about') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium mb-1 {{ request()->routeIs('about') ? 'bg-primary/10 text-primary' : 'text-gray-600 dark:text-gray-400' }}"><i class="fas fa-info-circle w-5"></i> About</a>
      <a href="{{ route('contact') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium mb-1 {{ request()->routeIs('contact') ? 'bg-primary/10 text-primary' : 'text-gray-600 dark:text-gray-400' }}"><i class="fas fa-envelope w-5"></i> Contact</a>
    </nav>
    <div class="mt-6 pt-6" style="border-top:1px solid var(--color-border)">
      <a href="#newsletter-section" onclick="document.getElementById('mobile-menu')?.classList.remove('active'); document.getElementById('menu-overlay')?.classList.remove('active'); setTimeout(function(){ document.querySelector('#newsletter-section input[type=email]')?.focus(); }, 300);" class="btn btn-primary w-full justify-center">
        <i class="fas fa-bell"></i> Subscribe to Newsletter
      </a>
    </div>
  </div>

  <!-- ==========================================
       SEARCH MODAL
       ========================================== -->
  <div class="search-modal" id="search-modal" role="dialog" aria-label="Search">
    <div class="search-modal-box">
      <form action="{{ route('search') }}" method="GET" class="w-full m-0 p-0">
        <div class="search-modal-input-wrap">
          <i class="fas fa-search" style="color:var(--color-text-muted)"></i>
          <input type="search" name="q" id="search-modal-input" class="search-modal-input" placeholder="Search articles, authors, topics…" autocomplete="off" />
          <button type="button" id="search-close" class="sawa-icon-btn text-sm" aria-label="Close search">
            <i class="fas fa-times"></i>
          </button>
        </div>
      </form>
      <div id="search-modal-results" class="max-h-96 overflow-y-auto"></div>
      <div class="px-4 py-3 flex items-center gap-4 text-xs" style="border-top:1px solid var(--color-border);color:var(--color-text-muted)">
        <span><kbd class="bg-gray-100 dark:bg-gray-800 px-1.5 py-0.5 rounded text-xs">↵</kbd> select</span>
        <span><kbd class="bg-gray-100 dark:bg-gray-800 px-1.5 py-0.5 rounded text-xs">Esc</kbd> close</span>
        <span><kbd class="bg-gray-100 dark:bg-gray-800 px-1.5 py-0.5 rounded text-xs">⌘K</kbd> open</span>
      </div>
    </div>
  </div>

  <main>
   @yield('content')
  </main>

  <!-- ==========================================
       FOOTER
       ========================================== -->
  <footer class="sawa-footer border-t border-gray-200/60 dark:border-gray-800/60 mt-10" role="contentinfo">
    <div class="sawa-container">
      <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-10 mb-12">
        <!-- Brand -->
        <div class="lg:col-span-1">
          <a href="/" class="footer-logo block">
            <img src="{{ optional(\App\Models\GeneralSetting::getSettings())->blog_logo ? asset('images/settings/' . \App\Models\GeneralSetting::getSettings()->blog_logo) : asset('Front/src/images/logo.png') }}" alt="{{ optional(\App\Models\GeneralSetting::getSettings())->blog_name ?? 'LaraTech' }}" style="height:40px;width:auto;object-fit:contain;" />
          </a>
          <p class="text-sm leading-relaxed mb-6" style="color:#64748B">
            {{ optional(\App\Models\GeneralSetting::getSettings())->blog_description ?? 'A premium platform for developers, designers, and tech enthusiasts. Curated knowledge, expertly crafted.' }}
          </p>
          <div class="footer-social">
            <a href="javascript:void(0)" aria-label="Twitter" class="social-twitter"><i class="fab fa-twitter"></i></a>
            <a href="javascript:void(0)" aria-label="LinkedIn" class="social-linkedin"><i class="fab fa-linkedin"></i></a>
            <a href="javascript:void(0)" aria-label="GitHub" class="social-github"><i class="fab fa-github"></i></a>
            <a href="javascript:void(0)" aria-label="YouTube" class="social-youtube"><i class="fab fa-youtube"></i></a>
            <a href="javascript:void(0)" aria-label="RSS Feed"><i class="fas fa-rss"></i></a>
          </div>
        </div>

        <!-- Quick Links -->
        <div>
          <h3 class="font-bold text-white mb-5 text-sm uppercase tracking-wider">Quick Links</h3>
          <ul class="footer-links">
            <li><a href="{{ route('home') }}">Home</a></li>
            <li><a href="{{ route('articles') }}">All Articles</a></li>
            <li><a href="{{ route('categories') }}">Categories</a></li>
            <li><a href="{{ route('authors') }}">Authors</a></li>
            <li><a href="{{ route('about') }}">About Us</a></li>
            <li><a href="{{ route('contact') }}">Contact</a></li>
          </ul>
        </div>

        <!-- Categories -->
        <div>
          <h3 class="font-bold text-white mb-5 text-sm uppercase tracking-wider">Categories</h3>
          <ul class="footer-links">
            @php
              $footerCategories = \App\Models\Category::withCount('posts')->orderBy('posts_count', 'desc')->take(6)->get();
            @endphp
            @forelse($footerCategories as $fCat)
              <li><a href="{{ route('category.posts', $fCat->slug) }}">{{ $fCat->name }}</a></li>
            @empty
              <li><a href="{{ route('categories') }}">Browse Categories</a></li>
            @endforelse
          </ul>
        </div>

        <!-- Newsletter -->
        <div id="newsletter-section">
          @livewire('newsletter-form')
        </div>
      </div>

      <div class="footer-bottom flex-wrap">
        <p class="text-sm" style="color:#64748B">© {{ date('Y') }} {{ optional(\App\Models\GeneralSetting::getSettings())->blog_name ?? 'LaraTech' }}. All rights reserved.</p>
        <div class="flex items-center gap-6">
          <a href="{{ route('privacy') }}" class="text-sm" style="color:#64748B" onmouseover="this.style.color='#7C6EE8'" onmouseout="this.style.color='#64748B'">Privacy Policy</a>
          <a href="{{ route('terms') }}" class="text-sm" style="color:#64748B" onmouseover="this.style.color='#7C6EE8'" onmouseout="this.style.color='#64748B'">Terms of Service</a>
          <a href="{{ route('cookies') }}" class="text-sm" style="color:#64748B" onmouseover="this.style.color='#7C6EE8'" onmouseout="this.style.color='#64748B'">Cookie Policy</a>
        </div>
      </div>
    </div>
  </footer>

  <!-- Back to Top -->
  <button id="back-to-top" aria-label="Scroll to top">
    <i class="fas fa-arrow-up"></i>
  </button>

  <!-- Cookie Banner -->
  <div id="cookie-banner" style="display:none;transition:transform 0.4s ease">
    <p class="text-sm" style="color:var(--color-text-secondary)">
      🍪 We use cookies to enhance your experience. By continuing to visit this site you agree to our use of cookies.
      <a href="{{ route('cookies') }}" style="color:var(--color-primary);font-weight:600">Learn more</a>
    </p>
    <div class="flex gap-2 flex-shrink-0">
      <button id="cookie-decline" class="btn btn-outline btn-sm">Decline</button>
      <button id="cookie-accept" class="btn btn-primary btn-sm">Accept All</button>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <script src="{{ asset('Front/src/js/animations.js') }}"></script>
  <script src="{{ asset('Front/src/js/slider.js') }}"></script>
  <script src="{{ asset('Front/src/js/search.js') }}"></script>
  <script src="{{ asset('Front/src/js/app.js') }}"></script>

  <script src="{{ asset('extra-assets/ijabo/ijabo.min.js') }}"></script>
  <script src="{{ asset('extra-assets/ijabo/ijaboCropTool.min.js') }}"></script>
  <script src="{{ asset('extra-assets/ijabo/jquery.ijaboViewer.min.js') }}"></script>

  <!-- Page-specific scripts -->
  @stack('scripts')
  
  <script>
    document.addEventListener('click', function(event) {
      // Categories Mega Menu
      const catBtn = document.getElementById('categories-btn');
      const catMenu = document.getElementById('categories-mega-menu');
      
      if (catBtn && catMenu) {
        if (catBtn.contains(event.target)) {
          catMenu.classList.toggle('hidden');
        } 
        else if (!catMenu.contains(event.target)) {
          catMenu.classList.add('hidden');
        }
      }

      // User Dropdown Menu
      const userBtn = document.getElementById('user-menu-btn');
      const userMenu = document.getElementById('user-dropdown-menu');
      
      if (userBtn && userMenu) {
        if (userBtn.contains(event.target)) {
          userMenu.classList.toggle('hidden');
        } 
        else if (!userMenu.contains(event.target)) {
          userMenu.classList.add('hidden');
        }
      }
    });

    function hideAllSubmenus() {
      document.querySelectorAll('.category-submenu').forEach(el => el.classList.add('hidden'));
    }
    
    function showSubmenu(id, itemElement) {
      hideAllSubmenus();
      const submenu = document.getElementById(id);
      if (submenu) {
        submenu.classList.remove('hidden');
        
        // Calculate vertical position relative to the wrapper
        const wrapper = document.getElementById('categories-mega-menu').firstElementChild;
        const itemRect = itemElement.getBoundingClientRect();
        const wrapperRect = wrapper.getBoundingClientRect();
        
        let topPos = itemRect.top - wrapperRect.top;
        
        submenu.style.top = topPos + 'px';
      }
    }
  </script>

  @livewireScripts
  <script>
    window.addEventListener('showToast', function(event) {
      const data = event.detail ? (Array.isArray(event.detail) ? event.detail[0] : event.detail) : null;
      if (data) {
        if (typeof ijabo !== 'undefined' && typeof ijabo.showToast === 'function') {
          ijabo.showToast(data.message, data.type || 'success');
        } else if (typeof window.showToast === 'function') {
          window.showToast(data.message);
        }
      }
    });
  </script>
</body>
</html>
