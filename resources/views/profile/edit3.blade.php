<x-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight text-center" style="font-family: 'Cormorant Garamond', serif; color: #e5e5e5;">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700&display=swap');
        body {
            font-family: 'Cormorant Garamond', serif;
        }

        .center-container {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            flex-direction: column;
            min-height: calc(100vh - 5rem); /* Deduct fixed header height */
            padding: 2rem;
        }

        .tabs {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 1rem;
        }

        button {
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: bold;
        }

        .tab-active {
            background-color: #4F46E5;
            color: white;
        }

        .tab-inactive {
            background-color: #E5E7EB;
            color: black;
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

        .profile-header {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .profile-header img {
            height: 8rem;
            width: 8rem;
            border-radius: 50%;
            margin: 0 auto;
            border: 4px solid #4F46E5;
        }

        .profile-header h1 {
            margin-top: 1rem;
        }
    </style>

    <!-- Main Content -->
    <div class="center-container bg-gray-100 dark:bg-gray-900 pt-20">
        <div class="max-w-4xl w-full mx-auto bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
            <!-- Profile Header -->
            <div class="profile-header">
                <img src="{{ auth()->user()->braider && auth()->user()->braider->headshot 
                            ? asset('storage/' . auth()->user()->braider->headshot) 
                            : asset('default-avatar.png') }}" 
                    alt="Profile Picture" />
                <h1 class="text-4xl font-semibold text-gray-800 dark:text-gray-100">
                    {{ auth()->user()->name }}
                </h1>
                <p class="text-lg text-gray-500 dark:text-gray-400">{{ auth()->user()->email }}</p>
                <span class="mt-2 inline-block px-4 py-1 text-sm text-white bg-indigo-600 rounded-full shadow">
                    {{ ucfirst(auth()->user()->role) }}
                </span>
            </div>

            <!-- Tabbed Interface -->
            <div class="tabs">
                <button id="view-tab" 
                        class="tab-active shadow-hover transition-all" 
                        onclick="showTab('view')">
                    View Profile
                </button>
                <button id="edit-tab" 
                        class="tab-inactive shadow-hover transition-all" 
                        onclick="showTab('edit')">
                    Edit Profile
                </button>
            </div>

            <!-- Tab Content -->
            <div id="view-tab-content" class="tab-content mt-6">
                <div class="bg-gray-100 dark:bg-gray-700 p-6 rounded-lg shadow">
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-4">
                        {{ __('Profile Information') }}
                    </h3>
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

            <div id="edit-tab-content" class="tab-content hidden mt-6">
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
                            <option value="member" {{ auth()->user()->role === 'braider' ? 'disabled' : (auth()->user()->role === 'member' ? 'selected' : '') }}>
                                {{ __('Member') }}
                            </option>
                            <option value="braider" {{ auth()->user()->role === 'braider' ? 'selected' : '' }}>
                                {{ __('Braider') }}
                            </option>
                        </select>

                        <!-- Braider-Specific Fields -->
                        <div id="braider-fields" class="mt-6 {{ auth()->user()->role !== 'braider' ? 'hidden' : '' }}">
                            <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                                {{ __('Braider Information') }}
                            </h4>
                            <div class="mt-4">
                                <label for="bio" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ __('Bio') }}
                                </label>
                                <textarea name="bio" id="bio" class="form-input">{{ auth()->user()->braider->bio ?? '' }}</textarea>
                            </div>
                            <div class="mt-4">
                                <label for="headshot" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ __('Headshot') }}
                                </label>
                                <input type="file" name="headshot" id="headshot" class="form-input">
                            </div>
                            <div class="mt-4">
                                <label for="min_price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ __('Minimum Price') }}
                                </label>
                                <input type="number" name="min_price" id="min_price" value="{{ auth()->user()->braider->min_price ?? '' }}" class="form-input">
                            </div>
                            <div class="mt-4">
                                <label for="max_price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ __('Maximum Price') }}
                                </label>
                                <input type="number" name="max_price" id="max_price" value="{{ auth()->user()->braider->max_price ?? '' }}" class="form-input">
                            </div>
                        </div>

                        <button type="submit" class="button-custom mt-4 w-full">
                            {{ __('Save Changes') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

        <script>
        document.addEventListener("DOMContentLoaded", function () {
            console.log("DOM fully loaded");

            // Show the modal if it exists
            const modal = document.getElementById('successModal');
            if (modal) {
                console.log("Success Modal found, displaying...");
                modal.style.display = 'flex';

                // Auto-close modal after 3 seconds
                setTimeout(() => {
                    closeModal();
                }, 3000);
            }

            // Handle tab switching
            const tabs = document.querySelectorAll(".tabs button");
            tabs.forEach((tab) => {
                tab.addEventListener("click", function () {
                    const target = tab.id.replace("-tab", "-tab-content");
                    showTab(target);
                });
            });

            // Role change functionality
            const roleDropdown = document.getElementById("role");
            const braiderFields = document.getElementById("braider-fields");

            if (roleDropdown) {
                roleDropdown.addEventListener("change", function () {
                    if (this.value === "braider") {
                        braiderFields.classList.remove("hidden");
                    } else {
                        braiderFields.classList.add("hidden");
                    }
                });
            }

            // Automatically show the "Role Management" section if hash is "#role-management"
            const hash = window.location.hash;
            if (hash === "#role-management") {
                showTab("edit-tab-content");
                const roleManagementSection = document.getElementById("role-management");
                if (roleManagementSection) {
                    roleManagementSection.scrollIntoView({ behavior: "smooth" });
                }
            }
        });

        // Function to handle showing tabs
        function showTab(targetId) {
            const tabContents = document.querySelectorAll(".tab-content");
            tabContents.forEach((content) => {
                content.classList.add("hidden");
            });

            const activeContent = document.getElementById(targetId);
            if (activeContent) {
                activeContent.classList.remove("hidden");
            }

            // Update button styles
            const tabs = document.querySelectorAll(".tabs button");
            tabs.forEach((tab) => {
                const isActive = tab.id === targetId.replace("-content", "-tab");
                tab.classList.toggle("tab-active", isActive);
                tab.classList.toggle("tab-inactive", !isActive);
            });
        }

        // Function to close the modal
        function closeModal() {
            const modal = document.getElementById("successModal");
            if (modal) {
                modal.style.display = "none";
            }
        }
    </script>

</x-layout>
