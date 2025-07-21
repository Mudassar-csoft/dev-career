<section
    class="bg-cover bg-center bg-no-repeat text-white bg-fixed relative mx-3 md:mx-7 lg:mx-12 px-3 md:px-8 lg:px-10 py-5 sm:py-0 md:py-7 lg:py-10 my-5 lg:my-10"
    style="background-image: url('/assets/img/backgrounds/Building-Wallpaper.jpg')">

    <!-- Dark overlay -->

    <div class="absolute inset-0 bg-black/50"></div>

    <div class="w-full md:w-full mx-auto h-full relative z-10">

        <div class="flex flex-col gap-4 md:gap-5 lg:gap-6">

            <!-- Heading -->

            <div class="flex flex-col items-center justify-center">
                <h2 class="text-3xl font-semibold">
                    Become a <span class="font-black">Partner</span>
                </h2>
                <h4 class="text-md">Get Franchise</h4>
            </div>

            <!-- Form -->

            <div class="">
                <form method="POST" action="{{ route('partner.store') }}">
                    @csrf

                    <!-- Input Fields Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

                        <!-- Full Name -->
                        <div class="flex items-center bg-white border px-3 py-2 border-gray-600">
                            <x-heroicon-o-user class="w-5 h-5 text-gray-700 mr-2" />
                            <input
                                type="text"
                                name="name"
                                value="{{ old('name') }}"
                                placeholder="Full Name"
                                required
                                class="w-full text-gray-700 border-none focus:outline-none" />
                        </div>
                        @error('name')
                        <div class="text-red-400 text-sm col-span-full">{{ $message }}</div>
                        @enderror

                        <!-- Contact Number -->
                        <div class="flex items-center bg-white border px-3 py-2 border-gray-600">
                            <x-heroicon-o-phone class="w-5 h-5 text-gray-700 mr-2" />
                            <input
                                type="text"
                                name="number"
                                oninput="validateInput(this)"
                                value="{{ old('number') }}"
                                placeholder="Contact No"
                                required
                                class="w-full text-gray-700 border-none focus:outline-none" />
                        </div>
                        @error('number')
                        <div class="text-red-400 text-sm col-span-full">{{ $message }}</div>
                        @enderror

                        <!-- Email -->
                        <div class="flex items-center bg-white border px-3 py-2 border-gray-600">
                            <x-heroicon-o-envelope class="w-5 h-5 text-gray-700 mr-2" />
                            <input
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="Email Address"
                                required
                                class="w-full text-gray-700 border-none focus:outline-none" />
                        </div>
                        @error('email')
                        <div class="text-red-400 text-sm col-span-full">{{ $message }}</div>
                        @enderror

                        <!-- City -->
                        <div class="flex items-center bg-white border px-3 py-2 border-gray-600">
                            <x-heroicon-o-globe-alt class="w-5 h-5 text-gray-700 mr-2" />
                            <input
                                type="text"
                                name="city"
                                value="{{ old('city') }}"
                                placeholder="City Interested"
                                required
                                class="w-full text-gray-700 border-none focus:outline-none" />
                        </div>
                        @error('city')
                        <div class="text-red-400 text-sm col-span-full">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Description Textarea -->
                    <div class="mt-6">
                        <textarea
                            name="discription"
                            rows="4"
                            placeholder="Describe partnership opportunity .."
                            class="w-full bg-white border border-gray-700 text-gray-800  p-3 focus:outline-none">{{ old('discription') }}</textarea>
                        @error('discription')
                        <div class="text-red-400 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="text-center mt-6">
                        <button
                            type="submit"
                            class="bg-[#ef5922] hover:bg-[#d74f1f] transition duration-300 text-white font-semibold px-6 py-2 rounded-full">
                            Submit
                        </button>
                    </div>
                </form>
            </div>

        </div>
        
    </div>

</section>