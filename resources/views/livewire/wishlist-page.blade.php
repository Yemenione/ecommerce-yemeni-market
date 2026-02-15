<div class="py-24 px-4 bg-[#FDFBF7] min-h-screen">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-5xl font-serif text-center mb-16 tracking-tight text-gray-900">{{ __('Your Saved Treasures') }}</h1>

        @if($this->wishlistItems->isEmpty())
            <div class="text-center py-32 bg-white border border-gray-100 shadow-sm rounded-sm">
                <svg class="w-16 h-16 text-gray-200 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
                <p class="text-gray-400 font-serif italic text-lg mb-8">{{ __('Your wishlist is empty. Start collecting your favorite items.') }}</p>
                <a href="{{ route('shop') }}" class="inline-block bg-black text-white px-10 py-4 text-xs font-bold uppercase tracking-[0.3em] hover:bg-[#D4AF37] transition-all duration-500">
                    {{ __('Explore Shop') }}
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
                @foreach($this->wishlistItems as $product)
                    <div class="relative group">
                        <button wire:click="removeFromWishlist({{ $product->id }})" 
                                class="absolute top-4 right-4 z-10 w-8 h-8 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center text-red-500 hover:bg-black hover:text-white transition-all shadow-sm">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                        
                        <x-product-card :product="$product" />
                        
                        <button wire:click="addToCart({{ $product->id }})" 
                                class="w-full mt-4 bg-black text-white py-3 text-[10px] font-bold uppercase tracking-[0.2em] hover:bg-[#D4AF37] transition-all duration-300">
                            {{ __('Move to Bag') }}
                        </button>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
