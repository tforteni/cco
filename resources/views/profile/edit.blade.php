<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Update Profile Information -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <!-- User Details -->
                        <div class="mb-4">
                            <label for="name" class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Name') }}</label>
                            <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" class="mt-1 block w-full bg-gray-100 border-gray-300">
                        </div>
                        <div class="mb-4">
                            <label for="email" class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Email') }}</label>
                            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" class="mt-1 block w-full bg-gray-100 border-gray-300">
                        </div>

                        <!-- Role Selector -->
                        <div class="mb-4">
                            <label for="role" class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Role') }}</label>
                            <select id="role" name="role" class="mt-1 block w-full bg-gray-100 border-gray-300">
                                <option value="member" {{ $user->role === 'member' ? 'selected' : '' }}>Member</option>
                                <option value="braider" {{ $user->role === 'braider' ? 'selected' : '' }}>Braider</option>
                            </select>
                        </div>

                        <!-- Braider Details (Conditional) -->
                        <div id="braider-fields" class="{{ $user->role === 'braider' ? '' : 'hidden' }}">
                            <div class="mb-4">
                                <label for="bio" class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Bio') }}</label>
                                <textarea id="bio" name="bio" class="mt-1 block w-full bg-gray-100 border-gray-300">{{ old('bio', $user->braider->bio ?? '') }}</textarea>
                            </div>
                            <div class="mb-4">
                                <label for="headshot" class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Headshot') }}</label>
                                <input id="headshot" name="headshot" type="file" class="mt-1 block w-full bg-gray-100 border-gray-300">
                            </div>
                            <div class="mb-4">
                                <label for="min_price" class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Minimum Price') }}</label>
                                <input id="min_price" name="min_price" type="number" value="{{ old('min_price', $user->braider->min_price ?? '') }}" class="mt-1 block w-full bg-gray-100 border-gray-300">
                            </div>
                            <div class="mb-4">
                                <label for="max_price" class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Maximum Price') }}</label>
                                <input id="max_price" name="max_price" type="number" value="{{ old('max_price', $user->braider->max_price ?? '') }}" class="mt-1 block w-full bg-gray-100 border-gray-300">
                            </div>
                            <!-- Add other fields as needed -->
                        </div>

                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Script to Show/Hide Braider Fields -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const roleSelect = document.getElementById('role');
            const braiderFields = document.getElementById('braider-fields');

            roleSelect.addEventListener('change', () => {
                if (roleSelect.value === 'braider') {
                    braiderFields.classList.remove('hidden');
                } else {
                    braiderFields.classList.add('hidden');
                }
            });
        });
    </script>
</x-app-layout>
