<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RenCMS Dashboard</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-black text-gray-100 antialiased scroll-smooth relative overflow-x-hidden">

@php
    $dashboardRoute = route('dashboard');

    if(auth()->check()) {
        $role = auth()->user()->role->name ?? null;

        switch ($role) {
            case 'super_admin':
                $dashboardRoute = route('super_admin.dashboard');
                break;
            case 'admin':
                $dashboardRoute = route('admin.dashboard');
                break;
            case 'editor':
                $dashboardRoute = route('editor.dashboard');
                break;
            case 'author':
                $dashboardRoute = route('author.dashboard');
                break;
            default:
                $dashboardRoute = route('dashboard');
                break;
        }
    }
@endphp


<!-- GLOBAL BACKGROUND GLOW -->
<div class="absolute inset-0 -z-10 bg-gradient-to-b from-emerald-500/5 via-transparent to-transparent pointer-events-none"></div>

<!-- OPTIONAL PARTICLES (biar konsisten seperti welcome) -->
<div class="particles absolute inset-0 -z-10">
    @for ($i = 0; $i < 30; $i++)
        <span
            class="particle"
            style="
                left: {{ rand(0,100) }}%;
                animation-duration: {{ rand(12,20) }}s;
                animation-delay: -{{ rand(0,20) }}s;
            "
        ></span>
    @endfor
</div>


<!-- NAVBAR -->
<nav class="fixed top-0 left-0 right-0 z-50 bg-black/80 backdrop-blur border-b border-white/10">
    <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">

        <div class="font-bold text-lg tracking-wide">
            Ren<span class="text-emerald-400">CMS</span>
        </div>

        <div class="hidden md:flex gap-6 text-sm text-gray-300 items-center">

            @auth
                <a href="{{ $dashboardRoute }}" class="hover:text-white transition">
                    Dashboard
                </a>

                <a href="{{ route('home') }}" class="hover:text-white transition">
                    Home
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="hover:text-white transition">
                        Logout
                    </button>
                </form>
            @endauth

        </div>
    </div>
</nav>


<!-- MAIN CONTENT -->
<main class="pt-20 relative z-10">
    @yield('content')
</main>


<!-- FOOTER -->
<footer class="border-t border-white/10 py-10 text-center text-sm text-gray-500 relative z-10">
    © {{ date('Y') }} RenCMS. Seluruh hak cipta dilindungi.
</footer>

</body>
</html>
