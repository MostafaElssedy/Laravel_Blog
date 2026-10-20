@extends('Front.layout.pages')

@section('title', 'Categories')

@section('content')
<section class="pb-20 dark:bg-[#0f172a] min-h-[80vh] relative overflow-hidden">
  
  <!-- Premium Header (Cyber-SaaS Stripe Style) -->
  <div class="sawa-container pt-12 md:pt-16 mb-16 relative z-10">
      <div class="relative rounded-3xl p-[1.5px] bg-gradient-to-r from-primary via-accent to-primary background-animate" data-aos="fade-up">
          
          <div class="relative bg-white dark:bg-[#0f172a] rounded-[23px] p-6 md:p-8 flex flex-col md:flex-row items-center justify-between z-10 overflow-hidden shadow-xl">
              
              <div class="absolute right-0 top-0 w-64 h-64 bg-gradient-to-bl from-primary/20 to-transparent rounded-full blur-3xl -translate-y-1/2 translate-x-1/2 pointer-events-none"></div>
              
              <div class="flex flex-col md:flex-row items-center text-center md:text-left gap-5 md:gap-6 relative z-20">
                  <div class="w-16 h-16 shrink-0 rounded-2xl bg-gradient-to-br from-primary to-accent flex items-center justify-center text-white shadow-lg shadow-primary/30 rotate-3 hover:rotate-0 transition-transform duration-300">
                      <i class="fas fa-folder-tree text-3xl"></i>
                  </div>
                  
                  <div>
                      <p class="text-[10px] md:text-xs font-bold text-primary uppercase tracking-widest mb-1.5 flex items-center justify-center md:justify-start gap-1.5">
                          <i class="fas fa-tags"></i> Topics & Subjects
                      </p>
                      <h1 class="text-4xl md:text-5xl font-black text-gray-900 dark:text-white tracking-tight">
                        Categories
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
                    <span class="text-gray-900 dark:text-white font-black">{{ $allCategories->count() }}</span> Categories Total
                  </span>
              </div>
          </div>
      </div>
  </div>

  <div class="sawa-container relative z-10">
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
      @forelse($parentCategories as $index => $parent)
      <div class="p-6 md:p-8 rounded-3xl bg-white dark:bg-[#151f32] border border-gray-100 dark:border-gray-800 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1" data-aos="fade-up" data-aos-delay="{{ ($index % 3) * 100 }}">
        <div class="flex items-center gap-4 mb-6 pb-4 border-b border-gray-100 dark:border-gray-800">
          <div class="w-12 h-12 rounded-2xl bg-primary/10 text-primary flex items-center justify-center text-xl shrink-0">
            <i class="fas fa-folder-open"></i>
          </div>
          <div>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ $parent->name }}</h3>
            <p class="text-xs text-gray-400 mt-0.5">{{ $parent->subcategories->count() }} subcategories</p>
          </div>
        </div>

        <div class="flex flex-col gap-2.5">
          @forelse($parent->subcategories as $sub)
          <a href="{{ route('category.posts', $sub->slug) }}" class="group flex items-center justify-between px-4 py-3 rounded-xl bg-gray-50 dark:bg-gray-800/60 hover:bg-primary hover:text-white transition-all text-sm font-medium text-gray-700 dark:text-gray-300">
            <span class="flex items-center gap-2.5 group-hover:text-white">
              <i class="fas fa-tag text-xs text-accent group-hover:text-white transition-colors"></i>
              {{ $sub->name }}
            </span>
            <span class="text-xs px-2.5 py-1 rounded-full bg-white dark:bg-gray-700 group-hover:bg-white/20 group-hover:text-white text-gray-500 dark:text-gray-400 font-semibold transition-colors">
              {{ $sub->posts_count }}
            </span>
          </a>
          @empty
          <p class="text-xs text-gray-400 italic py-2">No subcategories under this group.</p>
          @endforelse
        </div>
      </div>
      @empty
      <div class="col-span-full text-center py-20" data-aos="fade-up">
        <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-gray-50 dark:bg-gray-800/50 mb-6 text-gray-400 border border-gray-100 dark:border-gray-800">
          <i class="fas fa-folder-open text-4xl"></i>
        </div>
        <h3 class="text-2xl font-bold mb-2" style="color:var(--color-text-primary)">No categories found</h3>
        <p style="color:var(--color-text-secondary)">Categories will appear here once added in the control panel.</p>
      </div>
      @endforelse
    </div>
  </div>
</section>
@endsection
