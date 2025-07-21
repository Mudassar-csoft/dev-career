<section class="flex flex-col gap-4">

    <div class="flex flex-col gap-[2px] mb-5">
        <h1 class="text-2xl font-bold"><span class="text-primary">Events</span></h1>
        <div class="h-[1px] w-12 bg-[#ef5922]"></div>
    </div>

    <div class="second-div-of-event-component flex flex-col gap-4 ">

        @foreach ([
        ['month' => 'DEC', 'day' => '18', 'title' => 'Inauguration Career Institute Lahore Wapda Town Branch', 'location' => 'Lahore, Pakistan', 'color' => 'bg-yellow-400'],
        ['month' => 'JAN', 'day' => '25', 'title' => 'Inauguration Career Institute Sargodha Branch', 'location' => 'Sargodha, Pakistan', 'color' => 'bg-orange-600'],
        ['month' => 'DEC', 'day' => '09', 'title' => 'Career Institute Signs Franchise MOU for Kohinoor Faisalabad Branch', 'location' => 'Faisalabad, Pakistan', 'color' => 'bg-blue-900'],
        ] as $event)

        <div class="div-inside-foreach flex items-center justify-center gap-4">

            <div class="flex flex-col justify-center items-center text-white w-24 h-24 {{ $event['color'] }}">

                <div class="text-xs sm:text-lg font-semibold">{{ $event['month'] }}</div>
                <div class="text-2xl font-bold">{{ $event['day'] }}</div>

            </div>

            <div class="flex-1">

                <h5 class="text-sm font-medium">{{ $event['title'] }}</h5>

                <div class="flex items-center text-sm text-gray-600">
                    <svg class="w-3 h-4 text-orange-600" fill="currentColor" viewBox="0 0 16 21">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M7.78402 5.83802C6.70918 5.83802 5.83802 6.70918 5.83802 7.78402C5.83802 8.85887 6.70918 9.73003 7.78402 9.73003C8.85887 9.73003 9.73003 8.85887 9.73003 7.78402C9.73003 6.70918 8.85887 5.83802 7.78402 5.83802ZM7.78402 11.0274C5.99305 11.0274 4.54068 9.57565 4.54068 7.78402C4.54068 5.9924 5.99305 4.54068 7.78402 4.54068C9.575 4.54068 11.0274 5.9924 11.0274 7.78402C11.0274 9.57565 9.575 11.0274 7.78402 11.0274ZM7.78402 0C3.4853 0 0 3.4853 0 7.78402C0 11.039 6.48993 20.7645 7.78402 20.7574C9.05801 20.7645 15.568 10.9949 15.568 7.78402C15.568 3.4853 12.0827 0 7.78402 0Z" />
                    </svg>
                    <span>{{ $event['location'] }}</span>
                </div>

            </div>

        </div>
        @endforeach
        
    </div>


    <div class="flex items-center gap-1 mt-6">
        <a href="#" class="text-primary font-semibold text-xl">View Events</a>
        <x-heroicon-o-calendar class="w-4 h-4 text-orange-600" />
    </div>

</section>