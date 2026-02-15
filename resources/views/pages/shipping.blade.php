<x-layouts.app>
    <div class="bg-white py-12">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto prose dark:prose-invert">
                <h1 class="text-3xl font-serif font-bold text-[#3E2723] mb-6">{{ __('Shipping & Returns') }}</h1>
                
                <h3>{{ __('Shipping Policy') }}</h3>
                <p>{{ __('We ship to most countries in Europe. Shipping costs are calculated at checkout based on your location and the weight of your order.') }}</p>
                <ul>
                    <li>{{ __('France: 2-3 business days') }}</li>
                    <li>{{ __('Germany, Benelux: 3-5 business days') }}</li>
                    <li>{{ __('Rest of Europe: 5-7 business days') }}</li>
                </ul>

                <h3>{{ __('Return Policy') }}</h3>
                <p>{{ __('We accept returns within 14 days of delivery. To be eligible for a return, your item must be unused, in the original packaging, and in the same condition that you received it.') }}</p>
                <p>{{ __('To initiate a return, please contact our support team.') }}</p>
            </div>
        </div>
    </div>
</x-layouts.app>
