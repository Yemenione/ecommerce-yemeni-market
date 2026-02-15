<div x-data="{ open: @entangle('show') }" 
     x-show="open" 
     @keydown.escape.window="open = false" 
     class="fixed inset-0 z-[110] overflow-y-auto" 
     x-cloak>
    
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Backdrop -->
        <div x-show="open" 
             x-transition:enter="ease-out duration-300" 
             x-transition:enter-start="opacity-0" 
             x-transition:enter-end="opacity-100" 
             x-transition:leave="ease-in duration-200" 
             x-transition:leave-start="opacity-100" 
             x-transition:leave-end="opacity-0" 
             class="fixed inset-0 transition-opacity bg-black/60 backdrop-blur-sm" 
             @click="open = false" 
             aria-hidden="true"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <!-- Modal -->
        <div x-show="open" 
             x-transition:enter="ease-out duration-300" 
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
             x-transition:leave="ease-in duration-200" 
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
             class="inline-block w-full max-w-4xl overflow-hidden text-left align-middle transition-all transform bg-white shadow-2xl rounded-sm sm:align-middle">
            
            @if($product)
                <div class="flex flex-col md:flex-row">
                    <!-- Image Gallery (Simplified) -->
                    <div class="w-full md:w-1/2 bg-[#FDFBF7] relative group/gallery">
                        <div class="aspect-[4/5] relative">
                            @if(is_array($product->images) && count($product->images) > 0)
                                <img src="{{ asset('storage/' . $product->images[0]) }}" class="object-cover w-full h-full">
                            @endif
                        </div>
                    </div>

                    <!-- Details -->
                    <div class="w-full p-8 md:w-1/2 flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h2 class="text-3xl font-serif text-gray-900 mb-1 tracking-tight">{{ $product->name }}</h2>
                                    <p class="text-xs text-gray-400 uppercase tracking-widest">{{ $product->category->name ?? '' }}</p>
                                </div>
                                <button @click="open = false" class="text-gray-400 hover:text-black transition-colors">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                </button>
                            </div>

                            <div class="flex items-baseline gap-4 mb-6">
                                <span class="text-2xl font-serif text-[#D4AF37]">€{{ number_format($product->base_price, 2) }}</span>
                                @if($product->is_flash_sale)
                                    <span class="text-sm text-gray-400 line-through">€{{ number_format($product->base_price * 1.2, 2) }}</span>
                                @endif
                            </div>

                            <div class="prose prose-sm text-gray-600 mb-8 max-h-40 overflow-y-auto no-scrollbar">
                                <p>{{ $product->description }}</p>
                            </div>

                            <!-- Quantity & Cart -->
                            <div class="space-y-4">
                                <div class="flex items-center gap-4">
                                    <span class="text-xs font-bold uppercase tracking-widest text-gray-400">{{ __('Quantity') }}</span>
                                    <div class="flex items-center border border-gray-100 rounded">
                                        <button wire:click="$set('quantity', Math.max(1, quantity - 1))" class="px-3 py-1 hover:bg-gray-50">-</button>
                                        <input type="number" wire:model="quantity" class="w-12 text-center border-none focus:ring-0 text-sm" readonly>
                                        <button wire:click="$set('quantity', quantity + 1)" class="px-3 py-1 hover:bg-gray-50">+</button>
                                    </div>
                                </div>

                                <button wire:click="addToCart" class="w-full bg-black text-white py-4 text-xs font-bold uppercase tracking-[0.3em] hover:bg-[#D4AF37] transition-all duration-500">
                                    {{ __('Add to Treasure') }}
                                </button>
                            </div>
                        </div>

                        <div class="mt-8 pt-6 border-t border-gray-50">
                            <a href="{{ route('product.show', $product->slug) }}" class="text-[10px] font-bold uppercase tracking-widest text-gray-400 hover:text-black transition-colors border-b border-transparent hover:border-black pb-1">
                                {{ __('View Full Details') }} &rarr;
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
