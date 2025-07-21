@props(['slides' => []])

@if (!empty($slides))
<div
    x-data="sliderComponent({{ json_encode($slides) }})"
    x-init="init"
    class="relative w-[100%] h-[100%]  overflow-hidden rounded-xl group"
    @mouseenter="pause = true"
    @mouseleave="pause = false">
    <!-- Track -->
    <div
        class="flex transition-transform duration-500 ease-in-out will-change-transform"
        x-ref="track"
        :style="`transform: translateX(-${getTranslateX()}%);`">
        <template x-for="slide in slides" :key="slide">
            <div
                class="flex-shrink-0"
                :style="`width: ${100 / getVisibleSlides()}%;`">
                <img
                    :src="slide"
                    alt="Slide"
                    class="object-cover rounded-lg mx-auto md:mx-0 md:w-full md:h-full"
                    loading="lazy" />
            </div>
        </template>
    </div>


    <!-- Dots -->
    <div class="absolute bottom-3 left-1/2 -translate-x-1/2 flex space-x-1.5">
        <template x-for="(slide, index) in slides" :key="index">
            <button
                @click="goToSlide(index)"
                :class="{ 'bg-white scale-125': activeIndex === index, 'bg-gray-400': activeIndex !== index }"
                class="w-2 h-2 rounded-full cursor-pointer transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-white/50"
                :aria-label="`Go to slide ${index + 1}`"></button>
        </template>
    </div>
</div>

<!-- Alpine Slider Component -->
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('sliderComponent', (slides) => ({
            slides,
            activeIndex: 0,
            pause: false,
            touchStartX: 0,
            touchEndX: 0,

            init() {
                // Start auto-slide
                this.startAutoSlide();

                // Throttle resize events
                let resizeTimeout;
                window.addEventListener('resize', () => {
                    clearTimeout(resizeTimeout);
                    resizeTimeout = setTimeout(() => {
                        this.activeIndex = Math.min(this.activeIndex, this.slides.length - this.getVisibleSlides());
                        this.$forceUpdate();
                    }, 100);
                }, {
                    passive: true
                });

                // Touch events
                this.$refs.track.addEventListener('touchstart', (e) => {
                    this.touchStartX = e.changedTouches[0].screenX;
                    this.pause = true;
                }, {
                    passive: true
                });

                this.$refs.track.addEventListener('touchend', (e) => {
                    this.touchEndX = e.changedTouches[0].screenX;
                    this.handleSwipe();
                    this.pause = false;
                }, {
                    passive: true
                });

                // Keyboard navigation
                this.$el.addEventListener('keydown', (e) => {
                    if (e.key === 'ArrowLeft') this.prev();
                    if (e.key === 'ArrowRight') this.next();
                });
            },

            startAutoSlide() {
                this.stopAutoSlide(); // Clear any existing interval
                this.intervalId = setInterval(() => {
                    if (!this.pause) {
                        if (this.activeIndex >= this.slides.length - this.getVisibleSlides()) {
                            this.activeIndex = 0; // Loop back to start
                        } else {
                            this.next();
                        }
                    }
                }, 3000);
            },

            stopAutoSlide() {
                if (this.intervalId) {
                    clearInterval(this.intervalId);
                    this.intervalId = null;
                }
            },

            next() {
                if (this.activeIndex < this.slides.length - this.getVisibleSlides()) {
                    this.activeIndex++;
                }
            },

            prev() {
                if (this.activeIndex > 0) {
                    this.activeIndex--;
                }
            },

            goToSlide(index) {
                this.activeIndex = Math.max(0, Math.min(index, this.slides.length - this.getVisibleSlides()));
            },

            getVisibleSlides() {
                const width = window.innerWidth;
                if (width >= 1536) return 1; // 2xl: 2 slides
                if (width >= 1280) return 1; // xl: 2 slides
                if (width >= 768) return 1; // md: 1.5 slides
                return 1; // sm: 1 slide
            },

            getTranslateX() {
                return this.activeIndex * (100 / this.getVisibleSlides());
            },

            handleSwipe() {
                const swipeDistance = this.touchEndX - this.touchStartX;
                const threshold = 50;

                if (swipeDistance > threshold) {
                    this.prev();
                } else if (swipeDistance < -threshold) {
                    this.next();
                }
            }
        }));
    });
</script>

@endif