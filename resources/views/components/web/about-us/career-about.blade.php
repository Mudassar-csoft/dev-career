<section class="px-3 py-6 sm:px-10 md:px-7 lg:px-10 sm:py-10 flex flex-col gap-5">

    <!-- Heading -->

    <div class="flex flex-col gap-[2px] my-6 lg:my-10">
        <h1 class="text-3xl sm:text-4xl font-bold text-gray-800">
            About <span class="text-primary">Us</span>
        </h1>
        <div class="w-20 h-[2px] bg-[#ff5500]"></div>
    </div>

    <div class="flex flex-col lg:flex-row gap-10">
        <!-- Slider -->
        <div class="w-full lg:w-1/2">
            <div
                x-data="{
                        active: 0,
                        images: [
                            '{{ url('Web/assets/img/Hero-banner/career-institute-slider-1.jpeg') }}',
                            '{{ url('Web/assets/img/Hero-banner/career-institute-slider-2.jpg') }}',
                            '{{ url('Web/assets/img/Hero-banner/Future-02.jpg') }}',
                        ],
                        prev() {
                            this.active = (this.active - 1 + this.images.length) % this.images.length;
                        },
                        next() {
                            this.active = (this.active + 1) % this.images.length;
                        }
                    }"
                class="relative overflow-hidden rounded-xl shadow-md">
                <img
                    :src="images[active]"
                    class="w-full h-72 sm:h-80 object-cover transition-all duration-500"
                    alt="About Slider">

                <!-- Controls -->
                <button @click="prev"
                    class="absolute left-2 top-1/2 -translate-y-1/2 bg-black/50 text-white px-3 py-1 rounded-full">
                    ‹
                </button>
                <button @click="next"
                    class="absolute right-2 top-1/2 -translate-y-1/2 bg-black/50 text-white px-3 py-1 rounded-full">
                    ›
                </button>
            </div>
        </div>

        <!-- Text Info -->
        <div class="w-full lg:w-1/2 flex flex-col justify-start">
            <h2 class="text-2xl sm:text-3xl font-bold mb-4">
                We are <span class="text-primary">Future of Career Development</span>
            </h2>
            <p class="text-gray-700 leading-relaxed">
                Career Institute, founded in 2010, has emerged as a leading IT education institution in Pakistan.
                Our commitment to excellence has led to a network of over 150,000 proud alumni. With more than 50
                globally recognized affiliations and a portfolio of over 100 meticulously crafted courses, we're
                dedicated to meeting the ever-growing global demand for skilled professionals.
            </p>
        </div>
    </div>

</section>