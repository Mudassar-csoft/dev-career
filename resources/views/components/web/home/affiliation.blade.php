<section x-data="affiliationSlider()" x-init="start" class="px-3 md:py-12 sm:px-8 lg:py-10 my-14 md:my-10 lg:my-12">

    <div class="my-5">
        <div class="">
            <div class="flex justify-between">
                <div class="lg:w-9/12">
                    <h1 class="text-2xl md:text-3xl font-medium">
                        Collaborations with leading
                        <span class="font-bold">Organizations</span>
                    </h1>
                    <div class="w-20 h-[2px] bg-orange-600 mt-2"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="overflow-hidden" @mouseenter="pause" @mouseleave="resume">
        <div class="container mx-auto px-4">
            <div class="relative w-full">
                <!-- Slider Track -->
                <div class="flex gap-10 whitespace-nowrap" :style="`transform: translateX(${translateX}px)`" x-ref="slider">
                    <template x-for="(slide, index) in allSlides" :key="index">
                        <div class="flex-shrink-0 flex flex-col items-center w-[160px]">
                            <img :src="slide" alt="" class="h-16 object-contain" @@error="replaceWithText($event)">
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    function affiliationSlider() {
        return {
            slides: [
                '{{ url("Web/assets/img/partners-logo/CISCO-ACADEMY.png") }}',
                '{{ url("Web/assets/img/partners-logo/FORTINET-ACADEMY.png") }}',
                '{{ url("Web/assets/img/partners-logo/KRYTERION.png") }}',
                '{{ url("Web/assets/img/partners-logo/LINUX-INSTITUTE.png") }}',
                '{{ url("Web/assets/img/partners-logo/MICROSOFT-ACADEMY.png") }}',
                '{{ url("Web/assets/img/partners-logo/ORACLE-ACADEMY.png") }}',
                '{{ url("Web/assets/img/partners-logo/PALOALTO.png") }}',
                '{{ url("Web/assets/img/partners-logo/PATHON-INSTITUTE.png") }}',
                '{{ url("Web/assets/img/partners-logo/pearson.png") }}',
                '{{ url("Web/assets/img/partners-logo/VM-WARE-ACADEMY.png") }}',
                '{{ url("Web/assets/img/partners-logo/ANDROID-ACADEMY.png") }}',
                '{{ url("Web/assets/img/partners-logo/BRITISH-COUNCIL.png") }}',
                '{{ url("Web/assets/img/partners-logo/C-INSTITUTE.png") }}',
                '{{ url("Web/assets/img/partners-logo/e-earn.png") }}'
            ],
            allSlides: [],
            translateX: 0,
            speed: 0.5, // pixels per frame
            animationFrame: null,
            paused: false,

            start() {
                this.allSlides = [...this.slides, ...this.slides]; // duplicate for seamless loop
                this.$nextTick(() => {
                    this.loop();
                });
            },

            loop() {
                if (!this.paused) {
                    this.translateX -= this.speed;

                    const sliderWidth = this.$refs.slider.scrollWidth / 2;
                    if (Math.abs(this.translateX) >= sliderWidth) {
                        this.translateX = 0; // reset seamlessly
                    }
                }

                this.animationFrame = requestAnimationFrame(() => this.loop());
            },

            pause() {
                this.paused = true;
            },

            resume() {
                this.paused = false;
            },

            replaceWithText(e) {
                e.target.outerHTML = `<span class="text-white text-sm">Logo not found</span>`;
            }
        }
    }
</script>