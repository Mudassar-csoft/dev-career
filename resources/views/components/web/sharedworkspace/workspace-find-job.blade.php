<!-- find job section start -->
<section class="px-3 md:px-8 lg:px-12 my-10">

    <div class="w-full">

        <!-- Filters Section -->
        <div class="grid grid-cols-1 md:grid-cols-1 gap-4 md:gap-3 lg:grid-cols-5">
            <!-- Title -->
            <div class="md:col-span-1">
                <div class="flex flex-col gap-2">
                    <h1 class="text-4xl">Find Jobs</h1>
                    <div class="bg-orange-600 w-20 h-[2px]"></div>
                </div>
            </div>

            <!-- Keyword Search -->
            <div>
                <div class="flex items-center border rounded-md overflow-hidden">
                    <span class="bg-gray-100 px-3 text-gray-500">
                        <i class="fa fa-search"></i>
                    </span>
                    <input type="text" id="keyword" placeholder="Search keyword..."
                        class="w-full px-2 py-2 text-sm outline-none" />
                </div>
            </div>

            <!-- Location Search -->
            <div>
                <div class="flex items-center border rounded-md overflow-hidden">
                    <span class="bg-gray-100 px-3 text-gray-500">
                        <i class="fa fa-map-marker"></i>
                    </span>
                    <input type="text" id="location" placeholder="Search location..."
                        class="w-full px-2 py-2 text-sm outline-none" />
                </div>
            </div>

            <!-- Job Type -->
            <div>
                <div class="flex items-center border rounded-md overflow-hidden">
                    <span class="bg-gray-100 px-3 text-gray-500">
                        <i class="fa fa-briefcase"></i>
                    </span>
                    <input type="text" id="jobType" placeholder="Job type..."
                        class="w-full px-2 py-2 text-sm outline-none" />
                </div>
            </div>

            <!-- Search Button -->
            <div class="text-right">
                <button id="searchBtn"
                    class="bg-cyan-600 hover:bg-cyan-700 text-white px-4 py-2 rounded-md w-full md:w-auto">
                    Search
                </button>
            </div>
        </div>

        <!-- Job Listings Table -->
        <div class="overflow-x-auto mt-6">
            <table class="w-full min-w-[800px] text-left border-separate border-spacing-y-2">
                <thead>
                    <tr class="text-gray-700 font-semibold text-sm border-b">
                        <th>Job Title</th>
                        <th>Type</th>
                        <th>Company</th>
                        <th>Location</th>
                        <th>Deadline</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($jobplace as $jobs)
                    <tr class="bg-white shadow-sm rounded-md">
                        <td class="py-2 px-3">
                            <p class="font-bold">{{ $jobs->title }}</p>
                            <div class="flex items-center text-sm text-gray-500 mt-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="#1E9BB7"
                                    class="mr-1" viewBox="0 0 16 16">
                                    <path
                                        d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z" />
                                    <path
                                        d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0" />
                                </svg>
                                2 Days Ago
                            </div>
                        </td>
                        <td class="py-2 px-3">
                            <span
                                class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-md inline-block">{{ $jobs->job_type }}</span>
                        </td>
                        <td class="py-2 px-3">{{ $jobs->company }}</td>
                        <td class="py-2 px-3">
                            <div class="flex items-center text-sm text-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#1E9BB7"
                                    class="mr-1" viewBox="0 0 16 16">
                                    <path
                                        d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A32 32 0 0 1 8 14.58a32 32 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10" />
                                    <path
                                        d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4m0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                                </svg>
                                {{ $jobs->location }}
                            </div>
                        </td>
                        <td class="py-2 px-3">{{ $jobs->deadline }}</td>
                        <td class="py-2 px-3">
                            <button
                                class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-3 py-1 rounded-md">Apply
                                Now</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

</section>
<!-- find job section end -->