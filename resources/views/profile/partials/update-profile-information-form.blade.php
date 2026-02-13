<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            Profile Information
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            Update your account profile and email.
        </p>
    </header>

    <form method="post"
          action="{{ route('profile.update') }}"
          enctype="multipart/form-data"
          class="mt-6 space-y-6">
        @csrf
        @method('patch')

        {{-- Avatar --}}
        <div>
            <x-input-label for="avatar" value="Avatar" />

            <div class="mt-2 flex items-center gap-4">
                @if($user->avatar)
                    <img src="{{ asset('storage/' . $user->avatar) }}"
                         class="w-20 h-20 rounded-full object-cover">
                @else
                    <div class="w-20 h-20 rounded-full bg-gray-300 dark:bg-gray-700 flex items-center justify-center text-gray-600">
                        ?
                    </div>
                @endif

                <input id="avatar"
                       name="avatar"
                       type="file"
                       accept="image/*"
                       class="block text-sm text-gray-500">
            </div>

            <p class="text-xs text-gray-500 mt-1">
                Max 2MB. JPG, PNG.
            </p>

            <x-input-error :messages="$errors->get('avatar')" class="mt-2" />
        </div>

        {{-- Name --}}
        <div>
            <x-input-label for="name" value="Name" />
            <x-text-input id="name"
                          name="name"
                          type="text"
                          class="mt-1 block w-full"
                          :value="old('name', $user->name)"
                          required />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        {{-- Email --}}
        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email"
                          name="email"
                          type="email"
                          class="mt-1 block w-full"
                          :value="old('email', $user->email)"
                          required />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        {{-- Username --}}
        <div>
            <x-input-label for="username" value="Username" />
            <x-text-input id="username"
                          name="username"
                          type="text"
                          class="mt-1 block w-full"
                          :value="old('username', $user->username)"
                          required />
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
        </div>

        {{-- Telepon --}}
        <div>
            <x-input-label for="telepon" value="Telepon" />
            <x-text-input id="telepon"
                          name="telepon"
                          type="text"
                          class="mt-1 block w-full"
                          :value="old('telepon', $user->telepon)" />
            <x-input-error :messages="$errors->get('telepon')" class="mt-2" />
        </div>

        {{-- Alamat --}}
        <div>
            <x-input-label for="alamat" value="Alamat" />
            <textarea id="alamat"
                      name="alamat"
                      class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-900 dark:border-gray-700">{{ old('alamat', $user->alamat) }}</textarea>
            <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>Save</x-primary-button>

            @if (session('success'))
                <p class="text-sm text-green-600">
                    {{ session('success') }}
                </p>
            @endif
        </div>
    </form>
</section>
