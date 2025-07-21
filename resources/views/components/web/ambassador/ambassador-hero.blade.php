<div x-data="carousel()" x-init="start()" class="relative w-full overflow-hidden">

    <!-- Slides Wrapper -->
    <div class="relative h-[450px]">

        <!-- Slide Item -->
        <template x-for="(slide, index) in slides" :key="index">
            <div
                x-show="active === index"
                x-transition:enter="transition-opacity duration-700 ease-in-out"
                x-transition:leave="transition-opacity duration-700 ease-in-out"
                class="absolute inset-0 w-full h-full bg-cover bg-center bg-blend-darken bg-black/50 flex items-center px-6 md:px-12 lg:px-20 xl:px-24"
                :style="`background-image: url('${slide.image}')`">

                <!-- Custom Bracket (Left Corner) -->
                <div class="absolute left-[5%] top-20 bottom-20" aria-hidden="true">
                    <!-- Top-Left Corner -->
                    <div class="w-6 h-full border-t-4 border-l-4 border-[#34d399]"></div>
                    <!-- Bottom-Left Corner -->
                    <div class="w-6 border-b-4 border-l-4 border-[#34d399]"></div>
                </div>

                <!-- Text Content -->
                <div class="flex flex-col gap-0 md:gap-1 lg:gap-4  pl-10">
                    <p class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl xl:text-6xl font-extrabold text-white mb-0"
                        x-text="slide.heading"></p>
                    <p class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl xl:text-6xl font-extrabold text-cyan-400 mb-0"
                        x-text="slide.subheading"></p>
                    <p class="text-sm sm:text-base md:text-lg text-white mt-2"
                        x-text="slide.description"></p>
                </div>

            </div>
        </template>
    </div>

    <!-- Prev Button -->
    <button @click="prev()"
        class="absolute top-16 right-[70px] sm:top-20 sm:right-14 transform -translate-y-1/2 w-[8%] bg-transparent text-white">
        <span class="w-8 h-8 border-2 border-white rounded-full flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 19l-7-7 7-7" />
            </svg>
        </span>
    </button>

    <!-- Next Button -->
    <button @click="next()"
        class="absolute top-16 right-6 sm:top-20 sm:right-0 transform -translate-y-1/2 w-[8%] bg-transparent text-white">
        <span class="w-8 h-8 border-2 border-white rounded-full flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 5l7 7-7 7" />
            </svg>
        </span>
    </button>
</div>

<!-- Alpine.js Carousel Logic -->
<script>
    function carousel() {
        return {
            active: 0, // Currently active slide index
            interval: null, // Auto-play interval handler
            slides: [{
                    image: "{{ asset('Web/assets/img/nadirImg/amb9.png') }}",
                    heading: 'Join the Movement',
                    subheading: 'Elevate, Empower, Inspire.',
                    description: 'You can customize the bracketed sections with details to your experience and career goals.'
                },
                {
                    image: "{{ asset('Web/assets/img/nadirImg/amb10.png') }}",
                    heading: 'Empowering Change',
                    subheading: 'One Ambassador at a Time.',
                    description: 'You can customize the bracketed sections with details to your experience and career goals.'
                },
                {
                    image: "{{ asset('Web/assets/img/nadirImg/amb12.png') }}",
                    heading: 'Join Us in Shaping',
                    subheading: 'Tomorrow\'s Leaders',
                    description: 'You can customize the bracketed sections with details to your experience and career goals.'
                }
            ],
            start() {
                // Auto-scroll every 5 seconds
                this.interval = setInterval(() => this.next(), 5000);
            },
            next() {
                // Go to next slide (loop back to start)
                this.active = (this.active + 1) % this.slides.length;
            },
            prev() {
                // Go to previous slide (loop to end)
                this.active = (this.active - 1 + this.slides.length) % this.slides.length;
            }
        };
    }
</script>