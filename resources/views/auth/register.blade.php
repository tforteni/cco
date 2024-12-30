<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" class="text-tahini font-semibold" />
            <x-text-input id="name" class="block mt-1 w-full bg-light-navy border-dark-tahini text-tahini" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" class="text-tahini font-semibold" />
            <x-text-input id="email" class="block mt-1 w-full bg-light-navy border-dark-tahini text-tahini" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-tahini font-semibold" />

            <x-text-input id="password" class="block mt-1 w-full bg-light-navy border-dark-tahini text-tahini"
                          type="password"
                          name="password"
                          required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-tahini font-semibold" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full bg-light-navy border-dark-tahini text-tahini"
                          type="password"
                          name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Role Selection -->
        <div class="mt-4">
            <x-input-label for="role" :value="__('Register As')" class="text-tahini font-semibold" />
            <select id="role" name="role" class="block mt-1 w-full bg-light-navy border-dark-tahini text-tahini rounded-md">
                <option value="member" {{ old('role') === 'member' ? 'selected' : '' }}>Member</option>
                <option value="braider" {{ old('role') === 'braider' ? 'selected' : '' }}>Braider</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <!-- Submit Button -->
        <div class="flex items-center justify-end mt-4 text-tahini font-semibold">
            <a class="underline text-sm text-tahini hover:text-light-navy focus:ring-2 focus:ring-offset-2 focus:ring-tahini" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4 text-tahini font-semibold">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
