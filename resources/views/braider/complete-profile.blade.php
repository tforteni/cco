<x-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight text-center" style="font-family: 'Cormorant Garamond', serif; color: #e5e5e5;">
            {{ __('Complete Your Profile') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 dark:bg-gray-900 min-h-screen">
        <div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 shadow-lg rounded-lg p-8">
            <!-- Feedback Section -->
            @if (session('message'))
                <div class="p-4 mb-6 text-sm text-green-800 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-900">
                    {{ session('message') }}
                </div>
            @endif

            @if (session('error'))
                <div class="p-4 mb-6 text-sm text-red-800 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-900">
                    {{ session('error') }}
                </div>
            @endif

            <h3 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 text-center mb-6" style="font-family: 'Cormorant Garamond', serif;">
                {{ __("Let's Get You Started!") }}
            </h3>

            <form method="POST" action="{{ route('braider.store-profile') }}" enctype="multipart/form-data">
                @csrf

                <!-- Bio -->
                <div class="mb-6">
                    <x-input-label for="bio" :value="__('Bio')" style="font-family: 'Cormorant Garamond', serif;" />
                    <textarea id="bio" name="bio" rows="4" class="block w-full mt-1 p-3 border rounded-lg shadow-sm" style="font-family: 'Cormorant Garamond', serif;" required>{{ old('bio') }}</textarea>
                    <x-input-error :messages="$errors->get('bio')" />
                </div>

                <!-- Headshot -->
                <div class="mb-6">
                    <x-input-label for="headshot" :value="__('Upload Your Headshot')" style="font-family: 'Cormorant Garamond', serif;" />
                    <input id="headshot" type="file" name="headshot" class="block w-full mt-2 border rounded-lg p-2" style="font-family: 'Cormorant Garamond', serif;" />
                    <x-input-error :messages="$errors->get('headshot')" />
                </div>

                <!-- Work Images -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                    @for ($i = 1; $i <= 3; $i++)
                        <div>
                            <x-input-label for="work_image{{ $i }}" :value="__('Work Photo ' . $i)" style="font-family: 'Cormorant Garamond', serif;" />
                            <input id="work_image{{ $i }}" type="file" name="work_image{{ $i }}" class="block w-full mt-2 border rounded-lg p-2" style="font-family: 'Cormorant Garamond', serif;" />
                            <x-input-error :messages="$errors->get('work_image'.$i)" />
                        </div>
                    @endfor
                </div>

                <!-- Pricing -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
                    <div>
                        <x-input-label for="min_price" :value="__('Minimum Price')" style="font-family: 'Cormorant Garamond', serif;" />
                        <input id="min_price" type="number" name="min_price" class="block w-full mt-2 border rounded-lg p-3" style="font-family: 'Cormorant Garamond', serif;" min="1" value="{{ old('min_price') }}" required />
                        <x-input-error :messages="$errors->get('min_price')" />
                    </div>
                    <div>
                        <x-input-label for="max_price" :value="__('Maximum Price')" style="font-family: 'Cormorant Garamond', serif;" />
                        <input id="max_price" type="number" name="max_price" class="block w-full mt-2 border rounded-lg p-3" style="font-family: 'Cormorant Garamond', serif;" value="{{ old('max_price') }}" required />
                        <x-input-error :messages="$errors->get('max_price')" />
                    </div>
                </div>

                <!-- Specialties dropdown -->
                <div class="mb-6">
                    <x-input-label for="specialties" :value="__('Select Your Specialties')" style="font-family: 'Cormorant Garamond', serif;" />
                    <select id="specialties" name="specialties[]" multiple class="block w-full mt-2 border rounded-lg p-3" style="font-family: 'Cormorant Garamond', serif;">
                        @foreach(App\Models\Specialty::all() as $specialty)
                            <option value="{{ $specialty->id }}">{{ $specialty->name }}</option>
                        @endforeach
                    </select>
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            new TomSelect("#specialties", {
                                create: false,
                                plugins: ['remove_button'],
                                placeholder: "Select specialties...",
                            });
                        });
                    </script>
                    <x-input-error :messages="$errors->get('specialties')" />
                </div>

                <!-- Submit Button -->
                <div class="text-center">
                    <x-primary-button class="w-full sm:w-auto px-8 py-3 text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg shadow-lg" style="font-family: 'Cormorant Garamond', serif;">
                        {{ __('Submit Profile') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-layout>
