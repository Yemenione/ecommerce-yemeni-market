<div class="bg-[#FDFBF7] min-h-screen" x-data="{ filtersOpen: false }">
    
    <!-- 1. Editorial Header -->
    <div class="relative pt-24 pb-16 md:pt-32 md:pb-24 bg-[#FDFBF7] border-b border-black/5">
        <div class="max-w-7xl mx-auto px-4 text-center" x-data="{ visible: false }" x-intersect.margin.-10%="visible = true">
            <div class="transition-all duration-1000 ease-out transform" :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-12'">
                <span class="block text-[#D4AF37] text-[10px] uppercase tracking-[0.4em] font-bold mb-6">{{ __('Discover Yemeni Excellence') }}</span>
                <h1 class="text-5xl md:text-8xl font-serif text-gray-900 tracking-tighter mb-6">{{ __('The') }} <span class="italic text-gray-400">{{ __('Collection') }}</span></h1>
                <p class="text-gray-500 font-serif italic max-w-xl mx-auto text-sm md:text-base">
                    {{ __('A curated selection of the world\'s finest natural treasures, harvested with centuries of tradition from the heart of Yemen.') }}
                </p>
            </div>
        </div>
    </div>

    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16">
        
        <!-- 2. Magnetic Category Chips (Swipeable on Mobile) -->
        <div class="mb-12 md:mb-16 -mx-4 px-4 sm:mx-0 sm:px-0">
            <div class="flex overflow-x-auto gap-3 pb-4 no-scrollbar snap-x">
                <button wire:click="$set('selectedCategories', [])" 
                        class="snap-start whitespace-nowrap px-6 py-2.5 rounded-full text-[11px] font-bold uppercase tracking-[0.2em] transition-all duration-300 flex-shrink-0 border {{ empty($selectedCategories) ? 'bg-[#1A1A1A] text-white border-[#1A1A1A]' : 'bg-transparent text-gray-500 border-black/10 hover:border-black/30' }}">
                    {{ __('All Editions') }}
                </button>
                @foreach($categories as $category)
                    <button wire:click="$set('selectedCategories', [{{ $category->id }}])" 
                            class="snap-start whitespace-nowrap px-6 py-2.5 rounded-full text-[11px] font-bold uppercase tracking-[0.2em] transition-all duration-300 flex-shrink-0 border {{ in_array($category->id, $selectedCategories) ? 'bg-[#D4AF37] text-white border-[#D4AF37] shadow-[0_5px_15px_rgba(212,175,55,0.3)]' : 'bg-white text-gray-600 border-black/5 hover:border-[#D4AF37]/50' }}">
                        {{ $category->name }}
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Desktop Control Bar (Hidden on Mobile) -->
        <div class="hidden md:flex justify-between items-center mb-12 border-b border-black/10 pb-6">
            <button @click="filtersOpen = true" class="group flex items-center gap-3 text-xs uppercase tracking-[0.2em] font-bold text-gray-900 hover:text-[#D4AF37] transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                <span class="border-b border-transparent group-hover:border-[#D4AF37] pb-0.5 transition-all">{{ __('Refine Selection') }}</span>
                @if(count($selectedCategories) > 0 || $minPrice || $maxPrice)
                    <span class="w-1.5 h-1.5 rounded-full bg-[#D4AF37]"></span>
                @endif
            </button>
            <div class="relative flex items-center">
                <label class="text-[10px] uppercase tracking-[0.2em] text-gray-400 mr-4">{{ __('Sort By') }}</label>
                <select wire:model.live="sort" class="appearance-none bg-transparent border-none text-xs font-bold uppercase tracking-[0.1em] text-gray-900 pr-8 focus:ring-0 cursor-pointer">
                    <option value="latest">{{ __('Latest Editions') }}</option>
                    <option value="price_low">{{ __('Ascending Value') }}</option>
                    <option value="price_high">{{ __('Descending Value') }}</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center text-gray-500">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
            </div>
        </div>

        <!-- Sticky Mobile Bottom Action Bar (App-like Feel) -->
        <div class="md:hidden fixed bottom-6 left-1/2 -translate-x-1/2 w-[90%] z-[80] transition-all duration-500 shadow-[0_10px_40px_rgba(0,0,0,0.15)] rounded-full bg-white/90 backdrop-blur-xl border border-white/50 flex divide-x divide-gray-100">
            <button @click="filtersOpen = true" class="flex-1 py-4 flex items-center justify-center gap-2 text-[10px] font-bold uppercase tracking-[0.2em] text-gray-900">
                <svg class="w-4 h-4 text-[#D4AF37]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                {{ __('Filter') }}
                @if(count($selectedCategories) > 0 || $minPrice || $maxPrice)
                    <span class="w-1.5 h-1.5 rounded-full bg-[#D4AF37] ml-1"></span>
                @endif
            </button>
            <div class="flex-1 relative flex items-center justify-center">
                <svg class="absolute left-6 w-4 h-4 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"></path></svg>
                <select wire:model.live="sort" class="appearance-none bg-transparent border-none text-[10px] font-bold uppercase tracking-[0.2em] text-gray-900 w-full pl-12 pr-4 py-4 focus:ring-0 text-center text-center-last">
                    <option value="latest">{{ __('Latest') }}</option>
                    <option value="price_low">{{ __('Low to High') }}</option>
                    <option value="price_high">{{ __('High to Low') }}</option>
                </select>
            </div>
        </div>

        <!-- 3. Expanded Product Stage -->
        <div class="relative" wire:loading.class="opacity-50 blur-sm pointer-events-none" wire:target="selectedCategories, minPrice, maxPrice, sort">
            <!-- Grid with Hyper Negative Space -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 gap-y-16 md:gap-y-24">
                @forelse($products as $index => $product)
                    <div class="transition-all duration-1000 ease-out transform" style="animation: fadeUp 0.8s ease-out forwards; animation-delay: {{ $index * 100 }}ms; opacity: 0; transform: translateY(20px);">
                        <x-product-card :product="$product" />
                    </div>
                @empty
                    <div class="col-span-full text-center py-32">
                        <span class="block text-[#D4AF37] text-4xl mb-6">✧</span>
                        <p class="text-xl font-serif text-gray-500 italic">{{ __('No masterpieces match your refined criteria.') }}</p>
                        <button wire:click="$set('selectedCategories', []); $set('minPrice', null); $set('maxPrice', null)" class="mt-8 text-xs uppercase tracking-[0.2em] border-b border-black pb-1 hover:text-[#D4AF37] hover:border-[#D4AF37] transition-colors">
                            {{ __('Clear Filters') }}
                        </button>
                    </div>
                @endforelse
            </div>

            <div class="mt-24 elegant-pagination">
                {{ $products->links() }}
            </div>
        </div>
    </div>

    <!-- 4. Interactive Filter Drawer (Bottom Sheet on Mobile / Slide-over on Desktop) -->
    <div x-show="filtersOpen" class="fixed inset-0 z-[100] overflow-hidden" aria-labelledby="slide-over-title" role="dialog" aria-modal="true" style="display: none;">
        <div class="absolute inset-0 overflow-hidden">
            <!-- Backdrop -->
            <div x-show="filtersOpen" 
                 x-transition:enter="ease-in-out duration-500" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" 
                 x-transition:leave="ease-in-out duration-500" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" 
                 class="absolute inset-0 bg-black/60 backdrop-blur-sm transition-opacity" @click="filtersOpen = false"></div>

            <div class="fixed inset-x-0 bottom-0 md:inset-y-0 md:right-0 md:left-auto md:pl-10 max-w-full flex h-[85vh] md:h-full rounded-t-3xl md:rounded-none overflow-hidden">
                <!-- Slide-over panel -->
                <div x-show="filtersOpen" 
                     x-transition:enter="transform transition ease-in-out duration-500" 
                     x-transition:enter-start="translate-y-full md:translate-y-0 md:translate-x-full" 
                     x-transition:enter-end="translate-y-0 md:translate-x-0" 
                     x-transition:leave="transform transition ease-in-out duration-500" 
                     x-transition:leave-start="translate-y-0 md:translate-x-0" 
                     x-transition:leave-end="translate-y-full md:translate-y-0 md:translate-x-full" 
                     class="w-screen max-w-md w-full">
                    <div class="h-full flex flex-col bg-[#FDFBF7] shadow-2xl overflow-y-scroll relative">
                        
                        <!-- Mobile Drag Handle -->
                        <div class="md:hidden w-full flex justify-center pt-4 pb-2">
                            <div class="w-12 h-1.5 bg-gray-300 rounded-full"></div>
                        </div>

                        <!-- Header -->
                        <div class="px-6 py-6 md:py-8 border-b border-black/5 flex items-center justify-between">
                            <h2 class="text-3xl font-serif text-gray-900" id="slide-over-title">{{ __('Refine') }}</h2>
                            <button @click="filtersOpen = false" class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 hover:text-black hover:bg-gray-200 transition-colors">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        </div>

                        <!-- Filters Content -->
                        <div class="mt-8 px-6 flex-1">
                            <h3 class="text-[10px] uppercase tracking-[0.2em] text-gray-400 mb-6 font-bold">{{ __('Categories') }}</h3>
                            <div class="flex flex-col gap-3 mb-12">
                                @foreach($categories as $category)
                                    <label class="relative flex items-center justify-between group cursor-pointer p-4 rounded-xl border {{ in_array($category->id, $selectedCategories) ? 'border-[#D4AF37] bg-white shadow-sm' : 'border-black/5 bg-transparent hover:border-black/20' }} transition-all">
                                        <div class="flex items-center gap-4">
                                            <div class="w-5 h-5 rounded border {{ in_array($category->id, $selectedCategories) ? 'border-[#D4AF37] bg-[#D4AF37]' : 'border-gray-300' }} flex items-center justify-center transition-colors">
                                                <svg class="w-3 h-3 text-white {{ in_array($category->id, $selectedCategories) ? 'opacity-100' : 'opacity-0' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                            </div>
                                            <span class="text-sm font-serif text-gray-900 group-hover:text-[#D4AF37] transition-colors">{{ $category->name }}</span>
                                        </div>
                                        <input wire:model.live="selectedCategories" value="{{ $category->id }}" type="checkbox" class="absolute opacity-0">
                                    </label>
                                @endforeach
                            </div>

                            <h3 class="text-[10px] uppercase tracking-[0.2em] text-gray-400 mb-6 font-bold">{{ __('Price Tier') }}</h3>
                            <div class="grid grid-cols-2 gap-3 mb-8">
                                <!-- Price Pills instead of boring inputs -->
                                <button wire:click="$set('minPrice', null); $set('maxPrice', 50)" class="py-3 rounded-xl text-xs font-bold uppercase tracking-widest border transition-all {{ $maxPrice == 50 && !$minPrice ? 'bg-black text-white border-black' : 'bg-transparent text-gray-600 border-black/10 hover:border-black/30' }}">
                                    Under €50
                                </button>
                                <button wire:click="$set('minPrice', 50); $set('maxPrice', 150)" class="py-3 rounded-xl text-xs font-bold uppercase tracking-widest border transition-all {{ $minPrice == 50 && $maxPrice == 150 ? 'bg-black text-white border-black' : 'bg-transparent text-gray-600 border-black/10 hover:border-black/30' }}">
                                    €50 - €150
                                </button>
                                <button wire:click="$set('minPrice', 150); $set('maxPrice', 300)" class="py-3 rounded-xl text-xs font-bold uppercase tracking-widest border transition-all {{ $minPrice == 150 && $maxPrice == 300 ? 'bg-black text-white border-black' : 'bg-transparent text-gray-600 border-black/10 hover:border-black/30' }}">
                                    €150 - €300
                                </button>
                                <button wire:click="$set('minPrice', 300); $set('maxPrice', null)" class="py-3 rounded-xl text-xs font-bold uppercase tracking-widest border transition-all {{ $minPrice == 300 && !$maxPrice ? 'bg-black text-white border-black' : 'bg-transparent text-gray-600 border-black/10 hover:border-black/30' }}">
                                    Over €300
                                </button>
                            </div>
                            
                            <!-- Custom inputs hidden inside an elegant accordion if needed, or left out for max minimalism -->
                            
                            <!-- Clear action -->
                            <div class="mt-8 text-center">
                                <button wire:click="$set('selectedCategories', []); $set('minPrice', null); $set('maxPrice', null)" class="text-xs text-gray-400 uppercase tracking-[0.2em] hover:text-[#D4AF37] transition-all pb-1 border-b border-transparent hover:border-[#D4AF37]">
                                    {{ __('Clear all refinements') }}
                                </button>
                            </div>
                        </div>
                        
                        <!-- Footer Action -->
                        <div class="px-6 py-6 pb-8 md:pb-6 border-t border-black/5 bg-[#FDFBF7]">
                            <button @click="filtersOpen = false" class="w-full bg-black text-white py-5 rounded-xl text-xs font-bold uppercase tracking-[0.3em] hover:bg-[#D4AF37] hover:shadow-[0_10px_20px_rgba(212,175,55,0.3)] transition-all duration-300">
                                {{ __('View Results') }} ({{ $products->total() }})
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <style>
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</div>
