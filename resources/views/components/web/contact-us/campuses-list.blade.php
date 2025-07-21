<section class="px-3 md:px-8 lg:px-12 py-10">

    <h2 class="text-3xl font-bold text-gray-800 mb-8">All Campuses</h2>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left: Campus List -->
        <div class="col-span-1 lg:col-span-2 max-h-[500px] overflow-y-auto pr-2">
            <ul class="space-y-6">
                @foreach($campuses as $campus)
                <li class="flex gap-4 items-start border-b pb-4">
                    <!-- Icon -->
                    <div class="pt-1 text-[#1E9BB7]">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M3 13h2v-2H3v2zm0 4h2v-2H3v2zm0-8h2V7H3v2zm4 8h14v-2H7v2zm0-4h14v-2H7v2zm0-6v2h14V7H7z" />
                        </svg>
                    </div>

                    <!-- Campus Info -->
                    <div>
                        <p class="text-lg font-semibold text-gray-900">{{ $campus['name'] }}</p>
                        <p class="text-gray-600 text-sm">{{ $campus['address'] }}</p>
                        <p class="text-gray-600 text-sm">{{ $campus['phone'] }}</p>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>

        <!-- Right: Google Map -->
        <div class="col-span-1">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d13625.84825543522!2d73.06473315000001!3d31.43365965!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x391901a6112a9a05%3A0x3125ac930bfd13d6!2sCareer%20Institute%20-%20Millat%20Chowk%20Campus!5e0!3m2!1sen!2s!4v1624547284206!5m2!1sen!2s"
                class="w-full h-[500px] rounded-lg shadow-md border"
                style="border:0;"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </div>

</section>