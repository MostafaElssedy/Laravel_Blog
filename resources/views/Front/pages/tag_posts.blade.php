@extends('Front.layout.pages')

@section('title', 'Tag: ' . $tag)

@section('content')
<section class="pb-20 dark:bg-[#0f172a] min-h-[80vh]">
  
  <!-- Premium Tag Header (Cyber-SaaS Stripe Style) -->
  <div class="sawa-container pt-12 md:pt-16 mb-16">
      <div class="relative rounded-3xl p-[1.5px] bg-gradient-to-r from-primary via-accent to-primary background-animate" data-aos="fade-up">
          
          <div class="relative bg-white dark:bg-[#0f172a] rounded-[23px] p-6 md:p-8 flex flex-col md:flex-row items-center justify-between z-10 overflow-hidden shadow-xl">
              
              <div class="absolute right-0 top-0 w-64 h-64 bg-gradient-to-bl from-primary/20 to-transparent rounded-full blur-3xl -translate-y-1/2 translate-x-1/2 pointer-events-none"></div>
              
              <div class="flex flex-col md:flex-row items-center text-center md:text-left gap-5 md:gap-6 relative z-20">
                  <!-- Hashtag Icon -->
                  <div class="w-16 h-16 shrink-0 rounded-2xl bg-gradient-to-br from-primary to-accent flex items-center justify-center text-white shadow-lg shadow-primary/30 rotate-3 hover:rotate-0 transition-transform duration-300">
                      <i class="fas fa-hashtag text-3xl"></i>
                  </div>
                  
                  <div>
                      <p class="text-[10px] md:text-xs font-bold text-primary uppercase tracking-widest mb-1.5 flex items-center justify-center md:justify-start gap-1.5">
                          <i class="fas fa-tag"></i> Browsing Tag
                      </p>
                      <h1 class="text-4xl md:text-5xl font-black text-gray-900 dark:text-white tracking-tight">
                        {{ ucfirst($tag) }}
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

  <div class="sawa-container">
    <!-- Posts Grid -->
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
      @forelse($posts as $index => $post)
      <!-- Article -->
      <article class="article-card">
        <div class="article-card-img">
          <img src="{{ $post->featured_image ? asset('images/posts/' . $post->featured_image) : 'https://images.unsplash.com/photo-1558655146-9f40138edfeb?w=600&q=80' }}" alt="{{ $post->title }}" loading="lazy" class="w-full h-full object-cover" />
          @if($post->category)
          <a href="{{ route('category.posts', $post->category->slug) }}" class="absolute top-4 left-4 badge badge-accent hover:bg-white transition-colors">{{ $post->category->name }}</a>
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
        <div class="col-span-full flex flex-col items-center justify-center py-20 text-center bg-white dark:bg-[#151f32] rounded-3xl border border-gray-100 dark:border-gray-800">
            <div class="w-24 h-24 bg-gray-50 dark:bg-gray-800/50 rounded-full flex items-center justify-center mb-6 text-gray-400 dark:text-gray-500">
                <i class="fas fa-tags text-4xl"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">No Posts Found</h3>
            <p class="text-gray-500 dark:text-gray-400 max-w-md">There are currently no articles associated with the tag <span class="font-bold text-gray-900 dark:text-white">"#{{ $tag }}"</span>.</p>
            <a href="/" class="mt-6 bg-primary hover:bg-primary-dark text-white px-6 py-2.5 rounded-full font-bold transition-all hover:shadow-lg hover:-translate-y-0.5">
                Back to Home
            </a>
        </div>
      @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-12 flex justify-center w-full">
      {{ $posts->links('vendor.pagination.tailwind') }}
    </div>

  </div>
</section>
@endsection