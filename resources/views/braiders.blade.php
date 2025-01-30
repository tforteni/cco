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
        <p>Would you like to become an affiliated braider?</p>
        <div class="content">
            <a href="{{ url('/profile#role-management') }}" class="text-indigo-600 hover:underline font-semibold">
                Become an Affiliated Braider
            </a>
        </div>
    </div>

    <!-- Braiders Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 px-4" style="font-family: 'Cormorant Garamond', serif; background-color: rgb(5, 15, 29); margin-top: 0;">
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
