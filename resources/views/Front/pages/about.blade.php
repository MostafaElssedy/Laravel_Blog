@extends('Front.layout.pages')

@section('title', 'About Us')

@section('content')
<section class="pb-24 dark:bg-[#0f172a] min-h-[80vh] relative overflow-hidden">
  
  <!-- Premium Header (Cyber-SaaS Stripe Style) -->
  <div class="sawa-container pt-12 md:pt-16 mb-16 relative z-10">
      <div class="relative rounded-3xl p-[1.5px] bg-gradient-to-r from-primary via-accent to-primary background-animate" data-aos="fade-up">
          
          <div class="relative bg-white dark:bg-[#0f172a] rounded-[23px] p-6 md:p-8 flex flex-col md:flex-row items-center justify-between z-10 overflow-hidden shadow-xl">
              
              <div class="absolute right-0 top-0 w-64 h-64 bg-gradient-to-bl from-primary/20 to-transparent rounded-full blur-3xl -translate-y-1/2 translate-x-1/2 pointer-events-none"></div>
              
              <div class="flex flex-col md:flex-row items-center text-center md:text-left gap-5 md:gap-6 relative z-20">
                  <div class="w-16 h-16 shrink-0 rounded-2xl bg-gradient-to-br from-primary to-accent flex items-center justify-center text-white shadow-lg shadow-primary/30 rotate-3 hover:rotate-0 transition-transform duration-300">
                      <i class="fas fa-heart text-3xl"></i>
                  </div>
                  
                  <div>
                      <p class="text-[10px] md:text-xs font-bold text-primary uppercase tracking-widest mb-1.5 flex items-center justify-center md:justify-start gap-1.5">
                          <i class="fas fa-sparkles"></i> Who We Are
                      </p>
                      <h1 class="text-4xl md:text-5xl font-black text-gray-900 dark:text-white tracking-tight">
                        About {{ optional(\App\Models\GeneralSetting::getSettings())->blog_name ?? 'LaraTech' }}
                      </h1>
                  </div>
              </div>

              <!-- Pill -->
              <div class="mt-6 md:mt-0 px-5 py-2.5 rounded-full bg-gray-50/80 dark:bg-gray-800/80 border border-gray-200 dark:border-gray-700 flex items-center gap-3 backdrop-blur-md relative z-20 hover:bg-white dark:hover:bg-gray-800 transition-colors cursor-default">
                  <div class="relative flex h-2.5 w-2.5">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-primary"></span>
                  </div>
                  <span class="text-sm font-medium text-gray-600 dark:text-gray-300">
                    Ideas Worth Reading
                  </span>
              </div>
          </div>
      </div>
  </div>

  <div class="sawa-container relative z-10">
    <div class="max-w-4xl mx-auto">
      
      <!-- Mission Card -->
      <div class="p-8 md:p-12 rounded-3xl bg-white dark:bg-[#151f32] border border-gray-100 dark:border-gray-800 shadow-xl mb-12" data-aos="fade-up">
        <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900 dark:text-white mb-6">Our Mission & Purpose</h2>
        <p class="text-gray-600 dark:text-gray-300 leading-relaxed text-base md:text-lg mb-6">
          {{ optional(\App\Models\GeneralSetting::getSettings())->blog_description ?? 'A modern, premium digital publication dedicated to empowering developers, designers, and innovators with high-impact insights, detailed tutorials, and thoughtful perspectives.' }}
        </p>
        <p class="text-gray-600 dark:text-gray-300 leading-relaxed text-base md:text-lg">
          We believe technology thrives on shared knowledge. Every tutorial, article, and case study published here is designed to elevate your craft and solve real-world problems.
        </p>
      </div>

      <!-- Live Stats Grid -->
      <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-12">
        <div class="p-6 rounded-2xl bg-white dark:bg-[#151f32] border border-gray-100 dark:border-gray-800 shadow-sm text-center" data-aos="fade-up" data-aos-delay="100">
          <div class="text-4xl font-black text-primary mb-2">{{ $totalArticles }}</div>
          <div class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Published Articles</div>
        </div>
        <div class="p-6 rounded-2xl bg-white dark:bg-[#151f32] border border-gray-100 dark:border-gray-800 shadow-sm text-center" data-aos="fade-up" data-aos-delay="200">
          <div class="text-4xl font-black text-secondary mb-2">{{ $totalAuthors }}</div>
          <div class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Expert Authors</div>
        </div>
        <div class="p-6 rounded-2xl bg-white dark:bg-[#151f32] border border-gray-100 dark:border-gray-800 shadow-sm text-center" data-aos="fade-up" data-aos-delay="300">
          <div class="text-4xl font-black text-accent mb-2">{{ $totalCategories }}</div>
          <div class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Topics & Categories</div>
        </div>
      </div>

      <!-- Feature Pillars -->
      <div class="grid md:grid-cols-3 gap-6 mb-12">
        <div class="p-6 rounded-2xl bg-white dark:bg-[#151f32] border border-gray-100 dark:border-gray-800 shadow-sm" data-aos="fade-up" data-aos-delay="100">
          <div class="w-12 h-12 rounded-xl bg-primary/10 text-primary flex items-center justify-center text-xl mb-4">
            <i class="fas fa-lightbulb"></i>
          </div>
          <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Curated Quality</h3>
          <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">No fluff or filler. Every article is crafted with care, code samples, and practical takeaways.</p>
        </div>

        <div class="p-6 rounded-2xl bg-white dark:bg-[#151f32] border border-gray-100 dark:border-gray-800 shadow-sm" data-aos="fade-up" data-aos-delay="200">
          <div class="w-12 h-12 rounded-xl bg-secondary/10 text-secondary flex items-center justify-center text-xl mb-4">
            <i class="fas fa-shield-halved"></i>
          </div>
          <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Zero Spam</h3>
          <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">We respect your time and inbox. Only valuable updates when great content is published.</p>
        </div>

        <div class="p-6 rounded-2xl bg-white dark:bg-[#151f32] border border-gray-100 dark:border-gray-800 shadow-sm" data-aos="fade-up" data-aos-delay="300">
          <div class="w-12 h-12 rounded-xl bg-accent/10 text-accent flex items-center justify-center text-xl mb-4">
            <i class="fas fa-users-gear"></i>
          </div>
          <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Community First</h3>
          <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">Built by passionate creators for passionate creators around the world.</p>
        </div>
      </div>

      <!-- Action Card -->
      <div class="p-8 md:p-12 rounded-3xl bg-gradient-to-br from-primary to-primary-dark text-white shadow-xl text-center" data-aos="fade-up">
        <h3 class="text-2xl md:text-3xl font-extrabold mb-3">Have a story or suggestion?</h3>
        <p class="text-white/80 max-w-xl mx-auto mb-8 text-sm md:text-base">We're always looking to connect with developers, authors, and readers. Get in touch with us anytime.</p>
        <div class="flex flex-wrap items-center justify-center gap-4">
          <a href="{{ route('contact') }}" class="btn bg-white text-primary hover:bg-gray-100 font-bold px-8 py-3 rounded-full">
            Contact Our Team <i class="fas fa-paper-plane ml-2"></i>
          </a>
          <a href="{{ route('articles') }}" class="btn bg-white/10 hover:bg-white/20 text-white font-bold px-8 py-3 rounded-full border border-white/20">
            Explore Articles <i class="fas fa-arrow-right ml-2"></i>
          </a>
        </div>
      </div>

    </div>
  </div>
</section>
@endsection
