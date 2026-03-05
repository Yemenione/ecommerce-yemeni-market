<div class="bg-white">
    <!-- 2. Highly Advanced Cinematic Hero -->
    <div x-data="{ activeSlide: 0, slides: {{ $banners->count() > 0 ? $banners->count() : 2 }}, timer: null, scrolled: 0 }" 
         x-init="timer = setInterval(() => { activeSlide = activeSlide === slides - 1 ? 0 : activeSlide + 1 }, 8000)"
         @scroll.window="scrolled = window.scrollY"
         class="hero-container relative w-full overflow-hidden bg-[#0A0A0A]">
        
        <!-- Animated Background Grain -->
        <div class="absolute inset-0 z-10 opacity-[0.04] pointer-events-none mix-blend-overlay bg-[url('https://grainy-gradients.vercel.app/noise.svg')]"></div>

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
                
                <!-- Blurred Background Layer to fill empty space for any aspect ratio (With Parallax) -->
                <div class="absolute inset-0 w-full h-full transform will-change-transform" :style="`transform: translateY(${scrolled * 0.4}px)`">
                    <img src="{{ asset('storage/' . (is_array($banner) ? $banner['image'] : $banner->image)) }}" 
                         class="w-full h-full object-cover blur-2xl opacity-40 scale-125">
                </div>

                <!-- Ken Burns + Parallax Effect Wrapper (Foreground) -->
                <div class="absolute inset-0 w-full h-full transform transition-transform duration-[10000ms] ease-out scale-105 will-change-transform" 
                     :class="activeSlide === {{ $index }} ? 'scale-100' : 'scale-110'"
                     :style="`transform: translateY(${scrolled * 0.15}px) ${activeSlide === {{ $index }} ? 'scale(1)' : 'scale(1.1)'}`">
                    <img src="{{ asset('storage/' . (is_array($banner) ? $banner['image'] : $banner->image)) }}" 
                         class="w-full h-full object-contain object-center brightness-90">
                </div>

                <!-- Gradient Overlays -->
                <div class="absolute inset-0 bg-gradient-to-r from-[#0A0A0A]/90 via-[#0A0A0A]/20 to-transparent z-20"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-[#0A0A0A]/80 via-transparent to-transparent z-20"></div>
                
                <!-- Content -->
                <div class="absolute inset-0 flex items-center z-30 px-4 md:px-12 lg:px-24">
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

                        <h1 class="text-4xl md:text-7xl lg:text-9xl font-serif text-white font-bold leading-tight mb-6 md:mb-8 tracking-tighter drop-shadow-2xl">
                            @php
                                $words = explode(' ', $headline);
                                $lastWord = array_pop($words);
                                $firstPart = implode(' ', $words);
                            @endphp
                            {{ $firstPart }} <span class="italic text-[#D4AF37]">{{ $lastWord }}</span>
                        </h1>

                        <div class="backdrop-blur-md bg-white/5 border border-white/10 p-6 md:p-8 rounded-sm inline-block transform hover:scale-[1.02] transition-transform duration-500 shadow-2xl">
                            <p class="text-white/80 text-sm md:text-xl font-light mb-6 md:mb-8 max-w-sm md:max-w-lg leading-relaxed font-serif italic text-left rtl:text-right">
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

    <!-- 3. Categories Asymmetrical Bento Grid (2026 Vision) -->
    <section class="py-32 px-4 max-w-7xl mx-auto" x-data="{ visible: false }" x-intersect.margin.-10%="visible = true">
        <div class="transition-all duration-[1500ms] ease-out transform" :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-24'">
            <div class="flex flex-col md:flex-row justify-between items-end mb-16 md:mb-24">
                <div>
                    <h2 class="text-4xl md:text-6xl font-serif tracking-tighter text-gray-900 mb-4">{{ __('Shop by Category') }}</h2>
                    <div class="h-[1px] w-24 bg-[#D4AF37]"></div>
                </div>
                <p class="hidden md:block text-gray-400 font-serif italic max-w-sm text-right">
                    {{ __('Explore our curated selection of Yemen\'s finest natural treasures, harvested with centuries of tradition.') }}
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-4 md:grid-rows-[auto] gap-4 md:gap-6">
                @foreach($categories as $index => $category)
                    @php
                        // Repeating Bento Grid Pattern (every 4 items)
                        $bentoClasses = match($index % 4) {
                            0 => 'md:col-span-2 md:row-[span_2_/_span_2] aspect-square md:aspect-auto md:h-[600px]', // Large Feature
                            1 => 'md:col-span-1 md:row-span-1 aspect-square md:aspect-auto md:h-[290px]', // Small Top
                            2 => 'md:col-span-1 md:row-span-1 aspect-square md:aspect-auto md:h-[290px]', // Small Top Right
                            3 => 'md:col-span-2 md:row-span-1 aspect-[2/1] md:aspect-[2/0.95] md:h-[290px]', // Wide Bottom
                        };
                    @endphp
                    <a href="{{ route('shop', ['selectedCategories' => [$category->id]]) }}" 
                       class="group relative overflow-hidden bg-[#FDFBF7] transition-all duration-[1200ms] ease-[cubic-bezier(0.23,1,0.32,1)] hover:shadow-2xl {{ $bentoClasses }}"
                       :style="visible ? `transition-delay: ${ {{ $index % 4 }} * 200 }ms` : ''"
                       :class="visible ? 'opacity-100 scale-100 translate-y-0' : 'opacity-0 scale-95 translate-y-12'">
                        
                        @if($category->image)
                            <div class="w-full h-full flex items-center justify-center p-8 group-hover:bg-[#F5F2EB] transition-colors duration-700">
                                <img src="{{ asset('storage/' . $category->image) }}" 
                                     loading="lazy"
                                     decoding="async"
                                     class="w-full h-full object-contain filter drop-shadow-lg transition-transform duration-[2000ms] ease-out group-hover:scale-110 group-hover:-rotate-2">
                            </div>
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-200 text-6xl font-serif">{{ substr($category->name, 0, 1) }}</div>
                        @endif
                        
                        <!-- Magnetic Hover Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/10 to-transparent opacity-40 group-hover:opacity-60 transition-opacity duration-700"></div>
                        
                        <!-- Content Reveal -->
                        <div class="absolute inset-0 flex flex-col items-center justify-center text-white opacity-0 group-hover:opacity-100 transition-all duration-700 transform group-hover:translate-y-0 translate-y-4">
                            <span class="text-[9px] uppercase tracking-[0.4em] mb-4 text-[#D4AF37]">{{ __('Discover') }}</span>
                            <h3 class="text-3xl font-serif text-center px-4">{{ $category->name }}</h3>
                        </div>
                        
                        <!-- Static Label (Fades out on hover) -->
                        <div class="absolute bottom-6 left-6 text-white group-hover:opacity-0 group-hover:translate-y-4 transition-all duration-500">
                            <span class="block text-[8px] uppercase tracking-[0.3em] text-[#D4AF37] mb-1 font-bold">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                            <h3 class="text-2xl font-serif drop-shadow-md">{{ $category->name }}</h3>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- 4. Flash Sale (If Active) -->
    @if($flashSales->isNotEmpty())
        <section class="bg-[#0A0A0A] py-20 text-white relative" x-data="{ visible: false }" x-intersect.margin.-15%="visible = true">
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
    <section class="py-32 md:py-40 max-w-7xl mx-auto px-4" x-data="{ visible: false }" x-intersect.margin.-10%="visible = true">
        <div class="flex flex-col md:flex-row justify-between items-end mb-20 md:mb-24 transition-all duration-1000 ease-out transform" :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-12'">
            <div>
                <span class="block text-[#D4AF37] text-[10px] uppercase tracking-[0.4em] font-bold mb-4">{{ __('Latest Editions') }}</span>
                <h2 class="text-4xl md:text-6xl font-serif text-gray-900 tracking-tighter">{{ __('New') }} <span class="italic text-gray-400">{{ __('Arrivals') }}</span></h2>
            </div>
            <div class="hidden md:flex flex-col items-end">
                <div class="h-[1px] w-12 bg-[#D4AF37] mb-4"></div>
                <p class="text-gray-400 font-serif italic max-w-xs text-right text-sm">
                    {{ __('Curated treasures from the heart of Yemen, arriving freshly to our collection.') }}
                </p>
            </div>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-x-6 md:gap-x-10 gap-y-16 md:gap-y-24">
            @foreach($newArrivals as $index => $product)
                <div class="transition-all duration-1000 ease-out transform pointer-events-auto group" :style="visible ? `transition-delay: ${ {{ $index }} * 100 }ms` : ''" :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-12'">
                    <x-product-card :product="$product" />
                </div>
            @endforeach
        </div>

        <div class="text-center mt-24 transition-all duration-1000 delay-500" :class="visible ? 'opacity-100' : 'opacity-0'">
            <a href="{{ route('shop') }}" class="group relative inline-flex items-center gap-4 text-xs uppercase tracking-[0.3em] font-bold text-gray-900 transition duration-300">
                <span class="relative z-10 group-hover:text-[#D4AF37] transition-colors">{{ __('View Full Collection') }}</span>
                <div class="w-12 h-[1px] bg-gray-300 group-hover:bg-[#D4AF37] group-hover:w-20 transition-all duration-500"></div>
            </a>
        </div>
    </section>

    <!-- 6. Best Sellers -->
    <section class="bg-[#FDFBF7] py-32 md:py-40" x-data="{ visible: false }" x-intersect.margin.-10%="visible = true">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex flex-col items-center mb-20 md:mb-24 transition-all duration-1000 ease-out transform" :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-12'">
                <span class="text-[#D4AF37] text-[10px] uppercase tracking-[0.4em] font-bold mb-4">{{ __('Iconic Pieces') }}</span>
                <h2 class="text-4xl md:text-6xl font-serif text-gray-900 tracking-tighter text-center">{{ __('The') }} <span class="italic text-gray-400">{{ __('Masterpieces') }}</span></h2>
                <div class="h-[1px] w-12 bg-[#D4AF37] mt-8"></div>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-10 gap-y-16 md:gap-y-24 text-center">
                @foreach($bestSellers as $index => $product)
                     <div class="transition-all duration-1000 ease-out transform pointer-events-auto group" :style="visible ? `transition-delay: ${ {{ $index }} * 100 }ms` : ''" :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-12'">
                        <x-product-card :product="$product" />
                     </div>
                @endforeach
            </div>
        </div>
    </section>



    <!-- 8. Premium Trust Signals -->
    <section class="bg-[#0A0A0A] py-16 overflow-hidden" x-data="{ visible: false }" x-intersect.margin.-10%="visible = true">
        <div class="max-w-7xl mx-auto px-4 grid grid-cols-2 md:grid-cols-4 gap-12 text-center transition-all duration-1000 ease-out transform" :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-12'">
            <div class="flex flex-col items-center gap-4 group cursor-default" :style="visible ? 'transition-delay: 100ms' : ''">
                <div class="w-14 h-14 rounded-full border border-[#D4AF37]/30 flex items-center justify-center text-[#D4AF37] group-hover:bg-[#D4AF37] group-hover:text-black group-hover:scale-110 group-hover:shadow-[0_0_20px_rgba(212,175,55,0.4)] transition-all duration-500">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="font-serif text-white text-lg tracking-tight">{{ __('Fast Delivery') }}</h3>
                <p class="text-[10px] text-gray-500 uppercase tracking-[0.2em]">{{ __('Across Europe in 3-5 days') }}</p>
            </div>
             <div class="flex flex-col items-center gap-4 group cursor-default" :style="visible ? 'transition-delay: 300ms' : ''">
                <div class="w-14 h-14 rounded-full border border-[#D4AF37]/30 flex items-center justify-center text-[#D4AF37] group-hover:bg-[#D4AF37] group-hover:text-black group-hover:scale-110 group-hover:shadow-[0_0_20px_rgba(212,175,55,0.4)] transition-all duration-500">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="font-serif text-white text-lg tracking-tight">{{ __('Authentic Quality') }}</h3>
                <p class="text-[10px] text-gray-500 uppercase tracking-[0.2em]">{{ __('100% Yemeni sourced directly') }}</p>
            </div>
             <div class="flex flex-col items-center gap-4 group cursor-default" :style="visible ? 'transition-delay: 500ms' : ''">
                <div class="w-14 h-14 rounded-full border border-[#D4AF37]/30 flex items-center justify-center text-[#D4AF37] group-hover:bg-[#D4AF37] group-hover:text-black group-hover:scale-110 group-hover:shadow-[0_0_20px_rgba(212,175,55,0.4)] transition-all duration-500">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 002 2z"></path></svg>
                </div>
                <h3 class="font-serif text-white text-lg tracking-tight">{{ __('Secure Payments') }}</h3>
                <p class="text-[10px] text-gray-500 uppercase tracking-[0.2em]">{{ __('PCI Compliant Stripe & COD') }}</p>
            </div>
             <div class="flex flex-col items-center gap-4 group cursor-default" :style="visible ? 'transition-delay: 700ms' : ''">
                <div class="w-14 h-14 rounded-full border border-[#D4AF37]/30 flex items-center justify-center text-[#D4AF37] group-hover:bg-[#D4AF37] group-hover:text-black group-hover:scale-110 group-hover:shadow-[0_0_20px_rgba(212,175,55,0.4)] transition-all duration-500">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <h3 class="font-serif text-white text-lg tracking-tight">{{ __('24/7 Concierge') }}</h3>
                <p class="text-[10px] text-gray-400 uppercase tracking-[0.2em]">{{ __('WhatsApp & Live assistance') }}</p>
            </div>
        </div>
    </section>

    <!-- 9. Styles -->
    <style>
        .hero-container { height: 60vh; }
        @media (min-width: 768px) { .hero-container { height: 65vh; } }
        @media (min-width: 1024px) { .hero-container { height: 80vh; max-height: 800px; } }
        
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        @keyframes marquee { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }
        .animate-marquee { animation: marquee 30s linear infinite; }
    </style>
</div>
