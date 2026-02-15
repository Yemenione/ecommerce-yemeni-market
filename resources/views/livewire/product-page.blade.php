@push('head')
<script type="application/ld+json">
{
    "@@context": "https://schema.org/",
    "@@type": "Product",
    "name": "{{ $product->name }}",
    "image": [
        @if(is_array($product->images))
            @foreach($product->images as $image)
                "{{ asset('storage/' . $image) }}"{{ !$loop->last ? ',' : '' }}
            @endforeach
        @endif
    ],
    "description": "{{ $product->description }}",
    "sku": "{{ $product->sku }}",
    "brand": {
        "@@type": "Brand",
        "name": "Yemen Souq Europe"
    },
    "offers": {
        "@@type": "Offer",
        "url": "{{ request()->url() }}",
        "priceCurrency": "EUR",
        "price": "{{ $product->base_price }}",
        "availability": "https://schema.org/InStock",
        "itemCondition": "https://schema.org/NewCondition"
    }
}
</script>
@endpush

<div class="bg-white min-h-screen pb-16">
    <div class="container mx-auto px-4 py-8">
        <!-- Breadcrumbs -->
        <nav class="flex text-sm text-gray-500 mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('home') }}" class="hover:text-[#D4AF37]">{{ __('Home') }}</a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                        </svg>
                        <a href="{{ route('shop') }}" class="ml-1 hover:text-[#D4AF37]">{{ __('Shop') }}</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                        </svg>
                        <span class="ml-1 text-gray-700 md:ml-2 font-medium">{{ $product->name }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            <!-- Image Gallery -->
            <div x-data="{ activeImage: '{{ is_array($product->images) && count($product->images) > 0 ? asset('storage/' . $product->images[0]) : '' }}' }">
                <div class="aspect-square bg-gray-100 rounded-lg overflow-hidden mb-4 relative group">
                    @if(is_array($product->images) && count($product->images) > 0)
                        <img :src="activeImage" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-400">{{ __('No Image') }}</div>
                    @endif
                    
                    @if($product->is_flash_sale)
                        <span class="absolute top-4 left-4 bg-red-600 text-white px-3 py-1 rounded text-sm font-bold uppercase">{{ __('Sale') }}</span>
                    @endif
                </div>

                @if(is_array($product->images) && count($product->images) > 1)
                    <div class="grid grid-cols-4 gap-4">
                        @foreach($product->images as $image)
                            <button @click="activeImage = '{{ asset('storage/' . $image) }}'" class="aspect-square rounded-md overflow-hidden border-2 border-transparent hover:border-[#D4AF37] focus:outline-none focus:border-[#D4AF37]">
                                <img src="{{ asset('storage/' . $image) }}" class="w-full h-full object-cover">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Product Info -->
            <div>
                <h1 class="text-3xl font-serif text-[#3E2723] font-bold mb-2">{{ $product->name }}</h1>
                <div class="flex items-center mb-4 cursor-pointer" onclick="document.getElementById('reviews').scrollIntoView({behavior: 'smooth'})">
                    <div class="flex text-[#D4AF37] text-sm">
                        @for($i=1; $i<=5; $i++)
                            <svg class="w-4 h-4" fill="{{ $i <= round($avgRating) ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @endfor
                    </div>
                    <span class="text-gray-500 text-sm ml-2">({{ count($approvedReviews) }} {{ __('reviews') }})</span>
                </div>

                <div class="text-2xl font-bold text-[#1A1A1A] mb-6">
                    €{{ number_format($this->price, 2) }}
                    @if($product->is_flash_sale)
                        <span class="text-lg text-gray-500 line-through font-normal ml-2">€{{ number_format($this->price * 1.2, 2) }}</span>
                    @endif
                </div>

                <div class="text-gray-600 leading-relaxed mb-8">
                    {!! $product->description !!}
                </div>

                <!-- Variants Selection -->
                @if($product->variants->count() > 0)
                    <div class="mb-8 space-y-6">
                        @php
                            $colors = $product->variants->whereNotNull('color_code')->unique('color_code');
                            $sizes = $product->variants->whereNotNull('size')->unique('size');
                            $weights = $product->variants->whereNotNull('weight')->unique('weight');
                        @endphp

                        @if($colors->count() > 0)
                            <div>
                                <h4 class="text-xs font-bold uppercase tracking-widest text-gray-900 mb-3">{{ __('Color') }}</h4>
                                <div class="flex gap-3">
                                    @foreach($colors as $v)
                                        <button 
                                            wire:click="$set('selectedVariantId', {{ $v->id }})"
                                            class="w-10 h-10 rounded-full border-2 transition-all {{ $selectedVariantId == $v->id ? 'border-[#D4AF37] scale-110 shadow-lg' : 'border-gray-200 hover:border-gray-400' }}"
                                            style="background-color: {{ $v->color_code }}"
                                            title="{{ $v->color_code }}"
                                        ></button>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if($sizes->count() > 0 || $weights->count() > 0)
                            <div class="grid grid-cols-2 gap-4">
                                @if($sizes->count() > 0)
                                    <div>
                                        <h4 class="text-xs font-bold uppercase tracking-widest text-gray-900 mb-3">{{ __('Size') }}</h4>
                                        <select wire:model.live="selectedVariantId" class="w-full border-gray-200 rounded-lg text-sm focus:ring-[#D4AF37] focus:border-[#D4AF37]">
                                            <option value="">{{ __('Select Size') }}</option>
                                            @foreach($product->variants->whereNotNull('size') as $v)
                                                <option value="{{ $v->id }}">{{ $v->size }} (+€{{ $v->price_modifier }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif

                                @if($weights->count() > 0)
                                    <div>
                                        <h4 class="text-xs font-bold uppercase tracking-widest text-gray-900 mb-3">{{ __('Weight') }}</h4>
                                        <select wire:model.live="selectedVariantId" class="w-full border-gray-200 rounded-lg text-sm focus:ring-[#D4AF37] focus:border-[#D4AF37]">
                                            <option value="">{{ __('Select Weight') }}</option>
                                            @foreach($product->variants->whereNotNull('weight') as $v)
                                                <option value="{{ $v->id }}">{{ $v->weight }} (+€{{ $v->price_modifier }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                @endif

                @if($product->material || $product->dimensions)
                    <div class="mb-8 p-4 bg-[#FDFBF7] border border-gray-100 rounded-sm">
                        <h4 class="text-[10px] font-bold uppercase tracking-widest text-[#D4AF37] mb-3">{{ __('Luxury Specifications') }}</h4>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            @if($product->material)
                                <div>
                                    <span class="block text-gray-400 text-[10px] uppercase font-bold tracking-tighter">{{ __('Composition') }}</span>
                                    <span class="text-gray-900 font-serif">{{ $product->material }}</span>
                                </div>
                            @endif
                            @if($product->dimensions)
                                <div>
                                    <span class="block text-gray-400 text-[10px] uppercase font-bold tracking-tighter">{{ __('Dimensions') }}</span>
                                    <span class="text-gray-900 font-serif">{{ $product->dimensions }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Actions -->
                <div class="flex items-center gap-4 mb-8">
                    <div class="flex items-center border border-gray-300 rounded">
                        <button wire:click="$set('quantity', Math.max(1, quantity - 1))" class="px-3 py-2 text-gray-600 hover:bg-gray-100">-</button>
                        <input type="number" wire:model.live="quantity" class="w-12 text-center border-none focus:ring-0 p-0" min="1">
                        <button wire:click="$set('quantity', quantity + 1)" class="px-3 py-2 text-gray-600 hover:bg-gray-100">+</button>
                    </div>
                    <button wire:click="addToCart" class="flex-1 bg-[#D4AF37] text-black font-bold py-3 px-6 rounded shadow hover:bg-[#bfa030] transition duration-300 uppercase tracking-widest">
                        {{ __('Add to Cart') }}
                    </button>
                </div>

                <div class="border-t pt-6 text-sm text-gray-500 space-y-2">
                    <div class="flex">
                        <span class="font-medium text-gray-900 w-24">{{ __('SKU') }}:</span>
                        <span>{{ $product->sku }}</span>
                    </div>
                    <div class="flex">
                        <span class="font-medium text-gray-900 w-24">{{ __('Category') }}:</span>
                        <span>{{ $product->category->name }}</span>
                    </div>
                    <div class="flex">
                        <span class="font-medium text-gray-900 w-24">{{ __('Share') }}:</span>
                        <div class="flex space-x-3">
                            <a href="#" class="hover:text-[#D4AF37]">Facebook</a>
                            <a href="#" class="hover:text-[#D4AF37]">Twitter</a>
                            <a href="#" class="hover:text-[#D4AF37]">Pinterest</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(is_array($product->detail_images) && count($product->detail_images) > 0)
            <div class="mt-24">
                <h3 class="text-2xl font-serif text-[#3E2723] mb-8 text-center uppercase tracking-widest px-4">
                    <span class="border-b border-[#D4AF37] pb-2">{{ __('The Art of Detail') }}</span>
                </h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($product->detail_images as $img)
                        <div class="aspect-square bg-gray-50 overflow-hidden group">
                            <img src="{{ asset('storage/' . $img) }}" class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        @if(is_array($product->lifestyle_images) && count($product->lifestyle_images) > 0)
            <div class="mt-24 h-[600px] relative overflow-hidden group">
                <img src="{{ asset('storage/' . $product->lifestyle_images[0]) }}" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-black/30 flex items-center justify-center">
                    <div class="text-center text-white px-4">
                        <p class="text-xs uppercase tracking-[0.5em] mb-4">{{ __('In Context') }}</p>
                        <h4 class="text-5xl font-serif italic">{{ __('Luxury in every moment') }}</h4>
                    </div>
                </div>
            </div>
            @if(count($product->lifestyle_images) > 1)
                <div class="grid grid-cols-1 md:grid-cols-2 mt-4 gap-4">
                    @foreach(array_slice($product->lifestyle_images, 1) as $img)
                         <div class="aspect-[16/9] overflow-hidden">
                            <img src="{{ asset('storage/' . $img) }}" class="w-full h-full object-cover">
                         </div>
                    @endforeach
                </div>
            @endif
        @endif

        @if($product->care_instructions)
            <div class="mt-24 grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div class="p-12 bg-[#3E2723] text-white">
                    <h3 class="text-3xl font-serif mb-6">{{ __('Preservation & Care') }}</h3>
                    <div class="prose prose-invert prose-sm">
                        {!! $product->care_instructions !!}
                    </div>
                </div>
                <div class="h-full min-h-[400px] bg-[#FDFBF7] flex items-center justify-center border-y border-gray-100">
                    <div class="text-center p-8 border border-dashed border-[#D4AF37] m-4">
                        <svg class="w-12 h-12 text-[#D4AF37] mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <p class="text-sm font-serif italic text-gray-600">{{ __('Crafted for longevity. Follow these steps to maintain the ancestral quality.') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Reviews Section -->
        <div class="mt-24 border-t pt-16" id="reviews">
            <div class="flex flex-col md:flex-row gap-12">
                <!-- Summary -->
                <div class="md:w-1/3">
                    <h2 class="text-3xl font-serif text-gray-900 mb-6">{{ __('Customer Reviews') }}</h2>
                    <div class="flex items-center gap-4 mb-8">
                        <span class="text-6xl font-serif text-gray-900">{{ number_format($avgRating, 1) }}</span>
                        <div>
                            <div class="flex text-[#D4AF37]">
                                @for($i=1; $i<=5; $i++)
                                    <svg class="w-5 h-5" fill="{{ $i <= round($avgRating) ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                @endfor
                            </div>
                            <p class="text-sm text-gray-500 mt-1">{{ count($approvedReviews) }} {{ __('reviews based on real purchases') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Review List -->
                <div class="md:w-2/3 space-y-12">
                    @forelse($approvedReviews as $review)
                        <div class="border-b border-gray-100 pb-12 last:border-0 transition-all duration-700">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-[#FDFBF7] rounded-full flex items-center justify-center text-[#D4AF37] font-bold text-sm">
                                        {{ substr($review->user->name ?? 'A', 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-sm text-gray-900">{{ $review->user->name ?? __('Anonymous') }}</p>
                                        <p class="text-[10px] text-gray-400 uppercase tracking-widest">{{ $review->created_at->format('M d, Y') }}</p>
                                    </div>
                                </div>
                                <div class="flex text-[#D4AF37]">
                                    @for($i=1; $i<=5; $i++)
                                        <svg class="w-3 h-3" fill="{{ $i <= $review->rating ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    @endfor
                                </div>
                            </div>
                            <p class="text-gray-600 leading-relaxed font-serif italic text-lg">"{{ $review->comment }}"</p>
                        </div>
                    @empty
                        <div class="py-12 text-center bg-[#FDFBF7] rounded-sm border border-dashed border-gray-200">
                            <p class="text-gray-400 font-serif italic">{{ __('No reviews yet. Be the first to share your experience.') }}</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
