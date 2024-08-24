@props(['active' => false])

<a class="{{ $active ? 'underline' : '' }} text-sm font-semibold leading-6 text-tahini" 
aria-current="{{ $active ? 'page' : 'false' }}"
{{ $attributes }}>
{{$slot}}</a>