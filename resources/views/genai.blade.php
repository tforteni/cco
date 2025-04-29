@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-10 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold mb-8 text-center text-gray-800 dark:text-white">🎀 GenAI Hairstyle Recommender 🎀</h1>

    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg mb-10">
        <h2 class="text-2xl font-semibold mb-4">Get a Suggestion</h2>

        <form method="GET" action="/genai-style-suggestion" class="space-y-4">
            <div>
                <label for="approach" class="block mb-2 text-gray-700 dark:text-gray-300">Select Approach:</label>
                <select id="approach" name="approach" class="select2 w-full rounded-md">
                    <option value="A">Approach A</option>
                    <option value="B">Approach B</option>
                    <option value="C">Approach C</option>
                </select>
            </div>

            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                Get Suggestion
            </button>
        </form>
    </div>

    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg mb-10">
        <h2 class="text-2xl font-semibold mb-4">Compare Two Approaches</h2>

        <form method="GET" action="/genai-style-suggestion" class="space-y-4">
            <input type="hidden" name="compare" value="true">

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="approach1" class="block mb-2 text-gray-700 dark:text-gray-300">Approach 1:</label>
                    <select id="approach1" name="approach1" class="select2 w-full rounded-md">
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                    </select>
                </div>

                <div>
                    <label for="approach2" class="block mb-2 text-gray-700 dark:text-gray-300">Approach 2:</label>
                    <select id="approach2" name="approach2" class="select2 w-full rounded-md">
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                Compare Suggestions
            </button>
        </form>
    </div>

    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-semibold mb-4">Submit Feedback</h2>

        <form method="POST" action="/genai-style-feedback" class="space-y-4">
            @csrf

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="winner" class="block mb-2 text-gray-700 dark:text-gray-300">Winner Approach:</label>
                    <select id="winner" name="winner" class="select2 w-full rounded-md">
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                    </select>
                </div>

                <div>
                    <label for="loser" class="block mb-2 text-gray-700 dark:text-gray-300">Loser Approach:</label>
                    <select id="loser" name="loser" class="select2 w-full rounded-md">
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="px-4 py-2 bg-pink-600 text-white rounded-md hover:bg-pink-700">
                Submit Feedback
            </button>
        </form>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        $('.select2').select2();
    });
</script>

@endsection
