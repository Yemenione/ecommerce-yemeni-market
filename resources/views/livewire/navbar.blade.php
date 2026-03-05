@inject('settings', 'App\Settings\GeneralSettings')

@push('head')
<style>
    @keyframes marquee {
        0% { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }
    .animate-marquee {
        display: flex;
        animation: marquee 30s linear infinite;
        width: max-content;
    }
    .animate-marquee:hover {
        animation-play-state: paused;
    }
</style>
@endpush

<div x-data="{ 
    mobileMenuOpen: false, 
    scrolled: window.pageYOffset > 20,
    searchOpen: false 
}" 
x-init="window.addEventListener('scroll', () => { scrolled = window.pageYOffset > 20 }, { passive: true })">
    <div class="fixed top-0 w-full z-[100] transition-all duration-500"
    :class="scrolled ? 'bg-white/90 backdrop-blur-md shadow-sm py-2' : 'bg-white py-4'">
        
        <!-- Top Bar (Persistent & Dynamic) -->
        <div class="bg-[#1A1A1A] text-white py-2 text-[10px] uppercase tracking-[0.2em] font-medium border-b border-white/5">
            <div class="container mx-auto px-4 flex justify-between items-center whitespace-nowrap overflow-visible">
                <!-- Announcement Section -->
                <div class="flex-1 overflow-hidden relative mr-12 h-4">
                    <div class="flex items-center gap-12 animate-marquee absolute">
                        @foreach(array_merge($settings->top_bar_announcements ?? [], $settings->top_bar_announcements ?? []) as $announcement)
                            <span class="flex items-center gap-2">
                                @if($announcement['icon'] === 'truck')
                                    <svg class="w-3.5 h-3.5 text-[#D4AF37]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 011 1v1m-1-1H4m10 0a2 2 0 114 0 2 2 0 01-4 0z"></path></svg>
                                @elseif($announcement['icon'] === 'bolt')
                                    <svg class="w-3.5 h-3.5 text-[#D4AF37]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                @elseif($announcement['icon'] === 'shield-check')
                                    <svg class="w-3.5 h-3.5 text-[#D4AF37]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                @else
                                    <span class="w-1.5 h-1.5 rounded-full bg-[#D4AF37]"></span>
                                @endif
                                {{ is_array($announcement['text']) ? ($announcement['text'][app()->getLocale()] ?? $announcement['text']['en']) : $announcement['text'] }}
                            </span>
                        @endforeach
                    </div>
                </div>

                <!-- Right Side Actions -->
                <div class="flex items-center gap-6">
                    <!-- Language Switcher -->
                    <div class="relative group" x-data="{ langOpen: false }" @mouseenter="langOpen = true" @mouseleave="langOpen = false">
                        <button class="flex items-center gap-1.5 hover:text-[#D4AF37] transition-all duration-300">
                            <span class="uppercase font-bold tracking-widest">{{ \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() }}</span>
                            <svg class="w-3 h-3 group-hover:rotate-180 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="langOpen" 
                             x-transition:enter="transition-all ease-out duration-300"
                             x-transition:enter-start="opacity-0 translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             class="absolute right-0 top-full pt-4 w-40 z-[120]">
                            <div class="bg-white text-gray-900 border border-gray-100 shadow-[0_10px_40px_-10px_rgba(0,0,0,0.2)] rounded-lg overflow-hidden p-2">
                                @foreach(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                    <a rel="alternate" hreflang="{{ $localeCode }}" href="{{ \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}" 
                                       class="flex items-center justify-between px-3 py-2.5 hover:bg-gray-50 rounded-md transition-colors text-[11px] font-medium group/item">
                                        <span class="text-gray-600 group-hover/item:text-black">{{ $properties['native'] }}</span>
                                        @if($localeCode === \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale())
                                            <div class="w-1.5 h-1.5 rounded-full bg-[#D4AF37] shadow-[0_0_8px_#D4AF37]"></div>
                                        @endif
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('contact') }}" class="hover:text-[#D4AF37] transition-colors flex items-center gap-2 group">
                        <span class="h-1 w-1 rounded-full bg-green-500 animate-pulse"></span>
                        {{ __('Support') }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Navigation -->
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center">
                
                <!-- Logo Section -->
                <div class="flex-1 flex items-center">
                    <a href="{{ route('home') }}" class="group flex items-center gap-3">
                        @if($settings->logo)
                            <img src="{{ asset('storage/' . $settings->logo) }}" alt="{{ $settings->site_name }}" class="h-10 w-auto object-contain transition-transform duration-500 group-hover:scale-105">
                        @else
                            <div class="flex flex-col">
                                <span class="font-serif text-2xl font-bold tracking-tight text-[#1A1A1A] leading-none">
                                    {{ explode(' ', $settings->site_name)[0] }} <span class="text-[#D4AF37]">{{ explode(' ', $settings->site_name)[1] ?? '' }}</span>
                                </span>
                                <span class="text-[9px] uppercase tracking-[0.4em] text-gray-400 mt-0.5">{{ __('Artisan Mastery') }}</span>
                            </div>
                        @endif
                    </a>
                </div>

                <!-- Nav Links (Desktop) -->
                <nav class="hidden lg:flex items-center gap-10">
                    <a href="{{ route('home') }}" class="text-xs font-bold uppercase tracking-[0.2em] {{ request()->routeIs('home') ? 'text-[#D4AF37]' : 'text-gray-900 hover:text-[#D4AF37]' }} transition-all duration-300 relative group">
                        {{ __('Home') }}
                        <span class="absolute -bottom-1 left-0 w-0 h-[1.5px] bg-[#D4AF37] transition-all duration-300 group-hover:w-full {{ request()->routeIs('home') ? 'w-full' : '' }}"></span>
                    </a>
                    
                    <!-- Collections Dropdown -->
                    <div class="relative group" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                        <button class="text-xs font-bold uppercase tracking-[0.2em] pb-1 border-b-[1.5px] border-transparent hover:text-[#D4AF37] transition-all duration-300 flex items-center gap-1.5">
                            {{ __('Collections') }}
                            <svg class="w-3 h-3 opacity-50 group-hover:rotate-180 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <!-- Mega Menu Content -->
                        <div x-show="open" 
                             x-transition:enter="transition-all ease-out duration-500"
                             x-transition:enter-start="opacity-0 translate-y-4"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             class="absolute left-1/2 -translate-x-1/2 top-full pt-4 w-[600px] z-50">
                            <div class="bg-white shadow-[0_20px_50px_rgba(0,0,0,0.1)] rounded-xl border border-gray-50 p-8 flex gap-10">
                                <div class="flex-1">
                                    <h3 class="text-[10px] font-bold uppercase tracking-[0.3em] text-[#D4AF37] mb-6">{{ __('Explore by Category') }}</h3>
                                    <div class="grid grid-cols-2 gap-x-8 gap-y-4">
                                        @foreach($this->categories as $cat)
                                            <a href="{{ route('shop', ['selectedCategories' => [$cat->id]]) }}" class="group flex items-center justify-between text-sm text-gray-600 hover:text-black transition-colors py-2 border-b border-gray-50">
                                                <span>{{ $cat->name }}</span>
                                                <svg class="w-3 h-3 opacity-0 group-hover:opacity-100 -translate-x-2 group-hover:translate-x-0 transition-all text-[#D4AF37]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"></path></svg>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="w-1/3 space-y-4">
                                    @foreach($this->categories->take(2) as $cat)
                                        <a href="{{ route('shop', ['selectedCategories' => [$cat->id]]) }}" class="block relative aspect-[4/3] rounded-lg overflow-hidden group/thumb">
                                            <img src="{{ asset('storage/' . $cat->image) }}" class="w-full h-full object-cover transition duration-1000 group-hover/thumb:scale-110">
                                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent flex items-end p-4">
                                                <span class="text-white text-[10px] font-bold uppercase tracking-widest">{{ $cat->name }}</span>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('shop') }}" class="text-xs font-bold uppercase tracking-[0.2em] {{ request()->routeIs('shop') ? 'text-[#D4AF37]' : 'text-gray-900 hover:text-[#D4AF37]' }} transition-all duration-300 relative group">
                        {{ __('Boutique') }}
                        <span class="absolute -bottom-1 left-0 w-0 h-[1.5px] bg-[#D4AF37] transition-all duration-300 group-hover:w-full {{ request()->routeIs('shop') ? 'w-full' : '' }}"></span>
                    </a>
                </nav>

                <!-- Actions Section -->
                <div class="flex-1 flex items-center justify-end gap-5">
                    
                    <!-- Search -->
                    <button @click="searchOpen = !searchOpen" class="text-gray-900 hover:text-[#D4AF37] transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </button>

                    <!-- Profile -->
                    <div class="relative" x-data="{ userOpen: false }" @mouseenter="userOpen = true" @mouseleave="userOpen = false">
                        <a href="{{ route('profile') }}" class="text-gray-900 hover:text-[#D4AF37] transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </a>
                        <!-- User Dropdown -->
                        <div x-show="userOpen" x-transition class="absolute right-0 top-full pt-4 w-48 z-50">
                            <div class="bg-white shadow-2xl rounded-xl border border-gray-100 py-3">
                                @auth
                                    <div class="px-4 py-2 border-b border-gray-50 mb-2">
                                        <p class="text-xs font-bold truncate">{{ auth()->user()->name }}</p>
                                        <p class="text-[9px] text-gray-400 uppercase tracking-widest mt-0.5">{{ __('Client Premium') }}</p>
                                    </div>
                                    <a href="{{ route('profile') }}" class="block px-4 py-2 text-xs text-gray-700 hover:bg-[#FDFBF7] hover:text-[#D4AF37] transition-all">{{ __('My Profile') }}</a>
                                    <a href="{{ route('my-orders') }}" class="block px-4 py-2 text-xs text-gray-700 hover:bg-[#FDFBF7] hover:text-[#D4AF37] transition-all">{{ __('My Orders') }}</a>
                                    <div class="px-2 mt-2">
                                        <a href="{{ route('logout') }}" class="block px-4 py-2 text-xs text-red-600 bg-red-50 rounded-lg hover:bg-red-100 transition-all font-bold">{{ __('Logout') }}</a>
                                    </div>
                                @else
                                    <a href="{{ route('login') }}" class="block px-4 py-2 text-xs text-gray-700 hover:bg-[#FDFBF7] transition-all">{{ __('Login') }}</a>
                                    <a href="{{ route('register') }}" class="block px-4 py-2 text-xs text-[#D4AF37] font-bold hover:bg-[#FDFBF7] transition-all">{{ __('Register') }}</a>
                                @endauth
                            </div>
                        </div>
                    </div>

                    <!-- Wishlist -->
                    <a href="{{ route('wishlist') }}" class="relative text-gray-900 hover:text-[#D4AF37] transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                        @if($wishlistCount > 0)
                            <span class="absolute -top-2 -right-2 w-4 h-4 bg-[#D4AF37] text-white text-[9px] font-bold rounded-full flex items-center justify-center border-2 border-white">{{ $wishlistCount }}</span>
                        @endif
                    </a>

                    <!-- Cart -->
                    <button @click="$dispatch('open-cart-drawer')" class="relative text-gray-900 hover:text-[#D4AF37] transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        @if($cartCount > 0)
                            <span class="absolute -top-2 -right-2 w-4 h-4 bg-[#1A1A1A] text-white text-[9px] font-bold rounded-full flex items-center justify-center border-2 border-white">{{ $cartCount }}</span>
                        @endif
                    </button>

                    <!-- Mobile Menu Button -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden text-gray-900">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                </div>
            </div>
        </div>
    </div> <!-- Close fixed header container -->

        <!-- Search Overlay -->
        <div x-show="searchOpen" 
             x-transition:enter="transition-all ease-out duration-700"
             x-transition:enter-start="opacity-0 -translate-y-full"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="absolute inset-x-0 top-0 bg-white/95 backdrop-blur-xl border-b border-gray-100 py-10 z-[120]">
            <div class="container mx-auto px-4 relative">
                <button @click="searchOpen = false" class="absolute right-4 top-0 p-2 text-gray-400 hover:text-black transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
                <div class="max-w-3xl mx-auto">
                    <p class="text-[10px] uppercase tracking-[0.4em] text-[#D4AF37] mb-6 text-center font-bold">{{ __('Begin your journey') }}</p>
                    <div class="relative group">
                        <input wire:model.live.debounce.300ms="search" 
                               type="text" 
                               class="w-full bg-transparent border-b-2 border-gray-100 focus:border-[#D4AF37] text-3xl font-serif py-6 px-12 outline-none transition-all placeholder:text-gray-200"
                               placeholder="{{ __('Seek a masterpiece...') }}"
                               @keydown.escape="searchOpen = false">
                        <svg class="absolute left-0 top-1/2 -translate-y-1/2 w-8 h-8 text-gray-300 group-focus-within:text-[#D4AF37] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>

                    <!-- Search Results -->
                    @if(strlen($search) >= 2)
                        <div class="mt-12 grid grid-cols-1 md:grid-cols-2 gap-8">
                            @forelse($this->results as $result)
                                <a href="{{ route('product.show', $result->slug) }}" class="group flex items-center gap-6 p-4 rounded-2xl hover:bg-[#FDFBF7] transition-all">
                                    <div class="w-20 h-20 rounded-xl overflow-hidden bg-white shadow-sm border border-gray-100">
                                        <img src="{{ asset('storage/' . ($result->images[0] ?? '')) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                    </div>
                                    <div>
                                        <h4 class="font-serif text-lg text-gray-900 group-hover:text-[#D4AF37] transition-colors">{{ $result->name }}</h4>
                                        <p class="text-sm font-bold text-[#D4AF37] mt-1">{{ number_format($result->base_price, 2) }} €</p>
                                    </div>
                                </a>
                            @empty
                                <div class="col-span-full py-10 text-center text-gray-400 italic font-serif">
                                    {{ __('No artifacts found for your quest.') }}
                                </div>
                            @endforelse
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Mobile Menu Overlay -->
        <div x-show="mobileMenuOpen" 
             x-transition:enter="transition-all ease-out duration-500"
             x-transition:enter-start="opacity-0 translate-x-full"
             x-transition:enter-end="opacity-100 translate-x-0"
             class="fixed inset-0 bg-white z-[150] lg:hidden overflow-y-auto">
            <div class="px-6 py-8 flex flex-col h-full">
                <div class="flex justify-between items-center mb-16">
                     <a href="{{ route('home') }}" @click="mobileMenuOpen = false">
                        @if($settings->logo)
                            <img src="{{ asset('storage/' . $settings->logo) }}" alt="{{ $settings->site_name }}" class="h-8 w-auto object-contain">
                        @else
                            <span class="font-serif text-2xl font-bold italic tracking-tight">
                                {{ explode(' ', $settings->site_name)[0] }} <span class="text-[#D4AF37]">{{ explode(' ', $settings->site_name)[1] ?? '' }}</span>
                            </span>
                        @endif
                     </a>
                     <button @click="mobileMenuOpen = false" class="p-2 text-gray-400">
                         <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"></path></svg>
                     </button>
                </div>
                <div class="flex flex-col gap-10 text-3xl font-serif">
                    <a href="{{ route('home') }}" class="hover:text-[#D4AF37] transition-all">{{ __('Home') }}</a>
                    <a href="{{ route('shop') }}" class="hover:text-[#D4AF37] transition-all">{{ __('Collections') }}</a>
                    <a href="{{ route('shop') }}" class="hover:text-[#D4AF37] transition-all">{{ __('Explore All') }}</a>
                    <a href="{{ route('contact') }}" class="hover:text-[#D4AF37] transition-all">{{ __('Conciergerie') }}</a>
                </div>
                <div class="mt-auto py-10 border-t border-gray-100">
                    <div class="flex justify-center gap-8">
                         @foreach($settings->social_media_links ?? [] as $link)
                            <a href="{{ $link['url'] }}" class="text-gray-400 hover:text-[#D4AF37]">{{ ucfirst($link['platform']) }}</a>
                         @endforeach
                    </div>
                </div>
            </div>
        </div>

    <!-- Spacer -->
    <div :class="scrolled ? 'h-16' : 'h-24 md:h-28'"></div>


    <!-- Cart Drawer (Kept same logic, just styled slightly) -->
    <div x-data="{ open: false }" 
         @open-cart-drawer.window="open = true"
         class="flex items-center">
        
        <template x-teleport="body">
            <div x-show="open" 
                 class="fixed inset-0 z-[200] overflow-hidden" 
                 x-cloak>
                
                <div class="absolute inset-0 overflow-hidden">
                    <div x-show="open" 
                         x-transition:enter="ease-in-out duration-500" 
                         x-transition:enter-start="opacity-0" 
                         x-transition:enter-end="opacity-100" 
                         x-transition:leave="ease-in-out duration-500" 
                         x-transition:leave-start="opacity-100" 
                         x-transition:leave-end="opacity-0" 
                         class="absolute inset-0 bg-black/60 backdrop-blur-md transition-opacity" 
                         @click="open = false"></div>

                    <div class="fixed inset-y-0 right-0 flex max-w-full pl-10">
                        <div x-show="open" 
                             x-transition:enter="transform transition ease-in-out duration-700" 
                             x-transition:enter-start="translate-x-full" 
                             x-transition:enter-end="translate-x-0" 
                             x-transition:leave="transform transition ease-in-out duration-500" 
                             x-transition:leave-start="translate-x-0" 
                             x-transition:leave-end="translate-x-full" 
                             class="w-screen max-w-md">
                            
                            <div class="flex flex-col h-full bg-white shadow-2xl">
                                <div class="flex-1 px-8 py-10 overflow-y-auto no-scrollbar">
                                    <div class="flex items-start justify-between mb-12">
                                        <div>
                                            <h2 class="text-[10px] font-bold uppercase tracking-[0.4em] text-[#D4AF37] mb-2">{{ __('Your Selection') }}</h2>
                                            <h3 class="text-3xl font-serif text-gray-900">{{ __('Bag') }}</h3>
                                        </div>
                                        <button @click="open = false" class="p-2 -mr-2 text-gray-300 hover:text-black transition-colors">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                    </div>

                                    <div class="flow-root">
                                        @if($this->cartItems->isEmpty())
                                            <div class="text-center py-24">
                                                <p class="text-gray-300 font-serif italic text-lg">{{ __('The collection is empty.') }}</p>
                                                <a href="{{ route('shop') }}" @click="open = false" class="mt-8 inline-block text-[10px] font-bold uppercase tracking-[0.3em] bg-black text-white px-8 py-4 hover:bg-[#D4AF37] transition-all">
                                                    {{ __('Explore Shop') }}
                                                </a>
                                            </div>
                                        @else
                                            <ul class="space-y-8">
                                                @foreach($this->cartItems as $key => $item)
                                                    <li class="group flex gap-6 pb-8 border-b border-gray-50">
                                                        <div class="flex-shrink-0 w-24 h-32 rounded-xl overflow-hidden bg-gray-50 border border-gray-100">
                                                            <img src="{{ asset('storage/' . ($item->images[0] ?? '')) }}" class="object-cover w-full h-full group-hover:scale-110 transition-transform duration-1000">
                                                        </div>
                                                        <div class="flex-1 flex flex-col justify-between py-1">
                                                            <div>
                                                                <h3 class="font-serif text-lg text-gray-900 leading-tight">{{ $item->name }}</h3>
                                                                @if($item->variant_name)
                                                                    <p class="text-[10px] text-[#D4AF37] uppercase tracking-widest mt-1">{{ $item->variant_name }}</p>
                                                                @endif
                                                                <p class="text-[10px] uppercase tracking-widest text-gray-400 font-bold mt-2">€{{ number_format($item->subtotal, 2) }}</p>
                                                            </div>
                                                            <div class="flex items-center justify-between text-[10px] font-bold uppercase tracking-widest text-gray-400">
                                                                <span>{{ __('Qty') }} {{ $item->quantity }}</span>
                                                                <button wire:click="removeFromCart('{{ $key }}')" class="hover:text-red-500 transition-colors">{{ __('Remove') }}</button>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                </div>

                                @if($this->cartItems->isNotEmpty())
                                    <div class="px-8 py-10 bg-[#FDFBF7] space-y-8">
                                        <div class="flex justify-between items-end border-b border-gray-200 pb-6">
                                            <div>
                                                <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-gray-400 mb-1">{{ __('Total') }}</p>
                                                <p class="text-4xl font-serif text-gray-900">€{{ number_format($this->cartTotal, 2) }}</p>
                                            </div>
                                            <p class="text-[10px] text-gray-400 italic">{{ __('Calculated at checkout') }}</p>
                                        </div>
                                        <div class="flex flex-col gap-4">
                                            <a href="{{ route('checkout') }}" class="w-full bg-[#1A1A1A] text-white py-5 text-[10px] font-bold uppercase tracking-[0.4em] text-center hover:bg-[#D4AF37] transition-all duration-500 shadow-xl">
                                                {{ __('Proceed to Checkout') }}
                                            </a>
                                            <a href="{{ route('cart') }}" @click="open = false" class="w-full py-4 text-[10px] font-bold uppercase tracking-[0.4em] text-center text-gray-400 hover:text-black transition-colors">
                                                {{ __('View My Bag') }}
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>
</div>

