<form method="POST" action="{{ route('braider.updateProfile') }}" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @method('PATCH')

    <div>
        <x-input-label for="role" :value="__('Your Role')" />
        <select id="role" name="role" class="form-input mt-1 block w-full bg-gray-900 text-tahini">
            <option value="member" {{ auth()->user()->role === 'braider' ? 'disabled' : (auth()->user()->role === 'member' ? 'selected' : '') }}>
                {{ __('Member') }}
            </option>
            <option value="braider" {{ auth()->user()->role === 'braider' ? 'selected' : '' }}>
                {{ __('Braider') }}
            </option>
        </select>
    </div>

    <div id="braider-fields" class="{{ auth()->user()->role !== 'braider' ? 'hidden' : '' }}">
        <h3 class="text-md font-semibold text-tahini">
            {{ __('Braider Information') }}
        </h3>

        <div>
            <x-input-label for="bio" :value="__('Bio')" />
            <x-textarea id="bio" name="bio" rows="5">
                {{ old('bio', auth()->user()->braider->bio ?? '') }}
            </x-textarea>
            <x-input-error class="mt-2" :messages="$errors->get('bio')" />
        </div>

        <div>
            <x-input-label for="headshot" :value="__('Headshot')" />
            <x-text-input id="headshot" name="headshot" type="file" class="mt-1 block w-full bg-gray-900 text-tahini" />
            <x-input-error class="mt-2" :messages="$errors->get('headshot')" />
        </div>

        <div>
            <x-input-label for="min_price" :value="__('Minimum Price')" />
            <x-text-input id="min_price" name="min_price" type="number" class="mt-1 block w-full text-tahini"
                            :value="old('min_price', auth()->user()->braider->min_price ?? '')" />
            <x-input-error class="mt-2" :messages="$errors->get('min_price')" />
        </div>

        <div>
            <x-input-label for="max_price" :value="__('Maximum Price')" />
            <x-text-input id="max_price" name="max_price" type="number" class="mt-1 block w-full text-tahini"
                            :value="old('max_price', auth()->user()->braider->max_price ?? '')" />
            <x-input-error class="mt-2" :messages="$errors->get('max_price')" />
        </div>

        <div>
            <x-input-label for="specialties" :value="__('Select Specialties')" />
            <select id="specialties" name="specialties[]" multiple class="form-input mt-1 block w-full bg-gray-900 text-tahini border-gray-700">
                @foreach(App\Models\Specialty::all() as $specialty)
                    <option value="{{ $specialty->id }}" {{ auth()->user()->braider && auth()->user()->braider->specialties->contains($specialty->id) ? 'selected' : '' }}>
                        {{ $specialty->name }}
                    </option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('specialties')" />

            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    new TomSelect("#specialties", {
                        create: false,
                        plugins: ['remove_button'],
                        placeholder: "Select specialties...",
                    });
                });
            </script>
        </div>
    </div>

    <div class="pt-4">
        <x-primary-button class="w-full">
            {{ __('Save Changes') }}
        </x-primary-button>
    </div>
</form>
