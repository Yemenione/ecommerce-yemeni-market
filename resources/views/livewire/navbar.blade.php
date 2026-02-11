<nav class="bg-white shadow-md sticky top-0 z-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="font-serif text-2xl font-bold text-[#3E2723]">
                        Yemen Souq <span class="text-[#D4AF37]">Europe</span>
                    </a>
                </div>
                <div class="hidden sm:ml-6 sm:flex sm:space-x-8 rtl:space-x-reverse">
                    <a href="{{ route('home') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('home') ? 'border-[#D4AF37] text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} text-sm font-medium">
                        {{ __('Home') }}
                    </a>
                    <a href="{{ route('shop') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('shop') ? 'border-[#D4AF37] text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} text-sm font-medium">
                        {{ __('Shop') }}
                    </a>
                </div>
            </div>
            <div class="flex items-center space-x-4 rtl:space-x-reverse">
                <!-- Search -->
                <div class="relative hidden md:block">
                    <input type="text" class="bg-gray-100 rounded-full px-4 py-1 text-sm focus:outline-none focus:ring-1 focus:ring-[#D4AF37]" placeholder="{{ __('Search...') }}">
                </div>

                <!-- Language Switcher -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center text-gray-500 hover:text-gray-700 focus:outline-none">
                        <span class="uppercase">{{ \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() }}</span>
                        <svg class="ml-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-32 bg-white rounded-md shadow-lg py-1 ring-1 ring-black ring-opacity-5 z-50">
                        @foreach(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                            <a rel="alternate" hreflang="{{ $localeCode }}" href="{{ \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                {{ $properties['native'] }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Cart -->
                <a href="{{ route('cart') }}" class="text-gray-500 hover:text-[#D4AF37] relative">
                    <span class="sr-only">{{ __('Cart') }}</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    {{-- <span class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full text-xs w-4 h-4 flex items-center justify-center">0</span> --}}
                </a>
            </div>
        </div>
    </div>
</nav>
