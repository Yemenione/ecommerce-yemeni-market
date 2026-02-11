<div class="bg-gray-50 min-h-screen py-12">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-extrabold text-[#3E2723] font-serif mb-8 text-center">{{ __('Checkout') }}</h1>

        <div class="lg:grid lg:grid-cols-2 lg:gap-x-12 xl:gap-x-16">
            <!-- Order Summary -->
            <div class="mt-10 lg:mt-0 order-2 lg:order-2">
                <h2 class="text-lg font-medium text-gray-900">{{ __('Order Summary') }}</h2>

                <div class="mt-4 bg-white border border-gray-200 rounded-lg shadow-sm">
                    <ul role="list" class="divide-y divide-gray-200">
                        @foreach($items as $item)
                            <li class="flex py-6 px-4 sm:px-6">
                                <div class="flex-shrink-0">
                                    @if($item->images && count($item->images) > 0)
                                        <img src="{{ asset('storage/' . $item->images[0]) }}" alt="{{ $item->name }}" class="w-20 rounded-md">
                                    @else
                                        <div class="w-20 h-20 bg-gray-100 flex items-center justify-center text-gray-400 text-xs">{{ __('No Img') }}</div>
                                    @endif
                                </div>

                                <div class="ml-6 flex-1 flex flex-col">
                                    <div class="flex">
                                        <div class="min-w-0 flex-1">
                                            <h4 class="text-sm">
                                                <a href="#" class="font-medium text-gray-700 hover:text-gray-800">
                                                    {{ $item->name }}
                                                </a>
                                            </h4>
                                        </div>
                                    </div>

                                    <div class="flex-1 pt-2 flex items-end justify-between">
                                        <p class="mt-1 text-sm font-medium text-gray-900">{{ number_format($item->subtotal, 2) }} €</p>
                                        <div class="ml-4">
                                            <p class="text-sm text-gray-500">Qty {{ $item->quantity }}</p>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    <dl class="border-t border-gray-200 py-6 px-4 sm:px-6">
                        <div class="flex items-center justify-between">
                            <dt class="text-base font-medium text-gray-900">{{ __('Total') }}</dt>
                            <dd class="text-base font-medium text-gray-900">{{ number_format($total, 2) }} €</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Checkout Form -->
            <div class="mt-10 lg:mt-0 order-1 lg:order-1">
                <h2 class="text-lg font-medium text-gray-900">{{ __('Shipping Information') }}</h2>

                <form wire:submit.prevent="placeOrder" class="mt-4">
                    <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4">
                        <div>
                            <label for="first-name" class="block text-sm font-medium text-gray-700">{{ __('First name') }}</label>
                            <div class="mt-1">
                                <input type="text" id="first-name" wire:model="firstName" autocomplete="given-name" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-[#D4AF37] focus:border-[#D4AF37] sm:text-sm">
                                @error('firstName') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div>
                            <label for="last-name" class="block text-sm font-medium text-gray-700">{{ __('Last name') }}</label>
                            <div class="mt-1">
                                <input type="text" id="last-name" wire:model="lastName" autocomplete="family-name" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-[#D4AF37] focus:border-[#D4AF37] sm:text-sm">
                                @error('lastName') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="sm:col-span-2">
                            <label for="email" class="block text-sm font-medium text-gray-700">{{ __('Email address') }}</label>
                            <div class="mt-1">
                                <input type="email" id="email" wire:model="email" autocomplete="email" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-[#D4AF37] focus:border-[#D4AF37] sm:text-sm">
                                @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="sm:col-span-2">
                            <label for="phone" class="block text-sm font-medium text-gray-700">{{ __('Phone') }}</label>
                            <div class="mt-1">
                                <input type="text" id="phone" wire:model="phone" autocomplete="tel" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-[#D4AF37] focus:border-[#D4AF37] sm:text-sm">
                                @error('phone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="sm:col-span-2">
                            <label for="address" class="block text-sm font-medium text-gray-700">{{ __('Address') }}</label>
                            <div class="mt-1">
                                <input type="text" id="address" wire:model="address" autocomplete="street-address" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-[#D4AF37] focus:border-[#D4AF37] sm:text-sm">
                                @error('address') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div>
                            <label for="city" class="block text-sm font-medium text-gray-700">{{ __('City') }}</label>
                            <div class="mt-1">
                                <input type="text" id="city" wire:model="city" autocomplete="address-level2" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-[#D4AF37] focus:border-[#D4AF37] sm:text-sm">
                                @error('city') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div>
                            <label for="postal-code" class="block text-sm font-medium text-gray-700">{{ __('ZIP / Postal code') }}</label>
                            <div class="mt-1">
                                <input type="text" id="postal-code" wire:model="zip" autocomplete="postal-code" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-[#D4AF37] focus:border-[#D4AF37] sm:text-sm">
                                @error('zip') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        
                         <div class="sm:col-span-2">
                            <label for="country" class="block text-sm font-medium text-gray-700">{{ __('Country') }}</label>
                            <div class="mt-1">
                                <select id="country" wire:model="country" autocomplete="country-name" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-[#D4AF37] focus:border-[#D4AF37] sm:text-sm">
                                    <option value="France">France</option>
                                    <option value="Belgium">Belgium</option>
                                    <option value="Germany">Germany</option>
                                    <option value="Switzerland">Switzerland</option>
                                    <option value="Other">Other</option>
                                </select>
                                @error('country') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mt-10 border-t border-gray-200 pt-10">
                        <h2 class="text-lg font-medium text-gray-900">{{ __('Payment') }}</h2>
                        <div class="mt-4">
                            <div class="relative flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="payment-stripe" name="paymentMethod" type="radio" wire:model="paymentMethod" value="stripe" class="focus:ring-[#D4AF37] h-4 w-4 text-[#D4AF37] border-gray-300">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="payment-stripe" class="font-medium text-gray-700">Stripe (Credit Card)</label>
                                </div>
                            </div>
                            <div class="relative flex items-start mt-4">
                                <div class="flex items-center h-5">
                                    <input id="payment-cod" name="paymentMethod" type="radio" wire:model="paymentMethod" value="cod" class="focus:ring-[#D4AF37] h-4 w-4 text-[#D4AF37] border-gray-300">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="payment-cod" class="font-medium text-gray-700">Cash on Delivery (Test)</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-10">
                        <button type="submit" class="w-full bg-[#3E2723] border border-transparent rounded-md shadow-sm py-3 px-4 text-base font-medium text-white hover:bg-[#2d1c19] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#D4AF37] focus:ring-offset-gray-50">
                            {{ __('Place Order') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
