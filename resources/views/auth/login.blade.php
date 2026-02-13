<x-guest-layout>
    <h1 class="text-2xl font-bold mb-6 text-center">
        Masuk ke <span class="text-emerald-400">RenCMS</span>
    </h1>

    <!-- SESSION STATUS -->
    <x-auth-session-status class="mb-4 text-sm text-emerald-400 text-center"
        :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Username or Email -->
        <div>
            <x-input-label for="login" value="Username atau Email" class="text-gray-300" />

            <input
                id="login"
                type="text"
                name="login"
                value="{{ old('login') }}"
                required
                autofocus
                class="mt-1 block w-full bg-black/40 border-white/10 text-gray-100
                    focus:border-emerald-400 focus:ring-emerald-400"
            />

            <x-input-error :messages="$errors->get('login')" class="mt-2" />
        </div>

        <!-- PASSWORD -->
        <x-password-input name="password" label="Password" id="password" />

        <!-- RECAPTCHA -->
        <div class="mt-4">
            <div
                class="g-recaptcha"
                data-sitekey="{{ config('services.recaptcha.site_key') }}">
            </div>

            @error('g-recaptcha-response')
                <p class="mt-2 text-sm text-red-500">
                    {{ $message }}
                </p>
            @enderror
        </div>


        <!-- REMEMBER -->
        <div class="flex items-center justify-between text-sm">
            <label for="remember_me" class="inline-flex items-center text-gray-400">
                <input
                    id="remember_me"
                    type="checkbox"
                    name="remember"
                    class="rounded bg-black/40 border-white/20 text-emerald-500
                           focus:ring-emerald-400"
                >
                <span class="ml-2">Ingat saya</span>
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}"
                   class="text-emerald-400 hover:underline">
                    Lupa password?
                </a>
            @endif
        </div>

        <!-- ACTION -->
        <div class="flex flex-col gap-4 mt-6">
            <button
                type="submit"
                class="w-full py-3 rounded-xl bg-emerald-500 text-black font-semibold
                       hover:bg-emerald-400 transition">
                Masuk
            </button>

            <p class="text-center text-sm text-gray-400">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-emerald-400 hover:underline">
                    Daftar sekarang
                </a>
            </p>
        </div>

        <a href="{{ route('auth.google') }}"
            class="w-full flex justify-center items-center gap-2 mt-4 px-4 py-2 border rounded-md text-sm font-medium hover:bg-gray-100 hover:text-black">
                Login with Google
        </a>


        <!-- KEMBALI BUTTON -->
        <div class="mt-4 text-right">
            <a href="{{ url('/') }}"
               class="text-sm text-gray-400 hover:text-emerald-400 transition">
                ← Kembali
            </a>
        </div>
    </form>

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

</x-guest-layout>
