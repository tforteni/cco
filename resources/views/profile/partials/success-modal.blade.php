@if (session('message') || session('status'))
    <div id="successModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
            <p class="text-lg text-green-700 dark:text-green-300 font-semibold">
                {{ session('message') ?? session('status') }}
            </p>
            <button onclick="closeModal()" class="mt-4 px-6 py-2 bg-blue-500 text-white rounded-lg">
                OK
            </button>
        </div>
    </div>
@endif
