<x-guest-layout>

    <div class="text-center mb-6">
        <h1 class="text-xl font-semibold text-white">
            Lengkapi Profil Kamu
        </h1>
        <p class="text-sm text-gray-400 mt-2">
            Atur username dan password untuk mengamankan akunmu
        </p>
    </div>

    <form method="POST" action="{{ route('profile.complete.store') }}" class="space-y-5">
        @csrf

        <!-- Nama (read only) -->
        <div>
            <x-input-label value="Nama Lengkap" class="text-gray-300" />
            <input
                type="text"
                value="{{ auth()->user()->name }}"
                disabled
                class="mt-1 block w-full bg-black/40 border-white/10 text-gray-400"
            />
        </div>

        <!-- Email (read only) -->
        <div>
            <x-input-label value="Email" class="text-gray-300" />
            <input
                type="email"
                value="{{ auth()->user()->email }}"
                disabled
                class="mt-1 block w-full bg-black/40 border-white/10 text-gray-400"
            />
        </div>

        <!-- Username -->
        <div
            x-data="{
                value: '{{ old('username', auth()->user()->username) }}',
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

        <!-- Telepon -->
        <div>
            <x-input-label for="telepon" value="Nomor Telepon" class="text-gray-300" />
            <input
                id="telepon"
                type="text"
                name="telepon"
                value="{{ old('telepon') }}"
                required
                class="mt-1 block w-full bg-black/40 border-white/10 text-gray-100
                       focus:border-emerald-400 focus:ring-emerald-400"
            />
            <x-input-error :messages="$errors->get('telepon')" class="mt-2" />
        </div>

        <!-- Alamat -->
        <div>
            <x-input-label for="alamat" value="Alamat" class="text-gray-300" />
            <textarea
                id="alamat"
                name="alamat"
                rows="3"
                required
                class="mt-1 block w-full bg-black/40 border-white/10 text-gray-100
                       focus:border-emerald-400 focus:ring-emerald-400"
            >{{ old('alamat') }}</textarea>
            <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
        </div>

        <!-- Password -->
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

            <div x-show="touched" class="mt-3 space-y-1 text-sm text-gray-400">
                <template x-if="!rules().length"><p>• Minimal 8 karakter</p></template>
                <template x-if="!rules().upper"><p>• Minimal 1 huruf besar</p></template>
                <template x-if="!rules().lower"><p>• Minimal 1 huruf kecil</p></template>
                <template x-if="!rules().number"><p>• Minimal 1 angka</p></template>
                <template x-if="!rules().symbol"><p>• Minimal 1 simbol</p></template>
            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Konfirmasi Password -->
        <x-password-input
            name="password_confirmation"
            label="Konfirmasi Password"
            required
        />

        <!-- Submit -->
        <button
            type="submit"
            class="w-full mt-6 py-3 rounded-xl bg-emerald-500 text-black font-semibold
                   hover:bg-emerald-400 transition">
            Simpan & Lanjutkan
        </button>
    </form>

    <p class="text-xs text-gray-500 text-center mt-6">
        Data ini digunakan untuk keamanan dan personalisasi akun kamu.
    </p>

</x-guest-layout>
