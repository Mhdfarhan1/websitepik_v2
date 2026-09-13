<x-layouts.app>
    <!-- Page Header (Small Header for internal pages) -->
    <div class="pt-40 pb-12 bg-slate-50 border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex mb-4 text-xs font-semibold text-slate-400 uppercase tracking-widest" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ url('/') }}" class="hover:text-brand transition-colors">Beranda</a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-[8px] mx-2"></i>
                            <a href="{{ route('news.index') }}" class="hover:text-brand transition-colors">Berita Terkini</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-[8px] mx-2 text-slate-300"></i>
                            <span class="text-slate-300 truncate max-w-[200px]" title="{{ $news->title }}">{{ Str::limit($news->title, 20) }}</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Main Content Section -->
    <section class="py-12 bg-white min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-16">
                
                <!-- Left: News Content -->
                <div class="lg:w-[65%]" data-aos="fade-up">
                    <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900 leading-[1.3] mb-6">
                        {{ $news->title }}
                    </h1>
                    
                    <div class="flex flex-wrap items-center justify-between gap-4 mb-10 pb-6 border-b border-slate-100">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-400">
                                <i class="fas fa-user text-sm"></i>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-[13px] font-bold text-slate-900">Admin PIK-R</span>
                                <span class="text-[11px] text-slate-400 font-medium">
                                    {{ $news->published_at ? $news->published_at->format('M d, Y') : '' }}
                                </span>
                            </div>
                        </div>

                        <!-- Share Buttons -->
                        <div class="flex items-center gap-2">
                            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mr-2">Share:</span>
                            <a href="https://api.whatsapp.com/send?text={{ urlencode($news->title . ' - ' . url()->current()) }}" target="_blank" class="w-8 h-8 rounded-full bg-[#25D366]/10 text-[#25D366] flex items-center justify-center hover:bg-[#25D366] hover:text-white transition-all duration-300">
                                <i class="fab fa-whatsapp text-sm"></i>
                            </a>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="w-8 h-8 rounded-full bg-[#1877F2]/10 text-[#1877F2] flex items-center justify-center hover:bg-[#1877F2] hover:text-white transition-all duration-300">
                                <i class="fab fa-facebook-f text-sm"></i>
                            </a>
                            <a href="https://twitter.com/intent/tweet?text={{ urlencode($news->title) }}&url={{ urlencode(url()->current()) }}" target="_blank" class="w-8 h-8 rounded-full bg-[#1DA1F2]/10 text-[#1DA1F2] flex items-center justify-center hover:bg-[#1DA1F2] hover:text-white transition-all duration-300">
                                <i class="fab fa-twitter text-sm"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Main Image -->
                    <div class="rounded-2xl overflow-hidden mb-12 shadow-xl shadow-slate-200/50">
                        @if(str_starts_with($news->image ?? '', 'http'))
                            <img src="{{ $news->image }}" alt="{{ $news->title }}" class="w-full h-auto hover:scale-105 transition-transform duration-1000">
                        @else
                            <img src="{{ asset($news->image ?? 'assets/img/bg_utama.JPG') }}" alt="{{ $news->title }}" class="w-full h-auto hover:scale-105 transition-transform duration-1000">
                        @endif
                    </div>

                    <!-- Article Body -->
                    <div class="prose prose-slate max-w-none text-slate-650 leading-relaxed text-base space-y-6">
                        {!! nl2br(e($news->content)) !!}
                    </div>
                </div>

                <!-- Right: Sidebar -->
                <div class="lg:w-[35%]" data-aos="fade-left">
                    <div class="sticky top-32">
                        
                        <!-- Recent News List -->
                        <div class="mb-12">
                            <h3 class="text-lg font-bold text-slate-900 mb-8">
                                Berita Terkini
                            </h3>
                            <div class="space-y-8">
                                @forelse($recentNews ?? [] as $recent)
                                    @if($recent->id !== $news->id)
                                    <a href="{{ route('news.show', $recent->slug) }}" class="group block border-b border-slate-50 pb-4 last:border-0">
                                        <h4 class="font-medium text-slate-700 group-hover:text-[#7ebcd8] transition-colors text-[14px] leading-snug mb-1">
                                            {{ $recent->title }}
                                        </h4>
                                        <span class="text-[11px] font-bold text-slate-300 uppercase tracking-wider">
                                            {{ $recent->published_at ? $recent->published_at->format('M d, Y') : '' }}
                                        </span>
                                    </a>
                                    @endif
                                @empty
                                    <p class="text-slate-400 text-xs">Belum ada berita lainnya.</p>
                                @endforelse
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>
</x-layouts.app>
