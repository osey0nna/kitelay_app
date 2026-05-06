<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @php
            $pageTitle = match (true) {
                request()->routeIs('login') => 'Login',
                request()->routeIs('register') => 'Register',
                request()->routeIs('password.request') => 'Lupa Password',
                request()->routeIs('password.reset') => 'Reset Password',
                request()->routeIs('password.confirm') => 'Konfirmasi Password',
                request()->routeIs('verification.notice') => 'Verifikasi Email',
                default => 'Autentikasi',
            };
        @endphp

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Kitelay') }} - {{ $pageTitle }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,900&display=swap" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="min-h-screen overflow-x-hidden bg-black font-sans text-slate-300 antialiased selection:bg-amber-400 selection:text-black">
        <div class="pointer-events-none absolute inset-0 overflow-hidden">
            <div class="absolute -left-24 top-[-4rem] h-72 w-72 rounded-full bg-red-700/20 blur-3xl"></div>
            <div class="absolute right-[-5rem] top-[12%] h-80 w-80 rounded-full bg-amber-500/10 blur-[110px]"></div>
            <div class="absolute bottom-[-8rem] left-1/2 h-96 w-96 -translate-x-1/2 rounded-full bg-red-600/10 blur-[140px]"></div>
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,rgba(255,255,255,0.05),transparent_30%),linear-gradient(to_bottom,rgba(255,255,255,0.03),transparent_18%)]"></div>
            <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-red-500/50 to-transparent"></div>
        </div>

        <main class="relative z-10 flex min-h-screen w-full items-start justify-center px-4 py-8 sm:items-center sm:px-6 sm:py-10 lg:px-8">
            <div class="w-full max-w-[29rem] [perspective:1800px]">
                <div
                    id="tilt-card"
                    class="relative overflow-hidden rounded-[30px] border border-red-900/40 bg-gradient-to-br from-[#121214] via-[#0b0b0e] to-black p-6 shadow-[0_24px_80px_rgba(0,0,0,0.55)] ring-1 ring-white/5 transition-[transform,box-shadow,border-color] duration-300 ease-out will-change-transform [transform-style:preserve-3d] sm:p-8"
                    style="--glow-x: 50%; --glow-y: 22%; --card-shine: 0.72;"
                >
                    <div
                        class="pointer-events-none absolute inset-0 opacity-90"
                        style="background: radial-gradient(circle at var(--glow-x) var(--glow-y), rgba(251, 191, 36, 0.18), transparent 34%), radial-gradient(circle at 85% 15%, rgba(220, 38, 38, 0.18), transparent 30%), linear-gradient(180deg, rgba(255,255,255,calc(var(--card-shine) * 0.06)), rgba(255,255,255,0));"
                    ></div>
                    <div
                        class="pointer-events-none absolute inset-[1px] rounded-[29px] border border-white/5 opacity-70"
                        style="transform: translateZ(18px);"
                    ></div>
                    <div
                        class="pointer-events-none absolute inset-x-[12%] top-0 h-24 rounded-b-[999px] bg-gradient-to-b from-white/15 via-white/5 to-transparent blur-2xl"
                        style="transform: translateZ(34px);"
                    ></div>
                    <div
                        class="pointer-events-none absolute inset-x-6 bottom-[-3.5rem] h-20 rounded-[999px] bg-red-950/40 blur-3xl"
                        style="transform: translateZ(-42px) scale(0.92);"
                    ></div>
                    <div class="pointer-events-none absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-amber-300/80 to-transparent"></div>
                    <div class="pointer-events-none absolute left-5 top-5 h-14 w-14 rounded-full border border-white/5" style="transform: translateZ(22px);"></div>
                    <div class="pointer-events-none absolute bottom-5 right-5 h-24 w-24 rounded-full border border-white/5" style="transform: translateZ(18px);"></div>

                    <div class="relative mb-8 flex items-center justify-between gap-4 [transform-style:preserve-3d]">
                        <a href="{{ url('/') }}" class="group flex items-center gap-3" data-tilt-layer data-tilt-depth="36">
                            <div class="relative flex h-12 w-12 items-center justify-center rounded-2xl border border-red-500/20 bg-gradient-to-br from-red-600 to-red-900 shadow-[0_0_20px_rgba(220,38,38,0.25)] transition-transform duration-300 group-hover:scale-105">
                                <img
                                    src="{{ asset('assets/logos/logo_kite_transp.png') }}"
                                    alt="Logo Kitelay"
                                    class="h-8 w-8 object-contain brightness-0 invert"
                                >
                            </div>
                            <div>
                                <p class="text-[10px] font-black uppercase tracking-[0.35em] text-slate-500">Portal</p>
                                <p class="text-lg font-black uppercase tracking-[0.2em] text-white">Kitelay</p>
                            </div>
                        </a>
                    </div>

                    <div class="relative z-10">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </main>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const card = document.getElementById('tilt-card');
                const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
                const supportsFinePointer = window.matchMedia('(pointer: fine)').matches;

                if (!card) {
                    return;
                }

                const layers = card.querySelectorAll('[data-tilt-layer]');

                let frameId = null;

                const resetCard = () => {
                    card.style.transform = 'perspective(1100px) rotateX(0deg) rotateY(0deg) translateY(0)';
                    card.style.boxShadow = '0 24px 80px rgba(0, 0, 0, 0.55)';
                    card.style.borderColor = 'rgba(127, 29, 29, 0.4)';
                    card.style.setProperty('--glow-x', '50%');
                    card.style.setProperty('--glow-y', '22%');
                    card.style.setProperty('--card-shine', '0.72');

                    layers.forEach((layer) => {
                        const depth = Number(layer.dataset.tiltDepth || 18);
                        layer.style.transform = `translate3d(0, 0, ${depth}px)`;
                    });
                };

                resetCard();

                if (prefersReducedMotion || !supportsFinePointer) {
                    return;
                }

                const updateCard = (clientX, clientY) => {
                    const rect = card.getBoundingClientRect();
                    const x = clientX - rect.left;
                    const y = clientY - rect.top;
                    const centerX = rect.width / 2;
                    const centerY = rect.height / 2;

                    const rotateX = ((y - centerY) / centerY) * -5;
                    const rotateY = ((x - centerX) / centerX) * 5;
                    const glowX = `${Math.max(0, Math.min(100, (x / rect.width) * 100))}%`;
                    const glowY = `${Math.max(0, Math.min(100, (y / rect.height) * 100))}%`;
                    const offsetX = ((x - centerX) / centerX) * 8;
                    const offsetY = ((y - centerY) / centerY) * 8;

                    card.style.transform = `perspective(1100px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateY(-2px)`;
                    card.style.boxShadow = '0 28px 90px rgba(0, 0, 0, 0.6), 0 0 24px rgba(251, 191, 36, 0.12)';
                    card.style.borderColor = 'rgba(251, 191, 36, 0.28)';
                    card.style.setProperty('--glow-x', glowX);
                    card.style.setProperty('--glow-y', glowY);
                    card.style.setProperty('--card-shine', '1');

                    layers.forEach((layer) => {
                        const depth = Number(layer.dataset.tiltDepth || 18);
                        const moveX = (offsetX * depth) / 50;
                        const moveY = (offsetY * depth) / 50;

                        layer.style.transform = `translate3d(${moveX}px, ${moveY}px, ${depth}px)`;
                    });
                };

                card.addEventListener('pointerenter', () => {
                    card.style.transitionDuration = '160ms';
                });

                card.addEventListener('pointermove', (event) => {
                    const { clientX, clientY } = event;

                    if (frameId) {
                        cancelAnimationFrame(frameId);
                    }

                    frameId = requestAnimationFrame(() => updateCard(clientX, clientY));
                });

                card.addEventListener('pointerleave', () => {
                    if (frameId) {
                        cancelAnimationFrame(frameId);
                        frameId = null;
                    }

                    card.style.transitionDuration = '420ms';
                    resetCard();
                });
            });
        </script>
    </body>
</html>
