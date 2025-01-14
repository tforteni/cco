<x-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Complete Your Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

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

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <form method="POST" action="{{ route('braider.store-profile') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Bio -->
                    <div class="mb-4">
                        <x-input-label for="bio" :value="__('Bio')" />
                        <textarea id="bio" name="bio" rows="5" class="block w-full mt-1" required>{{ old('bio') }}</textarea>
                        <x-input-error :messages="$errors->get('bio')" />
                    </div>

                    <!-- Headshot -->
                    <div class="mb-4">
                        <x-input-label for="headshot" :value="__('Headshot')" />
                        <input id="headshot" type="file" name="headshot" class="block w-full mt-1" />
                        <x-input-error :messages="$errors->get('headshot')" />
                    </div>

                    <!-- Work Images -->
                    @for ($i = 1; $i <= 3; $i++)
                        <div class="mb-4">
                            <x-input-label for="work_image{{ $i }}" :value="__('Work Photo ' . $i)" />
                            <input id="work_image{{ $i }}" type="file" name="work_image{{ $i }}" class="block w-full mt-1" />
                            <x-input-error :messages="$errors->get('work_image'.$i)" />
                        </div>
                    @endfor

                    <!-- Pricing -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="min_price" :value="__('Minimum Price')" />
                            <input id="min_price" type="number" name="min_price" class="block w-full mt-1" min="1" value="{{ old('min_price') }}" required />
                            <x-input-error :messages="$errors->get('min_price')" />
                        </div>
                        <div>
                            <x-input-label for="max_price" :value="__('Maximum Price')" />
                            <input id="max_price" type="number" name="max_price" class="block w-full mt-1" value="{{ old('max_price') }}" required />
                            <x-input-error :messages="$errors->get('max_price')" />
                        </div>
                    </div>
                    <!-- Specialties dropdown -->
                    <label for="specialties">Select Your Specialties:</label>
                    <select id="specialties" name="specialties[]" multiple>
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



                    <div class="mt-6">
                        <x-primary-button>
                            {{ __('Submit Profile') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>

