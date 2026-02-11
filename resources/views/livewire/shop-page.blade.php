<div class="bg-white min-h-screen py-8">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-extrabold text-[#3E2723] font-serif mb-8 text-center">{{ __('Shop') }}</h1>

        <div class="lg:grid lg:grid-cols-4 lg:gap-x-8">
            <!-- Sidebar Filters -->
            <div class="hidden lg:block">
                <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">{{ __('Categories') }}</h3>
                <div class="space-y-4">
                    @foreach($categories as $category)
                        <div class="flex items-center">
                            <input id="category-{{ $category->id }}" wire:model.live="selectedCategories" value="{{ $category->id }}" type="checkbox" class="h-4 w-4 text-[#D4AF37] border-gray-300 rounded focus:ring-[#D4AF37]">
                            <label for="category-{{ $category->id }}" class="ml-3 text-sm text-gray-600">
                                {{ $category->name }}
                            </label>
                        </div>
                    @endforeach
                </div>

                <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4 mt-8">{{ __('Price Range') }}</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-xs text-gray-500">{{ __('Min') }}</label>
                        <input type="number" wire:model.live.debounce.500ms="minPrice" class="w-full border-gray-300 rounded text-sm focus:ring-[#D4AF37] focus:border-[#D4AF37]">
                    </div>
                    <div>
                        <label class="text-xs text-gray-500">{{ __('Max') }}</label>
                        <input type="number" wire:model.live.debounce.500ms="maxPrice" class="w-full border-gray-300 rounded text-sm focus:ring-[#D4AF37] focus:border-[#D4AF37]">
                    </div>
                </div>
            </div>

            <!-- Product Grid -->
            <div class="mt-6 lg:mt-0 lg:col-span-3">
                <!-- Sorting -->
                <div class="flex justify-end mb-4">
                    <select wire:model.live="sort" class="border-gray-300 rounded text-sm focus:ring-[#D4AF37] focus:border-[#D4AF37]">
                        <option value="latest">{{ __('Latest') }}</option>
                        <option value="price_low">{{ __('Price: Low to High') }}</option>
                        <option value="price_high">{{ __('Price: High to Low') }}</option>
                    </select>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($products as $product)
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
                                <button wire:click="addToCart({{ $product->id }})" class="w-full bg-[#3E2723] text-white py-2 rounded hover:bg-gray-800 relative z-10 transition">
                                    {{ __('Add to Cart') }}
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-3 text-center py-12 text-gray-500">
                            {{ __('No products found matching your selection.') }}
                        </div>
                    @endforelse
                </div>

                <div class="mt-8">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
