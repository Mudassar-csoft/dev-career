@php
$bg = asset('Web/assets/img/job-placement/job-online.jpeg');
@endphp
<section>
    <div class="w-full h-[550px] bg-center bg-cover bg-black/80 bg-blend-darken flex flex-col justify-center items-center text-center px-4"
         style="background-image: url('{{ $bg }}');"
    >
        <p class="text-white text-lg md:text-xl mb-2">Transform Your Future</p>
        <p class="text-white text-2xl md:text-4xl font-semibold mb-1">Discover Opportunities</p>
        <p class="text-white text-2xl md:text-4xl font-semibold mb-6">
            That <span class="text-cyan-400 font-bold">Inspire !</span>
        </p>
        <div class="flex flex-col sm:flex-row gap-4">
            <a href="#submit_resume" class="bg-[#00CFE5] hover:bg-[#00bcd4] text-white font-semibold py-2 px-6 rounded-full transition">
                Submit Resume
            </a>
            <a href="{{ route('postjob') }}" class="bg-[#00CFE5] hover:bg-[#00bcd4] text-white font-semibold py-2 px-6 rounded-full transition">
                Post a Job
            </a>
        </div>
    </div>
</section>