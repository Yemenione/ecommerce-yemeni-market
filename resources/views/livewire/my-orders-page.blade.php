<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
  <div class="flex flex-col">
    <div class="-m-1.5 overflow-x-auto">
      <div class="p-1.5 min-w-full inline-block align-middle">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">{{ __('My Orders') }}</h1>
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden dark:bg-slate-900 dark:border-gray-700">
          <!-- Header -->
          <div class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-b border-gray-200 dark:border-gray-700">
            <div>
              <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                {{ __('Order History') }}
              </h2>
              <p class="text-sm text-gray-600 dark:text-gray-400">
                {{ __('View details of your past orders.') }}
              </p>
            </div>
          </div>
          <!-- End Header -->

          <!-- Table -->
          <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-slate-800">
              <tr>
                <th scope="col" class="ps-6 py-3 text-start">
                  <div class="flex items-center gap-x-2">
                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                      {{ __('Order ID') }}
                    </span>
                  </div>
                </th>

                <th scope="col" class="px-6 py-3 text-start">
                  <div class="flex items-center gap-x-2">
                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                      {{ __('Date') }}
                    </span>
                  </div>
                </th>

                <th scope="col" class="px-6 py-3 text-start">
                  <div class="flex items-center gap-x-2">
                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                      {{ __('Status') }}
                    </span>
                  </div>
                </th>

                <th scope="col" class="px-6 py-3 text-start">
                  <div class="flex items-center gap-x-2">
                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                      {{ __('Total') }}
                    </span>
                  </div>
                </th>

                <th scope="col" class="px-6 py-3 text-end"></th>
              </tr>
            </thead>

            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
              @forelse($orders as $order)
              <tr>
                <td class="h-px w-px whitespace-nowrap">
                  <div class="ps-6 py-3">
                    <span class="block text-sm font-semibold text-gray-800 dark:text-gray-200">#{{ $order->id }}</span>
                  </div>
                </td>
                <td class="h-px w-px whitespace-nowrap">
                  <div class="px-6 py-3">
                    <span class="block text-sm text-gray-500 dark:text-gray-400">{{ $order->created_at->format('d M Y') }}</span>
                  </div>
                </td>
                <td class="h-px w-px whitespace-nowrap">
                  <div class="px-6 py-3">
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
                    <span class="inline-flex items-center gap-1.5 py-0.5 px-2 rounded-full text-xs font-medium {{ $statusClass }}">
                      {{ $statusLabel }}
                    </span>
                  </div>
                </td>
                <td class="h-px w-px whitespace-nowrap">
                  <div class="px-6 py-3">
                    <span class="block text-sm font-semibold text-gray-800 dark:text-gray-200">€{{ number_format($order->total_eur, 2) }}</span>
                  </div>
                </td>
                <td class="h-px w-px whitespace-nowrap">
                  <div class="px-6 py-1.5">
                    <a class="inline-flex items-center gap-x-1 text-sm text-[#D4AF37] decoration-2 hover:underline font-medium" href="{{ route('orders.invoice', $order) }}">
                      {{ __('Invoice') }}
                    </a>
                  </div>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                  {{ __('No orders found.') }}
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
          <!-- End Table -->

          <!-- Footer -->
          <div class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-t border-gray-200 dark:border-gray-700">
            {{ $orders->links() }}
          </div>
          <!-- End Footer -->
        </div>
      </div>
    </div>
  </div>
</div>
