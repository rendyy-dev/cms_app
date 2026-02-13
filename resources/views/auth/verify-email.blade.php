<x-guest-layout>

    <div class="text-center mb-6">
        <h1 class="text-xl font-semibold text-white">
            Verifikasi Email Kamu
        </h1>
        <p class="text-sm text-gray-400 mt-2">
            Satu langkah lagi sebelum akunmu siap digunakan
        </p>
    </div>

    <div class="text-sm text-gray-300 leading-relaxed mb-4">
        Kami sudah mengirimkan <span class="text-emerald-400 font-medium">email verifikasi</span>
        ke alamat email yang kamu gunakan saat mendaftar.
        <br><br>
        Silakan klik link di email tersebut untuk melanjutkan proses pendaftaran
        dan melengkapi profil akunmu.
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 rounded-lg bg-emerald-500/10 border border-emerald-500/30 p-3 text-sm text-emerald-400">
            Link verifikasi baru berhasil dikirim ke email kamu.
            Silakan cek inbox atau folder spam.
        </div>
    @endif

    <div class="mt-6 flex flex-col gap-4">

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button
                type="submit"
                class="w-full flex justify-center items-center px-4 py-2 rounded-lg
                       bg-emerald-500 text-black font-medium
                       hover:bg-emerald-400 transition">
                Kirim Ulang Email Verifikasi
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button
                type="submit"
                class="w-full text-center text-sm text-gray-400 hover:text-gray-200 transition">
                Keluar dari akun
            </button>
        </form>

    </div>

    <div class="mt-6 text-xs text-gray-500 text-center">
        Setelah email terverifikasi, kamu akan diarahkan untuk
        <span class="text-gray-300">melengkapi profil akun</span>.
    </div>

</x-guest-layout>
