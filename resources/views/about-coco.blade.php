<x-layout>
    <style>
        /* General Styling */
        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Cormorant Garamond', serif;
            color: #f7ebcb;
            background-color: #121a26; /* Dark background for contrast */
        }

        /* Section Styling */
        .section {
            padding: 60px 20px;
            text-align: center;
        }

        .section-header {
            background-color: #121a26;
            /* background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
                url('/images/banner.jpg') no-repeat center center/cover; */
            color: #f7ebcb;
            height: 100vh; /* Full viewport height */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .section-header h1 {
            font-size: 4rem;
            margin-bottom: 1rem;
            text-shadow: 0 4px 6px rgba(0, 0, 0, 0.5);
        }

        .section-header p {
            font-size: 1.5rem;
            line-height: 1.8;
            max-width: 900px;
            margin: 0 auto;
        }

        .section-board {
            /* background-color:dark-tahini; */
            /* background-color: #121a26; */
            background-color:rgb(14, 14, 15);
        }

        /* Board Members Styling */
        .board-members {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
            padding: 60px 20px;
        }

        .board-member {
           
            background-color: #121a26;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .board-member:hover {
            transform: translateY(-10px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
        }

        .board-member img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 15px;
            border: 4px solid #f7ebcb;
        }

        .board-member h3 {
            font-size: 1.8rem;
            margin: 10px 0;
            color:rgb(218, 190, 107);
        }

        .board-member p {
            font-size: 1.2rem;
            margin: 0;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .section-header h1 {
                font-size: 3rem;
            }

            .section-header p {
                font-size: 1.2rem;
            }

            .board-member img {
                width: 120px;
                height: 120px;
            }

            .board-member h3 {
                font-size: 1.4rem;
            }

            .board-member p {
                font-size: 1rem;
            }
        }
    </style>

    <!-- Header Section -->
    <div class="section section-header">
        <h1>The Coily Curly Office</h1>
        <p>The Coily Curly Office seeks to promote a healthy love of kinky/coily and curly hair in an environment where people learn to care for their God-given hair. We not only aim to provide tools needed to care for coily and curly hair—primarily through workshops—but to create a network between students and local salons for cheaper hair care services. It is our desire that people leave a little bit more confident about the beauty of coils and curls and are equipped to teach others around them.</p>
    </div>

    <!-- Board Members Section -->
    <div class="section section-board">
        <h2 class="text-3xl font-bold mb-6">Board Members</h2>
        <div class="board-members">
            <!-- Co-President 1 -->
            <div class="board-member">
                <img src="{{ asset('images/board-headshots/zaneta.jpg') }}" alt="Zaneta Otoo">
                <h3>Zaneta Otoo</h3>
                <p>Co-President</p>
            </div>

            <!-- Co-President 2 -->
            <div class="board-member">
                <img src="{{ asset('images/board-headshots/nana.jpg') }}" alt="Nana Akua Annoh-Quarshie">
                <h3>Nana Akua Annoh-Quarshie</h3>
                <p>Co-President</p>
            </div>

            <!-- Treasurer -->
            <div class="board-member">
                <img src="{{ asset('images/board-headshots/getrude.jpg') }}" alt="Getrude Jeruto">
                <h3>Getrude Jeruto</h3>
                <p>Treasurer</p>
            </div>

            <!-- Communications 1 -->
            <div class="board-member">
                <img src="{{ asset('images/board-headshots/aileen.jpeg') }}" alt="Aileen Siele">
                <h3>Aileen Siele</h3>
                <p>Communications</p>
            </div>

            <!-- Communications 2 -->
            <div class="board-member">
                <img src="{{ asset('images/board-headshots/vimbisai.jpg') }}" alt="Vimbisai Basvi">
                <h3>Vimbisai Basvi</h3>
                <p>Communications</p>
            </div>

            <!-- Equipment Manager -->
            <div class="board-member">
                <img src="{{ asset('images/board-headshots/yasmina.png') }}" alt="Yasmina">
                <h3>Yasmina</h3>
                <p>Equipment Manager</p>
            </div>

            <!-- Publicity -->
            <div class="board-member">
                <img src="{{ asset('images/board-headshots/daheun.jpg') }}" alt="Daheun Oh">
                <h3>Daheun Oh</h3>
                <p>Publicity</p>
            </div>

            <!-- Secretary -->
            <div class="board-member">
                <img src="{{ asset('images/board-headshots/yasmeen.jpg') }}" alt="Yasmeen Adeleke">
                <h3>Yasmeen Adeleke</h3>
                <p>Secretary</p>
            </div>

            <!-- Outreach -->
            <div class="board-member">
                <img src="{{ asset('images/board-headshots/brenda.jpeg') }}" alt="Brenda Cherotich">
                <h3>Brenda Cherotich</h3>
                <p>Outreach</p>
            </div>
        </div>
    </div>
</x-layout>
