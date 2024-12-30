<x-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight" style="font-family: 'Cormorant Garamond', serif; color: #e5e5e5;">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <!-- Import Cormorant Garamond -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700&display=swap');
        body {
            font-family: 'Cormorant Garamond', serif;
        }
    </style>

    <!-- Main Content Container with Padding -->
    <div class="pt-20">
        <!-- Profile Header -->
        <div class="bg-light-navy p-6 rounded-lg shadow-md text-center">
            <img src="{{ auth()->user()->braider && auth()->user()->braider->headshot 
                        ? asset('storage/' . auth()->user()->braider->headshot) 
                        : asset('default-avatar.png') }}" 
                alt="Profile Picture" 
                class="h-32 w-32 rounded-full mx-auto shadow">
            <h1 class="text-3xl font-semibold text-tahini mt-4" style="font-family: 'Cormorant Garamond', serif;">
                {{ auth()->user()->name }}
            </h1>
            <p class="text-gray-400">{{ auth()->user()->email }}</p>
        </div>


        <!-- Tabbed Interface -->
        <div class="tabs mt-6">
            <div class="tab-header flex justify-center space-x-4">
                <button id="view-tab" 
                        class="px-4 py-2 rounded bg-indigo-500 text-white text-lg font-semibold"
                        style="font-family: 'Cormorant Garamond', serif;" 
                        onclick="showTab('view')">
                    View Profile
                </button>
                <button id="edit-tab" 
                        class="px-4 py-2 rounded bg-gray-300 text-black text-lg font-semibold"
                        style="font-family: 'Cormorant Garamond', serif;" 
                        onclick="showTab('edit')">
                    Edit Profile
                </button>
            </div>

            <!-- View Profile Tab -->
            <div id="view-tab-content" class="tab-content mt-6">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200" 
                        style="font-family: 'Cormorant Garamond', serif;">
                        {{ __('Profile Information') }}
                    </h3>
                    <p class="text-gray-600 mt-2" style="font-family: 'Cormorant Garamond', serif;">
                        <strong>Name:</strong> {{ auth()->user()->name }}
                    </p>
                    <p class="text-gray-600" style="font-family: 'Cormorant Garamond', serif;">
                        <strong>Email:</strong> {{ auth()->user()->email }}
                    </p>
                    <p class="text-gray-600" style="font-family: 'Cormorant Garamond', serif;">
                        <strong>Role:</strong> {{ ucfirst(auth()->user()->role) }}
                    </p>
                </div>
            </div>

            <!-- Edit Profile Tab -->
            <div id="edit-tab-content" class="tab-content hidden mt-6">
                <!-- Update Profile Information -->
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <!-- Update Password -->
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg mt-6">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <!-- Update Role -->
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg mt-6">
                    <div class="max-w-xl">
                        <form method="POST" action="{{ route('profile.switchRole') }}" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')

                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200" 
                                style="font-family: 'Cormorant Garamond', serif;">
                                {{ __('Role Management') }}
                            </h3>
                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400" 
                               style="font-family: 'Cormorant Garamond', serif;">
                                {{ __('Select your role.') }}
                            </p>

                            <!-- Role Selector -->
                            <div class="mt-4">
                                <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ __('Role') }}
                                </label>
                                <select id="role" name="role" 
                                        class="block w-full mt-1 rounded-md border-gray-300 shadow-sm 
                                               focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm 
                                               dark:bg-gray-700 dark:text-gray-300"
                                        style="font-family: 'Cormorant Garamond', serif;">
                                    <option value="member" {{ auth()->user()->role === 'member' ? 'selected' : '' }}>
                                        {{ __('Member') }}
                                    </option>
                                    <option value="braider" {{ auth()->user()->role === 'braider' ? 'selected' : '' }}>
                                        {{ __('Braider') }}
                                    </option>
                                </select>
                            </div>

                            <!-- Braider-Specific Fields -->
                            <div id="braider-fields" class="mt-6 {{ auth()->user()->role !== 'braider' ? 'hidden' : '' }}">
                                <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200" 
                                    style="font-family: 'Cormorant Garamond', serif;">
                                    {{ __('Braider Information') }}
                                </h4>
                                <div class="mt-4">
                                    <label for="bio" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ __('Bio') }}
                                    </label>
                                    <textarea name="bio" id="bio" 
                                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                                                     focus:ring-indigo-500 focus:border-indigo-500">{{ auth()->user()->braider->bio ?? '' }}</textarea>
                                </div>
                                <div class="mt-4">
                                    <label for="headshot" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ __('Headshot') }}
                                    </label>
                                    <input type="file" name="headshot" id="headshot" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                                <div class="mt-4">
                                    <label for="min_price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ __('Minimum Price') }}
                                    </label>
                                    <input type="number" name="min_price" id="min_price" value="{{ auth()->user()->braider->min_price ?? '' }}" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                                <div class="mt-4">
                                    <label for="max_price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ __('Maximum Price') }}
                                    </label>
                                    <input type="number" name="max_price" id="max_price" value="{{ auth()->user()->braider->max_price ?? '' }}" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="mt-6">
                                <button type="submit" 
                                        class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 focus:ring focus:ring-indigo-300">
                                    {{ __('Update Role') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Delete Account -->
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg mt-6">
                    <div class="max-w-xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script to Handle Tabs and Braider Fields -->
    <script>
        function showTab(tab) {
            document.getElementById('view-tab-content').classList.add('hidden');
            document.getElementById('edit-tab-content').classList.add('hidden');
            document.getElementById(tab + '-tab-content').classList.remove('hidden');

            // Update button styles
            document.getElementById('view-tab').classList.toggle('bg-indigo-500', tab === 'view');
            document.getElementById('view-tab').classList.toggle('bg-gray-300', tab !== 'view');
            document.getElementById('edit-tab').classList.toggle('bg-indigo-500', tab === 'edit');
            document.getElementById('edit-tab').classList.toggle('bg-gray-300', tab !== 'edit');
        }

        document.getElementById('role').addEventListener('change', function () {
            const braiderFields = document.getElementById('braider-fields');
            if (this.value === 'braider') {
                braiderFields.classList.remove('hidden');
            } else {
                braiderFields.classList.add('hidden');
            }
        });
    </script>
</x-layout>
