<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            [x-cloak] { display: none !important; }
        </style>
    </head>
    <body class="bg-slate-50 font-sans antialiased text-slate-900">
        <div class="min-h-screen bg-[radial-gradient(circle_at_top_left,_rgba(14,165,233,0.08),_transparent_25%),radial-gradient(circle_at_bottom_right,_rgba(249,115,22,0.08),_transparent_25%),linear-gradient(180deg,_#f8fafc_0%,_#f8fafc_100%)]">
            @include('layouts.navigation')
            <x-flash-toast />

            <!-- Page Heading -->
            @isset($header)
                <header class="relative z-0 border-b border-slate-200 bg-white/80 backdrop-blur">
                    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="relative z-0">
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
