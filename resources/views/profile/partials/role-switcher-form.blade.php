
@if (auth()->user()->role !== 'braider')
    {{-- Show switch role form --}}
    <form method="POST" action="{{ route('profile.switchRole') }}" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
                @include('profile.partials.braider-manage-profile')
        </div>
        
    </form>
@else
    {{-- Already a braider, show message and link to manage braider profile --}}
    <div class="bg-gray-100 dark:bg-gray-800 p-6 rounded-lg shadow-md text-center">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">You are now a Braider</h2>
        <p class="text-gray-700 dark:text-gray-300 mb-4">
            You’ve successfully switched to a braider account. You cannot switch back to a member. You have access to all resources that are accessible to members.
        </p>
        <a href="{{ route('braider.manage') }}" class="text-tahini hover:underline">
            → Manage Braider Profile
        </a>
    </div>
@endif
