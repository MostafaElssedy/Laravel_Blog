@extends('Front.layout.pages')

@section('title', 'Terms of Service')

@section('content')
<section class="pb-24 dark:bg-[#0f172a] min-h-[80vh] relative overflow-hidden">
  
  <!-- Premium Header (Cyber-SaaS Stripe Style) -->
  <div class="sawa-container pt-12 md:pt-16 mb-16 relative z-10">
      <div class="relative rounded-3xl p-[1.5px] bg-gradient-to-r from-primary via-accent to-primary background-animate" data-aos="fade-up">
          <div class="relative bg-white dark:bg-[#0f172a] rounded-[23px] p-6 md:p-8 flex flex-col md:flex-row items-center justify-between z-10 overflow-hidden shadow-xl">
              <div class="absolute right-0 top-0 w-64 h-64 bg-gradient-to-bl from-primary/20 to-transparent rounded-full blur-3xl -translate-y-1/2 translate-x-1/2 pointer-events-none"></div>
              
              <div class="flex flex-col md:flex-row items-center text-center md:text-left gap-5 md:gap-6 relative z-20">
                  <div class="w-16 h-16 shrink-0 rounded-2xl bg-gradient-to-br from-primary to-accent flex items-center justify-center text-white shadow-lg shadow-primary/30 rotate-3 hover:rotate-0 transition-transform duration-300">
                      <i class="fas fa-file-contract text-3xl"></i>
                  </div>
                  <div>
                      <p class="text-[10px] md:text-xs font-bold text-primary uppercase tracking-widest mb-1.5 flex items-center justify-center md:justify-start gap-1.5">
                          <i class="fas fa-scale-balanced"></i> Usage Agreement
                      </p>
                      <h1 class="text-4xl md:text-5xl font-black text-gray-900 dark:text-white tracking-tight">
                        Terms of Service
                      </h1>
                  </div>
              </div>

              <div class="mt-6 md:mt-0 px-5 py-2.5 rounded-full bg-gray-50/80 dark:bg-gray-800/80 border border-gray-200 dark:border-gray-700 flex items-center gap-3 backdrop-blur-md relative z-20 hover:bg-white dark:hover:bg-gray-800 transition-colors cursor-default">
                  <span class="text-sm font-medium text-gray-600 dark:text-gray-300">
                    Effective: {{ date('F Y') }}
                  </span>
              </div>
          </div>
      </div>
  </div>

  <div class="sawa-container relative z-10">
    <div class="max-w-4xl mx-auto p-8 md:p-12 rounded-3xl bg-white dark:bg-[#151f32] border border-gray-100 dark:border-gray-800 shadow-xl prose dark:prose-invert max-w-none text-gray-600 dark:text-gray-300 leading-relaxed" data-aos="fade-up">
      <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">1. Agreement to Terms</h2>
      <p class="mb-6">
        By accessing or using {{ optional(\App\Models\GeneralSetting::getSettings())->blog_name ?? 'LaraTech' }}, you agree to be bound by these Terms of Service. If you disagree with any part of these terms, you may not access our website.
      </p>

      <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">2. Intellectual Property Rights</h2>
      <p class="mb-6">
        All content published on this site—including articles, code examples, images, and graphics—is owned by {{ optional(\App\Models\GeneralSetting::getSettings())->blog_name ?? 'LaraTech' }} or its contributing authors and is protected by applicable copyright and intellectual property laws.
      </p>

      <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">3. User Conduct</h2>
      <p class="mb-4">When using our platform and contact services, you agree not to:</p>
      <ul class="list-disc pl-6 mb-6 space-y-2">
        <li>Submit false, misleading, or abusive information.</li>
        <li>Attempt to compromise the security or integrity of our systems.</li>
        <li>Use automated scripts or scrapers to overwhelm our servers.</li>
      </ul>

      <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">4. Disclaimer & Limitation of Liability</h2>
      <p class="mb-6">
        All educational articles and tutorials are provided on an "as is" and "as available" basis. While we strive for accuracy, we cannot guarantee that every code sample will fit every unique infrastructure setup without modification.
      </p>
    </div>
  </div>
</section>
@endsection
