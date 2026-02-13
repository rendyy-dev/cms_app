@props(['disabled' => false, 'type' => 'text'])

<input
    type="{{ $type }}"
    name="{{ $attributes->get('name') }}"
    id="{{ $attributes->get('id') }}"
    value="{{ $attributes->get('value') }}"
    {{ $disabled ? 'disabled' : '' }}
    {{ $attributes->merge([
        'class' => 'mt-1 block w-full bg-black/40 border-white/10 text-gray-100
                    focus:border-emerald-400 focus:ring-emerald-400 rounded-md'
    ]) }}
>
