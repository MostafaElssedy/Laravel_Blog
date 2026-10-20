@extends('Front.layout.pages')

@section('title', $post->title)

@push('styles')
<style>
    /* Floating Social Share */
    .sticky-share-container {
        position: sticky;
        top: 120px;
        z-index: 50;
    }
    
    .social-share-btn {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--color-bg-light, #f9fafb);
        color: var(--color-text-muted, #9ca3af);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(0,0,0,0.02);
    }
    
    .dark .social-share-btn {
        background: #1e293b;
        border-color: rgba(255,255,255,0.05);
    }
    
    .social-share-btn:hover {
        transform: translateY(-3px) scale(1.05);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        color: white;
    }
    
    .social-share-btn.fb:hover { background-color: #1877F2; }
    .social-share-btn.x:hover { background-color: #000000; }
    .social-share-btn.li:hover { background-color: #0A66C2; }
    .social-share-btn.link:hover { background-color: var(--color-primary, #7B68EE); }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="relative pt-12 pb-24 lg:pt-16 bg-gray-50 dark:bg-[#0f172a] overflow-hidden">
    <div class="absolute inset-0 z-0">
        <img src="{{ $post->featured_image ? asset('images/posts/' . $post->featured_image) : 'https://images.unsplash.com/photo-1518770660439-4636190af475?w=1200&q=80' }}" class="w-full h-full object-cover opacity-10" alt="{{ $post->title }}">
        <div class="absolute inset-0 bg-gradient-to-b from-gray-50/90 via-gray-50/95 to-gray-50 dark:from-[#0f172a]/90 dark:via-[#0f172a]/95 dark:to-[#0f172a]"></div>
    </div>
    <div class="sawa-container relative z-10 max-w-4xl mx-auto text-center" data-aos="fade-up">
        @if($post->category)
        <a href="{{ route('category.posts', $post->category->slug) }}" class="inline-block mb-6 px-4 py-1.5 rounded-full text-sm font-semibold tracking-wide bg-primary/10 text-primary border border-primary/20 hover:bg-primary hover:text-white transition-colors">
            {{ $post->category->name }}
        </a>
        @endif
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-black mb-6 text-gray-900 dark:text-white leading-tight">
            {{ $post->title }}
        </h1>
        
        <div class="flex flex-wrap items-center justify-center gap-6 text-sm text-gray-600 dark:text-gray-400 mt-8">
            <div class="flex items-center gap-3">
                <a href="{{ route('author.posts', optional($post->author)->username ?? 'admin') }}" class="w-10 h-10 rounded-full overflow-hidden shadow-sm">
                    @if(optional($post->author)->profile_image)
                        <img src="{{ asset('images/users/' . $post->author->profile_image) }}" alt="{{ optional($post->author)->name }}" class="w-full h-full object-cover">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(optional($post->author)->name ?? 'Admin') }}&background=random&color=fff&bold=true" alt="{{ optional($post->author)->name ?? 'Admin' }}" class="w-full h-full object-cover">
                    @endif
                </a>
                <a href="{{ route('author.posts', optional($post->author)->username ?? 'admin') }}" class="font-bold hover:text-primary transition-colors text-gray-900 dark:text-white">
                    {{ optional($post->author)->name ?? 'Admin' }}
                </a>
            </div>
            <span class="w-1.5 h-1.5 rounded-full bg-gray-300 dark:bg-gray-700"></span>
            <span class="flex items-center gap-2">
                <i class="far fa-calendar-alt"></i> {{ optional($post->created_at)->format('M d, Y') ?? '' }}
            </span>
        </div>
    </div>
</section>

<!-- Content Section -->
<section class="py-12 -mt-16 relative z-20">
    <div class="sawa-container max-w-6xl mx-auto flex flex-col lg:flex-row gap-8">
        
        <!-- Left Sidebar: Social Share (Sticky & Improved) -->
        <div class="hidden lg:block w-20 shrink-0">
            <div class="sticky-share-container flex flex-col items-center bg-white dark:bg-[#151f32] p-3 py-8 rounded-full shadow-xl shadow-gray-200/40 dark:shadow-none border border-gray-100 dark:border-gray-800 transition-all duration-300 hover:shadow-2xl hover:shadow-gray-200/50 w-full">
                <span class="text-[11px] font-bold text-gray-400 uppercase tracking-[0.25em] mb-6 select-none" style="writing-mode: vertical-rl; transform: rotate(180deg);">SHARE</span>
                <div class="flex flex-col gap-3 w-full items-center">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('post.show', $post->slug)) }}" target="_blank" class="social-share-btn fb" title="Share on Facebook">
                        <i class="fab fa-facebook-f text-base"></i>
                    </a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('post.show', $post->slug)) }}&text={{ urlencode($post->title) }}" target="_blank" class="social-share-btn x" title="Share on X">
                        <i class="fab fa-x-twitter text-base"></i>
                    </a>
                    <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(route('post.show', $post->slug)) }}&title={{ urlencode($post->title) }}" target="_blank" class="social-share-btn li" title="Share on LinkedIn">
                        <i class="fab fa-linkedin-in text-base"></i>
                    </a>
                    <button onclick="copyToClipboard(this)" class="social-share-btn link" title="Copy Link">
                        <i class="fas fa-link text-base"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Main Article Area -->
        <div class="flex-1 bg-white dark:bg-[#151f32] rounded-3xl shadow-xl shadow-gray-200/50 dark:shadow-none border border-gray-100 dark:border-gray-800 p-8 md:p-12 lg:p-16" data-aos="fade-up" data-aos-delay="100">
            <!-- Featured Image -->
            @if($post->featured_image)
            <div class="rounded-2xl overflow-hidden mb-12 shadow-lg">
                <img src="{{ asset('images/posts/' . $post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-auto object-cover max-h-[500px]">
            </div>
            @endif
            
            <!-- Article Body -->
            <div class="prose prose-lg prose-primary dark:prose-invert max-w-none">
                {!! $post->content !!}
            </div>

            <!-- Tags Section -->
            @if($post->tags)
            <div class="mt-12 pt-8 border-t border-gray-100 dark:border-gray-800 flex flex-wrap items-center gap-3">
                <span class="font-semibold text-gray-900 dark:text-white mr-2"><i class="fas fa-tags text-primary"></i> Tags:</span>
                @foreach(explode(',', $post->tags) as $tag)
                @if(trim($tag) != "")
                <a href="{{ route('tag.posts', trim($tag)) }}" class="px-4 py-1.5 bg-gray-50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700 rounded-full text-sm font-medium hover:border-primary hover:text-primary transition-colors text-gray-600 dark:text-gray-400">
                    {{ trim($tag) }}
                </a>
                @endif
                @endforeach
            </div>
            @endif
        </div>

        <!-- Right Spacer for balance (matches left sticky share) -->
        <div class="hidden lg:block w-20 shrink-0"></div>

    </div>
</section>

<!-- Next/Previous Posts Navigation -->
<section class="py-12 bg-gray-50 dark:bg-[#0f172a] border-y border-gray-200 dark:border-gray-800">
    <div class="sawa-container max-w-5xl mx-auto">
        <div class="flex flex-col md:flex-row justify-between gap-6">
            @if($previousPost)
            <a href="{{ route('post.show', $previousPost->slug) }}" class="flex-1 group flex flex-col p-6 rounded-2xl bg-white dark:bg-[#151f32] border border-gray-100 dark:border-gray-800 hover:border-primary/50 transition-all shadow-sm hover:shadow-md">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 group-hover:text-primary transition-colors flex items-center gap-2"><i class="fas fa-arrow-left"></i> Previous Article</span>
                <h4 class="text-lg font-bold text-gray-900 dark:text-white group-hover:text-primary transition-colors line-clamp-2">{{ $previousPost->title }}</h4>
            </a>
            @else
            <div class="flex-1"></div>
            @endif

            @if($nextPost)
            <a href="{{ route('post.show', $nextPost->slug) }}" class="flex-1 group flex flex-col items-end text-right p-6 rounded-2xl bg-white dark:bg-[#151f32] border border-gray-100 dark:border-gray-800 hover:border-primary/50 transition-all shadow-sm hover:shadow-md">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 group-hover:text-primary transition-colors flex items-center gap-2">Next Article <i class="fas fa-arrow-right"></i></span>
                <h4 class="text-lg font-bold text-gray-900 dark:text-white group-hover:text-primary transition-colors line-clamp-2">{{ $nextPost->title }}</h4>
            </a>
            @else
            <div class="flex-1"></div>
            @endif
        </div>
    </div>
</section>

<!-- Related Posts Section -->
@if($relatedPosts && $relatedPosts->count() > 0)
<section class="py-16 bg-white dark:bg-[#151f32]">
    <div class="sawa-container max-w-6xl mx-auto">
        <div class="text-center mb-12">
            <h3 class="text-3xl font-black text-gray-900 dark:text-white">Related Articles</h3>
            <div class="w-16 h-1 bg-primary mx-auto mt-4 rounded-full"></div>
        </div>
        
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($relatedPosts as $index => $relPost)
            <article class="article-card" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                <div class="article-card-img">
                    <img src="{{ $relPost->featured_image ? asset('images/posts/' . $relPost->featured_image) : 'https://images.unsplash.com/photo-1558655146-9f40138edfeb?w=600&q=80' }}" alt="{{ $relPost->title }}" loading="lazy" class="w-full h-full object-cover" />
                    @if($relPost->category)
                    <span class="absolute top-4 left-4 badge badge-accent">{{ $relPost->category->name }}</span>
                    @endif
                </div>
                <div class="article-card-body flex flex-col h-full">
                    <div class="article-card-meta mb-3 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('author.posts', optional($relPost->author)->username ?? 'admin') }}" class="w-7 h-7 shrink-0 rounded-full overflow-hidden bg-gray-100 dark:bg-gray-800 ring-2 ring-transparent hover:ring-primary transition-all shadow-sm">
                                @if(optional($relPost->author)->profile_image)
                                    <img src="{{ asset('images/users/' . $relPost->author->profile_image) }}" alt="{{ optional($relPost->author)->name }}" class="w-full h-full object-cover">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode(optional($relPost->author)->name ?? 'Admin') }}&background=random&color=fff&bold=true" alt="{{ optional($relPost->author)->name ?? 'Admin' }}" class="w-full h-full object-cover">
                                @endif
                            </a>
                            <a href="{{ route('author.posts', optional($relPost->author)->username ?? 'admin') }}" class="text-sm font-bold hover:text-primary transition-colors text-gray-900 dark:text-white">
                                {{ optional($relPost->author)->name ?? 'Admin' }}
                            </a>
                        </div>
                        <span class="text-xs font-medium px-2 py-1 rounded-md bg-gray-50 dark:bg-gray-800/50 text-gray-500">
                            {{ optional($relPost->created_at)->format('M d, Y') ?? '' }}
                        </span>
                    </div>
                    <h3 class="article-card-title"><a href="{{ route('post.show', $relPost->slug) }}">{{ $relPost->title }}</a></h3>
                    <p class="article-card-excerpt">{{ \Illuminate\Support\Str::limit(strip_tags($relPost->content ?? ''), 80) }}</p>
                    <div class="article-card-footer mt-auto pt-4">
                        <a href="{{ route('post.show', $relPost->slug) }}" class="btn btn-secondary btn-sm w-full text-center">Read More</a>
                    </div>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Toast Notification (Hidden by default) -->
<div id="copy-toast" class="fixed bottom-5 left-1/2 -translate-x-1/2 lg:bottom-10 lg:left-10 lg:translate-x-0 bg-gray-900 text-white px-6 py-3 rounded-xl shadow-2xl flex items-center gap-3 transition-all duration-300 opacity-0 pointer-events-none z-50 translate-y-4">
    <div class="w-8 h-8 rounded-full bg-green-500/20 flex items-center justify-center text-green-400">
        <i class="fas fa-check"></i>
    </div>
    <span class="font-medium text-sm">Link copied to clipboard!</span>
</div>

@endsection

@push('scripts')
<script>
    function copyToClipboard(button) {
        navigator.clipboard.writeText(window.location.href).then(() => {
            const toast = document.getElementById('copy-toast');
            // Show toast
            toast.classList.remove('opacity-0', 'translate-y-4');
            toast.classList.add('opacity-100', 'translate-y-0');
            
            // Hide toast after 3 seconds
            setTimeout(() => {
                toast.classList.remove('opacity-100', 'translate-y-0');
                toast.classList.add('opacity-0', 'translate-y-4');
            }, 3000);
        });
    }
</script>
@endpush
