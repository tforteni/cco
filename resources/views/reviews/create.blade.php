<x-layout>
    <style>
        body {
            font-family: 'Cormorant Garamond', serif;
        }
    </style>

    <div class="max-w-2xl mx-auto pt-24 px-4 sm:px-6 lg:px-8 text-gray-900 dark:text-gray-100">
        <h2 class="text-3xl font-bold text-center mb-8">
            Leave a Review for {{ $appointment->braider->user->name }}
        </h2>

        @if (session('message'))
            <div class="bg-green-100 text-green-800 p-4 rounded mb-6">
                {{ session('message') }}
            </div>
        @endif

        <form method="POST" action="{{ route('reviews.store', $appointment) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Rating -->
            <div>
                <label for="rating" class="block text-lg font-medium">Rating (1 to 10)</label>
                <input type="number" name="rating" id="rating" min="1" max="10"
                    class="form-input mt-1 block w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 text-gray-900 bg-white"
                    required>

                @error('rating')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Comment -->
            <div>
                <label for="comment" class="block text-lg font-medium">Comment <span class="text-sm text-gray-400">(max 1000 characters)</span></label>
                
                <textarea name="comment" id="comment" rows="4" maxlength="1000"
                    class="form-input mt-1 block w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 text-gray-900 bg-white"
                    placeholder="Share your experience..." oninput="updateCharCount()"></textarea>

                <div class="text-sm text-gray-500 mt-1" id="charCount">1000 characters remaining</div>

                @error('comment')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Media Uploads -->
            <div>
                <label class="block text-lg font-medium">Upload up to 3 images (optional)</label>
                <div class="space-y-3 mt-3">
                    <input type="file" name="media1" class="form-input w-full rounded-lg border-gray-300 text-gray-900 bg-white">
                    <input type="file" name="media2" class="form-input w-full rounded-lg border-gray-300 text-gray-900 bg-white">
                    <input type="file" name="media3" class="form-input w-full rounded-lg border-gray-300 text-gray-900 bg-white">
                </div>

                @foreach (['media1', 'media2', 'media3'] as $field)
                    @error($field)
                        <span class="text-red-500 text-sm block mt-1">{{ $message }}</span>
                    @enderror
                @endforeach
            </div>

            <!-- Submit -->
            <div class="flex justify-end">
                <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                    Submit Review
                </button>
            </div>
        </form>
    </div>
<script>
    function updateCharCount() {
        const textarea = document.getElementById('comment');
        const counter = document.getElementById('charCount');
        const remaining = 1000 - textarea.value.length;
        counter.textContent = `${remaining} characters remaining`;
    }

    // Initialize on page load in case there's old input
    document.addEventListener('DOMContentLoaded', updateCharCount);
</script>

</x-layout>
