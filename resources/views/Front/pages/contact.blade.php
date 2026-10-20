@extends('Front.layout.pages')

@section('title', 'Contact Us')

@section('content')
<!-- Page Header -->
<section class="pt-16 pb-32 lg:pt-20 lg:pb-40 bg-gray-50 dark:bg-[#0f172a] relative overflow-hidden">
    <!-- Decorative Blurs -->
    <div class="absolute top-0 right-1/4 w-[500px] h-[500px] bg-primary/10 rounded-full blur-3xl opacity-60 pointer-events-none transform translate-x-1/2 -translate-y-1/4"></div>
    <div class="absolute bottom-0 left-1/4 w-[400px] h-[400px] bg-blue-500/10 rounded-full blur-3xl opacity-50 pointer-events-none transform -translate-x-1/2 translate-y-1/4"></div>
    
    <div class="sawa-container relative z-10 text-center">
        <span class="inline-flex items-center gap-2 py-1.5 px-4 rounded-full bg-white dark:bg-gray-800/80 text-primary font-bold text-sm mb-6 shadow-sm border border-gray-200/50 dark:border-gray-700/50" data-aos="fade-down">
            <span class="relative flex h-2 w-2">
              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary opacity-75"></span>
              <span class="relative inline-flex rounded-full h-2 w-2 bg-primary"></span>
            </span>
            Contact Us
        </span>
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-black mb-6 text-gray-900 dark:text-white tracking-tight" data-aos="fade-up">
            Let's <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-blue-500">Get In Touch</span>
        </h1>
        <p class="text-lg md:text-xl text-gray-600 dark:text-gray-400 max-w-2xl mx-auto leading-relaxed" data-aos="fade-up" data-aos-delay="100">
            Have a question, feedback, or just want to say hi? We'd love to hear from you. Fill out the form below and we'll get back to you as soon as possible.
        </p>
    </div>
</section>

<!-- Contact Section -->
<section class="pb-16 lg:pb-20 relative z-20 -mt-24 lg:-mt-32">
    <div class="sawa-container max-w-5xl mx-auto">
        <div class="bg-white dark:bg-[#151f32] rounded-[2rem] shadow-2xl shadow-gray-200/40 dark:shadow-none border border-gray-100 dark:border-gray-800 overflow-hidden flex flex-col md:flex-row">
            
            <!-- Contact Info Side -->
            <div class="md:w-2/5 bg-primary p-10 lg:p-12 text-white flex flex-col justify-between relative overflow-hidden">
                <!-- Decorative background elements -->
                <div class="absolute -top-24 -right-24 w-48 h-48 bg-white opacity-10 rounded-full blur-2xl"></div>
                <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-white opacity-5 rounded-full blur-3xl"></div>
                <div class="absolute inset-0 bg-gradient-to-br from-white/5 to-transparent"></div>
                
                <div class="relative z-10">
                    <h3 class="text-2xl font-bold mb-8">Contact Information</h3>
                    
                    <div class="space-y-8">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center shrink-0">
                                <i class="fas fa-map-marker-alt text-lg"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-lg mb-1">Our Location</h4>
                                <p class="text-white/80 text-sm leading-relaxed">123 Tech Street, Silicon Valley,<br>CA 94025, United States</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center shrink-0">
                                <i class="fas fa-envelope text-lg"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-lg mb-1">Email Us</h4>
                                <a href="mailto:hello@sawa.com" class="text-white/80 text-sm hover:text-white block transition-colors">hello@sawa.com</a>
                                <a href="mailto:support@sawa.com" class="text-white/80 text-sm hover:text-white block transition-colors">support@sawa.com</a>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center shrink-0">
                                <i class="fas fa-phone-alt text-lg"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-lg mb-1">Call Us</h4>
                                <a href="tel:+15551234567" class="text-white/80 text-sm hover:text-white block transition-colors">+1 (555) 123-4567</a>
                                <p class="text-white/80 text-sm mt-1">Mon-Fri, 9am - 5pm PST</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="relative z-10 mt-12 pt-8 border-t border-white/20">
                    <h4 class="font-semibold mb-4 text-white/90">Follow Us</h4>
                    <div class="flex gap-3">
                        <a href="javascript:void(0)" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-white hover:text-primary transition-all duration-300 transform hover:-translate-y-1"><i class="fab fa-twitter"></i></a>
                        <a href="javascript:void(0)" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-white hover:text-primary transition-all duration-300 transform hover:-translate-y-1"><i class="fab fa-facebook-f"></i></a>
                        <a href="javascript:void(0)" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-white hover:text-primary transition-all duration-300 transform hover:-translate-y-1"><i class="fab fa-linkedin-in"></i></a>
                        <a href="javascript:void(0)" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-white hover:text-primary transition-all duration-300 transform hover:-translate-y-1"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>

            <!-- Contact Form Side -->
            <div class="md:w-3/5 p-10 lg:p-14 bg-white dark:bg-[#151f32]">
                <h3 class="text-3xl font-bold mb-2 text-gray-900 dark:text-white">Send us a Message</h3>
                <p class="text-gray-500 dark:text-gray-400 mb-8 text-sm">We'll get back to you within 24 hours.</p>
                
                @if(session('success'))
                    <div class="mb-6 p-4 rounded-xl bg-green-50 dark:bg-green-500/10 border border-green-200 dark:border-green-500/20 text-green-700 dark:text-green-400 flex items-start gap-3">
                        <i class="fas fa-check-circle mt-1 text-lg"></i>
                        <div>
                            <h4 class="font-bold text-sm">Success!</h4>
                            <p class="text-sm mt-0.5">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 p-4 rounded-xl bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20 text-red-700 dark:text-red-400 flex items-start gap-3">
                        <i class="fas fa-exclamation-triangle mt-1 text-lg"></i>
                        <div>
                            <h4 class="font-bold text-sm">Error!</h4>
                            <p class="text-sm mt-0.5">{{ session('error') }}</p>
                        </div>
                    </div>
                @endif
                
                <form action="{{ route('contactProcess') }}" method="POST" class="space-y-5">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2 pl-1">Your Name</label>
                            <input type="text" id="name" name="name" class="w-full px-5 py-3.5 rounded-xl bg-gray-50 dark:bg-gray-800/50 border {{ $errors->has('name') ? 'border-red-500/50 focus:border-red-500/50 focus:ring-red-500/20' : 'border-gray-200 dark:border-gray-700 focus:border-primary/60 focus:ring-primary/40' }} focus:outline-none focus:ring-2 dark:text-white transition-all duration-300" placeholder="John Doe" value="{{ old('name') }}" >
                            @error('name')
                                <p class="text-red-500 text-xs font-medium mt-1.5 ml-1 flex items-center gap-1">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2 pl-1">Your Email</label>
                            <input type="email" id="email" name="email" class="w-full px-5 py-3.5 rounded-xl bg-gray-50 dark:bg-gray-800/50 border {{ $errors->has('email') ? 'border-red-500/50 focus:border-red-500/50 focus:ring-red-500/20' : 'border-gray-200 dark:border-gray-700 focus:border-primary/60 focus:ring-primary/40' }} focus:outline-none focus:ring-2 dark:text-white transition-all duration-300" placeholder="john@example.com" value="{{ old('email') }}" >
                            @error('email')
                                <p class="text-red-500 text-xs font-medium mt-1.5 ml-1 flex items-center gap-1">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                    
                    <div>
                        <label for="subject" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2 pl-1">Subject</label>
                        <input type="text" id="subject" name="subject" class="w-full px-5 py-3.5 rounded-xl bg-gray-50 dark:bg-gray-800/50 border {{ $errors->has('subject') ? 'border-red-500/50 focus:border-red-500/50 focus:ring-red-500/20' : 'border-gray-200 dark:border-gray-700 focus:border-primary/60 focus:ring-primary/40' }} focus:outline-none focus:ring-2 dark:text-white transition-all duration-300" placeholder="How can we help you?" value="{{ old('subject') }}" >
                        @error('subject')
                            <p class="text-red-500 text-xs font-medium mt-1.5 ml-1 flex items-center gap-1">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="message" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2 pl-1">Message</label>
                        <textarea id="message" name="message" rows="5" class="w-full px-5 py-3.5 rounded-xl bg-gray-50 dark:bg-gray-800/50 border {{ $errors->has('message') ? 'border-red-500/50 focus:border-red-500/50 focus:ring-red-500/20' : 'border-gray-200 dark:border-gray-700 focus:border-primary/60 focus:ring-primary/40' }} focus:outline-none focus:ring-2 dark:text-white transition-all duration-300 resize-none" placeholder="Write your message here..." >{{ old('message') }}</textarea>
                        @error('message')
                            <p class="text-red-500 text-xs font-medium mt-1.5 ml-1 flex items-center gap-1">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-full py-4 rounded-xl text-base font-bold flex justify-center items-center gap-2 group mt-2">
                        Send Message <i class="fas fa-paper-plane group-hover:translate-x-1 group-hover:-translate-y-1 transition-transform"></i>
                    </button>
                </form>
            </div>
            
        </div>
    </div>
</section>
@endsection
