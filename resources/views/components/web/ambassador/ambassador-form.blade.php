<div class="px-3 md:px-7 lg:px-12 flex flex-col gap-2 md:gap-4">

    <div class="flex flex-col gap-1 ">
        <h1 class="text-2xl md:text-2xl lg:text-4xl  font-bold">Become Ambassador</h1>
        <div class="w-20 h-[2px] bg-gradient-to-r from-[#2BA6AF] to-[#61C27C]"></div>
    </div>

    <p class="text-lg sm:text-xl">Fill the form below to avail this opportunity</p>

    <div class="flex flex-col lg:flex-row  overflow-hidden justify-between gap-5">

        <div class="lg:w-1/2  flex flex-col gap-2 md:gap-5">

            <p class="text-gray-500 text-lg sm:text-2xl font-bold">
                We are Future of <span class="text-gray-800">Tech Education</span>
            </p>

            <p class="">
                Joining an Institute Ambassadors Program offers numerous benefits that can significantly enhance personal and professional growth.
            </p>

            <div class="flex flex-col sm:flex-row gap-5 ">
                <div class="flex items-center sm:w-1/2">
                    <div class="w-12 h-12 sm:w-16 sm:h-16 bg-gray-800 rounded-xl flex items-center justify-center mr-4">
                        <img src="{{ asset('Web/assets/img/icons/v692_1096.png') }}" class="w-8 h-8 sm:w-10 sm:h-10" alt="Call Icon">
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm sm:text-base font-semibold">Call Us</p>
                        <p class="text-gray-600 text-xs sm:text-sm">0341-4444010</p>
                        <p class="text-gray-600 text-xs sm:text-sm">0314-4444010</p>
                    </div>
                </div>
                <div class="flex items-center sm:w-1/2">
                    <div class="w-12 h-12 sm:w-16 sm:h-16 bg-gray-800 rounded-xl flex items-center justify-center mr-4">
                        <img src="{{ asset('Web/assets/img/icons/v692_1094.png') }}" class="w-8 h-8 sm:w-10 sm:h-10" alt="Email Icon">
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm sm:text-base font-semibold ">Email</p>
                        <p class="text-gray-600 text-xs sm:text-sm ">info@career.edu.pk</p>
                    </div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-5 ">
                <div class="flex items-center sm:w-1/2">
                    <div class="w-12 h-12 sm:w-16 sm:h-16 bg-gray-800 rounded-xl flex items-center justify-center mr-4">
                        <img src="{{ asset('Web/assets/img/icons/v692_1079.png') }}" class="w-10 h-10 sm:w-12 sm:h-12" alt="Webex Icon">
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm sm:text-base font-semibold mb-0">Webex Meetings</p>
                        <p class="text-gray-600 text-xs sm:text-sm mb-0">Career.pk</p>
                    </div>
                </div>
                <div class="flex items-center sm:w-1/2">
                    <div class="w-12 h-12 sm:w-16 sm:h-16 bg-gray-800 rounded-xl flex items-center justify-center mr-4">
                        <img src="{{ asset('Web/assets/img/icons/v692_1095.png') }}" class="w-8 h-8 sm:w-10 sm:h-10" alt="Clock Icon">
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm sm:text-base font-semibold mb-0">Office Hours</p>
                        <p class="text-gray-600 text-xs sm:text-sm mb-0">Monday - Saturday</p>
                        <p class="text-gray-600 text-xs sm:text-sm mb-0">09:00am - 06:00pm</p>
                    </div>
                </div>
            </div>

        </div>

        <div class="lg:w-1/2 ">
            <form action="{{ route('store.ambassador') }}" enctype="multipart/form-data" method="post">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-y-2 md:gap-x-4">

                    <div class="flex">
                        <span class="bg-gray-800 text-white flex items-center justify-center px-3 py-2 rounded-l-md">
                            <x-heroicon-o-user class="w-5 h-5" />
                        </span>
                        <input type="text" name="name" required
                            class="flex-1 p-2 border border-gray-400 rounded-r-md focus:outline-none"
                            placeholder="Full Name">
                    </div>

                    <div class="flex">
                        <span class="bg-gray-800 text-white flex items-center justify-center px-3 py-2 rounded-l-md">
                            <x-heroicon-o-envelope class="w-5 h-5" />
                        </span>
                        <input type="email" name="email" required
                            class="flex-1 p-2 border border-gray-400 rounded-r-md focus:outline-none"
                            placeholder="Email Address">
                    </div>

                    <div class="flex">
                        <span class="bg-gray-800 text-white flex items-center justify-center px-3 py-2 rounded-l-md">
                            <x-heroicon-o-phone class="w-5 h-5" />
                        </span>
                        <input type="number" name="contact" required
                            class="flex-1 p-2 border border-gray-400 rounded-r-md focus:outline-none"
                            placeholder="Contact Number">
                    </div>

                    <div class="flex">
                        <span class="bg-gray-800 text-white flex items-center justify-center px-3 py-2 rounded-l-md">
                            <x-heroicon-o-globe-alt class="w-5 h-5" />
                        </span>
                        <input type="text" name="linkedin" required
                            class="flex-1 p-2 border border-gray-400 rounded-r-md focus:outline-none"
                            placeholder="Your Linked In Profile URL">
                    </div>

                    <div class="flex">
                        <span class="bg-gray-800 text-white flex items-center justify-center px-3 py-2 rounded-l-md">
                            <x-heroicon-o-academic-cap class="w-5 h-5" />
                        </span>
                        <input type="text" name="organization" required
                            class="flex-1 p-2 border border-gray-400 rounded-r-md focus:outline-none"
                            placeholder="College/University/Organization">
                    </div>

                    <div class="flex">
                        <span class="bg-gray-800 text-white flex items-center justify-center px-3 py-2 rounded-l-md">
                            <x-heroicon-o-book-open class="w-5 h-5" />
                        </span>
                        <input type="text" name="education" required
                            class="flex-1 p-2 border border-gray-400 rounded-r-md focus:outline-none"
                            placeholder="Qualification">
                    </div>

                    <div class="flex">
                        <span class="bg-gray-800 text-white flex items-center justify-center px-3 py-2 rounded-l-md">
                            <x-heroicon-o-map-pin class="w-5 h-5" />
                        </span>
                        <input type="text" name="city" required
                            class="flex-1 p-2 border border-gray-400 rounded-r-md focus:outline-none"
                            placeholder="Current City">
                    </div>

                    <div class="flex">
                        <span class="bg-gray-800 text-white flex items-center justify-center px-3 py-2 rounded-l-md">
                            <x-heroicon-o-arrow-up-on-square class="w-5 h-5" />
                        </span>
                        <input type="file" name="file" required
                            class="flex-1 p-1 border border-gray-400 rounded-r-md focus:outline-none"
                            placeholder="Upload Resume">
                    </div>

                    <!-- Submit button -->
                    <div class="flex justify-end px-4 py-4 md:translate-x-16 lg:translate-x-0">
                        <button type="submit"
                            class="px-6 py-2 rounded-full bg-gradient-to-r from-orange-600 to-yellow-500 text-white text-base font-semibold border-2 border-transparent shadow-md hover:shadow-none transition-all duration-200">
                            Submit
                        </button>
                    </div>

                </div>
            </form>
        </div>

    </div>

</div>
