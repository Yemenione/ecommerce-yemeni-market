@props(['product'])

<div class="group relative bg-white transition-all duration-700 ease-[cubic-bezier(0.23,1,0.32,1)] hover:-translate-y-2 hover:shadow-[0_20px_40px_rgba(0,0,0,0.04)]">
    <!-- Image Container with Aspect Ratio -->
    <a href="{{ route('product.show', $product->slug) }}" class="block relative aspect-[4/5] overflow-hidden bg-[#FDFBF7]">
        @if(is_array($product->images) && count($product->images) > 0)
            <img src="{{ asset('storage/' . $product->images[0]) }}" 
                 alt="{{ $product->name }}" 
                 loading="lazy"
                 decoding="async"
                 class="w-full h-full object-cover object-center group-hover:scale-110 transition-transform duration-[2000ms] ease-out">
             @if(count($product->images) > 1)
                <img src="{{ asset('storage/' . $product->images[1]) }}" 
                     alt="{{ $product->name }}" 
                     loading="lazy"
                     decoding="async"
                     class="absolute inset-0 w-full h-full object-cover object-center opacity-0 group-hover:opacity-100 transition-opacity duration-700 ease-in-out">
             @endif
        @else
            <div class="w-full h-full flex items-center justify-center text-gray-300">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
        @endif

        <!-- Minimalist Badges -->
        <div class="absolute top-3 left-3 flex flex-col gap-1.5">
            @if($product->is_flash_sale)
                <span class="bg-black text-white text-[10px] font-bold px-2 py-0.5 uppercase tracking-[0.2em]">Sale</span>
            @endif
            @if($product->created_at->diffInDays(now()) < 7)
                <span class="bg-[#D4AF37] text-white text-[10px] font-bold px-2 py-0.5 uppercase tracking-[0.2em]">New</span>
            @endif
        </div>

        <div class="absolute inset-0 bg-black/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        
        <div class="absolute top-3 right-3 flex flex-col gap-2 translate-x-12 group-hover:translate-x-0 transition-transform duration-500">
            @php
                $inWishlist = in_array($product->id, session()->get('wishlist', []));
            @endphp
            <button wire:click.prevent="$dispatch('toggle-wishlist', { productId: {{ $product->id }} })" 
                    class="w-8 h-8 rounded-full flex items-center justify-center transition-all shadow-sm {{ $inWishlist ? 'bg-[#D4AF37] text-white' : 'bg-white/90 backdrop-blur-sm text-gray-900 hover:bg-black hover:text-white' }}">
                <svg class="w-4 h-4" fill="{{ $inWishlist ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
            </button>
            <button @click.stop="$dispatch('open-quick-view', { productId: {{ $product->id }} })" 
                    class="w-8 h-8 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center text-gray-900 hover:bg-black hover:text-white transition-all shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
            </button>
        </div>

        <button wire:click.prevent="addToCart({{ $product->id }})" 
                class="absolute bottom-4 left-4 right-4 bg-white/90 backdrop-blur-sm text-black py-3 text-[10px] font-bold uppercase tracking-[0.2em] transform translate-y-4 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-500 hover:bg-black hover:text-white border border-black/5">
            {{ __('Add to Cart') }}
        </button>
    </a>

    <!-- Details Section -->

    <!-- Details Section -->
    <div class="pt-4 pb-2 text-center">
        <h3 class="text-xs text-gray-500 uppercase tracking-widest mb-1 px-2 line-clamp-1">
            <a href="{{ route('product.show', $product->slug) }}" class="hover:text-[#D4AF37] transition-colors duration-300">{{ $product->name }}</a>
        </h3>
        <div class="flex flex-col items-center gap-1">
            <span class="font-serif text-lg text-gray-900 tracking-tight">€{{ number_format($product->base_price, 2) }}</span>
            @if($product->is_flash_sale)
                <span class="text-xs text-gray-400 line-through">€{{ number_format($product->base_price * 1.2, 2) }}</span>
            @endif
        </div>
        
        <!-- Subtle Star Rating -->
        <div class="flex justify-center items-center mt-2 opacity-60">
            @for($i=0; $i<5; $i++)
                <svg class="w-2.5 h-2.5 {{ $i < 4 ? 'text-[#D4AF37]' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
            @endfor
        </div>
    </div>
</div>
