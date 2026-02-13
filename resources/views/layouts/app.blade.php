<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>RenCMS Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-black text-gray-100 antialiased">

<!-- NAVBAR -->
<nav class="fixed top-0 left-0 right-0 z-50 bg-black/80 backdrop-blur border-b border-white/10">
    <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">
        <div class="font-bold text-lg">
            Ren<span class="text-emerald-400">CMS</span>
        </div>

        <div class="hidden md:flex gap-6 text-sm text-gray-300 items-center">
            <a href="{{ route('dashboard') }}" class="hover:text-white">Dashboard</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="hover:text-white">Logout</button>
            </form>
        </div>
    </div>
</nav>

<!-- MAIN CONTENT -->
<main class="pt-20">
    @yield('content')
</main>

<footer class="border-t border-white/10 py-10 text-center text-sm text-gray-500">
    © {{ date('Y') }} RenCMS. Seluruh hak cipta dilindungi.
</footer>

</body>
</html>
