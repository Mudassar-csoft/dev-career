<style>
    [x-cloak] {
        display: none !important;
    }
</style>

{{-- Top Bar --}}
<div class="bg-[#05284A] w-full flex flex-col sm:flex-row justify-between px-0 md:px-7 lg:px-8">

    <!-- Left: Phone & Email -->
    <div
        class="flex items-center justify-between sm:justify-start bg-gradient-to-r from-[#2BA6AF] to-[#61C27C] sm:bg-none w-full sm:w-auto flex-1 sm:flex-initial gap-4 text-xs sm:text-sm lg:text-sm px-2 sm:px-4 py-3 sm:py-5">
        <p class="flex items-center text-white gap-1">
            <x-heroicon-o-phone class="w-4 h-4 text-white" />
            <a href="tel:+923144444010" class="text-white">+92 314 4444010</a>
        </p>
        <p class="flex items-center text-white gap-1">
            <x-heroicon-o-envelope class="w-4 h-4 text-white" />
            <a href="mailto:info@career.edu.pk" class="text-white">info@career.edu.pk</a>
        </p>
    </div>

    <!-- Right: Links and Search -->

    <div
        class="flex items-center justify-between w-full sm:w-auto flex-1 sm:flex-initial gap-3 sm:gap-6 text-xs sm:text-sm py-2 sm:py-0 px-2 sm:px-0">
        <div class="flex flex-wrap justify-center sm:justify-start gap-2 text-white">
            <a class="text-light" data-toggle="modal" data-target="#admissionform">Online Admission</a>
            <a class="hidden lg:block" href="{{ route('howToPay') }}">How to Pay</a>
            <a class="hidden lg:block" href="{{ route('verification') }}">Verification</a>
            <a class="hidden lg:block" href="{{ route('career-job') }}">Job Placement</a>
            <a class="hidden lg:block" href="{{ route('ambassadorProgram') }}">Ambassador Program</a>
            <a href="#" class="hidden lg:block">Success Stories</a>
        </div>

        <!-- Search -->
        <div class="flex items-center gap-2 lg:hidden xl:block">
            <input type="text" placeholder="Search..."
                class="lg:hidden text-gray-400 p-[2px] rounded bg-inherit border border-gray-400 w-28 sm:w-44">
            <button class="bg-[#ff5500] rounded flex items-center justify-center">
                <x-heroicon-o-magnifying-glass class="w-6 h-6 text-white" />
            </button>
        </div>
    </div>

</div>

{{-- Sticky Navbar --}}
<div x-data="{ open: false, isSticky: false, openDropdown: null }"
    x-init="window.addEventListener('scroll', () => isSticky = window.scrollY > 20)" class="sticky top-0 z-50"
    style="transform: translateZ(0);">

    <nav :class="isSticky 
                ? 'bg-gradient-to-r from-[#2BA6AF] to-[#61C27C] shadow-md py-2' 
                : 'bg-gradient-to-r from-[#2BA6AF] to-[#61C27C] py-2'"
        class="transition-all duration-300 text-white px-[4px] md:px-4 lg:px-8">

        <div class="flex justify-between items-center transition-all duration-300">

            <!-- Logo + Small Links -->
            <a href="{{ route('index') }}" class="flex items-center gap-1 sm:gap-1 transition-all duration-300">
                <img class="w-[100px] h-[60px] sm:w-[150px] sm:h-[90px] md:w-[160px] md:h-[100px] lg:w-[140px] lg:h-[100px]"
                    src="https://career.edu.pk/Web/assets/img/logo/career-revised-logo.png" alt="Logo" />

                <div
                    class="flex flex-col sm:gap-[1px] md:gap-0 lg:gap-1 text-[10px] sm:text-[13px] md:text-md lg:text-sm transition-all duration-300">
                    <span>Trainings</span>
                    <span>Study Abroad</span>
                    <span>Certification</span>
                    <span>Co-working Space</span>
                </div>
            </a>


            <!-- Hamburger -->
            <button @click="open = !open" class="lg:hidden">
                <template x-if="!open">
                    <x-heroicon-o-bars-3 class="w-8 md:w-10 h-8 md:h-10 text-white" />
                </template>
                <template x-if="open">
                    <x-heroicon-o-x-mark class="w-8 h-8 text-white" />
                </template>
            </button>

            <!-- Desktop Links -->
            <div
                class="hidden lg:flex lg:space-x-3 xl:space-x-6 justify-between items-center lg:text-sm xl:text-md transition-all duration-300 mr-0 sm:mr-3">

                <a href="/">Home</a>

                <a href="{{ route('aboutUs') }}">About</a>

                <!-- Trainings Dropdown -->
                <div x-data="{ openDropdown: null, timeoutId: null }"
                    @mouseenter="clearTimeout(timeoutId); openDropdown = 'programs'"
                    @mouseleave="timeoutId = setTimeout(() => openDropdown = null, 200)" class="relative">
                    <button @click="openDropdown = openDropdown === 'programs' ? null : 'programs'"
                        class="flex items-center gap-1">
                        Trainings ▾
                    </button>
                    <div x-show="openDropdown === 'programs'" x-cloak @click.away="openDropdown = null"
                        @mouseenter="clearTimeout(timeoutId)"
                        @mouseleave="timeoutId = setTimeout(() => openDropdown = null, 200)"
                        class="absolute left-0 mt-2 w-60 bg-white text-black shadow-md rounded z-50 p-2 space-y-2">
                        <a href="{{ route('courses') }}" class="block hover:bg-gray-100 px-2 py-1">Courses &
                            Certifications</a>
                        <a href="#" class="block hover:bg-gray-100 px-2 py-1">Intermediate (HSSC)</a>
                        <a href="#" class="block hover:bg-gray-100 px-2 py-1">Associate Degree (ADP)</a>
                    </div>
                </div>

                <!-- Testing Services Dropdown -->
                <div x-data="{ openDropdown: null, timeoutId: null }"
                    @mouseenter="clearTimeout(timeoutId); openDropdown = 'testing'"
                    @mouseleave="timeoutId = setTimeout(() => openDropdown = null, 200)" class="relative">
                    <button @click="openDropdown = openDropdown === 'testing' ? null : 'testing'"
                        class="flex items-center gap-1">
                        Testing Services ▾
                    </button>
                    <div x-show="openDropdown === 'testing'" x-cloak @click.away="openDropdown = null"
                        @mouseenter="clearTimeout(timeoutId)"
                        @mouseleave="timeoutId = setTimeout(() => openDropdown = null, 200)"
                        class="absolute left-0 mt-2 w-72 bg-white text-black shadow-md rounded z-50 p-2 space-y-2">
                        <a href="{{ route('pearsonTesting') }}" class="block hover:bg-gray-100 px-2 py-1">Pearson
                            VUE</a>
                        <a href="{{ route('psiExamCenter') }}" class="block hover:bg-gray-100 px-2 py-1">PSI Exam
                            Center</a>
                        <a href="{{ route('kryterionTestingCenter') }}"
                            class="block hover:bg-gray-100 px-2 py-1">Kryterion Testing</a>
                    </div>
                </div>

                <a href="Workspace">Coworking Space</a>

                <a href="{{ route('studyAbroad') }}">Study Abroad</a>

                <a href="{{ route('contactUs') }}">Contact Us</a>

            </div>

        </div>

        <!-- Mobile Menu -->
        <div x-show="open" x-transition
            class="lg:hidden md:flex flex-col justify-between px-2 md:px-7 py-3 space-y-3 text-md">
            <a href="/" class="block">Home</a>
            <a href="{{ route('aboutUs') }}" class="block">About</a>

            <!-- Trainings Dropdown -->
            <div @mouseenter="openDropdown = 'programs'" @mouseleave="openDropdown = null" class="relative">
                <button @click="openDropdown = openDropdown === 'programs' ? null : 'programs'"
                    class="flex items-center gap-1">Trainings ▾</button>
                <div x-show="openDropdown === 'programs'" x-cloak @click.away="openDropdown = null"
                    class="absolute left-0 mt-2 w-60 bg-white text-black shadow-md rounded z-50 p-2 space-y-2">
                    <a href="{{ route('courses') }}" class="block hover:bg-gray-100 px-2 py-1">Courses &
                        Certifications</a>
                    <a href="#" class="block hover:bg-gray-100 px-2 py-1">Intermediate (HSSC)</a>
                    <a href="#" class="block hover:bg-gray-100 px-2 py-1">Associate Degree (ADP)</a>
                </div>
            </div>

            <!-- Testing Services Dropdown -->
            <div @mouseenter="openDropdown = 'testing'" @mouseleave="openDropdown = null" class="relative">
                <button @click="openDropdown = openDropdown === 'testing' ? null : 'testing'"
                    class="flex items-center gap-1">Testing Services ▾</button>
                <div x-show="openDropdown === 'testing'" x-cloak @click.away="openDropdown = null"
                    class="absolute left-0 mt-2 w-72 bg-white text-black shadow-md rounded z-50 p-2 space-y-2">
                    <a href="{{ route('pearsonTesting') }}" class="block hover:bg-gray-100 px-2 py-1">Pearson VUE</a>
                    <a href="{{ route('psiExamCenter') }}" class="block hover:bg-gray-100 px-2 py-1">PSI Exam Center</a>
                    <a href="{{ route('kryterionTestingCenter') }}" class="block hover:bg-gray-100 px-2 py-1">Kryterion
                        Testing</a>
                </div>
            </div>
            <a href="{{ route('Workspace') }}" class="block">Coworking Space</a>
            <a href="{{ route('studyAbroad') }}" class="block">Study Abroad</a>
            <a href="{{ route('contactUs') }}" class="block">Contact Us</a>
            <a class="block" href="{{ route('howToPay') }}">How to Pay</a>
            <a class="block" href="{{ route('verification') }}">Verification</a>
            <a class="block" href="{{ route('career-job') }}">Job Placement</a>
            <a class="block" href="{{ route('ambassadorProgram') }}">Ambassador Program</a>
            <a href="#" class="block">Success Stories</a>
        </div>

    </nav>
    
</div>