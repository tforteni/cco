<x-layout>
    <style>
        .section-header {
            background-color: #121a26;
            color: #f7ebcb;
            min-height: 80vh; /* Ensures adequate height on all screens */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 20px;
        }

        .section-header h1 {
            font-size: 3.5rem; /* Optimized for large screens */
            margin-bottom: 1rem;
            text-shadow: 0 4px 6px rgba(0, 0, 0, 0.5);
        }

        .section-header p {
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            max-width: 800px;
            line-height: 1.8;
        }

        .content a {
            font-size: 1.2rem;
            color: #f7ebcb;
            text-decoration: none;
            padding: 10px 20px;
            border: 2px solid #f7ebcb;
            border-radius: 5px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .content a:hover {
            background-color: #f7ebcb;
            color: #333;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .section-header {
                min-height: 60vh; /* Adjusted for smaller screens */
                padding: 40px 20px; /* Add padding for better spacing */
            }

            .section-header h1 {
                font-size: 2.5rem;
            }

            .section-header p {
                font-size: 1rem; 
                line-height: 1.6;
                margin-bottom: 1rem;
            }

            .content a {
                font-size: 1rem; 
                padding: 8px 15px; 
            }
        }
    </style>

    <!-- Header Section -->
    <div class="section-header">
        <h1>Meet Our Braiders!</h1>
        <p>Discover the talented braiders who are part of our community. Each braider brings their unique style and expertise to create beautiful hairstyles just for you.</p>
        
        <!-- Searchable Hairstyle Filter -->
        <div class="px-4 py-6 bg-[#0d1725] text-[#f7ebcb] text-center">
            <h2 class="text-xl font-semibold mb-4">What hairstyle are you looking for?</h2>
            <div class="flex justify-center relative">
                <input 
                    id="hairstyleSearch" 
                    type="text" 
                    placeholder="Type a hairstyle..." 
                    class="w-full max-w-md px-4 py-2 rounded border border-[#f7ebcb] bg-transparent text-[#f7ebcb] focus:outline-none"
                >
                <ul id="suggestions" class="absolute top-full left-0 w-full max-w-md bg-white text-black rounded shadow-lg mt-1 hidden z-50"></ul>
            </div>
        </div>



        <p>Would you like to become an affiliated braider?</p>
        <div class="content">
            <a href="{{ url('/profile#role-management') }}" class="text-indigo-600 hover:underline font-semibold">
                Become an Affiliated Braider
            </a>
        </div>
    </div>

    <!-- Braiders Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 px-4" id="braiderList" style="font-family: 'Cormorant Garamond', serif; background-color: rgb(5, 15, 29); margin-top: 0;">
        @foreach($braiders as $braider)
            <x-braider-card :braider="$braider" />
        @endforeach
    </div>
</x-layout>

<!-- Global Styles -->
<style>
    body {
        font-family: 'Cormorant Garamond', serif !important;
        margin: 0; /* Ensure no body margin affects layout */
    }

    .grid {
        padding-top: 20px; /* Add space above the grid for better spacing */
    }

    /* Responsive Grid Adjustments */
    @media (max-width: 768px) {
        .grid {
            padding: 0 10px; /* Adjust grid padding for smaller screens */
        }
    }
</style>

<script>
    const input = document.getElementById('hairstyleSearch');
    const suggestions = document.getElementById('suggestions');

    input.addEventListener('input', function () {
        const query = this.value;

        if (query.length < 1) {
            suggestions.innerHTML = '';
            suggestions.classList.add('hidden');
            return;
        }

        fetch(`/specialty-suggestions?q=${query}`)
            .then(response => response.json())
            .then(data => {
                suggestions.innerHTML = '';
                if (data.length === 0) {
                    suggestions.classList.add('hidden');
                    return;
                }

                data.forEach(item => {
                    const li = document.createElement('li');
                    li.textContent = item.name;
                    li.classList.add('cursor-pointer', 'hover:bg-gray-200', 'px-4', 'py-2');
                    li.addEventListener('click', () => {
                        input.value = item.name;
                        suggestions.innerHTML = '';
                        suggestions.classList.add('hidden');
                        fetchBraiders(item.id);
                        console.log("Selected specialty ID:", item.id);

                    });
                    suggestions.appendChild(li);
                });

                suggestions.classList.remove('hidden');
            });
    });

    function fetchBraiders(specialtyId) {
        fetch("{{ route('braiders.filter') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ specialties: [specialtyId] })
        })
        .then(res => res.json())
        .then(data => {
            document.getElementById('braiderList').innerHTML = data.html;
        });
    }
</script>
