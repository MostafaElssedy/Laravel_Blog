@extends('Front.layout.pages')

@section('title', isset($title) ? $title : 'Home')

@section('content')
 <!-- ==========================================
         MAIN LAYOUT: FEATURED POST & SIDEBAR
         ========================================== -->
    <section class="pt-6 pb-12 lg:pt-10">
      <div class="sawa-container">
        <div class="grid lg:grid-cols-3 gap-8">
          
          <!-- Left: Main Featured Post(s) -->
          <div class="lg:col-span-2">
            <!-- Swiper Slider -->
            <div class="swiper main-hero-swiper bg-white dark:bg-[#151f32] pb-10 rounded-2xl shadow-sm border border-gray-100 overflow-hidden" data-aos="fade-up">
              <div class="swiper-wrapper">
                
                @foreach($featuredPosts as $post)
                <!-- Slide -->
                <div class="swiper-slide">
                  <article class="h-full flex flex-col">
                    <div class="relative w-full aspect-[16/9] overflow-hidden group">
                      <img src="{{ $post->featured_image ? asset('images/posts/' . $post->featured_image) : 'https://images.unsplash.com/photo-1518770660439-4636190af475?w=1200&q=80' }}" 
                           class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" 
                           alt="{{ $post->title }}" />
                      @if($post->category)
                      <div class="absolute bottom-6 left-6 z-10">
                        <span class="bg-black/70 text-white px-4 py-1.5 rounded text-sm font-semibold backdrop-blur-md">{{ $post->category->name }}</span>
                      </div>
                      @endif
                    </div>
                    <div class="p-6 md:p-8 flex-1 flex flex-col">
                      <h2 class="text-2xl md:text-3xl font-bold mb-4 leading-tight" style="color:var(--color-text-primary)">
                        <a href="{{ route('post.show', $post->slug) }}" class="hover:text-primary transition-colors">{{ $post->title }}</a>
                      </h2>
                      <p class="mb-6 text-gray-600 dark:text-gray-400 line-clamp-3 leading-relaxed">
                        {{ \Illuminate\Support\Str::limit(strip_tags($post->content ?? ''), 150) }}
                      </p>
                      
                      <div class="flex flex-wrap items-center gap-4 text-sm mt-auto pt-4 border-t border-gray-100 dark:border-gray-800" style="color:var(--color-text-muted)">
                        <a href="{{ route('author.posts', optional($post->author)->username ?? 'admin') }}" class="flex items-center gap-1.5 hover:text-primary transition-colors"><i class="fas fa-user text-gray-400"></i> {{ optional($post->author)->name ?? optional($post->author)->username ?? 'Admin' }}</a>
                        <span class="flex items-center gap-1.5"><i class="fas fa-calendar-alt text-gray-400"></i> {{ optional($post->created_at)->format('M d, Y') ?? '' }}</span>
                        @if($post->tags)
                        <span class="flex items-center gap-1.5"><i class="fas fa-tags text-gray-400"></i> {{ $post->tags }}</span>
                        @endif
                      </div>
                    </div>
                  </article>
                </div>
                @endforeach

              </div>
              
              <!-- Navigation & Pagination overlay -->
              <div class="swiper-pagination mb-4"></div>
              
              <div class="main-hero-prev absolute left-4 z-50 flex items-center justify-center !text-white bg-black/40 hover:bg-primary rounded-full w-12 h-12 backdrop-blur-md transition-colors cursor-pointer shadow-lg border border-white/20" style="top:35%; transform: translateY(-50%);">
                <i class="fas fa-chevron-left text-xl !text-white"></i>
              </div>
              <div class="main-hero-next absolute right-4 z-50 flex items-center justify-center !text-white bg-black/40 hover:bg-primary rounded-full w-12 h-12 backdrop-blur-md transition-colors cursor-pointer shadow-lg border border-white/20" style="top:35%; transform: translateY(-50%);">
                <i class="fas fa-chevron-right text-xl !text-white"></i>
              </div>
            </div>
          </div>

          <!-- Right: Sidebar -->
          <div class="relative w-full h-full" data-aos="fade-left" data-aos-delay="100">
            <div class="lg:absolute lg:inset-0 flex flex-col gap-8">
            
            <!-- Search Widget -->
            <div class="bg-white dark:bg-[#151f32] p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 shrink-0">
              <h3 class="text-lg font-bold mb-4 pb-3 border-b border-gray-100 dark:border-gray-800" style="color:var(--color-text-primary)">Search</h3>
              <form action="{{ route('search') }}" method="GET" class="relative">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Type to discover articles..." 
                       class="w-full bg-gray-50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700 dark:text-gray-200 rounded-lg py-3 pl-4 pr-12 text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all">
                <button type="submit" class="absolute right-0 top-0 bottom-0 px-4 text-white rounded-r-lg hover:bg-opacity-90 transition-colors flex items-center justify-center" style="background-color:#7B68EE">
                  <i class="fas fa-search"></i>
                </button>
              </form>
            </div>

            <!-- Categories Widget -->
            <div class="bg-white dark:bg-[#151f32] p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 shrink-0">
              <h3 class="text-lg font-bold mb-4 pb-3 border-b border-gray-100 dark:border-gray-800" style="color:var(--color-text-primary)">Categories</h3>
              <ul class="space-y-3">
                @foreach($sidebarCategories as $category)
                <li>
                  <a href="{{ route('category.posts', $category->slug ?? '') }}" class="flex items-center justify-between text-sm hover:text-primary transition-colors" style="color:var(--color-text-secondary)">
                    <span>{{ $category->name }}</span>
                    <span class="text-xs" style="color:var(--color-text-muted)">({{ $category->posts_count }})</span>
                  </a>
                </li>
                @endforeach
              </ul>
            </div>

            <!-- Tags Widget -->
            <div class="bg-white dark:bg-[#151f32] p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 flex-1 flex flex-col min-h-[250px]">
              <h3 class="text-lg font-bold mb-4 pb-3 border-b border-gray-100 dark:border-gray-800 shrink-0" style="color:var(--color-text-primary)">Tags</h3>
              <div class="flex flex-wrap gap-2 overflow-y-auto custom-scrollbar pr-2 flex-1 content-start">
                @foreach($sidebarTags as $tag)
                <a href="{{ route('tag.posts', $tag) }}" class="px-4 py-1.5 bg-gray-50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700 rounded-full text-xs font-medium hover:border-primary hover:text-primary transition-colors" style="color:var(--color-text-secondary)">{{ $tag }}</a>
                @endforeach
              </div>
            </div>

            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ==========================================
         LATEST ARTICLES GRID
         ========================================== -->
    <section class="section-py bg-gray-50 dark:bg-[#151f32]" aria-labelledby="latest-heading">
      <div class="sawa-container">
        <div class="flex items-center justify-between mb-10">
          <div>
            <p class="section-label"><i class="fas fa-clock-rotate-left"></i> Recent</p>
            <h2 class="section-title" id="latest-heading">Latest Articles</h2>
          </div>
          <a href="{{ route('articles') }}" class="btn btn-outline hidden md:inline-flex">
            View All <i class="fas fa-arrow-right"></i>
          </a>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6" data-stagger data-stagger-delay="100">
          @foreach($latestPosts as $index => $post)
          <!-- Article -->
          <article class="article-card" data-stagger-child data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
            <div class="article-card-img">
              <img src="{{ $post->featured_image ? asset('images/posts/' . $post->featured_image) : 'https://images.unsplash.com/photo-1558655146-9f40138edfeb?w=600&q=80' }}" alt="{{ $post->title }}" loading="lazy" class="w-full h-full object-cover" />
              @if($post->category)
              <span class="absolute top-4 left-4 badge badge-accent">{{ $post->category->name }}</span>
              @endif
            </div>
            <div class="article-card-body flex flex-col h-full">
                <div class="article-card-meta mb-3 flex items-center justify-between">
                  <div class="flex items-center gap-2">
                    <a href="{{ route('author.posts', optional($post->author)->username ?? 'admin') }}" class="w-7 h-7 shrink-0 rounded-full overflow-hidden bg-gray-100 dark:bg-gray-800 ring-2 ring-transparent hover:ring-primary transition-all shadow-sm">
                      @if(optional($post->author)->profile_image)
                        <img src="{{ asset('images/users/' . $post->author->profile_image) }}" alt="{{ optional($post->author)->name }}" class="w-full h-full object-cover">
                      @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(optional($post->author)->name ?? 'Admin') }}&background=random&color=fff&bold=true" alt="{{ optional($post->author)->name ?? 'Admin' }}" class="w-full h-full object-cover">
                      @endif
                    </a>
                    <a href="{{ route('author.posts', optional($post->author)->username ?? 'admin') }}" class="text-sm font-bold hover:text-primary transition-colors" style="color:var(--color-text-primary)">
                      {{ optional($post->author)->name ?? 'Admin' }}
                    </a>
                  </div>
                  <span class="text-xs font-medium px-2 py-1 rounded-md bg-gray-50 dark:bg-gray-800/50" style="color:var(--color-text-muted)">
                    {{ optional($post->created_at)->format('M d, Y') ?? '' }}
                  </span>
                </div>
              <h3 class="article-card-title"><a href="{{ route('post.show', $post->slug) }}">{{ $post->title }}</a></h3>
              <p class="article-card-excerpt">{{ \Illuminate\Support\Str::limit(strip_tags($post->content ?? ''), 80) }}</p>
              <div class="article-card-footer mt-auto pt-4">
                <a href="{{ route('post.show', $post->slug) }}" class="btn btn-secondary btn-sm w-full text-center">Read More</a>
              </div>
            </div>
          </article>
          @endforeach
        </div>
      </div>
    </section>

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    if(typeof Swiper !== 'undefined') {
      new Swiper('.main-hero-swiper', {
        loop: true,
        spaceBetween: 20,
        slidesPerView: 1,
        autoplay: {
          delay: 5000,
          disableOnInteraction: false,
          pauseOnMouseEnter: true,
        },
        pagination: {
          el: '.main-hero-swiper .swiper-pagination',
          clickable: true,
        },
        navigation: {
          nextEl: '.main-hero-swiper .main-hero-next',
          prevEl: '.main-hero-swiper .main-hero-prev',
        },
        effect: 'fade',
        fadeEffect: {
          crossFade: true
        },
        speed: 800,
      });
    }
  });
</script>
@endpush

@endsection