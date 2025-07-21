@extends('layouts.web')

@section('webContent')

<section class="px-3 my-10 md:px-7 lg:px-12 flex flex-col gap-10" x-data="{ tab: 'meezan' }">

    <div>

        <div class="flex flex-col gap-1 mb-5">
            <h4 class="text-sm md:text-2xl font-bold">
                Pay quickly and easily with your preferred methods.
            </h4>
            <div class="w-20 h-[1px] bg-[#FF4400]"></div>
        </div>

        <div class="flex flex-col lg:flex-row gap-6 lg:gap-20 lg:items-start items-center justify-center">
            <!-- Tabs Nav -->
            <div class="w-full lg:w-1/4">
                <div class="flex lg:flex-col gap-3">
                    <template x-for="(bank, i) in [
                        { id: 'meezan', img: '{{ url('Web/assets/img/Bank%20Logos/Meezan-Bank.png') }}' },
                        { id: 'hbl', img: '{{ url('Web/assets/img/Bank%20Logos/HBL.png') }}' },
                        { id: 'easypaisa', img: '{{ url('Web/assets/img/Bank%20Logos/Easy-Paisa.png') }}' }
                    ]" :key="bank.id">
                        <button @click="tab = bank.id"
                            :class="tab === bank.id ? 'bg-gray-100' : 'bg-white'"
                            class="relative flex items-center justify-center p-2 rounded shadow w-full transition">
                            <img :src="bank.img" class="w-full h-[80px] object-contain" alt="">
                            <!-- Desktop Arrow (Right) -->
                            <div
                                x-show="tab === bank.id"
                                class="hidden lg:block absolute right-0 lg:-right-4 top-1/2 -translate-y-1/2 border-t-[8px] border-b-[8px] border-t-transparent border-b-transparent border-l-[10px] border-l-[#ef5323]"></div>
                            <!-- Mobile/Tablet Arrow (Down) -->
                            <div
                                x-show="tab === bank.id"
                                class="block lg:hidden absolute top-full left-1/2 -translate-x-1/2 mt-1 border-l-[8px] border-r-[8px] border-l-transparent border-r-transparent border-t-[10px] border-t-[#ef5323]"></div>
                        </button>
                    </template>
                </div>
            </div>

            <!-- Tab Content -->
            <div class="w-full h-full min-h-[300px]">
                <!-- Meezan Bank -->
                <div x-show="tab === 'meezan'" class="overflow-x-auto">
                    <table class="min-w-full h-full text-sm text-left border border-gray-300 rounded-lg">
                        <tbody class="divide-y divide-gray-200">
                            <tr>
                                <th class="p-2 font-medium bg-gray-100 w-40">Bank Name</th>
                                <td class="p-2 font-semibold">Meezan Bank</td>
                            </tr>
                            <tr>
                                <th class="p-2 font-medium bg-gray-100">Account Title</th>
                                <td class="p-2 font-semibold">CAREER INSTITUTE (PRIVATE) LIMITED</td>
                            </tr>
                            <tr>
                                <th class="p-2 font-medium bg-gray-100">Account Number</th>
                                <td class="p-2 font-semibold">04070106379883</td>
                            </tr>
                            <tr>
                                <th class="p-2 font-medium bg-gray-100">Branch Code</th>
                                <td class="p-2 font-semibold">0407</td>
                            </tr>
                            <tr>
                                <th class="p-2 font-medium bg-gray-100">IBAN Number</th>
                                <td class="p-2 font-semibold">PK10MEZN0004070106379883</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- HBL -->
                <div x-show="tab === 'hbl'" class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left border border-gray-300 rounded-lg">
                        <tbody class="divide-y divide-gray-200">
                            <tr>
                                <th class="p-2 font-medium bg-gray-100 w-40">Bank Name</th>
                                <td class="p-2 font-semibold">HBL</td>
                            </tr>
                            <tr>
                                <th class="p-2 font-medium bg-gray-100">Account Title</th>
                                <td class="p-2 font-semibold">CAREER INSTITUTE (PRIVATE) LIMITED</td>
                            </tr>
                            <tr>
                                <th class="p-2 font-medium bg-gray-100">IBAN Number</th>
                                <td class="p-2 font-semibold">PK94HABB0002957901554603</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Easypaisa -->
                <div x-show="tab === 'easypaisa'" class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left border border-gray-300 rounded-lg">
                        <tbody class="divide-y divide-gray-200">
                            <tr>
                                <th class="p-2 font-medium bg-gray-100 w-40">Bank Name</th>
                                <td class="p-2 font-semibold">EasyPaisa</td>
                            </tr>
                            <tr>
                                <th class="p-2 font-medium bg-gray-100">Account Title</th>
                                <td class="p-2 font-semibold">Muhammad Adeel Javaid</td>
                            </tr>
                            <tr>
                                <th class="p-2 font-medium bg-gray-100">Account Number</th>
                                <td class="p-2 font-semibold">03145000083</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div>
        <h3 class="text-lg font-bold">Note:</h3>
        <p class="text-gray-700">
            Make payments to specified bank accounts through online banking, ATM, or internet banking for your course at
            Career.edu.pk. After payment, send deposit slip image with Course Name or invoice reference to
            <span class="font-bold text-black">accounts@career.edu.pk</span> or WhatsApp at
            <span class="font-bold text-black">0314-5000083</span>.
        </p>
    </div>

</section>

@endsection