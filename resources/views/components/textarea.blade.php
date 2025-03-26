@props([
    'rows' => 4,
    'disabled' => false,
])

<textarea
    rows="{{ $rows }}"
    {{ $disabled ? 'disabled' : '' }}
    {!! $attributes->merge([
        'class' => 'form-input mt-1 block w-full bg-gray-900 text-tahini rounded-md shadow-sm focus:ring focus:ring-indigo-500 focus:border-indigo-500'
    ]) !!}
>{{ $slot }}</textarea>
