<!-- job source start -->

<section class="px-3 md:px-8 lg:px-12 my-10">

    <div class="flex flex-col lg:flex-row gap-8">

        <!-- Left Column -->
        <div class="w-full lg:w-1/2">
            <p class="text-[30px] font-bold text-gray-400 mb-2">
                Discover your Ideal <span class="text-black font-bold">Job or Resource</span> with us!
            </p>
            <p class="text-gray-700">
                We connect talented professionals with exciting career opportunities across various industries.
                Our comprehensive resources and job listings are tailored to help you find the perfect fit for
                your skills and aspirations.
            </p>

            <!-- Contact Info -->
            <div class="mt-6 flex flex-col gap-4">
                <!-- Email -->
                <div class="flex items-center space-x-3">
                    <div class="bg-gray-200 p-2 rounded-full text-gray-600">
                        <!-- Envelope Icon -->
                        <x-heroicon-o-envelope class="w-4 h-4 text-black" />

                    </div>
                    <span class="text-gray-800">job@career.edu.pk</span>
                </div>

                <!-- Phone -->
                <div class="flex items-center space-x-3">
                    <div class="bg-gray-200 p-2 rounded-full text-gray-600">
                        <!-- Phone Icon -->
                        <x-heroicon-o-phone class="w-4 h-4 text-black" />

                    </div>
                    <span class="text-gray-800">0314 4444010</span>
                </div>

                <!-- Website -->
                <div class="flex items-center space-x-3">
                    <div class="bg-gray-200 p-2 rounded-full text-gray-600">
                        <!-- Globe Icon -->
                        <x-heroicon-o-globe-alt class="w-4 h-4 text-black" />

                    </div>
                    <span class="text-gray-800">www.career.edu.pk</span>
                </div>

                <!-- WhatsApp -->

            </div>
        </div>

        <!-- Right Column - Resume Form -->
        <div class="w-full lg:w-1/2 bg-white shadow-lg rounded-lg p-6">
            <div>
                <p class="text-sm font-bold text-white bg-gradient-to-r from-green-500 to-cyan-600 inline-block px-4 py-2 rounded mb-4">
                    Submit Resume
                </p>
                <form action="{{ route('store.job-placement') }}" enctype="multipart/form-data" method="post" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <input type="text" name="name" placeholder="Full Name" required
                            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-cyan-500">
                        <input type="email" name="email" placeholder="Email Address" required
                            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-cyan-500">
                        <input type="number" name="number" placeholder="Contact Number" required
                            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-cyan-500">
                        <input type="text" name="city" placeholder="Postal Address" required
                            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-cyan-500">
                        <input type="text" name="education" placeholder="Qualification" required
                            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-cyan-500">
                        <input type="file" name="file" required
                            class="w-full border border-gray-300 rounded px-3 py-2 bg-white file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:bg-cyan-600 file:text-white hover:file:bg-cyan-700">
                    </div>
                    <button type="submit"
                        class="mt-4 bg-gradient-to-r from-green-500 to-cyan-600 text-white px-6 py-2 rounded-full hover:shadow-md transition">
                        Submit
                    </button>
                </form>
            </div>
        </div>

    </div>

</section>

<!-- job source end -->