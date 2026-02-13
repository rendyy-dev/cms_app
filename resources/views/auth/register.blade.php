<x-guest-layout>
    <h1 class="text-2xl font-bold mb-6 text-center">
        Buat Akun <span class="text-emerald-400">RenCMS</span>
    </h1>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" value="Nama Lengkap" class="text-gray-300" />
            <input
                id="name"
                type="text"
                name="name"
                value="{{ old('name') }}"
                required
                autofocus
                class="mt-1 block w-full bg-black/40 border-white/10 text-gray-100
                       focus:border-emerald-400 focus:ring-emerald-400"
            />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Username (locked: no space & uppercase) -->
        <div
            x-data="{
                value: '{{ old('username') }}',
                sanitize() {
                    this.value = this.value
                        .toLowerCase()
                        .replace(/\s+/g, '')
                        .replace(/[^a-z0-9._]/g, '');
                }
            }"
        >
            <x-input-label for="username" value="Username" class="text-gray-300" />
            <input
                id="username"
                type="text"
                name="username"
                x-model="value"
                @input="sanitize"
                required
                class="mt-1 block w-full bg-black/40 border-white/10 text-gray-100
                       focus:border-emerald-400 focus:ring-emerald-400"
            />
            <p class="mt-1 text-xs text-gray-400">
                Huruf kecil, angka, titik, underscore. Tanpa spasi.
            </p>
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
        </div>

        <!-- Email -->
        <div>
            <x-input-label for="email" value="Email" class="text-gray-300" />
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                class="mt-1 block w-full bg-black/40 border-white/10 text-gray-100
                       focus:border-emerald-400 focus:ring-emerald-400"
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password with live rules (show only unmet rules) -->
        <div
            x-data="{
                password: '',
                touched: false,
                rules() {
                    return {
                        length: this.password.length >= 8,
                        upper: /[A-Z]/.test(this.password),
                        lower: /[a-z]/.test(this.password),
                        number: /[0-9]/.test(this.password),
                        symbol: /[^A-Za-z0-9]/.test(this.password),
                    }
                }
            }"
        >
            <x-password-input
                name="password"
                label="Password"
                x-model="password"
                @input="touched = true"
                required
            />

            <!-- Live rules: ONLY unmet -->
            <div x-show="touched" class="mt-3 space-y-1 text-sm text-gray-400">
                <template x-if="!rules().length">
                    <p>• Minimal 8 karakter</p>
                </template>
                <template x-if="!rules().upper">
                    <p>• Minimal 1 huruf besar</p>
                </template>
                <template x-if="!rules().lower">
                    <p>• Minimal 1 huruf kecil</p>
                </template>
                <template x-if="!rules().number">
                    <p>• Minimal 1 angka</p>
                </template>
                <template x-if="!rules().symbol">
                    <p>• Minimal 1 simbol</p>
                </template>
            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Password Confirmation -->
        <x-password-input
            name="password_confirmation"
            label="Konfirmasi Password"
            id="password_confirmation"
            required
        />

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

        <!-- Actions -->
        <div class="flex flex-col gap-4 mt-6">
            <button type="submit"
                    class="w-full py-3 rounded-xl bg-emerald-500 text-black font-semibold
                           hover:bg-emerald-400 transition">
                Daftar Sekarang
            </button>

            <p class="text-center text-sm text-gray-400">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-emerald-400 hover:underline">
                    Login
                </a>
            </p>
        </div>

        <a href="{{ route('auth.google') }}"
            class="w-full flex justify-center items-center gap-2 mt-4 px-4 py-2 border rounded-md text-sm font-medium hover:bg-gray-100 hover:text-black">
                Regis with Google
        </a>

        <!-- Kembali -->
        <div class="mt-4 text-right">
            <a href="{{ url('/') }}" class="text-sm text-gray-400 hover:text-emerald-400 transition">
                ← Kembali
            </a>
        </div>
    </form>

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    
</x-guest-layout>
