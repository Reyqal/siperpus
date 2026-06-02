<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Perpustakaan Digital')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.1/src/regular/style.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.1/src/fill/style.css"/>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Poppins', sans-serif; }
        .font-display { font-family: 'Poppins', sans-serif; }

        :root {
            --ink:     #0f0f0f;
            --paper:   #faf8f4;
            --cream:   #f2ede4;
            --gold:    #b8860b;
            --gold-lt: #d4a41f;
            --muted:   #6b6457;
            --border:  #e0d9cf;
            --red:     #c0392b;
        }

        body { background-color: var(--paper); color: var(--ink); }

        /* Flash message animation */
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-8px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .flash-msg { animation: slideDown 0.3s ease; }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: var(--cream); }
        ::-webkit-scrollbar-thumb { background: var(--gold); border-radius: 3px; }
    </style>
</head>
<body class="min-h-screen flex flex-col" style="background-color:#faf8f4; color:#0f0f0f;">

    <x-navbar />

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="flash-msg mx-6 mt-4 px-5 py-3 rounded-lg flex items-center justify-between text-sm font-medium"
             style="background:#f0fdf0; border:1px solid #86efac; color:#166534;">
            <span class="flex items-center gap-2">
                <i class="ph-fill ph-check-circle text-lg"></i>
                {{ session('success') }}
            </span>
            <button onclick="this.parentElement.remove()" class="ml-4 opacity-60 hover:opacity-100 transition">
                <i class="ph ph-x"></i>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="flash-msg mx-6 mt-4 px-5 py-3 rounded-lg flex items-center justify-between text-sm font-medium"
             style="background:#fef2f2; border:1px solid #fca5a5; color:#991b1b;">
            <span class="flex items-center gap-2">
                <i class="ph-fill ph-warning-circle text-lg"></i>
                {{ session('error') }}
            </span>
            <button onclick="this.parentElement.remove()" class="ml-4 opacity-60 hover:opacity-100 transition">
                <i class="ph ph-x"></i>
            </button>
        </div>
    @endif

    <main class="flex-1 container mx-auto px-4 py-10 max-w-7xl">
        @yield('content')
    </main>

    <x-footer />
@stack('scripts')
</body>
</html>