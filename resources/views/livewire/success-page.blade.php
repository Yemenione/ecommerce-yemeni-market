<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
  <div class="max-w-xl mx-auto">
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-gray-800 dark:border-gray-700">
      <div class="p-4 sm:p-7 text-center">
        <!-- Icon -->
        <div class="mb-5">
            <div class="flex items-center justify-center w-16 h-16 mx-auto bg-green-100 rounded-full dark:bg-green-900">
                <svg class="w-8 h-8 text-green-600 dark:text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
        </div>
        <!-- End Icon -->

        <h1 class="block text-2xl font-bold text-gray-800 dark:text-white">{{ __('Thank you for your order!') }}</h1>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
          {{ __('Your order has been placed successfully.') }}
        </p>
        <p class="mt-2 text-sm text-gray-800 font-semibold dark:text-gray-200">
            {{ __('Order ID') }}: #{{ $order->id }}
        </p>

        <div class="mt-5 flex justify-center gap-4">
            <a href="{{ route('orders.invoice', $order) }}" target="_blank" class="py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-white dark:hover:bg-gray-800 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                <svg class="flex-shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
                {{ __('Download Invoice') }}
            </a>
            @auth
            <a href="{{ route('my-orders') }}" class="py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-[#D4AF37] text-white hover:bg-[#b08d26] disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                {{ __('View My Orders') }}
            </a>
            @else
            <a href="{{ route('home') }}" class="py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-[#D4AF37] text-white hover:bg-[#b08d26] disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                {{ __('Continue Shopping') }}
            </a>
            @endauth
        </div>
      </div>
    </div>
  </div>
</div>
