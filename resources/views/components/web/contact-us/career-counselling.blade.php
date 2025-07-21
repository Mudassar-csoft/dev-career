<section class="px-3 md:px-7 lg:px-12 grid grid-cols-1 lg:grid-cols-2 gap-8 my-10">

    <!-- Left Content -->

    <div class="flex flex-col gap-3">

        <p class="text-lg font-semibold text-gray-500">Request a Free</p>
        <p class="text-2xl md:text-3xl font-bold text-gray-800">Career Counseling Session</p>

        <p class="text-gray-600 text-lg">
            We offer a complimentary, no-obligation career counseling session to
            learn about your aspirations and help you map out your path to success.
        </p>

        <!-- Contact Info Grid -->
        <div class="grid grid-cols-2 gap-3">
            <!-- Call Us -->
            <div class="flex gap-2 items-center">
                <img src="{{ asset('Web/assets/img/icons/v692_1096.png') }}" alt="Call Icon" class="w-10 h-10 md:w-14 md:h-14 bg-gray-600 p-2 rounded-lg" />
                <div>
                    <p class="font-semibold text-gray-800 text-xs">Call Us</p>
                    <p class="text-gray-600 text-xs">0341-4444010</p>
                    <p class="text-gray-600 text-xs">0314-4444010</p>
                </div>
            </div>

            <!-- Email -->
            <div class="flex gap-2 items-center">
                <img src="{{ asset('Web/assets/img/icons/v692_1094.png') }}" alt="Email Icon" class="w-10 h-10 md:w-14 md:h-14 bg-gray-600 p-2 rounded-lg" />
                <div>
                    <p class="font-semibold text-gray-800">Email</p>
                    <p class="text-gray-600 text-xs">info@career.edu.pk</p>
                </div>
            </div>

            <!-- Webex Meetings -->
            <div class="flex gap-2 items-center">
                <img src="{{ asset('Web/assets/img/icons/v692_1079.png') }}" alt="Webex Icon" class="w-10 h-10 md:w-14 md:h-14 bg-gray-600 p-2 rounded-lg" />
                <div>
                    <p class="font-semibold text-gray-800">Webex Meetings</p>
                    <p class="text-gray-600 text-xs">Career.pk</p>
                </div>
            </div>

            <!-- Office Hours -->
            <div class="flex gap-2 items-center">
                <img src="{{ asset('Web/assets/img/icons/v692_1095.png') }}" alt="Clock Icon" class="w-10 h-10 md:w-14 md:h-14 bg-gray-600 p-2 rounded-lg" />
                <div>
                    <p class="font-semibold text-gray-800">Office Hours</p>
                    <p class="text-gray-600 text-xs">Monday - Saturday</p>
                    <p class="text-gray-600 text-xs">09:00am - 06:00pm</p>
                </div>
            </div>
        </div>

    </div>

    <!-- Right Form -->

    <div>
        <p class="text-2xl md:text-3xl font-bold text-gray-800 ">Request a Call Back.</p>

        <p class="text-gray-600 ">
            Request a call back to take the first step towards achieving your goals.
            Let's connect and explore how we can turn your ambitions into reality.
        </p>

        <form action="{{ route('contectStore') }}" method="POST" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="text" name="name" required placeholder="Your Name"
                    class="w-full px-4 py-2 border border-gray-300 rounded focus:ring-2 focus:ring-[#1E9BB7]">
                <input type="email" name="email" required placeholder="Enter Email"
                    class="w-full px-4 py-2 border border-gray-300 rounded focus:ring-2 focus:ring-[#1E9BB7]">
                <input type="text" name="subject" required placeholder="Subject"
                    class="w-full px-4 py-2 border border-gray-300 rounded focus:ring-2 focus:ring-[#1E9BB7]">
                <input type="number" name="number" required placeholder="Phone"
                    class="w-full px-4 py-2 border border-gray-300 rounded focus:ring-2 focus:ring-[#1E9BB7]">
            </div>

            <textarea name="remaks" placeholder="Message" rows="4"
                class="w-full px-4 py-2 border border-gray-300 rounded focus:ring-2 focus:ring-[#1E9BB7]">
            </textarea>

            <div class="flex justify-end">
                <button type="submit"
                    class="bg-orange-600 text-white px-4 py-3 rounded-2xl">Send Message
                </button>
            </div>

        </form>

    </div>

</section>