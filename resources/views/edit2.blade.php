<x-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight text-center" style="font-family: 'Cormorant Garamond', serif; color: #e5e5e5;">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <!-- Import Cormorant Garamond -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700&display=swap');
        body {
            font-family: 'Cormorant Garamond', serif;
        }

        .tab-active {
            background-color: #4F46E5;
            color: white;
        }

        .tab-inactive {
            background-color: #E5E7EB;
            color: black;
        }

        .tab:hover {
            background-color: #6366F1;
            color: white;
        }

        .shadow-hover:hover {
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
        }

        .form-input {
            width: 100%;
            padding: 12px;
            margin-top: 8px;
            border-radius: 8px;
            border: 1px solid #D1D5DB;
            transition: border-color 0.3s;
        }

        .form-input:focus {
            border-color: #6366F1;
            outline: none;
            box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.5);
        }

        .form-label {
            font-weight: bold;
            color: #374151;
        }

        .hidden {
            display: none;
        }

        .bg-light-navy {
            background-color: #1E293B;
        }

        .text-tahini {
            color: #FCD34D;
        }

        .button-custom {
            background-color: #6366F1;
            color: white;
            font-weight: 600;
            padding: 10px 20px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .button-custom:hover {
            background-color: #4F46E5;
        }

        .center-container {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            flex-direction: column;
            /* min-height: calc(100vh - 5rem); Deduct fixed header height */
            padding: 2rem;
        }
    </style>

    <!-- Main Content Container -->
    <div class="center-container bg-gray-100 dark:bg-gray-900 pt-20">
        <div class="max-w-4xl w-full mx-auto bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
            <!-- Profile Header -->
            <div class="text-center mb-8">
                <img src="{{ auth()->user()->braider && auth()->user()->braider->headshot 
                            ? asset('storage/' . auth()->user()->braider->headshot) 
                            : asset('default-avatar.png') }}" 
                    alt="Profile Picture" 
                    class="h-36 w-36 rounded-full mx-auto shadow-lg border-4 border-indigo-600">
                <h1 class="text-4xl font-semibold text-gray-800 dark:text-gray-100 mt-4">
                    {{ auth()->user()->name }}
                </h1>
                <p class="text-lg text-gray-500 dark:text-gray-400">{{ auth()->user()->email }}</p>
                <span class="mt-2 inline-block px-4 py-1 text-sm text-white bg-indigo-600 rounded-full shadow">
                    {{ ucfirst(auth()->user()->role) }}
                </span>
            </div>

            <!-- Tabbed Interface -->
            <div class="tabs mt-6">
                <div class="tab-header flex justify-center space-x-4">
                    <button id="view-tab" 
                            class="px-6 py-2 rounded-lg tab-active font-semibold text-lg shadow-hover transition-all" 
                            onclick="showTab('view')">
                        View Profile
                    </button>
                    <button id="edit-tab" 
                            class="px-6 py-2 rounded-lg tab-inactive font-semibold text-lg shadow-hover transition-all" 
                            onclick="showTab('edit')">
                        Edit Profile
                    </button>
                </div>
            </div>

            <!-- View Profile Tab -->
            <div id="view-tab-content" class="tab-content mt-6">
                <div class="bg-gray-100 dark:bg-gray-700 p-6 rounded-lg shadow">
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-4">
                        {{ __('Profile Information') }}
                    </h3>
                    <div class="space-y-4">
                        <p class="text-lg text-gray-700 dark:text-gray-300">
                            <strong>Name:</strong> {{ auth()->user()->name }}
                        </p>
                        <p class="text-lg text-gray-700 dark:text-gray-300">
                            <strong>Email:</strong> {{ auth()->user()->email }}
                        </p>
                        <p class="text-lg text-gray-700 dark:text-gray-300">
                            <strong>Role:</strong> {{ ucfirst(auth()->user()->role) }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Edit Profile Tab -->
            <div id="edit-tab-content" class="tab-content hidden mt-6 pt-6 ">
                <!-- Update Profile Information -->
                <div class="p-6 bg-gray-100 dark:bg-gray-700 rounded-lg shadow">
                    @include('profile.partials.update-profile-information-form')
                </div>

                <!-- Update Password -->
                <div class="p-6 bg-gray-100 dark:bg-gray-700 rounded-lg shadow mt-6">
                    @include('profile.partials.update-password-form')
                </div>

                <!-- Update Role -->
                <div id="role-management" class="p-6 bg-gray-100 dark:bg-gray-700 rounded-lg shadow mt-6">
                    <form method="POST" action="{{ route('profile.switchRole') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">{{ __('Role Management') }}</h3>

                        <label for="role" class="form-label">{{ __('Select Role') }}</label>
                        <select id="role" name="role" class="form-input">
                                <option value="member" 
                                        {{ auth()->user()->role === 'braider' ? 'disabled' : (auth()->user()->role === 'member' ? 'selected' : '') }}>
                                    {{ __('Member') }}
                                </option>
                            <option value="braider" {{ auth()->user()->role === 'braider' ? 'selected' : '' }}>
                                {{ __('Braider') }}
                            </option>
                        </select>

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

                        <button type="submit" class="button-custom mt-4 w-full">
                            {{ __('Save Changes') }}
                        </button>
                    </form>
                </div>

                <!-- Delete Account -->
                <div class="p-6 bg-gray-100 dark:bg-gray-700 rounded-lg shadow mt-6">
                    <div class="max-w-xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (session('message'))
    <div id="successModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
            <p class="text-lg text-green-700 dark:text-green-300 font-semibold">
                {{ session('message') }}
            </p>
            <button onclick="closeModal()" class="mt-4 px-6 py-2 bg-blue-500 text-white rounded-lg">
                OK
            </button>
        </div>
    </div>
    @endif

    <!-- Scripts -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            console.log("DOM fully loaded"); // Debugging

            // Check if modal exists and show it
            const modal = document.getElementById('successModal');
            if (modal) {
                console.log("Success Modal found, displaying...");
                modal.style.display = 'flex';

                // Auto-close modal after 3 seconds
                setTimeout(() => {
                    closeModal();
                }, 3000);
            } else {
                console.log("No modal found, session message might be missing.");
            }

            // Role change functionality
            const roleDropdown = document.getElementById('role');
            if (roleDropdown) {
                roleDropdown.addEventListener('change', function () {
                    const braiderFields = document.getElementById('braider-fields');
                    if (this.value === 'braider') {
                        braiderFields.classList.remove('hidden');
                    } else {
                        braiderFields.classList.add('hidden');
                    }
                });
            }

            // Automatically show the "Role Management" section if #role-management is in the URL
            const hash = window.location.hash;
            if (hash === "#role-management") {
                showTab('edit'); // Activate the edit tab
                const roleManagementSection = document.getElementById('role-management');
                if (roleManagementSection) {
                    roleManagementSection.scrollIntoView({ behavior: "smooth" });
                }
            }
        });

        // Function to handle tabs
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

        // Function to close modal
        function closeModal() {
            const modal = document.getElementById('successModal');
            if (modal) {
                modal.style.display = 'none';
            }
        }
    </script>
</x-layout>
