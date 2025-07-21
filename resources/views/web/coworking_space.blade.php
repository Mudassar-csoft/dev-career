@extends('layouts.web')

@section('webContent')

    <div>

        <!-- Hero section -->

        <section
            class="flex items-center justify-center w-full min-h-[400px] bg-cover bg-center bg-no-repeat text-white relative text-center font-['Kumbh_Sans',sans-serif]"
            style="background-image: url('{{ asset("Web/assets/img/workspace/hero_weokspace.jpeg") }}');">

            <!-- Overlay -->
            <div class="absolute inset-0 bg-black/50"></div>

            <!-- Content -->
            <div class="relative">
                <p class="text-[25px] mb-2">Our modern spaces are simply stunning</p>

                <h1 class="text-3xl md:text-5xl uppercase font-semibold co-text">Coworking Space</h1>
                <h1 class="text-3xl md:text-5xl uppercase font-semibold co-text">for Success</h1>

                <div class="flex flex-col sm:flex-row justify-center items-center gap-4 mt-6">
                    <button type="button" @click="document.getElementById('exampleModalCenter').showModal()"
                        class="quote_btn bg-[#ef5323] hover:bg-[#d94b1f] text-white font-semibold px-6 py-2 rounded-full transition duration-200">
                        Get Quote
                    </button>

                    <div class="flex items-center gap-2 coworking_btn bg-white rounded-full py-2 px-3">
                        <a href="#" class="h-6 w-6 flex items-center justify-center rounded-full bg-[#ef5323] transition">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="white" class="bi bi-play-fill"
                                viewBox="0 0 16 16">
                                <path
                                    d="m11.596 8.697-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.692-1.01 1.233-.696l6.363 3.692a.802.802 0 0 1 0 1.393" />
                            </svg>
                        </a>
                        <span class="btn-text text-orange-600 font-medium">Watch Now</span>
                    </div>
                </div>
            </div>

        </section>

        <!-- About section -->

        <section class="mt-12 px-4">
            <div class="max-w-7xl mx-auto flex flex-col lg:flex-row gap-10 items-start">
                <!-- Left Content -->
                <div class="lg:w-1/2 space-y-4">
                    <h4 class="text-[#ef5922] font-bold mb-0 text-lg">Our modern spaces</h4>
                    <h1 class="text-2xl md:text-4xl font-semibold leading-tight modern-heading">
                        Where Ambition Meets Opportunity - Explore the spaces today!
                    </h1>
                    <p class="mt-2 text-gray-700 leading-relaxed">
                        Our modern office spaces provide freelancers, entrepreneurs, and teams with comfortable work areas.
                        <br /><br />
                        Explore today and find the perfect environment to enhance your productivity and achieve your goals!
                        Experience the difference of a workspace designed to support your success and innovation.
                    </p>
                </div>

                <!-- Right Images -->
                <div class="lg:w-1/2 grid grid-cols-2 gap-4">
                    <!-- Left Image Group -->
                    <div class="space-y-4">
                        <div>
                            <img src="{{ asset('Web/assets/img/workspace/about_2.jpg') }}" alt=""
                                class="h-48 w-full object-cover rounded-lg shadow-md" />
                        </div>
                        <div>
                            <img src="{{ asset('Web/assets/img/workspace/about_1.jpg') }}" alt=""
                                class="h-48 w-full object-cover rounded-lg shadow-md" />
                        </div>
                    </div>

                    <!-- Right Image Group -->
                    <div class="space-y-4">
                        <div>
                            <img src="{{ asset('Web/assets/img/workspace/about_3.jpg') }}" alt=""
                                class="h-48 w-full object-cover rounded-lg shadow-md" />
                        </div>
                        <div>
                            <img src="{{ asset('Web/assets/img/workspace/about_4.jpg') }}" alt=""
                                class="h-48 w-full object-cover rounded-lg shadow-md" />
                        </div>
                    </div>
                </div>
            </div>
        </section>


        @include('components.web.coworking-space.coworking-building-blocks')
        @include('components.web.coworking-space.coworking-features-amenities')

    </div>

@endsection