<div class="bg-gray-50 min-h-screen py-12">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-extrabold text-[#3E2723] font-serif mb-8 text-center">{{ __('Your Cart') }}</h1>

        @if($this->cartItems->count() > 0)
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <ul role="list" class="divide-y divide-gray-200">
                    @foreach($this->cartItems as $item)
                        <li class="p-4 flex items-center justify-between sm:px-6">
                            <div class="flex items-center flex-1">
                                <div class="flex-shrink-0 h-16 w-16 bg-gray-100 rounded-md overflow-hidden">
                                    @if($item->images && count($item->images) > 0)
                                        <img src="{{ asset('storage/' . $item->images[0]) }}" alt="{{ $item->name }}" class="h-full w-full object-cover">
                                    @else
                                        <div class="h-full w-full flex items-center justify-center text-gray-400 text-xs">{{ __('No Img') }}</div>
                                    @endif
                                </div>
                                <div class="ml-4 flex-1">
                                    <h3 class="text-sm font-medium text-gray-900">{{ $item->name }}</h3>
                                    <p class="text-sm text-gray-500">{{ number_format($item->price_eur, 2) }} €</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center space-x-4">
                                <div class="flex items-center border border-gray-300 rounded">
                                    <button wire:click="decrement({{ $item->id }})" class="px-2 py-1 text-gray-600 hover:bg-gray-100">-</button>
                                    <span class="px-2 text-sm text-gray-700">{{ $item->quantity }}</span>
                                    <button wire:click="increment({{ $item->id }})" class="px-2 py-1 text-gray-600 hover:bg-gray-100">+</button>
                                </div>
                                <div class="text-sm font-medium text-gray-900 w-20 text-right">
                                    {{ number_format($item->subtotal, 2) }} €
                                </div>
                                <button wire:click="remove({{ $item->id }})" class="text-red-500 hover:text-red-700">
                                    <span class="sr-only">{{ __('Remove') }}</span>
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <div class="bg-gray-50 px-4 py-4 sm:px-6 flex justify-between items-center">
                    <div class="text-lg font-bold text-[#3E2723]">
                        {{ __('Total') }}: {{ number_format($this->total, 2) }} €
                    </div>
                    <a href="{{ route('checkout') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-[#3E2723] bg-[#D4AF37] hover:bg-[#B38F2D]">
                        {{ __('Proceed to Checkout') }}
                    </a>
                </div>
            </div>
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">{{ __('Cart is empty') }}</h3>
                <p class="mt-1 text-sm text-gray-500">{{ __('Start shopping to add items to your cart.') }}</p>
                <div class="mt-6">
                    <a href="{{ route('shop') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-[#3E2723] hover:bg-gray-800">
                        {{ __('Go to Shop') }}
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
