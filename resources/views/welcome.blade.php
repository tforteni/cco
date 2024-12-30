<x-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;700&display=swap');

        /* General page and section styling */
        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            font-family: 'Cormorant Garamond', serif; /* Global font family */
        }

        /* Section Styling */
        .section {
            min-height: 100vh; /* Set minimum height for sections */
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            position: relative;
            padding: 20px; /* Add padding for better spacing */
        }

        .section-1 {
            background-color: #121a26;
            color: #f7ebcb;
        }

        .section-2 {
            background: url('/images/photo1.jpg') no-repeat center center/cover;
            color: black;
        }

        .section-3 {
            background-color: #121a26;
            color: #f7ebcb;
        }

        .section-4 {
            background: url('/images/photo2.jpg') no-repeat center center/cover;
            color: #f7ebcb;
        }

        .section-5 {
            background-color: #121a26;
            /* background-color: #172336; Navy background */
            color: #f7ebcb;
            padding: 10px 20px;
        }

        /* Content Styling */
        .content {
            max-width: 80%;
            z-index: 2;
            padding: 0 20px; /* Add some horizontal padding for smaller screens */
        }

        .content h1, .content h3, .content p, .content a {
            font-family: 'Cormorant Garamond', serif; /* Apply font to all text elements */
        }

        .content h1 {
            font-size: 6rem;
            margin-bottom: 20px;
            font-weight: 700;
        }

        .content h3 {
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .content p {
            font-size: 2rem;
            margin-bottom: 30px;
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

        iframe {
            border: solid 1px #777;
            width: 100%;
            height: 700px;
            max-width: 1100px;
            margin: 0 auto;
        }

        @media (max-width: 768px) {
            .content h1 {
                font-size: 2.5rem; /* Reduce heading size */
                margin-bottom: 15px;
            }

            .content h3 {
                font-size: 1.5rem; /* Adjust h3 for smaller screens */
            }

            .content p {
                font-size: 1rem; /* Reduce paragraph text size */
                margin-bottom: 20px;
            }

            .content a {
                font-size: 1rem; /* Adjust button text size */
                padding: 8px 15px; /* Reduce button padding */
            }

            iframe {
                height: 500px; /* Adjust iframe height for smaller screens */
            }
        }
    </style>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Section 1: Welcome -->
        <div id="section-1" class="section section-1">
            <div class="content">
                <h3>WELCOME TO THE</h3>
                <h1>Coily Curly Office</h1>
                <p>Discover hairstyles, braiders, and a community of like-minded people!</p>
                <a href="/#">Explore More</a>
            </div>
        </div>

        <!-- Section 2: Find Braiders -->
        <div id="section-2" class="section section-2">
            <style>
                .section-2 {
                    position: relative;
                    background: url('/images/photo1.jpg') no-repeat center center/cover;
                    color: black;
                }

                /* Add an overlay */
                .section-2::before {
                    content: '';
                    position: absolute;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background-color: rgba(223, 142, 36, 0.5); /* Black overlay with 50% opacity */
                    z-index: 1;
                }

                /* Ensure the content appears above the overlay */
                .section-2 .content {
                    position: relative;
                    z-index: 2;
                }
            </style>
            <div class="content">
                <h1>Find Braiders Near You</h1>
                <p>Locate braiders on your campus with ease.</p>
                <a href="/braiders">Find Braiders</a>
            </div>
        </div>


        <!-- Section 3: Become an Ambassador -->
         <!-- remove this section for now -->
        <!-- <div id="section-3" class="section section-3">
            <div class="content">
                <h1>Become a Student Ambassador</h1>
                <p>Join us and represent the Coily Curly Office in your community.</p>
                <a href="/ambassadors">Learn More</a>
            </div>
        </div> -->

        <!-- Section 4: Events -->
        <div id="section-4" class="section section-4">
            <style>
                .section-4 {
                    position: relative;
                    background: url('/images/photo2.jpg') no-repeat center center/cover;
                    color:rgb(19, 15, 2); /* Adjust text color for better contrast */
                }

                /* Add an overlay */
                .section-4::before {
                    content: '';
                    position: absolute;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background-color: rgba(142, 134, 134, 0.5); /* Black overlay with 40% opacity */
                    z-index: 1;
                }

                /* Ensure the content appears above the overlay */
                .section-4 .content {
                    position: relative;
                    z-index: 2;
                }
            </style>
            <div class="content">
                <h1>Upcoming Events</h1>
                <p>Stay up-to-date with our latest events and gatherings.</p>
                <a href="#calendar">View Calendar</a>
            </div>
        </div>


        <!-- Section 5: Calendar -->
        <div id="calendar" class="section section-5">
            <div class="content">
                <h1 class="text-4xl font-bold mb-10">CoCO Events Calendar</h1>
                <iframe src="https://calendar.google.com/calendar/embed?height=600&wkst=1&ctz=America%2FNew_York&showPrint=0&src=ODllYWNiYzdhOTI1ZTE5ZmQ0MDkyM2RjOTE3OGVhN2UwMWRjZDlhYjNiODBlMWRmODQ1MmVjZTc4OWQwNTk2ZEBncm91cC5jYWxlbmRhci5nb29nbGUuY29t&color=%23616161" frameborder="0" scrolling="no"></iframe>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // Smooth scrolling for anchor links
            document.querySelectorAll("a[href^='#']").forEach(anchor => {
                anchor.addEventListener("click", function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute("href"));
                    if (target) {
                        target.scrollIntoView({ behavior: "smooth" });
                    }
                });
            });
        });
    </script>
</x-layout>
