@props([
    'label' => 'Password',
    'name',
    'id' => null,
    'required' => true,
])

<div x-data="{ show: false }" class="relative">
    <!-- Label -->
    <x-input-label :for="$id ?? $name" :value="$label" class="text-gray-300" />

    <!-- Input -->
    <input
        :type="show ? 'text' : 'password'"
        name="{{ $name }}"
        id="{{ $id ?? $name }}"
        autocomplete="{{ $attributes->get('autocomplete', 'new-password') }}"
        @if($required) required @endif
        {{ $attributes->merge([
            'class' => 'mt-1 block w-full bg-black/40 border-white/10 text-gray-100
                        focus:border-emerald-400 focus:ring-emerald-400 pr-10 rounded-lg'
        ]) }}
    />

    <!-- Toggle show/hide -->
    <button type="button"
            @click="show = !show"
            class="absolute inset-y-11 right-3 flex items-center text-gray-400 hover:text-gray-200">
        <!-- Eye open -->
        <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
        </svg>

        <!-- Eye closed -->
        <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a10.05 10.05 0 012.342-3.918M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3 3l18 18" />
        </svg>
    </button>

    <!-- Error -->
    <x-input-error :messages="$errors->get($name)" class="mt-2" />
</div>
