<x-guest-layout>
    <div class="text-center">
        <h2 class="text-2xl font-bold mb-4">Verify Your Email</h2>

        <p class="text-sm text-gray-300 leading-relaxed mb-6">
            Thanks for signing up! Please verify your email address by clicking the link we just sent.
            If you didn’t receive it, we can send another.
        </p>

        @if (session('status') === 'verification-link-sent')
            <div class="text-green-400 text-sm font-medium mb-4">
                A new verification link has been sent to your email.
            </div>
        @endif

        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <x-primary-button class="w-full sm:w-auto">
                    Resend Verification Email
                </x-primary-button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="text-sm text-gray-400 underline hover:text-tahini transition">
                    Log Out
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
