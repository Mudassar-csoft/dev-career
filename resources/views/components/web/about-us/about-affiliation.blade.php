<section class="bg-white py-12 px-3 md:px-7 lg:px-12 w-full flex flex-col gap-8 lg:gap-10">


    <div class="flex flex-col gap-1">
        <h1 class="text-lg lg:text-3xl font-bold text-gray-800">
            Our <span class="">Affiliation</span>
        </h1>
        <div class="w-16 h-[2px] bg-[#ff5500]"></div>
    </div>


    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach ([
        'Cisco-Networking-Academy',
        'Oracle-Academy',
        'Microsoft-IT-Academy',
        'Pearson-Vue-test-center',
        'PSI-Exam-Center',
        'Kryterion-Test-Center',
        'British-Council',
        'Linux-Professional-Institute',
        'CInstitute',
        'Python-Institute',
        'VM-Ware-IT-Academy',
        'Android-Training-Center',
        'Paloalto-Academy',
        'Fortinet-Academy',
        'Navttc-Kamyab-Jawan'
        ] as $affiliation)
        <div
            class="group relative flex justify-center items-center bg-white rounded-xl shadow-md p-10 sm:p-14 transition duration-500 hover:scale-105 cursor-pointer overflow-hidden">

            <!-- Hover gradient background -->
             
            <div
                class="absolute inset-0 bg-gradient-to-br from-[#1E9BB7] to-[#60C380] opacity-0 scale-0 group-hover:opacity-100 group-hover:scale-100 transition-all duration-300 z-0 rounded-xl">
            </div>

            <!-- Affiliation logos -->

            <div class="relative z-10">
                <img src="{{ url('Web/assets/img/about-us/Color/' . $affiliation . '.png') }}"
                    alt="{{ $affiliation }}" class="simple-img block group-hover:hidden h-16 md:h-20 object-contain" />
                <img src="{{ url('Web/assets/img/about-us/White/' . $affiliation . '.png') }}"
                    alt="{{ $affiliation }}" class="hov-img hidden group-hover:block h-16 md:h-20 object-contain" />
            </div>
        </div>
        @endforeach
    </div>

</section>