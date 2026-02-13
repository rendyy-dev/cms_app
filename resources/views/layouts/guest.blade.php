<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'RenCMS') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-black text-gray-100 min-h-screen flex items-center justify-center">

    <!-- BACKGROUND PARTICLES -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        @for ($i = 0; $i < 40; $i++)
            <span
                class="absolute w-[2px] h-[2px] rounded-full bg-emerald-400/80"
                style="
                    left: {{ rand(0,100) }}%;
                    top: -10px;
                    animation: fall {{ rand(10,18) }}s linear infinite;
                    animation-delay: -{{ rand(0,18) }}s;
                "
            ></span>
        @endfor
    </div>

    <!-- CARD -->
    <div class="relative z-10 w-full max-w-md px-6">
        <div class="mb-8 text-center">
            <a href="/" class="inline-block text-2xl font-bold tracking-wide">
                Ren<span class="text-emerald-400">CMS</span>
            </a>
            <p class="text-gray-400 text-sm mt-2">
                Platform CMS modern & sederhana
            </p>
        </div>

        <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-2xl p-8 shadow-xl">
            {{ $slot }}
        </div>

        <p class="text-center text-xs text-gray-500 mt-6">
            © {{ date('Y') }} RenCMS
        </p>
    </div>

</body>
</html>
