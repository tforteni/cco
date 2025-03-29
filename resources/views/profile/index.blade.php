<x-layout>
@include('profile.partials.styles')
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight text-center text-tahini">
            {{ __('My Profile') }}
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto pt-32 sm:px-6 lg:px-8">
        {{-- Profile card --}}
        <div class="bg-dark-navy text-white rounded-xl shadow-md p-6 mb-8 text-center">
            <div class="flex justify-center mb-4">
                <img src="{{ auth()->user()->braider && auth()->user()->braider->headshot 
                            ? asset('storage/' . auth()->user()->braider->headshot) 
                            : asset('default-avatar.png') }}"
                     alt="Profile Picture"
                     class="h-24 w-24 rounded-full border-4 border-tahini object-cover">
            </div>

            <h1 class="text-2xl font-bold">{{ auth()->user()->name }}</h1>
            <p class="text-gray-300">{{ auth()->user()->email }}</p>
            <span class="mt-2 inline-block px-3 py-1 text-sm font-medium text-white bg-indigo-600 rounded-full shadow">
                {{ ucfirst(auth()->user()->role) }}
            </span>
        </div>

        {{-- Quick Links --}}
        <div class="bg-gray-100 dark:bg-gray-800 rounded-xl shadow p-6">
            <h3 class="text-lg font-semibold text-dark-tahini dark:text-white mb-4">Account Settings</h3>

            <ul class="space-y-4 text-sm">
                <li>
                    <a href="{{ route('profile.edit') }}"
                       class="flex items-center justify-between text-tahini dark:text-tahini hover:underline">
                        Edit Profile Information
                        <x-chevron />
                    </a>
                </li>
                @if(auth()->user()->role === 'braider')
                    <li>
                        <a href="{{ route('braider.profile.edit') }}"
                        class="flex items-center justify-between text-tahini dark:text-tahini hover:underline">
                            Manage Braider Profile
                            <x-chevron />
                        </a>
                    </li>
                @endif
                <li>
                    <a href="{{ route('profile.password') }}"
                       class="flex items-center justify-between text-tahini dark:text-tahini hover:underline">
                        Change Password
                        <x-chevron />
                    </a>
                </li>
                <li>
                    <a href="{{ route('profile.role') }}"
                       class="flex items-center justify-between text-tahini dark:text-tahini hover:underline">
                        Switch Role
                        <x-chevron />
                    </a>
                </li>
                <li>
                    <a href="{{ route('profile.delete') }}"
                       class="flex items-center justify-between text-red-600 hover:underline">
                        Delete Account
                        <x-chevron class="text-red-600" />
                    </a>
                </li>
            </ul>
        </div>
    </div>
    @include('profile.partials.success-modal')
    @include('profile.partials.scripts')
</x-layout>
