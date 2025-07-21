<section class=" flex flex-col space-y-3 md:mt-5 lg:mt-0 md:mx-auto">

    <div class="flex flex-col gap-[2px] mb-5">
        <h1 class="text-2xl font-bold  sm:mb-0 ">Why <span class="text-primary">Choose Us</span></h1>
        <div class="h-[1px] w-20 bg-[#ef5922]"></div>
    </div>

    <div class="flex flex-col space-y-5 sm:space-y-3 md:space-y-5">

        <img src="{{ url('https://career.edu.pk/Web/assets/img/news-blog-section/Ai-hand.png') }}" alt="hand-ai"
            class="rounded-lg shadow w-full">

        <div>
            <h5 class="font-bold">About Career Institute.</h5>
            <p class="text-sm text-gray-700">
                <b>Since 2010, Career Institute,</b> a global tech training leader, has impacted 150,000+ students worldwide.
                Our commitment to industry trends is seen in our current curriculum and certified trainers.
                Beyond training, we offer coworking spaces to tech startups, fostering professional excellence.
                Elevate your skills and business at Career Institute – where innovation meets education.
            </p>
        </div>

    </div>

    <div class="mt-4 flex gap-2 items-center ">
        <a href="{{ route('aboutUs') }}" class="text-primary font-semibold text-xl">Read More</a>
        <x-heroicon-o-book-open class="w-4 h-4 text-orange-600" />
    </div>

</section>