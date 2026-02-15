<x-layouts.app>
    <div class="bg-white py-12">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl mx-auto">
                <h1 class="text-3xl font-serif font-bold text-[#3E2723] mb-6 text-center">{{ __('Contact Us') }}</h1>
                 <p class="text-lg text-gray-600 mb-8 text-center">
                    {{ __('Have a question or need assistance? We are here to help!') }}
                </p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-10">
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-xl font-bold text-[#3E2723] mb-4">{{ __('Get in Touch') }}</h3>
                        <div class="space-y-4 text-gray-600">
                            <p><strong>{{ __('Email') }}:</strong> support@yemensouqeurope.com</p>
                            <p><strong>{{ __('Phone') }}:</strong> +33 1 23 45 67 89</p>
                            <p><strong>{{ __('Address') }}:</strong> 123 Avenue des Champs-Élysées, Paris, France</p>
                        </div>
                    </div>
                     <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-xl font-bold text-[#3E2723] mb-4">{{ __('Business Hours') }}</h3>
                        <div class="space-y-4 text-gray-600">
                            <p>{{ __('Monday - Friday') }}: 9:00 AM - 6:00 PM</p>
                            <p>{{ __('Saturday') }}: 10:00 AM - 4:00 PM</p>
                            <p>{{ __('Sunday') }}: {{ __('Closed') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
