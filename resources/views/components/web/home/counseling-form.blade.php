@php
$slides = [
'https://career.edu.pk/Web/assets/img/Hero-banner/career-institute-slider-2.jpg',
'https://career.edu.pk/Web/assets/img/Hero-banner/Future-02.jpg',
];
@endphp

<section class="relative bg-[#05284A] px-3 md:px-7 lg:px-12 py-4 md:py-6 lg:py-10 pb-28 sm:pb-24 md:pb-32 lg:pb-20">

    <!-- Slider + Form -->

    <div class="space-y-5 sm:space-y-0 md:space-y-7 lg:space-y-6  grid grid-cols-1 md:grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 lg:gap-4">

        <!-- Slider -->

        <div class="sm:mt-4 lg:mt-0">
            <x-slider :slides="$slides" />
        </div>

        <!-- Form -->

        <div class="text-white rounded-md shadow-md p-0 md:p-0 lg:p-4">
            <h2 class="text-xl md:text-2xl font-bold">Get a Free Counseling Session</h2>

            <p class="text-xs md:text-2xl">
                Complete the form below, and one of our counselors will promptly get in touch with you.
            </p>

            <form action="{{ route('aboutUs') }}" method="POST" class="space-y-2 mt-4">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    {{-- Full Name --}}
                    <div class="relative">
                        <x-heroicon-o-user class="w-5 h-5 absolute top-1/2 left-3 -translate-y-1/2 text-gray-400" />
                        <input type="text" name="name" placeholder="Full Name" required
                            class="pl-10 w-full bg-[#20405E] rounded-md px-3 py-2 focus:outline-none focus:ring-2">
                    </div>

                    {{-- Course Interested --}}
                    <div class="relative">
                        <x-heroicon-o-academic-cap class="w-5 h-5 absolute top-1/2 left-3 -translate-y-1/2 text-gray-400" />
                        <input type="text" name="course" placeholder="Course Interested" required
                            class="pl-10 w-full bg-[#20405E] rounded-md px-3 py-2 focus:outline-none focus:ring-2">
                    </div>

                    {{-- Contact No --}}
                    <div class="relative">
                        <x-heroicon-o-phone class="w-5 h-5 absolute top-1/2 left-3 -translate-y-1/2 text-gray-400" />
                        <input type="text" name="primary_contact" placeholder="Contact No"
                            oninput="this.value=this.value.replace(/[^0-9]/g,'')"
                            class="pl-10 w-full bg-[#20405E] rounded-md px-3 py-2 focus:outline-none focus:ring-2">
                    </div>

                    {{-- Email --}}
                    <div class="relative">
                        <x-heroicon-o-envelope class="w-5 h-5 absolute top-1/2 left-3 -translate-y-1/2 text-gray-400" />
                        <input type="email" name="email" placeholder="Email Address" required
                            class="pl-10 w-full bg-[#20405E] rounded-md px-3 py-2 focus:outline-none focus:ring-2">
                    </div>

                    {{-- Country --}}
                    <div class="relative">
                        <x-heroicon-o-globe-alt class="w-5 h-5 absolute top-1/2 left-3 -translate-y-1/2 text-gray-400" />
                        <input type="text" name="country" id="selected-country" value="Pakistan" readonly
                            class="pl-10 w-full bg-[#20405E] rounded-md px-3 py-2 focus:outline-none focus:ring-2 cursor-pointer">
                    </div>

                    {{-- City --}}
                    <div class="relative">
                        <x-heroicon-o-map-pin class="w-5 h-5 absolute top-1/2 left-3 -translate-y-1/2 text-gray-400" />
                        <input type="text" name="city" placeholder="Your City" required
                            class="pl-10 w-full bg-[#20405E] rounded-md px-3 py-2 focus:outline-none focus:ring-2">
                    </div>
                </div>

                <div class="flex items-center space-x-2 mt-2">
                    <input type="checkbox" checked name="news_later" class="accent-orange-600">
                    <label for="news_later" class="text-sm">Subscribe to newsletter</label>
                </div>

                <input type="hidden" name="type" value="Quick Lead">
                <input type="hidden" name="status" value="Pending">

                <div class="flex justify-end mt-2">
                    <button type="submit"
                        class="px-6 py-2 rounded-full border border-[#ff5500] text-[#ff5500] bg-transparent hover:bg-[#ff5500] hover:text-white transition-all duration-300">
                        Apply Now
                    </button>
                </div>
            </form>
        </div>


    </div>

    <!-- Alumni Cards -->

    <div class="w-[93%] sm:w-[94%] absolute -bottom-[690px] sm:-bottom-[60px] md:-bottom-[290px] lg:-bottom-[130px] transform translate-x-0 sm:transform md:transform md:translate-x-5 sm:translate-x-0 lg:transform lg:translate-x-0  flex flex-col sm:flex-row flex-wrap  sm:justify-between gap-6 z-10 ">

        @php
        $cards = [
        [
        'count' => '150,000+',
        'label' => 'Alumni',
        'icon' => '<svg width="50" height="42" viewBox="0 0 77 70" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M46.8876 1.95456C41.4341 -0.602205 35.3223 -0.602205 29.8688 1.95456L4.18938 13.9936C0.0598674 15.9297 -1.01676 21.3889 0.959457 25.162V44.1721C0.959457 45.7618 2.24817 47.0505 3.83784 47.0505C5.42751 47.0505 6.71622 45.7618 6.71622 44.1721V29.4809L29.8692 40.3355C35.3227 42.8922 41.4345 42.8922 46.888 40.3355L72.5674 28.2965C78.1534 25.6778 78.1534 16.6126 72.5674 13.9938L46.8876 1.95456Z" fill="#1D354E"></path>
            <path d="M11.5135 38.0881V52.3292C11.5135 56.1977 13.4459 59.8198 16.8302 61.6942C22.4656 64.8148 31.4857 69.1182 38.3784 69.1182C45.2712 69.1182 54.2913 64.8148 59.9267 61.6942C63.311 59.8198 65.2433 56.1977 65.2433 52.3292V38.0885L49.3316 45.5481C42.3299 48.8306 34.4274 48.8306 27.4255 45.5481L11.5135 38.0881Z" fill="#1D354E"></path>
        </svg>'
        ],
        [
        'count' => '50+',
        'label' => 'Affiliations',
        'icon' => '<svg width="50" height="42" viewBox="0 0 74 74" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M63.8477 52.7563L56.7826 47.7846L45.5307 39.9344L37.9423 34.701C37.9423 34.701 37.9423 34.701 37.6806 34.4393C37.4189 34.4393 37.1573 34.1777 37.1573 34.1777C36.8956 34.1777 36.6339 34.1777 36.3723 34.1777H36.1106C35.8489 34.1777 35.5872 34.4393 35.5872 34.4393C35.5872 34.4393 35.5872 34.4393 35.3256 34.4393L27.7371 39.6728L16.4853 47.5229L9.42015 52.7563C4.18673 53.2797 0 57.7281 0 63.2231C0 68.9799 4.71008 73.69 10.4668 73.69C16.2236 73.69 20.9337 68.9799 20.9337 63.2231C20.9337 59.5598 19.102 56.4197 16.2236 54.588L19.3636 52.233L30.6155 44.3828L34.0172 42.0278V46.2145V53.018C29.5688 54.0647 26.1671 58.2514 26.1671 63.2231C26.1671 68.9799 30.8772 73.69 36.6339 73.69C42.3907 73.69 47.1008 68.9799 47.1008 63.2231C47.1008 58.2514 43.699 54.3263 39.2506 53.018V46.2145V42.0278L42.6524 44.3828L53.9042 52.233L57.0443 54.588C54.1659 56.4197 52.3342 59.5598 52.3342 63.2231C52.3342 68.9799 57.0443 73.69 62.801 73.69C68.5578 73.69 73.2679 68.9799 73.2679 63.2231C73.2679 57.7281 69.0811 53.2797 63.8477 52.7563Z" fill="#1D354E"></path>
            <path d="M23.5504 31.8227H49.7175C50.5025 31.8227 51.2875 31.561 51.8109 30.776C52.3342 30.2527 52.5959 29.4677 52.3342 28.6826C51.5492 24.7576 48.6708 21.6175 44.7458 20.5708C43.6991 20.3092 42.9141 19.5242 42.6524 18.4775C43.6991 17.1691 44.4841 15.3374 44.4841 13.5057V8.27231C44.4841 3.8239 41.0824 0.42218 36.634 0.42218C32.1855 0.42218 28.7838 3.8239 28.7838 8.27231V13.5057C28.7838 15.3374 29.5688 17.1691 30.6155 18.4775C30.3538 19.5242 29.5688 20.3092 28.5222 20.5708C24.5971 21.6175 21.7187 24.7576 21.1954 28.6826C20.9337 29.4677 21.1954 30.2527 21.7187 30.776C21.9804 31.561 22.7654 31.8227 23.5504 31.8227Z" fill="#1D354E"></path>
        </svg>'
        ],
        [
        'count' => '100+',
        'label' => 'Trainings',
        'icon' => '<svg width="50" height="42" viewBox="0 0 84 70" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path ... />
        </svg>'
        ],
        [
        'count' => '15+',
        'label' => 'Campuses',
        'icon' => '<svg width="50" height="42" viewBox="0 0 84 70" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path ... />
        </svg>'
        ]
        ];
        @endphp

        <div class="w-full md:w-[95%] lg:w-full">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-x-8 lg:gap-x-5">
                @foreach ($cards as $card)
                <div class="flex flex-col items-center shadow-xl ring-1 ring-white/30 bg-white rounded-3xl px-6 py-10 transition-all duration-300 hover:-translate-y-1">
                    <div class="mb-2">{!! $card['icon'] !!}</div>
                    <h2 class="text-2xl sm:text-3xl text-[#ef5922] font-bold">{{ $card['count'] }}</h2>
                    <h4 class="text-sm sm:text-base text-[#05284A]">{{ $card['label'] }}</h4>
                </div>
                @endforeach
            </div>
        </div>

    </div>

</section>