<x-layouts.app>
    <!-- Page Header -->
    <div class="pt-[140px] md:pt-[220px] pb-12 md:pb-20 bg-slate-900 relative overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('assets/img/bg_berita.JPG') }}" alt="Gallery BG" class="w-full h-full object-cover opacity-20">
            <div class="absolute inset-0 bg-gradient-to-b from-slate-900/40 to-slate-900"></div>
        </div>

        <div class="relative z-10 w-full max-w-7xl mx-auto px-4 text-center">
            <h1 class="text-3xl md:text-5xl font-black text-white tracking-tight mb-4" data-aos="fade-up">
                Galeri & <span class="text-[#f59e0b]">Kegiatan</span>
            </h1>
            <p class="text-slate-300 text-sm md:text-base max-w-xl mx-auto font-light leading-relaxed" data-aos="fade-up" data-aos-delay="100">
                Dokumentasi potret kegiatan, kreativitas, edukasi sebaya, dan momen kebersamaan pengurus serta anggota PIK-R REQUEST.
            </p>
        </div>
    </div>

    <!-- Gallery Grid Section -->
    <section class="py-20 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(count($galleryList) > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($galleryList as $index => $gallery)
                        @php
                            $isPolaroid = ($index % 3 === 0);
                            $cardClass = $isPolaroid 
                                ? 'bg-white p-3 border border-slate-200/60 shadow-md hover:shadow-xl' 
                                : 'bg-white shadow-md hover:shadow-xl border border-slate-100';
                            $imgClass = $isPolaroid ? 'rounded-lg' : 'rounded-t-2xl';
                        @endphp
                        
                        <div class="group rounded-2xl overflow-hidden {{ $cardClass }} transition-all duration-300 transform hover:-translate-y-1.5 flex flex-col justify-between" data-aos="fade-up" data-aos-delay="{{ ($index % 4) * 100 }}">
                            <!-- Image Container -->
                            <div class="relative overflow-hidden aspect-[4/3] w-full bg-slate-100 shrink-0 rounded-xl">
                                @if(str_starts_with($gallery->image ?? '', 'http'))
                                    <img src="{{ $gallery->image }}" alt="{{ $gallery->title ?? 'Galeri' }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                                @else
                                    <img src="{{ asset($gallery->image ?? 'assets/img/bg_utama.JPG') }}" alt="{{ $gallery->title ?? 'Galeri' }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                                @endif
                                <div class="absolute inset-0 bg-slate-900/10 group-hover:bg-slate-900/0 transition-colors duration-300"></div>
                            </div>
                            
                            <!-- Description -->
                            @if($gallery->title)
                                <div class="p-4 {{ $isPolaroid ? 'text-center pt-5 pb-2 font-serif text-slate-800' : '' }}">
                                    @if(!$isPolaroid)
                                        <p class="text-[9px] font-black uppercase tracking-widest text-[#f59e0b] mb-1">Momen Kegiatan</p>
                                    @endif
                                    <h3 class="font-bold text-sm text-slate-700 leading-snug group-hover:text-blue-600 transition-colors">
                                        {{ $gallery->title }}
                                    </h3>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-16 flex justify-center">
                    {{ $galleryList->links() }}
                </div>
            @else
                <div class="text-center py-20 bg-white rounded-2xl border border-slate-100 shadow-sm max-w-xl mx-auto">
                    <div class="w-16 h-16 rounded-3xl bg-slate-50 flex items-center justify-center mx-auto mb-4 text-slate-300">
                        <i class="fas fa-images text-2xl"></i>
                    </div>
                    <p class="text-slate-400 font-medium">Belum ada foto galeri kegiatan yang dipublikasikan.</p>
                </div>
            @endif
        </div>
    </section>
</x-layouts.app>
