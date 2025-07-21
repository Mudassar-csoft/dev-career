<section class="coworking_hero font-['Kumbh_Sans'] text-white py-12 px-4 md:px-10 lg:px-20 bg-cover bg-center">
    <div class="text-center">
        <p class="mb-2 text-[25px]">Our modern spaces are simply stunning</p>

        <h1 class="uppercase text-4xl font-semibold co-text">Coworking Space</h1>
        <h1 class="uppercase text-4xl font-semibold co-text">for Success</h1>

        <div class="flex flex-col sm:flex-row justify-center items-center gap-4 mt-4">
            <!-- Get Quote Button -->
            <button type="button" @click="openModal = true"
                class="quote_btn bg-orange-500 hover:bg-orange-600 text-white py-2 px-5 rounded-md transition">
                Get Quote
            </button>

            <!-- Watch Now Button -->
            <div class="flex items-center space-x-2 coworking_btn">
                <button class="w-10 h-10 flex items-center justify-center rounded-full bg-white/20 hover:bg-white/30">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="white" class="bi bi-play-fill"
                        viewBox="0 0 16 16">
                        <path
                            d="m11.596 8.697-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.692-1.01 1.233-.696l6.363 3.692a.802.802 0 0 1 0 1.393" />
                    </svg>
                </button>
                <span class="btn-text text-white">Watch Now</span>
            </div>
        </div>
    </div>
</section>