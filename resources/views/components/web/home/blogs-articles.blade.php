<section>
    <div class="my-5">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex flex-col lg:flex-row justify-between">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-semibold">
                        Blogs <span class="font-bold">& Articles</span>
                    </h1>
                    <div class="w-16 h-1 bg-orange-500 mt-2"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="px-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach ($blog->take(4) as $topblogs)
            <a href="{{ route('blogdetails', $topblogs->id) }}" class="text-black no-underline">
                <div class="relative bg-white rounded-lg shadow hover:shadow-lg transition">
                    <div class="relative">
                        <img src="{{ $topblogs->fimage }}"
                            alt=""
                            class="w-full h-48 object-cover rounded-t-lg">
                        <div class="absolute top-6 right-4 flex flex-col items-center">
                            <div class="w-14 h-16 bg-orange-600 text-white font-bold flex flex-col justify-center items-center rounded">
                                <span>{{ date("d", strtotime($topblogs->publish_date)) }}</span>
                                <span>{{ date("M", strtotime($topblogs->publish_date)) }}</span>
                            </div>
                            <div class="w-14 h-7 bg-black text-white font-bold text-sm flex justify-center items-center mt-1 rounded">
                                {{ date("Y", strtotime($topblogs->publish_date)) }}
                            </div>
                        </div>
                    </div>
                    <div class="px-3 py-4 space-y-2">
                        <p class="text-gray-500 text-sm">
                            {{ $topblogs['blogcate']['name'] ?? '' }}
                        </p>
                        <p class="text-lg font-bold h-[103px]">
                            {{ $topblogs->title }}
                        </p>
                    </div>
                </div>
            </a>
            @endforeach
        </div>

        <div class="text-center mt-8 mb-10">
            <a href="{{ route('blogs') }}"
                class="inline-block px-6 py-2 border border-orange-500 text-orange-500 rounded-full hover:bg-orange-500 hover:text-white transition">
                Our Blogs
            </a>
        </div>
    </div>
</section>