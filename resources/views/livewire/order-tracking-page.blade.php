<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
  <div class="max-w-2xl mx-auto text-center mb-10">
    <h1 class="text-3xl font-bold text-gray-800 dark:text-white sm:text-4xl">
      {{ __('Track Your Order') }}
    </h1>
    <p class="mt-1 text-gray-600 dark:text-gray-400">
      {{ __('Enter your Order ID and Email to check the status of your order.') }}
    </p>
  </div>

  <div class="max-w-xl mx-auto bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-slate-900 dark:border-gray-700">
    <div class="p-4 sm:p-7">
      <form wire:submit.prevent="trackOrder">
        <div class="grid gap-y-4">
          <!-- Order ID -->
          <div>
            <label for="order_id" class="block text-sm mb-2 dark:text-white">{{ __('Order ID') }}</label>
            <div class="relative">
              <input type="text" id="order_id" wire:model="order_id" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" required aria-describedby="order-id-error">
              @error('order_id')
              <div class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-3">
                <svg class="h-5 w-5 text-red-500" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                  <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
                </svg>
              </div>
              @enderror
            </div>
            @error('order_id')
            <p class="text-xs text-red-600 mt-2" id="order-id-error">{{ $message }}</p>
            @enderror
          </div>

          <!-- Email -->
          <div>
            <label for="email" class="block text-sm mb-2 dark:text-white">{{ __('Email Address') }}</label>
            <div class="relative">
              <input type="email" id="email" wire:model="email" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" required aria-describedby="email-error">
              @error('email')
              <div class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-3">
                <svg class="h-5 w-5 text-red-500" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                  <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
                </svg>
              </div>
              @enderror
            </div>
            @error('email')
            <p class="text-xs text-red-600 mt-2" id="email-error">{{ $message }}</p>
            @enderror
          </div>

          <button type="submit" class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
            <span wire:loading.remove wire:target="trackOrder">{{ __('Track Order') }}</span>
            <span wire:loading wire:target="trackOrder">{{ __('Tracking...') }}</span>
          </button>
        </div>
      </form>

      @if($errorMessage)
      <div class="mt-5 bg-red-100 border border-red-200 text-sm text-red-800 rounded-lg p-4 dark:bg-red-800/10 dark:border-red-900 dark:text-red-500" role="alert">
        {{ $errorMessage }}
      </div>
      @endif
    </div>
  </div>

  @if($order)
  <div class="mt-10 max-w-4xl mx-auto bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-slate-900 dark:border-gray-700">
    <div class="p-4 sm:p-7">
      <div class="flex justify-between items-center mb-6">
        <div>
          <h2 class="text-xl font-bold text-gray-800 dark:text-white">
            {{ __('Order Details') }} #{{ $order->id }}
          </h2>
          <p class="text-sm text-gray-500 dark:text-gray-400">
            {{ __('Placed on') }} {{ $order->created_at->format('F j, Y') }}
          </p>
        </div>
        <div>
          @php
            $statusClass = match($order->status->value) {
                'new' => 'bg-blue-100 text-blue-800',
                'processing' => 'bg-yellow-100 text-yellow-800',
                'shipped' => 'bg-teal-100 text-teal-800',
                'delivered' => 'bg-green-100 text-green-800',
                'cancelled' => 'bg-red-100 text-red-800',
                default => 'bg-gray-100 text-gray-800',
            };
             $statusLabel = match($order->status->value) {
                'new' => __('New'),
                'processing' => __('Processing'),
                'shipped' => __('Shipped'),
                'delivered' => __('Delivered'),
                'cancelled' => __('Cancelled'),
                default => $order->status->value,
            };
          @endphp
          <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full text-xs font-medium {{ $statusClass }}">
            {{ $statusLabel }}
          </span>
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div>
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">{{ __('Shipping Address') }}</h3>
            <address class="text-sm text-gray-600 dark:text-gray-400 not-italic">
                {{ $order->shipping_address['first_name'] }} {{ $order->shipping_address['last_name'] }}<br>
                {{ $order->shipping_address['address'] }}<br>
                {{ $order->shipping_address['city'] }}, {{ $order->shipping_address['zip'] }}<br>
                {{ $order->shipping_address['country'] }}
            </address>
        </div>
        <div>
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">{{ __('Order Summary') }}</h3>
            <div class="flex justify-between text-sm mb-1">
                <span class="text-gray-600 dark:text-gray-400">{{ __('Subtotal') }}</span>
                <span class="font-medium text-gray-800 dark:text-white">{{ number_format($order->subtotal_eur ?? 0, 2) }} €</span>
            </div>
            <div class="flex justify-between text-sm mb-1">
                <span class="text-gray-600 dark:text-gray-400">{{ __('Shipping') }}</span>
                <span class="font-medium text-gray-800 dark:text-white">{{ number_format($order->shipping_cost ?? 0, 2) }} €</span>
            </div>
            <div class="flex justify-between text-base font-bold mt-2 pt-2 border-t border-gray-200 dark:border-gray-700">
                <span class="text-gray-800 dark:text-white">{{ __('Total') }}</span>
                <span class="text-green-600 dark:text-green-400">{{ number_format($order->total_eur ?? 0, 2) }} €</span>
            </div>
        </div>
      </div>

      <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">{{ __('Items') }}</h3>
      <div class="border rounded-lg overflow-hidden dark:border-gray-700">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-800">
                <tr>
                    <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">{{ __('Product') }}</th>
                    <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">{{ __('Price') }}</th>
                    <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">{{ __('Qty') }}</th>
                    <th scope="col" class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase">{{ __('Total') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($order->items as $item)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200">
                        {{ $item['name'] }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                        {{ number_format($item['price'], 2) }} €
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                        {{ $item['quantity'] }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-end font-medium text-gray-800 dark:text-gray-200">
                        {{ number_format($item['subtotal'], 2) }} €
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
      </div>
    </div>
  </div>
  @endif
</div>
