@php
$bg = asset('Web/assets/img/workspace/co-work-bg.jpg');
@endphp

<section>
    <div class="w-full h-[300px] bg-center bg-cover bg-black/60 bg-blend-darken flex flex-col justify-center items-center text-center px-4 text-white"
        style="background-image: url('{{ $bg }}');">
        <h1 class="text-2xl md:text-3xl font-bold">Make a Difference With Your</h1>
        <h1 class="text-2xl md:text-3xl font-bold">Online Resume!</h1>

        <button class="mt-4 inline-flex items-center gap-2 bg-cyan-600 hover:bg-cyan-700 text-white font-semibold py-2 px-5 rounded-full transition">
            Build Resume
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                class="bi bi-chevron-right" viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                    d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708" />
            </svg>
        </button>
    </div>
</section>