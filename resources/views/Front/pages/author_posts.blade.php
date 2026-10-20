@extends('Front.layout.pages')

@section('title', 'Posts by ' . $author->name)

@section('content')
<section class="pb-20 dark:bg-[#0f172a] min-h-[80vh]">
  <!-- Premium Image Cover -->
  <div class="w-full h-64 md:h-80 relative overflow-hidden bg-[#0f172a]">
      <!-- Photographic Background Image (Laptop, Headphones, iPhone on Elegant Desk) -->
      <img src="{{ asset('assets/images/author_banner.png') }}" alt="Author Cover" class="absolute inset-0 w-full h-full object-cover opacity-80 object-center" />
      
      <!-- Subtle Dark Overlay for contrast -->
      <div class="absolute inset-0 bg-black/40"></div>

      <!-- Bottom Gradient Fade to blend with the page -->
      <div class="absolute bottom-0 left-0 right-0 h-32 bg-gradient-to-t from-gray-50 dark:from-[#0f172a] to-transparent"></div>
  </div>

  <div class="sawa-container relative z-10">
    <!-- Premium Liquid Glass Author Profile Card -->
    <div class="relative -mt-20 md:-mt-24 mb-16 rounded-[2rem] p-6 md:p-8 bg-white/40 dark:bg-[#1E293B]/40 backdrop-blur-2xl shadow-[0_8px_32px_0_rgba(31,38,135,0.1)] border border-white/60 dark:border-white/10 flex flex-col md:flex-row items-center md:items-start gap-6 md:gap-8" data-aos="fade-up">
      
      <!-- Inner reflection line for glass -->
      <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-white/70 dark:via-white/20 to-transparent rounded-t-[2rem]"></div>

      <!-- Avatar with Verified Badge -->
      <div class="shrink-0 relative -mt-16 md:-mt-20 z-10">
        <div class="w-32 h-32 md:w-40 md:h-40 rounded-3xl bg-white dark:bg-[#151f32] p-1.5 shadow-xl relative group">
          <div class="w-full h-full rounded-2xl overflow-hidden bg-gray-100 dark:bg-gray-800">
            @if($author->profile_image)
                <img src="{{ asset('images/users/' . $author->profile_image) }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" alt="{{ $author->name }}">
            @else
                <img src="https://ui-avatars.com/api/?name={{ urlencode($author->name) }}&background=random&color=fff&bold=true" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" alt="{{ $author->name }}">
            @endif
          </div>
          <!-- Verified Checkmark -->
          <div class="absolute -bottom-2 -right-2 w-10 h-10 bg-gradient-to-br from-primary to-accent rounded-full border-4 border-white dark:border-[#1E293B] flex items-center justify-center text-white text-sm shadow-md" title="Verified Author">
            <i class="fas fa-check"></i>
          </div>
        </div>
      </div>

      <!-- Info & Actions -->
      <div class="flex-1 text-center md:text-left mt-2 md:mt-0 w-full relative z-10">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 mb-4">
          
          <!-- Name and Bio -->
          <div>
            <div class="flex items-center justify-center md:justify-start gap-3 mb-2">
                <h1 class="text-3xl md:text-4xl font-black text-gray-900 dark:text-white tracking-tight drop-shadow-sm">
                  {{ $author->name }}
                </h1>
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-primary/10 text-primary font-bold text-xs uppercase tracking-widest border border-primary/20 backdrop-blur-sm">
                  <i class="fas fa-shield-alt"></i> Official
                </span>
            </div>
            
            <p class="text-lg font-semibold text-primary mb-5 drop-shadow-sm">
              {{ $author->bio ?? 'Passionate writer sharing insights and thoughts with the community.' }}
            </p>
            
            <div class="flex flex-wrap items-center justify-center md:justify-start gap-3 text-sm font-medium">
                
                <div class="flex items-center gap-2 px-4 py-2 bg-white/50 dark:bg-gray-800/50 backdrop-blur-md rounded-xl text-gray-800 dark:text-gray-200 font-bold border border-white/50 dark:border-white/10 shadow-sm">
                    <i class="fas fa-file-alt text-primary"></i> {{ $posts->total() }} Published
                </div>

                <button onclick="copyEmailToClipboard('{{ $author->email }}', this)" class="flex items-center gap-2 px-4 py-2 bg-white/50 dark:bg-gray-800/50 backdrop-blur-md rounded-xl text-gray-700 dark:text-gray-300 hover:text-primary dark:hover:text-primary transition-colors relative group outline-none border border-white/50 dark:border-white/10 shadow-sm" title="Copy Email">
                  <i class="fas fa-envelope"></i> <span>{{ $author->email }}</span>
                  <span class="copy-tooltip absolute -top-10 left-1/2 -translate-x-1/2 bg-[#151f32] dark:bg-white text-white dark:text-[#151f32] text-xs font-bold px-3 py-1.5 rounded-lg shadow-xl opacity-0 transition-all duration-300 pointer-events-none whitespace-nowrap flex items-center gap-1.5 transform scale-95 group-hover:scale-100">
                      <span>Copy Email</span>
                  </span>
                </button>

                <div class="flex items-center gap-2 px-4 py-2 bg-white/50 dark:bg-gray-800/50 backdrop-blur-md rounded-xl text-gray-700 dark:text-gray-300 border border-white/50 dark:border-white/10 shadow-sm">
                    <i class="fas fa-calendar-alt"></i> Joined {{ $author->created_at->format('M Y') }}
                </div>
            </div>
          </div>
          
          <!-- Social Buttons -->
          <div class="flex items-center justify-center lg:justify-end gap-3 shrink-0 mt-2 lg:mt-0">
            @if($author->socialLinks)
              @if($author->socialLinks->x)
              <a href="{{ $author->socialLinks->x }}" target="_blank" class="w-12 h-12 rounded-xl bg-white/60 dark:bg-[#0f172a]/60 backdrop-blur-md border border-white/50 dark:border-white/10 flex items-center justify-center text-gray-600 hover:text-white hover:bg-[#000000] hover:border-[#000000] hover:-translate-y-1 transition-all shadow-sm hover:shadow-md">
                <i class="fab fa-x-twitter text-lg"></i>
              </a>
              @endif
              
              @if($author->socialLinks->facebook)
              <a href="{{ $author->socialLinks->facebook }}" target="_blank" class="w-12 h-12 rounded-xl bg-white/60 dark:bg-[#0f172a]/60 backdrop-blur-md border border-white/50 dark:border-white/10 flex items-center justify-center text-gray-600 hover:text-white hover:bg-[#1877F2] hover:border-[#1877F2] hover:-translate-y-1 transition-all shadow-sm hover:shadow-md">
                <i class="fab fa-facebook-f text-lg"></i>
              </a>
              @endif

              @if($author->socialLinks->instagram)
              <a href="{{ $author->socialLinks->instagram }}" target="_blank" class="w-12 h-12 rounded-xl bg-white/60 dark:bg-[#0f172a]/60 backdrop-blur-md border border-white/50 dark:border-white/10 flex items-center justify-center text-gray-600 hover:text-white hover:bg-[#E4405F] hover:border-[#E4405F] hover:-translate-y-1 transition-all shadow-sm hover:shadow-md">
                <i class="fab fa-instagram text-lg"></i>
              </a>
              @endif

              @if($author->socialLinks->linkedin)
              <a href="{{ $author->socialLinks->linkedin }}" target="_blank" class="w-12 h-12 rounded-xl bg-white/60 dark:bg-[#0f172a]/60 backdrop-blur-md border border-white/50 dark:border-white/10 flex items-center justify-center text-gray-600 hover:text-white hover:bg-[#0077B5] hover:border-[#0077B5] hover:-translate-y-1 transition-all shadow-sm hover:shadow-md">
                <i class="fab fa-linkedin-in text-lg"></i>
              </a>
              @endif

              @if($author->socialLinks->github)
              <a href="{{ $author->socialLinks->github }}" target="_blank" class="w-12 h-12 rounded-xl bg-white/60 dark:bg-[#0f172a]/60 backdrop-blur-md border border-white/50 dark:border-white/10 flex items-center justify-center text-gray-600 hover:text-white hover:bg-[#333] hover:border-[#333] hover:-translate-y-1 transition-all shadow-sm hover:shadow-md">
                <i class="fab fa-github text-lg"></i>
              </a>
              @endif
              
              @if($author->socialLinks->youtube)
              <a href="{{ $author->socialLinks->youtube }}" target="_blank" class="w-12 h-12 rounded-xl bg-white/60 dark:bg-[#0f172a]/60 backdrop-blur-md border border-white/50 dark:border-white/10 flex items-center justify-center text-gray-600 hover:text-white hover:bg-[#FF0000] hover:border-[#FF0000] hover:-translate-y-1 transition-all shadow-sm hover:shadow-md">
                <i class="fab fa-youtube text-lg"></i>
              </a>
              @endif

              @if($author->socialLinks->whatsapp)
              <a href="{{ $author->socialLinks->whatsapp }}" target="_blank" class="w-12 h-12 rounded-xl bg-white/60 dark:bg-[#0f172a]/60 backdrop-blur-md border border-white/50 dark:border-white/10 flex items-center justify-center text-gray-600 hover:text-white hover:bg-[#25D366] hover:border-[#25D366] hover:-translate-y-1 transition-all shadow-sm hover:shadow-md">
                <i class="fab fa-whatsapp text-lg"></i>
              </a>
              @endif
            @else
              <div class="px-4 py-2 rounded-xl bg-white/50 dark:bg-gray-800/50 backdrop-blur-md text-gray-500 text-sm font-medium border border-white/50 dark:border-white/10 shadow-sm">
                No Social Links
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>

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
          <div class="article-card-meta mb-2 flex items-center gap-3">
            <span class="text-sm" style="color:var(--color-text-muted)"><i class="fas fa-clock mr-1"></i> {{ optional($post->created_at)->format('M d, Y') ?? '' }}</span>
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
          <i class="fas fa-pen-slash text-4xl"></i>
        </div>
        <h3 class="text-2xl font-bold mb-2" style="color:var(--color-text-primary)">No articles found</h3>
        <p style="color:var(--color-text-secondary)">This author hasn't published any articles yet.</p>
        <a href="{{ route('home') }}" class="btn btn-primary mt-8 inline-flex items-center gap-2"><i class="fas fa-home"></i> Return Home</a>
      </div>
      @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-8 flex justify-center w-full" data-aos="fade-up">
      {{ $posts->links('vendor.pagination.tailwind') }}
    </div>

  </div>
</section>

<script>
function copyEmailToClipboard(email, buttonElement) {
    navigator.clipboard.writeText(email).then(() => {
        const tooltip = buttonElement.querySelector('.copy-tooltip');
        const span = tooltip.querySelector('span');
        
        // Change text and add icon
        span.innerHTML = 'Copied <i class="fas fa-check-circle text-green-400"></i>';
        
        // Show tooltip
        tooltip.classList.remove('opacity-0', 'scale-95');
        tooltip.classList.add('opacity-100', 'scale-100', '-translate-y-2');
        
        // Reset after 2 seconds
        setTimeout(() => {
            tooltip.classList.remove('opacity-100', '-translate-y-2');
            tooltip.classList.add('opacity-0');
            setTimeout(() => {
                span.innerHTML = 'Copy Email';
            }, 300);
        }, 2000);
    }).catch(err => {
        console.error('Failed to copy!', err);
    });
}
</script>
@endsection
