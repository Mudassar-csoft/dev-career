<section class=" flex flex-col gap-4">

    <div class="mb-5 flex flex-col gap-[2px]">
        <h1 class="text-2xl md:text-3xl font-bold">Latest <span class="text-primary">News</span></h1>
        <div class="h-[1px] w-20 bg-[#ef5922]"></div>
    </div>

    <div class="flex flex-col ">

        <div class="relative h-[344px] overflow-hidden news-container">
            <ul class="absolute top-0 w-full space-y-4 animate-slide" id="news-list">
                <!-- Original news items -->
                <li>
                    <div class="flex items-center gap-2 text-sm text-gray-600">
                        <i class="fa fa-calendar"></i>
                        <span>10-Jul-2025</span>
                    </div>
                    <h5 class="text-base font-medium">
                        <a href="#" class="text-black hover:underline">
                            Admissions Open for Fall 2025 – Apply Now!
                        </a>
                    </h5>
                </li>
                <li>
                    <div class="flex items-center gap-2 text-sm text-gray-600">
                        <i class="fa fa-calendar"></i>
                        <span>08-Jul-2025</span>
                    </div>
                    <h5 class="text-base font-medium">
                        <a href="#" class="text-black hover:underline">
                            Workshop on Artificial Intelligence – Register Today
                        </a>
                    </h5>
                </li>
                <li>
                    <div class="flex items-center gap-2 text-sm text-gray-600">
                        <i class="fa fa-calendar"></i>
                        <span>06-Jul-2025</span>
                    </div>
                    <h5 class="text-base font-medium">
                        <a href="#" class="text-black hover:underline">
                            Eid Holidays Announced from 15th to 18th July
                        </a>
                    </h5>
                </li>
                <li>
                    <div class="flex items-center gap-2 text-sm text-gray-600">
                        <i class="fa fa-calendar"></i>
                        <span>04-Jul-2025</span>
                    </div>
                    <h5 class="text-base font-medium">
                        <a href="#" class="text-black hover:underline">
                            Annual Sports Day Scheduled on 25th July
                        </a>
                    </h5>
                </li>
                <li>
                    <div class="flex items-center gap-2 text-sm text-gray-600">
                        <i class="fa fa-calendar"></i>
                        <span>02-Jul-2025</span>
                    </div>
                    <h5 class="text-base font-medium">
                        <a href="#" class="text-black hover:underline">
                            Mid-Term Examination Results Declared
                        </a>
                    </h5>
                </li>
                <li>
                    <div class="flex items-center gap-2 text-sm text-gray-600">
                        <i class="fa fa-calendar"></i>
                        <span>30-Jun-2025</span>
                    </div>
                    <h5 class=" text-base font-medium">
                        <a href="#" class="text-black hover:underline">
                            New Library Resources Available for Students
                        </a>
                    </h5>
                </li>
                <!-- Duplicated news items will be added here via JavaScript -->
            </ul>
        </div>



    </div>
    
    <div class="flex items-center gap-1 hover:text-orange-600">
        <a href="#" class="text-xl font-semibold">All News</a>
        <div>
            <x-heroicon-o-pencil-square class="w-4 h-4 text-orange-600" />
        </div>
    </div>

    <style>
        @keyframes slideUp {
            0% {
                transform: translateY(0);
            }

            45% {
                transform: translateY(-50%);
            }

            50% {
                transform: translateY(-50%);
            }

            100% {
                transform: translateY(0);
            }
        }

        .animate-slide {
            animation: slideUp 20s ease-in-out infinite;
        }

        .news-container:hover .animate-slide {
            animation-play-state: paused;
        }
    </style>

    <script>
        // JavaScript to duplicate news items for seamless looping
        const newsList = document.getElementById('news-list');
        const newsItems = newsList.querySelectorAll('li');
        const fragment = document.createDocumentFragment();

        newsItems.forEach(item => {
            const clone = item.cloneNode(true);
            fragment.appendChild(clone);
        });

        newsList.appendChild(fragment);
    </script>

</section>