<div class="bg-white">
    <!-- 2. Highly Advanced Cinematic Hero -->
    <div x-data="{ activeSlide: 0, slides: {{ $banners->count() > 0 ? $banners->count() : 2 }}, timer: null }" 
         x-init="timer = setInterval(() => { activeSlide = activeSlide === slides - 1 ? 0 : activeSlide + 1 }, 8000)"
         class="relative h-[85vh] w-full overflow-hidden bg-black">
        
        <!-- Animated Background Grain -->
        <div class="absolute inset-0 z-10 opacity-[0.03] pointer-events-none mix-blend-overlay bg-[url('https://grainy-gradients.vercel.app/noise.svg')]"></div>

        @php
            $fallbackBanners = [
                ['headline' => __('Authentic Treasures from Yemen'), 'image' => 'categories/honey.png', 'sub' => __('Experience the world\'s finest Sidr honey.')],
                ['headline' => __('Ancient Harazi Heritage'), 'image' => 'categories/coffee.png', 'sub' => __('Discover the original Mocha coffee ritual.')]
            ];
            $displayBanners = $banners->count() > 0 ? $banners : collect($fallbackBanners);
        @endphp

        @foreach($displayBanners as $index => $banner)
            <div x-show="activeSlide === {{ $index }}"
                 x-transition:enter="transition ease-out duration-1500"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-1500"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="absolute inset-0 w-full h-full">
                
                <!-- Ken Burns Effect Wrapper -->
                <div class="absolute inset-0 w-full h-full transform transition-transform duration-[10000ms] ease-out scale-110" 
                     :class="activeSlide === {{ $index }} ? 'scale-100' : 'scale-125'">
                    <img src="{{ asset('storage/' . (is_array($banner) ? $banner['image'] : $banner->image)) }}" 
                         class="w-full h-full object-cover brightness-75">
                </div>

                <!-- Gradient Overlays -->
                <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/20 to-transparent z-20"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent z-20"></div>
                
                <!-- Content -->
                <div class="absolute inset-0 flex items-center z-30 px-6 md:px-24">
                    <div class="max-w-4xl"
                         x-show="activeSlide === {{ $index }}"
                         x-transition:enter="transition ease-out duration-1000 delay-500"
                         x-transition:enter-start="opacity-0 translate-y-10 blur-sm"
                         x-transition:enter-end="opacity-100 translate-y-0 blur-0">
                        
                        @php
                            $preTitle = is_array($banner) ? (__('Exclusive Collection')) : ($banner->pre_title ?? __('Exclusive Collection'));
                            $headline = is_array($banner) ? $banner['headline'] : $banner->headline;
                            $subheadline = is_array($banner) ? $banner['sub'] : ($banner->subheadline ?? __('Authentic Yemeni quality delivered to your doorstep in Europe.'));
                            $ctaText = is_array($banner) ? __('Shop Now') : ($banner->cta_text ?? __('Shop Now'));
                            $ctaUrl = is_array($banner) ? route('shop') : ($banner->cta_url ?? route('shop'));
                            $videoUrl = is_array($banner) ? null : ($banner->video_url ?? null);
                        @endphp

                        <div class="inline-flex items-center gap-3 mb-6">
                            <div class="h-[1px] w-12 bg-[#D4AF37]"></div>
                            <span class="text-[#D4AF37] text-xs font-bold uppercase tracking-[0.4em]">{{ $preTitle }}</span>
                        </div>

                        <h1 class="text-6xl md:text-9xl font-serif text-white font-bold leading-tight mb-8 tracking-tighter drop-shadow-2xl">
                            @php
                                $words = explode(' ', $headline);
                                $lastWord = array_pop($words);
                                $firstPart = implode(' ', $words);
                            @endphp
                            {{ $firstPart }} <span class="italic text-[#D4AF37]">{{ $lastWord }}</span>
                        </h1>

                        <!-- Glassmorphism Card -->
                        <div class="backdrop-blur-md bg-white/5 border border-white/10 p-8 rounded-sm inline-block transform hover:scale-[1.02] transition-transform duration-500 shadow-2xl">
                            <p class="text-white/80 text-lg md:text-xl font-light mb-8 max-w-lg leading-relaxed font-serif italic text-left rtl:text-right">
                                {{ $subheadline }}
                            </p>
                            
                            <div class="flex flex-wrap gap-6 items-center">
                                <a href="{{ $ctaUrl }}" 
                                   class="group relative overflow-hidden bg-[#D4AF37] text-black px-10 py-4 font-bold text-xs uppercase tracking-[0.3em] transition-all duration-500 hover:bg-white hover:text-black">
                                    <span class="relative z-10">{{ $ctaText }}</span>
                                    <div class="absolute inset-0 bg-white transform -translate-x-full group-hover:translate-x-0 transition-transform duration-500 ease-out"></div>
                                </a>
                                
                                @if($videoUrl)
                                    <a href="{{ $videoUrl }}" target="_blank" class="flex items-center gap-3 text-white/60 hover:text-white transition-colors duration-300">
                                        <div class="w-10 h-10 rounded-full border border-white/20 flex items-center justify-center group">
                                            <svg class="w-4 h-4 transform group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        </div>
                                        <span class="text-[10px] font-bold uppercase tracking-widest">{{ __('View Film') }}</span>
                                    </a>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Floating Decorative Elements -->
                <div class="absolute bottom-24 right-24 z-30 hidden lg:block animate-bounce-slow">
                    <div class="w-32 h-32 border border-[#D4AF37]/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                        <div class="w-24 h-24 border border-[#D4AF37]/40 rounded-full flex items-center justify-center">
                             <span class="text-[#D4AF37] text-[10px] font-bold text-center tracking-tighter uppercase leading-none">100%<br>Authentic</span>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <!-- Advanced Indicators -->
        <div class="absolute bottom-12 left-1/2 transform -translate-x-1/2 flex items-center space-x-6 z-40">
            @for($i = 0; $i < ($banners->count() > 0 ? $banners->count() : 2); $i++)
                <button @click="activeSlide = {{ $i }}" 
                        class="relative group h-12 w-1 flex items-center justify-center">
                    <div :class="activeSlide === {{ $i }} ? 'h-10 bg-[#D4AF37]' : 'h-4 bg-white/30 group-hover:bg-white/60'" 
                         class="w-[2px] transition-all duration-500 rounded-full"></div>
                    <span x-show="activeSlide === {{ $i }}" 
                          class="absolute -top-6 text-[10px] font-bold text-[#D4AF37] whitespace-nowrap tracking-widest">0{{ $i + 1 }}</span>
                </button>
            @endfor
        </div>

        <!-- Vertical Text Label -->
        <div class="absolute right-8 top-1/2 transform -translate-y-1/2 rotate-90 z-40 hidden md:block">
            <span class="text-white/20 text-[10px] font-bold uppercase tracking-[1em] whitespace-nowrap">{{ __('ESTABLISHED 2024') }} — {{ __('REDEFINING LUXURY') }}</span>
        </div>
    </div>

    <!-- 3. Categories Grid (Modern) -->
    <section class="py-24 px-4 max-w-7xl mx-auto" x-data="{ visible: false }" x-intersect.margin.-20%="visible = true">
        <h2 class="text-4xl font-serif text-center mb-16 tracking-tight text-gray-900" :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'" class="transition-all duration-1000 ease-out">{{ __('Shop by Category') }}</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-10">
            @foreach($categories as $category)
                <a href="{{ route('shop', ['selectedCategories' => [$category->id]]) }}" class="group relative aspect-[3/4] overflow-hidden">
                    @if($category->image)
                        <img src="{{ asset('storage/' . $category->image) }}" 
                             loading="lazy"
                             decoding="async"
                             class="w-full h-full object-cover transition duration-1000 group-hover:scale-105">
                    @else
                        <div class="w-full h-full bg-[#FDFBF7] flex items-center justify-center text-gray-300 text-3xl font-serif border border-gray-100">{{ substr($category->name, 0, 1) }}</div>
                    @endif
                    <div class="absolute inset-0 bg-black/10 group-hover:bg-black/20 transition duration-500"></div>
                    <div class="absolute inset-0 flex flex-col items-center justify-center text-white opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                        <span class="text-[10px] uppercase tracking-[0.3em] mb-2">{{ __('Explore') }}</span>
                        <h3 class="text-2xl font-serif border-b border-white pb-1">{{ $category->name }}</h3>
                    </div>
                    <!-- Default labels for accessibility/visual when not hovered -->
                    <div class="absolute bottom-6 left-6 text-white group-hover:opacity-0 transition-opacity duration-500">
                        <h3 class="text-xl font-serif drop-shadow-sm">{{ $category->name }}</h3>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    <!-- 4. Flash Sale (If Active) -->
    @if($flashSales->isNotEmpty())
        <section class="bg-black py-20 text-white relative" x-data="{ visible: false }" x-intersect.margin.-15%="visible = true">
            <div class="max-w-7xl mx-auto px-4 relative z-10 transition-all duration-1000 ease-out" :class="visible ? 'opacity-100' : 'opacity-0'">
                <div class="flex flex-col md:flex-row items-center justify-between mb-12 transform transition-all duration-1000 delay-300" :class="visible ? 'translate-y-0 opacity-100' : 'translate-y-10 opacity-0'">
                    <div>
                        <h2 class="text-4xl font-serif text-[#D4AF37] mb-2 lowercase italic">{{ __('Exclusive Offers') }}</h2>
                        <p class="text-gray-400 uppercase tracking-[0.2em] text-xs">{{ __('Limited time. Exceptional value.') }}</p>
                    </div>
                    <div class="mt-8 md:mt-0 flex gap-6 text-center" x-data="{ 
                            endTime: new Date(Date.now() + 86400000),
                            days: 0, hours: 0, minutes: 0, seconds: 0,
                            update() {
                                const diff = this.endTime - new Date();
                                this.hours = Math.floor((diff / (1000 * 60 * 60)) % 24);
                                this.minutes = Math.floor((diff / 1000 / 60) % 60);
                                this.seconds = Math.floor((diff / 1000) % 60);
                            }
                         }" x-init="setInterval(() => update(), 1000)">
                         <div class="flex flex-col"><span class="text-3xl font-serif text-[#D4AF37]" x-text="hours"></span><span class="text-[9px] tracking-widest text-gray-500 uppercase">Hours</span></div>
                         <div class="flex flex-col"><span class="text-3xl font-serif text-[#D4AF37]" x-text="minutes"></span><span class="text-[9px] tracking-widest text-gray-500 uppercase">Minutes</span></div>
                         <div class="flex flex-col"><span class="text-3xl font-serif text-[#D4AF37]" x-text="seconds"></span><span class="text-[9px] tracking-widest text-gray-500 uppercase">Seconds</span></div>
                    </div>
                </div>
                
                <div class="flex gap-8 overflow-x-auto pb-8 no-scrollbar snap-x">
                    @foreach($flashSales as $sale)
                        <div class="min-w-[260px] md:min-w-[300px] snap-center flex-shrink-0">
                            <x-product-card :product="$sale->product" />
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- 5. New Arrivals -->
    <section class="py-24 max-w-7xl mx-auto px-4" x-data="{ visible: false }" x-intersect.margin.-15%="visible = true">
        <div class="text-center mb-16 transition-all duration-1000 ease-out" :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
            <h2 class="text-4xl font-serif text-gray-900 mb-4">{{ __('New Arrivals') }}</h2>
            <div class="h-0.5 w-12 bg-[#D4AF37] mx-auto mb-4"></div>
            <p class="text-gray-500 uppercase tracking-[0.2em] text-[10px]">{{ __('Curated treasures from the heart of Yemen') }}</p>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-x-8 gap-y-16">
            @foreach($newArrivals as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>

        <div class="text-center mt-16">
            <a href="{{ route('shop') }}" class="inline-block border-b border-black pb-1 text-xs uppercase tracking-[0.3em] font-bold hover:text-[#D4AF37] hover:border-[#D4AF37] transition duration-300">
                {{ __('View Full Collection') }}
            </a>
        </div>
    </section>

    <!-- 6. Best Sellers -->
    <section class="bg-[#FDFBF7] py-24" x-data="{ visible: false }" x-intersect.margin.-15%="visible = true">
        <div class="max-w-7xl mx-auto px-4 transition-all duration-1000 ease-out" :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
            <h2 class="text-4xl font-serif text-center mb-16 tracking-tight text-gray-900">{{ __('The Masterpieces') }}</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                @foreach($bestSellers as $product)
                     <x-product-card :product="$product" />
                @endforeach
            </div>
        </div>
    </section>

    <!-- 7. Instagram Feed (Shop the Look) -->
    <section class="py-24 border-t border-gray-100" x-data="{ visible: false }" x-intersect.margin.-15%="visible = true">
        <div class="max-w-7xl mx-auto px-4 transition-all duration-1000 ease-out" :class="visible ? 'opacity-100' : 'opacity-0 translate-y-8'">
            <div class="text-center mb-16">
                <span class="text-[#D4AF37] text-xs font-bold uppercase tracking-[0.4em] mb-4 block">{{ __('Social Proof') }}</span>
                <h2 class="text-4xl font-serif text-gray-900 mb-4">{{ __('Shop the Look') }}</h2>
                <p class="text-gray-500 uppercase tracking-[0.2em] text-[10px]">{{ __('Tag @YemenSouqEurope to be featured') }}</p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @foreach(range(1, 6) as $i)
                    <div class="aspect-square bg-gray-100 overflow-hidden relative group cursor-pointer">
                        <div class="w-full h-full flex items-center justify-center text-gray-300">
                             <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-white">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- 8. Premium Trust Signals -->
    <section class="bg-black py-16 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 grid grid-cols-2 md:grid-cols-4 gap-12 text-center">
            <div class="flex flex-col items-center gap-4 group cursor-default">
                <div class="w-14 h-14 rounded-full border border-[#D4AF37]/30 flex items-center justify-center text-[#D4AF37] group-hover:bg-[#D4AF37] group-hover:text-black transition-all duration-500">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="font-serif text-white text-lg tracking-tight">{{ __('Fast Delivery') }}</h3>
                <p class="text-[10px] text-gray-500 uppercase tracking-[0.2em]">{{ __('Across Europe in 3-5 days') }}</p>
            </div>
             <div class="flex flex-col items-center gap-4 group cursor-default">
                <div class="w-14 h-14 rounded-full border border-[#D4AF37]/30 flex items-center justify-center text-[#D4AF37] group-hover:bg-[#D4AF37] group-hover:text-black transition-all duration-500">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="font-serif text-white text-lg tracking-tight">{{ __('Authentic Quality') }}</h3>
                <p class="text-[10px] text-gray-500 uppercase tracking-[0.2em]">{{ __('100% Yemeni sourced directly') }}</p>
            </div>
             <div class="flex flex-col items-center gap-4 group cursor-default">
                <div class="w-14 h-14 rounded-full border border-[#D4AF37]/30 flex items-center justify-center text-[#D4AF37] group-hover:bg-[#D4AF37] group-hover:text-black transition-all duration-500">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 002 2z"></path></svg>
                </div>
                <h3 class="font-serif text-white text-lg tracking-tight">{{ __('Secure Payments') }}</h3>
                <p class="text-[10px] text-gray-500 uppercase tracking-[0.2em]">{{ __('PCI Compliant Stripe & COD') }}</p>
            </div>
             <div class="flex flex-col items-center gap-4 group cursor-default">
                <div class="w-14 h-14 rounded-full border border-[#D4AF37]/30 flex items-center justify-center text-[#D4AF37] group-hover:bg-[#D4AF37] group-hover:text-black transition-all duration-500">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <h3 class="font-serif text-white text-lg tracking-tight">{{ __('24/7 Concierge') }}</h3>
                <p class="text-[10px] text-gray-400 uppercase tracking-[0.2em]">{{ __('WhatsApp & Live assistance') }}</p>
            </div>
        </div>
    </section>

    <!-- 9. Styles -->
    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        @keyframes marquee { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }
        .animate-marquee { animation: marquee 30s linear infinite; }
    </style>
</div>
