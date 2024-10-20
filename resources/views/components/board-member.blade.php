@props(['name', 'role', 'image'])
<div class="text-center">
    <img src="{{ asset($image) }}" class="object-cover w-32 h-44 rounded-full mx-auto mb-4 border-2 border-dark-tahini">
    <h3 class="text-xl font-semibold text-tahini">{{ $name }}</h3>
    <p class="text-tahini">{{ $role }}</p>
</div>