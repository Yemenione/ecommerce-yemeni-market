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
                        <x-product-card :product="$product" />
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
