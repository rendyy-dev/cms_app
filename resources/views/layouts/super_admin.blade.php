<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>RenCMS Super Admin</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <style> [x-cloak] { display: none !important; } </style>
</head>
<body class="bg-black text-gray-100 antialiased flex h-screen">

<!-- SIDEBAR -->
<aside class="w-80 bg-black/90 border-r border-white/10 flex flex-col">
    <!-- Logo -->
    <div class="px-6 py-6 font-bold text-lg border-b border-white/10 flex items-center justify-between">
        <span>Ren<span class="text-emerald-400">CMS</span></span>
    </div>

    <!-- NAVIGATION -->
    <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">

        <!-- Dashboard -->
        <a href="{{ route('super_admin.dashboard') }}"
           class="block px-4 py-3 rounded-lg transition flex items-center gap-3
           {{ request()->routeIs('super_admin.dashboard') ? 'bg-white/10' : 'hover:bg-white/10' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 12l2-2m0 0l7-7 7 7M13 5v6h6"/>
            </svg>
            Dashboard
        </a>

        <!-- Profile -->
        <a href="{{ route('super_admin.profile') }}"
           class="block px-4 py-3 rounded-lg transition flex items-center gap-3
           {{ request()->routeIs('super_admin.profile') ? 'bg-white/10' : 'hover:bg-white/10' }}">
            <svg xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5 text-emerald-400"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M5.121 17.804A9 9 0 1118.88 17.8M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            Profile
        </a>

        <!-- Users -->
        <a href="{{ route('super_admin.users') }}"
           class="block px-4 py-3 rounded-lg transition flex items-center gap-3
           {{ request()->routeIs('super_admin.users') ? 'bg-white/10' : 'hover:bg-white/10' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M17 20h5v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2h5"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 12a5 5 0 100-10 5 5 0 000 10z"/>
            </svg>
            Users
        </a>

        <!-- Roles -->
        <a href="{{ route('super_admin.roles.index') }}"
           class="block px-4 py-3 rounded-lg transition flex items-center gap-3
           {{ request()->routeIs('super_admin.roles.*') ? 'bg-white/10' : 'hover:bg-white/10' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2v-5H3v5a2 2 0 002 2z"/>
            </svg>
            Roles
        </a>

        <!-- Articles -->
        <a href="{{ route('articles.index') }}"
           class="block px-4 py-3 rounded-lg transition flex items-center gap-3
           {{ request()->routeIs('articles.*') ? 'bg-white/10' : 'hover:bg-white/10' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M7 7h10M7 11h10M7 15h6M5 3h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2z"/>
            </svg>
            Articles
        </a>

        <!-- Album -->
        <a href="{{ route('admin.albums.index') }}"
           class="block px-4 py-3 rounded-lg transition flex items-center gap-3
           {{ request()->routeIs('admin.albums.*') ? 'bg-white/10' : 'hover:bg-white/10' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 4a1 1 0 011-1h16a1 1 0 011 1v16a1 1 0 01-1 1H4a1 1 0 01-1-1V4z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 8h18M8 12l2 2 4-4"/>
            </svg>
            Album
        </a>

        <!-- Categories -->
        <a href="{{ route('admin.categories.index') }}"
           class="block px-4 py-3 rounded-lg transition flex items-center gap-3
           {{ request()->routeIs('admin.categories.*') ? 'bg-white/10' : 'hover:bg-white/10' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
            Categories
        </a>

        <!-- Galleries -->
        <a href="{{ route('admin.media.index') }}"
           class="block px-4 py-3 rounded-lg transition flex items-center gap-3
           {{ request()->routeIs('admin.media.*') ? 'bg-white/10' : 'hover:bg-white/10' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 3h18v18H3V3z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 9l6 6 4-4 6 6"/>
            </svg>
            Galleries
        </a>

        <!-- Ebook -->
        <a href="{{ route('admin.ebooks.index') }}"
        class="block px-4 py-3 rounded-lg transition flex items-center gap-3
        {{ request()->routeIs('admin.ebooks.*') ? 'bg-white/10' : 'hover:bg-white/10' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 20h9M3 4h18v16H3V4zM3 8h18"/>
            </svg>
            Ebook
        </a>


    </nav>

    <!-- FOOTER ACTION -->
    <div class="px-6 py-6 border-t border-white/10 space-y-3">

        <!-- Home -->
        <a href="{{ route('home') }}"
        class="w-full flex items-center justify-center px-4 py-2 rounded-lg 
                bg-white/5 hover:bg-white/10 
                text-white font-semibold transition">
            Home
        </a>

        <!-- Logout -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="w-full px-4 py-2 rounded-lg 
                        bg-emerald-500 text-black font-semibold 
                        hover:bg-emerald-400 transition">
                Logout
            </button>
        </form>
    </div>

</aside>

<!-- MAIN CONTENT -->
<main class="flex-1 overflow-y-auto p-8">
    @yield('content')
</main>

<script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>

<!-- GLOBAL CONFIRM MODAL -->
<div 
    x-data 
    x-show="$store.confirm.open"
    x-cloak
    class="fixed inset-0 z-50 flex items-center justify-center">

    <div class="absolute inset-0 bg-black/70 backdrop-blur-sm"
         @click="$store.confirm.close()"></div>

    <div 
        x-transition
        class="relative w-full max-w-md bg-black border border-white/10 rounded-2xl shadow-2xl p-6">

        <h2 class="text-lg font-semibold mb-3 text-white"
            x-text="$store.confirm.title"></h2>

        <p class="text-gray-400 text-sm mb-6"
           x-text="$store.confirm.message"></p>

        <div class="flex justify-end gap-3">
            <button
                @click="$store.confirm.close()"
                class="px-4 py-2 rounded-lg bg-white/10 hover:bg-white/20 transition">
                Batal
            </button>

            <button
                @click="$store.confirm.confirm()"
                class="px-4 py-2 rounded-lg bg-red-500 text-black font-semibold hover:bg-red-400 transition">
                Ya, Hapus
            </button>
        </div>
    </div>
</div>

<script>
    function confirmModal() {
        return {
            open: false,
            title: '',
            message: '',
            action: null,

            show(title, message, callback) {
                this.title = title
                this.message = message
                this.action = callback
                this.open = true
            },

            close() {
                this.open = false
            },

            confirm() {
                if (this.action) this.action()
                this.close()
            }
        }
    }
</script>

@stack('scripts')
</body>
</html>
