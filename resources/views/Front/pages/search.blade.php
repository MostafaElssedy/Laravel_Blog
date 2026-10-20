@extends('Front.layout.pages')

@section('title', 'Search Results: ' . $query)

@section('content')
<section class="pb-20 dark:bg-[#0f172a] min-h-[80vh] relative overflow-hidden">
  
  <!-- Premium Search Header (Cyber-SaaS Stripe Style) -->
  <div class="sawa-container pt-12 md:pt-16 mb-16 relative z-10">
      <div class="relative rounded-3xl p-[1.5px] bg-gradient-to-r from-primary via-accent to-primary background-animate" data-aos="fade-up">
          
          <div class="relative bg-white dark:bg-[#0f172a] rounded-[23px] p-6 md:p-8 flex flex-col md:flex-row items-center justify-between z-10 overflow-hidden shadow-xl">
              
              <div class="absolute right-0 top-0 w-64 h-64 bg-gradient-to-bl from-primary/20 to-transparent rounded-full blur-3xl -translate-y-1/2 translate-x-1/2 pointer-events-none"></div>
              
              <div class="flex flex-col md:flex-row items-center text-center md:text-left gap-5 md:gap-6 relative z-20">
                  <!-- Search Icon -->
                  <div class="w-16 h-16 shrink-0 rounded-2xl bg-gradient-to-br from-primary to-accent flex items-center justify-center text-white shadow-lg shadow-primary/30 rotate-3 hover:rotate-0 transition-transform duration-300">
                      <i class="fas fa-search text-3xl"></i>
                  </div>
                  
                  <div>
                      <p class="text-[10px] md:text-xs font-bold text-primary uppercase tracking-widest mb-1.5 flex items-center justify-center md:justify-start gap-1.5">
                          <i class="fas fa-poll-h"></i> Search Results
                      </p>
                      <h1 class="text-4xl md:text-5xl font-black text-gray-900 dark:text-white tracking-tight">
                        "{{ $query }}"
                      </h1>
                  </div>
              </div>

              <!-- Stats Pill -->
              <div class="mt-6 md:mt-0 px-5 py-2.5 rounded-full bg-gray-50/80 dark:bg-gray-800/80 border border-gray-200 dark:border-gray-700 flex items-center gap-3 backdrop-blur-md relative z-20 hover:bg-white dark:hover:bg-gray-800 transition-colors cursor-default">
                  <div class="relative flex h-2.5 w-2.5">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-primary"></span>
                  </div>
                  <span class="text-sm font-medium text-gray-600 dark:text-gray-300">
                    <span class="text-gray-900 dark:text-white font-black">{{ $posts->total() }}</span> Articles Found
                  </span>
              </div>
          </div>
      </div>
  </div>

  <div class="sawa-container relative z-10">
    <!-- Posts Grid -->
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
      @forelse($posts as $index => $post)
      <!-- Article -->
      <article class="article-card">
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
      @empty
      <div class="col-span-full text-center py-20" data-aos="fade-up">
        <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-gray-50 dark:bg-gray-800/50 mb-6 text-gray-400 border border-gray-100 dark:border-gray-800">
          <i class="fas fa-search-minus text-4xl"></i>
        </div>
        <h3 class="text-2xl font-bold mb-2" style="color:var(--color-text-primary)">No articles found</h3>
        <p style="color:var(--color-text-secondary)">We couldn't find any articles matching "{{ $query }}". Please try another search term.</p>
        <div class="mt-8 flex justify-center max-w-md mx-auto">
            <form action="{{ route('search') }}" method="GET" class="relative w-full shadow-lg rounded-lg">
                <input type="text" name="q" placeholder="Try a different search..." 
                       class="w-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 dark:text-gray-200 rounded-lg py-3 pl-4 pr-12 text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all">
                <button type="submit" class="absolute right-0 top-0 bottom-0 px-4 text-white rounded-r-lg hover:bg-opacity-90 transition-colors flex items-center justify-center" style="background-color:#7B68EE">
                  <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
      </div>
      @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-8 flex justify-center w-full" data-aos="fade-up">
      {{ $posts->appends(['q' => $query])->links('vendor.pagination.tailwind') }}
    </div>

  </div>
</section>
@endsection
