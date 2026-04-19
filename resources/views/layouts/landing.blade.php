<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>KITELAY | @yield('title', 'Platform Pendaftaran Lomba Modern')</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
      html { scroll-behavior: smooth; scroll-padding-top: 2.75rem; }
      section[id] { scroll-margin-top: 2.75rem; }
      [x-cloak] { display: none !important; }
      .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
      .glass-card { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); }
      .vibrant-gradient-bg { background: radial-gradient(circle at 10% 20%, rgba(0, 6, 102, 0.05) 0%, transparent 50%), radial-gradient(circle at 90% 80%, rgba(56, 11, 0, 0.05) 0%, transparent 50%); }
      .hero-glow { filter: drop-shadow(0 0 20px rgba(0, 6, 102, 0.3)); }
      body { min-height: max(884px, 100dvh); }
    </style>
</head>
<body class="bg-surface font-body text-on-surface selection:bg-primary-fixed-dim selection:text-primary">

    <x-navbar />
    <x-flash-toast />

    <main>
        @yield('content')
    </main>

    <x-footer />

</body>
</html>