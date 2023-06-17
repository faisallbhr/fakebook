<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="shortcut icon" href="{{ asset('assets/logo.svg') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased h-screen">
        <div class="h-[75%] flex flex-col sm:justify-center items-center bg-[#f0f2f5]">
            <div>
                {{ $slot }}
            </div>
        </div>
        <div class="max-w-6xl mx-auto text-gray-500 text-sm py-10">
            <div>
                <ul class="flex gap-3 py-2 border-b border-gray-400">
                    <li class="font-bold">English (UK)</li>
                    <li>Bahasa Indonesia</li>
                    <li> Basa Jawa</li>
                    <li>Bahasa Melayu</li>
                    <li>日本語</li>
                    <li>العربية</li>
                    <li>Français (France)</li>
                    <li>Español</li>
                    <li></li>
                    <li>한국어</li>
                    <li>Português (Brasil)</li>
                    <li>Deutsch</li>
                </ul>
            </div>
            <div>
                <ul class="flex flex-wrap whitespace-nowrap gap-x-4 py-2">
                    <li>Sign Up</li>
                    <li>Log in</li>
                    <li>Messenger</li>
                    <li>Facebook Lite</li>
                    <li>Watch</li>
                    <li>Places</li>
                    <li>Games</li>
                    <li>Marketplace</li>
                    <li>Meta Pay</li>
                    <li>Meta Store</li>
                    <li>Meta Quest</li>
                    <li>Instagram</li>
                    <li>Fundraisers</li>
                    <li>Services</li>
                    <li>Voting Information Center</li>
                    <li>Privacy Policy</li>
                    <li>Privacy Center</li>
                    <li>Groups</li>
                    <li>About</li>
                    <li>Create at</li>
                    <li>Create Page</li>
                    <li>Developers</li>
                    <li>Careers</li>
                    <li>Cookies</li>
                    <li>Ad Choices</li>
                    <li>Terms</li>
                    <li>Help</li>
                    <li>Contact uploading non-users</li>
                </ul>
            </div>
            <div>
                <p class="font-bold">Meta © 2023</p>
            </div>
        </div>
        {{-- FlowBite --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
    </body>
</html>
