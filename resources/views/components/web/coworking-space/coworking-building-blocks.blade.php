@php
    $slides = [
        ['title' => 'Coworking Space', 'img' => '/Web/assets/img/workspace/servie-img-1.jpg'],
        ['title' => 'Private Office', 'img' => '/Web/assets/img/workspace/servie-img-2.jpg'],
        ['title' => 'Virtual Office', 'img' => '/Web/assets/img/workspace/servie-img-3.jpg'],
        ['title' => 'Dedicated Desk', 'img' => '/Web/assets/img/workspace/servie-img-4.jpg'],
        ['title' => 'Meeting Room', 'img' => '/Web/assets/img/workspace/servie-img-5.jpg'],
        ['title' => 'Event Space', 'img' => '/Web/assets/img/workspace/servie-img-6.jpg'],
    ];
@endphp

<section class="w-full bg-white pt-14">
    <div class="text-center mb-6">
        <p class="text-[#ff7e5f] text-base font-semibold">Work Comfortably</p>
        <h2 class="text-[#05284A] text-2xl md:text-3xl font-bold mt-1">Experience More Than</h2>
        <h2 class="text-[#05284A] text-2xl md:text-3xl font-bold mb-2">Just a Space!</h2>
        <small class="text-gray-400">All essentials provided for a productive workspace</small>
    </div>

    <div x-data="slider" class="relative px-4" data-slides='@json($slides)'>
        <!-- Arrows -->
        <button @click="scrollLeft"
            class="absolute left-0 top-1/2 -translate-y-1/2 z-10 bg-white shadow p-2 rounded-full">
            <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M15 19l-7-7 7-7" />
            </svg>
        </button>
        <button @click="scrollRight"
            class="absolute right-0 top-1/2 -translate-y-1/2 z-10 bg-white shadow p-2 rounded-full">
            <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M9 5l7 7-7 7" />
            </svg>
        </button>

        <!-- Slider -->
        <div x-ref="track" class="flex overflow-x-auto gap-4 no-scrollbar py-4 scroll-smooth">
            <template x-for="(slide, index) in slides" :key="index">
                <div class="flex-shrink-0 w-full sm:w-1/2 lg:w-1/3">
                    <div class="relative rounded overflow-hidden shadow-lg">
                        <img :src="slide.img" alt="" class="w-full h-64 object-cover block"
                            onerror="this.src='/Web/assets/img/workspace/fallback.jpg'; this.style.border='2px solid red';">
                        <div class="absolute inset-0 flex items-end p-4">
                            <h4 class="text-white text-lg font-semibold" x-text="slide.title"></h4>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('slider', () => ({
                slides: [],
                autoScrollInterval: null,

                init() {
                    this.slides = JSON.parse(this.$el.dataset.slides);

                    // Auto-scroll every 3 seconds
                    this.autoScrollInterval = setInterval(() => {
                        this.scrollRight();
                    }, 3000);

                    // Pause on hover (optional)
                    this.$refs.track.addEventListener('mouseenter', () => clearInterval(this.autoScrollInterval));
                    this.$refs.track.addEventListener('mouseleave', () => {
                        this.autoScrollInterval = setInterval(() => this.scrollRight(), 3000);
                    });
                },

                scrollLeft() {
                    this.$refs.track.scrollBy({ left: -300, behavior: 'smooth' });
                },

                scrollRight() {
                    const el = this.$refs.track;
                    const maxScroll = el.scrollWidth - el.clientWidth;

                    if (el.scrollLeft + 300 >= maxScroll) {
                        // Rewind to start
                        el.scrollTo({ left: 0, behavior: 'smooth' });
                    } else {
                        el.scrollBy({ left: 300, behavior: 'smooth' });
                    }
                }
            }));
        });
    </script>

</section>

<style>
    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }

    .no-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>