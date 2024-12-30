<x-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Complete Your Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <form method="POST" action="{{ route('braider.store-profile') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Bio -->
                    <div class="mb-4">
                        <x-input-label for="bio" :value="__('Bio')" />
                        <textarea id="bio" name="bio" rows="5" class="block w-full mt-1" required></textarea>
                        <x-input-error :messages="$errors->get('bio')" />
                    </div>

                    <!-- Headshot -->
                    <div class="mb-4">
                        <x-input-label for="headshot" :value="__('Headshot')" />
                        <input id="headshot" type="file" name="headshot" class="block w-full mt-1" required />
                        <x-input-error :messages="$errors->get('headshot')" />
                    </div>

                    <!-- Work Images -->
                    @for ($i = 1; $i <= 3; $i++)
                        <div class="mb-4">
                            <x-input-label for="work_image{{ $i }}" :value="__('Work Photo ' . $i)" />
                            <input id="work_image{{ $i }}" type="file" name="work_image{{ $i }}" class="block w-full mt-1" required />
                            <x-input-error :messages="$errors->get('work_image'.$i)" />
                        </div>
                    @endfor

                    <!-- Pricing -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="min_price" :value="__('Minimum Price')" />
                            <input id="min_price" type="number" name="min_price" class="block w-full mt-1" min="1" required />
                            <x-input-error :messages="$errors->get('min_price')" />
                        </div>
                        <div>
                            <x-input-label for="max_price" :value="__('Maximum Price')" />
                            <input id="max_price" type="number" name="max_price" class="block w-full mt-1" required />
                            <x-input-error :messages="$errors->get('max_price')" />
                        </div>
                    </div>

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
