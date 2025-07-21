<section class="course-data px-3 md:px-7 sm:px-8  my-8 md:my-12 flex flex-col gap-10">

    <!-- Header -->

    <div>
        <div>
            <div class="flex flex-col lg:flex-row lg:justify-between">
                <div class="lg:w-3/4">
                    <h1 class="text-3xl md:text-4xl font-bold">
                        Featured <span class="font-extrabold">Courses</span>
                    </h1>
                    <div class="w-16 h-[2px] bg-orange-600 mt-2"></div>
                    <p class="mt-4 text-base md:text-lg text-gray-600">
                        Elevate Your Skills and Land Your Dream Job - Whether you prefer the convenience of learning from home or the advantages of direct sessions on campus with our expert instructors, we've got you covered!
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Courses Slider -->
    <div class="relative px-3 md:px-0 sm:px-6 lg:px-1">
        @if (!empty($feature_courses))
        <div
            x-data="featuredSliderComponent({{ json_encode($feature_courses) }})"
            x-init="init"
            class="relative w-full overflow-hidden">

            <!-- Arrows -->
            <div class="absolute -top-10 right-4 flex space-x-2 z-10">
                <button @click="prev" class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">←</button>
                <button @click="next" class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">→</button>
            </div>

            <!-- Track -->
            <div
                class="flex transition-transform duration-500 ease-in-out gap-x-4 pr-4"
                x-ref="track"
                :style="`transform: translateX(-${getTranslateX()}%);`">
                <template x-for="course in slides" :key="course.id">
                    <div class="flex-shrink-0 w-full md:w-1/2 lg:w-1/4">
                        <div class="overflow-hidden bg-white h-full flex flex-col">
                            <div class="relative w-full h-40 bg-gray-200 flex items-center justify-center text-sm font-semibold text-gray-600">
                                <div class="w-full h-full flex items-center justify-center rounded-lg">
                                    Dummy Image
                                </div>
                            </div>

                            <div class="p-4 flex-1 flex flex-col justify-between">
                                <h4 class="text-lg font-bold">
                                    <a :href="`{{ route('showCourse', ['id' => '__ID__', 'title' => '__TITLE__']) }}`.replace('__ID__', course.id).replace('__TITLE__', course.title.replace(/\s+/g, '-').toLowerCase())">
                                        <span x-text="course.title"></span>
                                    </a>
                                </h4>
                                <div class="text-sm text-gray-500 mt-1">
                                    <span>Category: </span>
                                    <span x-text="course.course_categoryy"></span>
                                </div>
                                <div class="flex gap-4 mt-2 text-xs text-gray-700">
                                    <div class="flex items-center gap-1">
                                        <span x-text="course.duration + ' Months'"></span>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <span x-text="course.classtype"></span>
                                    </div>
                                </div>
                                <a
                                    :href="`{{ route('showCourse', ['id' => '__ID__', 'title' => '__TITLE__']) }}`.replace('__ID__', course.id).replace('__TITLE__', course.title.replace(/\s+/g, '-').toLowerCase())"
                                    class="mt-4 border border-orange-600 w-max text-orange-600 py-2 px-4 text-sm font-semibold ">
                                    More Details
                                </a>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

        </div>
        @endif
    </div>
    
</section>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('featuredSliderComponent', (slides) => ({
            slides,
            activeIndex: 0,
            pause: false,

            init() {
                this.startAutoSlide();
                window.addEventListener('resize', () => {
                    this.activeIndex = Math.min(this.activeIndex, this.slides.length - this.getVisibleSlides());
                });
            },

            startAutoSlide() {
                setInterval(() => {
                    if (!this.pause) this.next();
                }, 3000);
            },

            next() {
                const maxIndex = this.getMaxIndex();
                this.activeIndex = this.activeIndex + 1 > maxIndex ? 0 : this.activeIndex + 1;
            },

            prev() {
                const maxIndex = this.getMaxIndex();
                this.activeIndex = this.activeIndex - 1 < 0 ? maxIndex : this.activeIndex - 1;
            },

            getVisibleSlides() {
                const w = window.innerWidth;
                if (w >= 1024) return 4;
                if (w >= 768) return 2;
                return 1;
            },

            getMaxIndex() {
                return Math.max(0, this.slides.length - this.getVisibleSlides());
            },

            getTranslateX() {
                const visible = this.getVisibleSlides();
                const total = this.slides.length;
                const maxIndex = this.getMaxIndex();

                if (this.activeIndex > maxIndex) {
                    this.activeIndex = maxIndex;
                }

                return (this.activeIndex * 100) / visible;
            },
        }));
    });
</script>