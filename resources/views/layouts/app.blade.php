<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Kitelay') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            /* 1. Paksa semua teks menjadi putih terang */
            body, h1, h2, h3, h4, h5, h6, p, span, div, a, li, td, th {
                color: #ffffff !important;
            }

            /* 2. Scrollbar Gaming */
            ::-webkit-scrollbar {
                width: 8px;
                height: 8px;
            }
            ::-webkit-scrollbar-track {
                background: #050505;
                border-left: 1px solid #171717;
            }
            ::-webkit-scrollbar-thumb {
                background: #7f1d1d;
                border-radius: 4px;
            }
            ::-webkit-scrollbar-thumb:hover {
                background: #dc2626;
            }

            *:focus {
                outline: none !important;
            }

            ::selection {
                background: #fbbf24;
                color: #000;
            }
        </style>
    </head>
    
    <body class="font-sans antialiased bg-black text-white">
        
        <div class="min-h-screen bg-black flex flex-col relative">
            
            @include('layouts.navigation')

            @isset($header)
                <header class="bg-black border-b border-red-900/50 relative z-20 shadow-[0_10px_30px_rgba(0,0,0,0.8)]">
                    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main class="flex-grow relative z-10">
                {{ $slot }}
            </main>

        </div>
    </body>
</html>