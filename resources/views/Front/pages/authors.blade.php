@extends('Front.layout.pages')

@section('title', 'Authors')

@section('content')
<section class="pb-20 dark:bg-[#0f172a] min-h-[80vh]">
  
  <!-- Premium Authors Header (Cyber-SaaS Stripe Style) -->
  <div class="sawa-container pt-12 md:pt-16 mb-16">
      <div class="relative rounded-3xl p-[1.5px] bg-gradient-to-r from-primary via-accent to-primary background-animate" data-aos="fade-up">
          
          <div class="relative bg-white dark:bg-[#0f172a] rounded-[23px] p-6 md:p-8 flex flex-col md:flex-row items-center justify-between z-10 overflow-hidden shadow-xl">
              
              <div class="absolute right-0 top-0 w-64 h-64 bg-gradient-to-bl from-primary/20 to-transparent rounded-full blur-3xl -translate-y-1/2 translate-x-1/2 pointer-events-none"></div>
              
              <div class="flex flex-col md:flex-row items-center text-center md:text-left gap-5 md:gap-6 relative z-20">
                  <!-- Authors Icon -->
                  <div class="w-16 h-16 shrink-0 rounded-2xl bg-gradient-to-br from-primary to-accent flex items-center justify-center text-white shadow-lg shadow-primary/30 rotate-3 hover:rotate-0 transition-transform duration-300">
                      <i class="fas fa-users text-3xl"></i>
                  </div>
                  
                  <div>
                      <p class="text-[10px] md:text-xs font-bold text-primary uppercase tracking-widest mb-1.5 flex items-center justify-center md:justify-start gap-1.5">
                          <i class="fas fa-pen-nib"></i> Our Writers
                      </p>
                      <h1 class="text-4xl md:text-5xl font-black text-gray-900 dark:text-white tracking-tight">
                        Authors
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
                    <span class="text-gray-900 dark:text-white font-black">{{ $authors->total() }}</span> Active Writers
                  </span>
              </div>
          </div>
      </div>
  </div>

  <div class="sawa-container">
    
    <!-- Authors Grid -->
    <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
      @forelse($authors as $author)
        <!-- Normal Square Card Wrapper with Overlapping Avatar -->
        <div class="relative group aspect-square h-auto w-full max-w-[320px] mx-auto mt-12">
            
            <!-- Solid Card -->
            <a href="{{ route('author.posts', $author->username) }}" class="block h-full w-full bg-white dark:bg-[#151f32] border border-gray-100 dark:border-gray-800 shadow-sm hover:shadow-xl rounded-[32px] transition-all duration-300 group-hover:-translate-y-2 relative flex flex-col justify-end items-center text-center p-6 sm:p-8 pt-20 sm:pt-24">
                
                <!-- Avatar Overlapping Top Edge -->
                <div class="absolute -top-12 left-1/2 -translate-x-1/2 z-20">
                    <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-full overflow-hidden border-4 border-white dark:border-[#151f32] shadow-lg group-hover:scale-105 transition-transform duration-300 bg-gray-100 dark:bg-gray-800">
                        @if($author->profile_image)
                            <img src="{{ asset('images/users/' . $author->profile_image) }}" alt="{{ $author->name }}" class="w-full h-full object-cover">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($author->name) }}&background=random&color=fff&bold=true" alt="{{ $author->name }}" class="w-full h-full object-cover">
                        @endif
                    </div>
                    
                    <!-- Verified Badge -->
                    <div class="absolute bottom-0 right-1 w-7 h-7 bg-white dark:bg-[#151f32] rounded-full flex items-center justify-center shadow-md border-2 border-white dark:border-[#151f32] z-30">
                        <i class="fas fa-check-circle text-primary text-sm"></i>
                    </div>
                </div>

                <!-- Content -->
                <div class="z-10 flex flex-col items-center w-full h-full justify-between mt-4">
                    <div class="w-full">
                        <h3 class="text-xl sm:text-2xl font-black text-gray-900 dark:text-white mb-1 group-hover:text-primary transition-colors truncate px-2">
                            {{ $author->name }}
                        </h3>
                        <p class="text-[10px] sm:text-xs text-primary font-bold mb-4 uppercase tracking-[0.15em]">
                            {{ '@' . $author->username }}
                        </p>

                        <!-- Bio -->
                        <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 line-clamp-2 leading-relaxed mb-6 w-full px-2">
                            {{ $author->bio ?? 'Passionate writer sharing insights.' }}
                        </p>
                    </div>

                    <!-- Stats -->
                    <div class="mt-auto inline-flex items-center gap-2 bg-gray-50 dark:bg-[#0f172a] border border-gray-100 dark:border-gray-800 px-5 py-2.5 rounded-xl text-xs font-bold text-gray-700 dark:text-gray-300 group-hover:bg-primary/10 group-hover:text-primary transition-colors">
                        <i class="fas fa-feather-alt text-primary"></i> {{ $author->posts_count }} Articles
                    </div>
                </div>
            </a>
        </div>
      @empty
        <div class="col-span-full flex flex-col items-center justify-center py-20 text-center bg-white dark:bg-[#151f32] rounded-3xl border border-gray-100 dark:border-gray-800">
            <div class="w-24 h-24 bg-gray-50 dark:bg-gray-800/50 rounded-full flex items-center justify-center mb-6 text-gray-400 dark:text-gray-500">
                <i class="fas fa-users-slash text-4xl"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">No Authors Yet</h3>
            <p class="text-gray-500 dark:text-gray-400 max-w-md">There are no published authors on the platform currently.</p>
        </div>
      @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-12 flex justify-center w-full">
      {{ $authors->links('vendor.pagination.tailwind') }}
    </div>

  </div>
</section>
@endsection
