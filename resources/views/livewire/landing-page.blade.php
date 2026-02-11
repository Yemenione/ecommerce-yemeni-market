<div class="min-h-screen">
    <!-- Hero Section -->
    <div class="relative bg-[#3E2723] h-[600px] flex items-center overflow-hidden">
        <div class="absolute inset-0">
            {{-- Placeholder for Hero Image --}}
            <div class="w-full h-full bg-gradient-to-r from-[#3E2723] to-[#5D4037] opacity-90"></div>
            {{-- <img src="..." class="w-full h-full object-cover opacity-50"> --}}
        </div>
        <div class="relative container mx-auto px-4 sm:px-6 lg:px-8 text-center sm:text-left">
            <h1 class="text-4xl tracking-tight font-extrabold text-white sm:text-5xl md:text-6xl font-serif">
                <span class="block">{{ __('The Authentic Taste') }}</span>
                <span class="block text-[#D4AF37]">{{ __('of Yemen') }}</span>
            </h1>
            <p class="mt-3 max-w-md mx-auto sm:mx-0 text-lg text-gray-300 sm:text-xl md:mt-5 md:max-w-3xl">
                {{ __('Discover the finest Sidr Honey, premium Coffee, and exotic Spices directly from the mountains of Yemen to your doorstep in Europe.') }}
            </p>
            <div class="mt-10 sm:flex sm:justify-start">
                <div class="rounded-md shadow">
                    <a href="{{ route('shop') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-[#3E2723] bg-[#D4AF37] hover:bg-[#B38F2D] md:py-4 md:text-lg md:px-10">
                        {{ __('Shop Now') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Products -->
    <div class="bg-white py-12">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-extrabold text-[#3E2723] font-serif mb-8 text-center">{{ __('Featured Products') }}</h2>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @forelse($featuredProducts as $product)
                    <div class="group relative border border-gray-200 rounded-lg p-4 hover:shadow-lg transition">
                        <div class="aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-md bg-gray-200 group-hover:opacity-75 lg:aspect-none lg:h-80">
                            @if($product->images && count($product->images) > 0)
                                <img src="{{ asset('storage/' . $product->images[0]) }}" alt="{{ $product->name }}" class="h-full w-full object-cover object-center lg:h-full lg:w-full">
                            @else
                                <div class="h-full w-full flex items-center justify-center bg-gray-100 text-gray-400">
                                    {{ __('No Image') }}
                                </div>
                            @endif
                        </div>
                        <div class="mt-4 flex justify-between">
                            <div>
                                <h3 class="text-sm text-gray-700">
                                    <a href="#">
                                        <span aria-hidden="true" class="absolute inset-0"></span>
                                        {{ $product->name }}
                                    </a>
                                </h3>
                                <p class="mt-1 text-sm text-gray-500">{{ Str::limit(strip_tags($product->description), 50) }}</p>
                            </div>
                            <p class="text-sm font-medium text-[#3E2723]">{{ number_format($product->price_eur, 2) }} €</p>
                        </div>
                        <div class="mt-4">
                            <button wire:click="addToCart({{ $product->id }})" class="w-full bg-[#3E2723] text-white py-2 rounded hover:bg-gray-800 relative z-10">
                                {{ __('Add to Cart') }}
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="col-span-4 text-center text-gray-500">
                        {{ __('No featured products found directly.') }}
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
