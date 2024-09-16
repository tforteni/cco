<x-layout>
    <div class="max-w-7xl mx-auto py-12">
        <!-- Image with Text on Top -->
        <div class="relative h-96">
            <img src="{{ asset('images/LOGO.JPEG') }}" alt="Mission Image" class="object-cover h-full w-full rounded-lg shadow-lg">
            
            <!-- Text overlay directly on top of the image -->
            <div class="absolute inset-0 flex flex-col justify-center items-start p-12">
                <h1 class="text-5xl font-bold text-tahini">The Coily Curly Office</h1>
                <p class="text-lg text-tahini mt-4 leading-relaxed">
                    We are committed to promoting the love and care of coily and curly hair by fostering a community where students can learn, practice, and embrace their natural hair with confidence.
                </p>
            </div>
        </div>

        <!-- Mission and Goals Section -->
        <div class="flex flex-col md:flex-row mt-12 space-y-6 md:space-y-0 md:space-x-8">
            <!-- Left: Mission -->
            <div class="flex-1">
                <h2 class="text-4xl font-bold text-navy">Our Mission</h2>
                <div class="flex items-start space-x-4 mt-4">
                    <div class="bg-tahini p-2 rounded-full">
                        <i class="fas fa-bullseye text-dark-tahini text-3xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-tahini">Our Mission</h3>
                        <p class="text-tahini">
                            Our mission is to promote a healthy love of kinky/coily and curly hair, while providing opportunities for students to connect, practice, and build a community.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Right: Goals -->
            <div class="flex-1">
                <h2 class="text-4xl font-bold text-navy">Our Goals</h2>
                <div class="flex items-start space-x-4 mt-4">
                    <div class="bg-tahini p-2 rounded-full">
                        <i class="fas fa-gem text-dark-tahini text-3xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-tahini">Our Goals</h3>
                        <p class="text-tahini">
                            Empower students with skills, foster a welcoming community, and create accessible, affordable platforms for hair care and styling.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Board Members Section -->
        <div class="mt-12">
            <h2 class="text-4xl font-bold text-navy text-center mb-8">Board Members</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
                <!-- Co-President 1 -->
                <div class="text-center">
                    <img src="{{ asset('images/member1.jpg') }}" alt="Board Member 1" class="w-32 h-32 rounded-full mx-auto mb-4 border-2 border-dark-tahini">
                    <h3 class="text-xl font-semibold text-tahini">Zaneta Otoo</h3>
                    <p class="text-tahini">Co-President</p>
                </div>

                <!-- Co-President 2 -->
                <div class="text-center">
                    <img src="{{ asset('images/member2.jpg') }}" alt="Board Member 2" class="w-32 h-32 rounded-full mx-auto mb-4 border-2 border-dark-tahini">
                    <h3 class="text-xl font-semibold text-tahini">Nana Akua Annoh-Quarshie</h3>
                    <p class="text-tahini">Co-President</p>
                </div>

                <!-- Treasurer -->
                <div class="text-center">
                    <img src="{{ asset('images/member3.jpg') }}" alt="Board Member 3" class="w-32 h-32 rounded-full mx-auto mb-4 border-2 border-dark-tahini">
                    <h3 class="text-xl font-semibold text-tahini">Getrude Jeruto</h3>
                    <p class="text-tahini">Treasurer</p>
                </div>

                <!-- Communications 1 -->
                <div class="text-center">
                    <img src="{{ asset('images/member4.jpg') }}" alt="Board Member 4" class="w-32 h-32 rounded-full mx-auto mb-4 border-2 border-dark-tahini">
                    <h3 class="text-xl font-semibold text-tahini">Aileen Siele</h3>
                    <p class="text-tahini">Communications</p>
                </div>

                <!-- Communications 2 -->
                <div class="text-center">
                    <img src="{{ asset('images/member5.jpg') }}" alt="Board Member 5" class="w-32 h-32 rounded-full mx-auto mb-4 border-2 border-dark-tahini">
                    <h3 class="text-xl font-semibold text-tahini">Vimbisai Basvi</h3>
                    <p class="text-tahini">Communications</p>
                </div>

                <!-- Equipment Manager -->
                <div class="text-center">
                    <img src="{{ asset('images/member6.jpg') }}" alt="Board Member 6" class="w-32 h-32 rounded-full mx-auto mb-4 border-2 border-dark-tahini">
                    <h3 class="text-xl font-semibold text-tahini">Yasmina</h3>
                    <p class="text-tahini">Equipment Manager</p>
                </div>

                <!-- Publicity -->
                <div class="text-center">
                    <img src="{{ asset('images/member7.jpg') }}" alt="Board Member 7" class="w-32 h-32 rounded-full mx-auto mb-4 border-2 border-dark-tahini">
                    <h3 class="text-xl font-semibold text-tahini">Daheun Oh</h3>
                    <p class="text-tahini">Publicity</p>
                </div>

                <!-- Secretary -->
                <div class="text-center">
                    <img src="{{ asset('images/member8.jpg') }}" alt="Yasmeen Adeleke" class="w-32 h-32 rounded-full mx-auto mb-4 border-2 border-dark-tahini">
                    <h3 class="text-xl font-semibold text-tahini">Yasmeen Adeleke</h3>
                    <p class="text-tahini">Secretary</p>
                </div>

                <!-- Outreach -->
                <div class="text-center">
                    <img src="{{ asset('images/member9.jpg') }}" alt="Board Member 9" class="w-32 h-32 rounded-full mx-auto mb-4 border-2 border-dark-tahini">
                    <h3 class="text-xl font-semibold text-tahini">Brenda Cherotich</h3>
                    <p class="text-tahini">Outreach</p>
                </div>
            </div>
        </div>

    </div>
</x-layout>
