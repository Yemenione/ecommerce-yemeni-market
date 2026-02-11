<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocaleDirection() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Yemen Souq Europe' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gray-50 text-gray-900 font-sans antialiased">
    <livewire:navbar />

    <main>
        {{ $slot }}
    </main>

    <footer class="bg-white border-t border-gray-200 mt-12 py-8">
        <div class="container mx-auto px-4 text-center text-gray-600">
            &copy; {{ date('Y') }} Yemen Souq Europe. All rights reserved.
        </div>
    </footer>

    @livewireScripts
</body>
</html>
