<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GenAI Hairstyle Recommender</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Select2 CSS & JS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-100 text-gray-900 font-sans">
<div class="max-w-4xl mx-auto py-10 px-4">
    <h1 class="text-3xl font-bold mb-10 text-center">🎀 GenAI Hairstyle Recommender 🎀</h1>

    <!-- Get Suggestion -->
    <div class="bg-white p-6 rounded-lg shadow mb-10">
        <h2 class="text-xl font-semibold mb-4">Get a Suggestion</h2>
        <select id="approach" class="select2 w-full border rounded p-2">
            <option value="A">Approach A</option>
            <option value="B">Approach B</option>
            <option value="C">Approach C</option>
        </select>
        <button onclick="getSuggestion()" class="mt-4 bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Get Suggestion</button>
        <div id="output" class="mt-4 whitespace-pre-line text-sm text-gray-800"></div>
    </div>

    <!-- Compare Suggestions -->
    <div class="bg-white p-6 rounded-lg shadow mb-10">
        <h2 class="text-xl font-semibold mb-4">Compare Two Approaches</h2>
        <div class="grid grid-cols-2 gap-4">
            <select id="compare-1" class="select2 w-full border rounded p-2">
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
            </select>
            <select id="compare-2" class="select2 w-full border rounded p-2">
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
            </select>
        </div>
        <button onclick="compareApproaches()" class="mt-4 bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700">Compare Suggestions</button>
        <div id="comparison-results" class="mt-4 space-y-4 text-sm text-gray-800"></div>
    </div>

    <!-- Feedback -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-semibold mb-4">Submit Feedback</h2>
        <div class="grid grid-cols-2 gap-4">
		<div>
			<label for="winner" class="block mb-2 font-medium text-gray-700">Winner (Preferred Approach):</label>
			<select id="winner" class="select2 w-full border rounded p-2">
				<option value="A">A</option>
				<option value="B">B</option>
				<option value="C">C</option>
			</select>
		</div>
		<div>
			<label for="loser" class="block mb-2 font-medium text-gray-700">Loser (Less Preferred Approach):</label>
			<select id="loser" class="select2 w-full border rounded p-2">
				<option value="A">A</option>
				<option value="B">B</option>
				<option value="C">C</option>
			</select>
		</div>

        <button onclick="submitFeedback()" class="mt-4 bg-pink-600 text-white px-4 py-2 rounded hover:bg-pink-700">Submit Feedback</button>
        <div id="feedback-confirm" class="mt-4 text-green-600 font-semibold"></div>
		<div id="feedback-result" class="mt-4 text-sm text-gray-800"></div>

    </div>
</div>

<script>
    $(document).ready(() => {
        $('.select2').select2();
        getSuggestion();  // Automatically show suggestion for Approach A
    });

    function getSuggestion() {
        const approach = document.getElementById('approach').value;
        fetch(`/genai-style-suggestion?approach=${approach}`)
            .then(res => res.json())
            .then(data => document.getElementById('output').innerText = data.response || 'No response.');
    }

    function compareApproaches() {
        const a1 = document.getElementById('compare-1').value;
        const a2 = document.getElementById('compare-2').value;
        fetch(`/genai-style-suggestion?compare=true&approach1=${a1}&approach2=${a2}`)
            .then(res => res.json())
            .then(data => {
                document.getElementById('comparison-results').innerHTML = `
                    <div><strong>Approach ${data.id1}:</strong><br>${data.response1}</div>
                    <div><strong>Approach ${data.id2}:</strong><br>${data.response2}</div>`;
            });
    }

    function submitFeedback() {
        const winner = document.getElementById('winner').value;
        const loser = document.getElementById('loser').value;

        fetch('/genai-style-feedback', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ winner, loser })
        })
        .then(res => res.json())
        .then(data => {
            const resultDiv = document.getElementById('feedback-result');
            if (data.success) {
                let scoresHtml = '<h3 class="text-lg font-semibold mt-4 text-green-700">ELO Scores Updated:</h3><ul class="list-disc ml-6">';
                for (const [approach, score] of Object.entries(data.scores)) {
                    scoresHtml += `<li><strong>Approach ${approach}:</strong> ${score}</li>`;
                }
                scoresHtml += '</ul>';
                resultDiv.innerHTML = `<p class="text-green-600 font-medium"> Feedback submitted and ELO scores updated!</p>${scoresHtml}`;
            } else {
                resultDiv.innerHTML = `<p class="text-red-600 font-medium"> Failed to update ELO scores.</p>`;
            }
        });
    }
</script>
</body>
</html>
