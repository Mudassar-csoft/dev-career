
<section class="overflow-hidden mt-[80px] sm:mt-[100px] bg-gradient-to-r from-[#2BA6AF] to-[#61C27C] pl-3 md:pl-7 lg:pl-10">
    <div class="flex flex-col lg:flex-row items-stretch" x-data="{ open: false }">
        <!-- Left Text -->
        <div class="w-full lg:w-1/2 text-white px-3 md:px-6 sm:px-8 py-10  lg:py-16 flex items-center">
            <div class="flex flex-col gap-7">
                <div>
                    <p class="text-lg sm:text-xl md:text-2xl lg:text-3xl font-bold leading-tight">
                        Explore our campuses through an immersive virtual tour.
                    </p>
                    <div class="w-20 h-[2px] bg-white mt-2"></div>
                </div>
                <p class="text-sm sm:text-base md:text-lg leading-relaxed">
                    Discover the allure of our stunning campuses in this captivating
                    video tour, where you can truly immerse yourself in the vibrant atmosphere
                    that characterizes our esteemed institution. We extend a warm invitation
                    for you to virtually experience our campus, offering you a glimpse into
                    what sets our educational and personal growth environment apart as
                    something truly exceptional.
                </p>
                <div>
                    <button
                        class="border border-white rounded-full text-white px-6 py-2 hover:bg-white hover:text-[#2BA6AF] transition">
                        Explore Campuses
                    </button>
                </div>
            </div>
        </div>

        <!-- Right Video Part -->
        <div x-data="{ open: false }" class="w-full lg:w-1/2 relative flex items-center justify-center bg-black">
            <div
                class="relative w-full h-72 sm:h-96 lg:h-full flex items-center justify-center bg-cover bg-center"
                style="background-image: url('https://career.edu.pk/Web/assets/img/gallery/millat%20chowk/12.jpg')">

                <!-- Play Button with Wave Effect -->
                <div class="relative w-20 h-20 cursor-pointer z-10" @click="open = true">
                    <img
                        src="{{ asset('Web/assets/img/video-section/play-btn.png') }}"
                        alt="Play Button"
                        class="w-full h-full relative z-10">
                    <div class="absolute inset-0 rounded-full bg-white/30 animate-wave"></div>
                    <div class="absolute inset-0 rounded-full bg-white/20 animate-wave delay-200"></div>
                    <div class="absolute inset-0 rounded-full bg-white/10 animate-wave delay-400"></div>
                </div>
                
            </div>

            <!-- Modal -->
            <template x-if="open">
                <div
                    class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50"
                    @click.self="open = false">
                    <div class="bg-gray-900 rounded-lg overflow-hidden w-[80%] h-[80%] relative">
                        <button
                            @click="open = false"
                            class="absolute top-2 right-2 text-white text-2xl hover:text-red-500">
                            ×
                        </button>
                        <div class="w-full h-full">
                            <iframe
                                src="https://www.youtube.com/embed/S_0I0RoFgXs"
                                title="YouTube video player"
                                class="w-full h-full"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>
</section>

<style>
    @keyframes wave {
        0% {
            transform: scale(1);
            opacity: 1;
        }

        100% {
            transform: scale(1.5);
            opacity: 0;
        }
    }

    .animate-wave {
        animation: wave 2s infinite ease-out;
    }

    .delay-200 {
        animation-delay: 0.2s;
    }

    .delay-400 {
        animation-delay: 0.4s;
    }
</style>

<script src="//unpkg.com/alpinejs" defer></script>