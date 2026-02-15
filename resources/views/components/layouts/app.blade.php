
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocaleDirection() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? $settings->site_name }}</title>
    @if($settings->logo)
        <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . $settings->logo) }}">
    @endif
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @stack('head')
</head>
<body class="bg-gray-50 text-gray-900 font-sans antialiased">
    <livewire:navbar />

    <main x-data 
          x-init="() => { $el.classList.add('opacity-100'); $el.classList.remove('opacity-0') }" 
          class="opacity-0 transition-opacity duration-1000 ease-in-out">
        {{ $slot }}
    </main>

    <footer class="bg-[#1A1A1A] text-white border-t border-gray-800 mt-0 pt-16 pb-8">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
                <!-- Brand -->
                <div class="space-y-6">
                    <a href="{{ route('home') }}" class="block">
                        @if($settings->logo)
                            <img src="{{ asset('storage/' . $settings->logo) }}" alt="{{ $settings->site_name }}" class="h-12 w-auto object-contain brightness-0 invert opacity-90 hover:opacity-100 transition-opacity">
                        @else
                            <h3 class="text-2xl font-serif text-[#D4AF37]">{{ $settings->site_name }}</h3>
                        @endif
                    </a>
                    <p class="text-gray-400 text-sm leading-relaxed max-w-xs">
                        {{ $settings->tagline ?? __('Authentic Yemeni products delivered directly to your doorstep in Europe.') }}
                    </p>
                    @if($settings->whatsapp_number)
                        <div class="mt-6">
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings->whatsapp_number) }}" target="_blank" class="inline-flex items-center gap-2 text-[#D4AF37] hover:text-white transition-colors duration-300">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                                <span>{{ __('Contact us on WhatsApp') }}</span>
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="font-bold mb-4 uppercase tracking-[0.2em] text-xs">{{ __('Shop') }}</h4>
                    <ul class="space-y-3 text-gray-400 text-sm">
                        <li><a href="{{ route('shop') }}" class="hover:text-[#D4AF37] transition-colors duration-300">{{ __('All Products') }}</a></li>
                        <li><a href="{{ route('shop') }}?sort=latest" class="hover:text-[#D4AF37] transition-colors duration-300">{{ __('New Arrivals') }}</a></li>
                        <li><a href="{{ route('shop') }}?sort=price_high" class="hover:text-[#D4AF37] transition-colors duration-300">{{ __('The Masterpieces') }}</a></li>
                    </ul>
                </div>

                <!-- Legal -->
                <div>
                    <h4 class="font-bold mb-4 uppercase tracking-wider">{{ __('Legal') }}</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li><a href="{{ route('terms') }}" class="hover:text-[#D4AF37] transition">{{ __('Terms of Service') }}</a></li>
                        <li><a href="{{ route('privacy') }}" class="hover:text-[#D4AF37] transition">{{ __('Privacy Policy') }}</a></li>
                        <li><a href="{{ route('shipping') }}" class="hover:text-[#D4AF37] transition">{{ __('Shipping Policy') }}</a></li>
                    </ul>
                </div>

                <!-- Social & Newsletter -->
                <div>
                    <h4 class="font-bold mb-4 uppercase tracking-wider">{{ __('Stay Connected') }}</h4>
                    <div class="flex space-x-4 mb-6">
                        @foreach($settings->social_media_links ?? [] as $link)
                            <a href="{{ $link['url'] }}" target="_blank" class="text-gray-400 hover:text-[#D4AF37] transition-colors duration-300">
                                @switch($link['platform'])
                                    @case('facebook')
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                        @break
                                    @case('instagram')
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.132 5.775.072 7.053.012 8.333 0 8.74 0 12s.012 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.012 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.066.935 20.395.33 19.61.03a7.39 7.39 0 0 0-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07s-3.585-.015-4.85-.074c-1.17-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z"/></svg>
                                        @break
                                    @case('twitter')
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                                        @break
                                    @case('tiktok')
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.01.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.9-.32-1.98-.23-2.81.33-.85.51-1.44 1.41-1.58 2.39-.14.98.05 1.91.74 2.61.44.48 1.03.81 1.66.92 1.26.27 2.7-.1 3.51-1.09.43-.51.68-1.12.72-1.78.03-3.69-.01-7.38-.01-11.07Z"/></svg>
                                        @break
                                @endswitch
                            </a>
                        @endforeach
                    </div>
                    
                    <livewire:newsletter-footer />
                </div>
            </div>

            <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="text-gray-500 text-xs">
                    &copy; {{ date('Y') }} {{ $settings->site_name }}. {{ __('All rights reserved.') }}
                </div>
                <div class="flex items-center space-x-6 opacity-60 grayscale hover:grayscale-0 transition-all duration-700">
                    <svg class="h-8 w-12" viewBox="0 0 48 48"><path fill="#ff9800" d="M32 10A14 14 0 1 0 32 38A14 14 0 1 0 32 10Z"/><path fill="#d50000" d="M16 10A14 14 0 1 0 16 38A14 14 0 1 0 16 10Z"/><path fill="#ff3d00" d="M18 24c0 4.4 2.1 8.4 5.5 10.8 3.4-2.4 5.5-6.4 5.5-10.8s-2.1-8.4-5.5-10.8C20.1 15.6 18 19.6 18 24z"/></svg>
                    <svg class="h-8 w-12" viewBox="0 0 48 48"><path fill="#1565C0" d="M41,36H7a4,4,0,0,1-4-4V16a4,4,0,0,1,4-4H41a4,4,0,0,1,4,4V32A4,4,0,0,1,41,36Z"/><path fill="#FFF" d="M19.1,28.1,16.6,18H14.1l-3.2,8.6L9.6,18H7l3.8,10.1h2.5L16.5,20l2.5,8.1Z"/><path fill="#FFF" d="M22.5,18h-2.4l3.1,10.1h2.4Z"/><path fill="#FFF" d="M30.4,18h-2.4l-3.1,10.1h2.4Z"/><path fill="#FFF" d="M38.8,18H36.3L33.1,26.6,31.8,18H29.2l3.8,10.1h2.5L38.7,20l2.5,8.1Z"/></svg>
                    <svg class="h-8 w-12" viewBox="0 0 48 48"><path fill="#29B6F6" d="M43,36H5c-2.2,0-4-1.8-4-4V16c0-2.2,1.8-4,4-4h38c2.2,0,4,1.8,4,4v16C47,34.2,45.2,36,43,36z"/><path fill="#FFF" d="M24,20c-2.2,0-4,1.8-4,4s1.8,4,4,4c2.2,0,4-1.8,4-4S26.2,20,24,20z"/><path fill="#1565C0" d="M32,24c0,4.4-3.6,8-8,8s-8-3.6-8-8s3.6-8,8-8S32,19.6,32,24z"/></svg>
                </div>
            </div>
        </div>
    </footer>

    <div 
        x-data="{ 
            notifications: [],
            add(message) {
                this.notifications.push({
                    id: Date.now(),
                    message: message,
                    show: true
                });
            },
            remove(id) {
                const index = this.notifications.findIndex(n => n.id === id);
                if (index > -1) {
                    this.notifications[index].show = false;
                    setTimeout(() => {
                        this.notifications = this.notifications.filter(n => n.id !== id);
                    }, 300);
                }
            }
        }"
        @notify.window="add($event.detail.message)"
        class="fixed bottom-4 right-4 z-50 flex flex-col gap-2"
    >
        <template x-for="notification in notifications" :key="notification.id">
            <div 
                x-show="notification.show"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-2"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 translate-y-2"
                x-init="setTimeout(() => remove(notification.id), 3000)"
                class="bg-black text-white px-6 py-3 rounded shadow-lg flex items-center gap-3 border border-[#D4AF37]"
            >
                <span class="text-[#D4AF37]">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </span>
                <span x-text="notification.message" class="font-medium"></span>
            </div>
        </template>
    </div>

    <livewire:quick-view />
    @livewireScripts
</body>
</html>
