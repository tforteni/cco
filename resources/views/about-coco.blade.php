<x-layout>
    <div class="max-w-7xl mx-auto">
        <!-- Image with Text on Top -->
        <div class="relative h-96">
            <!-- <img src="{{ asset('images/logo.JPEG') }}" alt="Mission Image" class="object-cover h-full w-full rounded-lg shadow-lg"> -->
            
            <!-- Text overlay directly on top of the image -->
            <div class="absolute inset-0 flex flex-col justify-center items-start p-12">
                <h1 class="text-5xl font-bold text-tahini">The Coily Curly Office</h1>
                <p class="text-lg text-tahini mt-4 leading-relaxed">
                    We are committed to promoting the love and care of coily and curly hair by fostering a community where students can learn, practice, and embrace their natural hair with confidence.
                </p>
            </div>
        </div>

        <!-- Mission and Goals Section -->
        <div class="flex flex-col md:flex-row space-y-6 md:space-y-0 md:space-x-8">
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
        <div class="mt-8 mb-12">
            <h2 class="text-4xl font-bold text-navy text-center mb-8">Board Members</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
                <!-- Co-President 1 -->
                <x-board-member :name="'Zaneta Otoo'" :role="'Co-President'" :image="'images/board-headshots/zaneta.jpg'"></x-board-member>

                <!-- Co-President 2 -->
                <x-board-member :name="'Nana Akua Annoh-Quarshie'" :role="'Co-President'" :image="'images/board-headshots/nana.jpg'"></x-board-member>

                <!-- Treasurer -->
                <x-board-member :name="'Getrude Jeruto'" :role="'Treasurer'" :image="'images/board-headshots/getrude.jpg'"></x-board-member>

                <!-- Communications 1 -->
                <x-board-member :name="'Aileen Siele'" :role="'Communications'" :image="'images/board-headshots/aileen.jpeg'"></x-board-member>

                <!-- Communications 2 -->
                <x-board-member :name="'Vimbisai Basvi'" :role="'Communications'" :image="'images/board-headshots/vimbisai.jpg'"></x-board-member>

                <!-- Equipment Manager -->
                <x-board-member :name="'Yasmina'" :role="'Equipment Manager'" :image="'images/board-headshots/yasmina.png'"></x-board-member>

                <!-- Publicity -->
                <x-board-member :name="'Daheun Oh'" :role="'Publicity'" :image="'images/board-headshots/daheun.jpg'"></x-board-member>

                <!-- Secretary -->
                <x-board-member :name="'Yasmeen Adeleke'" :role="'Secretary'" :image="'images/board-headshots/yasmeen.jpg'"></x-board-member>

                <!-- Outreach -->
                 <x-board-member :name="'Brenda Cherotich'" :role="'Outreach'" :image="'images/board-headshots/brenda.jpeg'"></x-board-member>
            </div>
        </div>

    </div>
</x-layout>
