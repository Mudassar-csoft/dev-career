<section class="mt-10">

   <div class="px-4">

      <div class="text-center mb-6">
         <h1 class="text-3xl font-bold">Gallery</h1>
         <div class="w-16 h-[2px] bg-gradient-to-r bg-orange-600 mx-auto mt-2"></div>
      </div>

      <div class="flex flex-wrap justify-center gap-2 mb-6" id="myDIV">
         @foreach($galleryTags as $tag)
         <button
            class="px-4 py-1 rounded-full text-gray-700 border hover:text-white hover:bg-gradient-to-r from-teal-400 to-green-400 transition filter-button"
            data-filter="{{ $tag->id }}">
            {{ $tag->title }}
         </button>
         @endforeach
      </div>

      @foreach($galleryTags as $tag)
      <div class="gallery-item hidden" data-category="{{ $tag->id }}">
         <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach($tag->gallery_images as $key => $image)
            @if($key < 8)
               <div class="relative overflow-hidden rounded-lg group">
               <img
                  src="{{ asset('storage/' . $image['image']) }}"
                  alt="{{ $image['title'] }}"
                  class="w-full h-48 sm:h-56 md:h-40 lg:h-48 object-cover transform transition-transform duration-300 group-hover:scale-110">
               <div
                  class="absolute inset-0 bg-gradient-to-t from-teal-600/70 to-green-500/70 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-center items-center rounded-lg">
                  <p class="text-lg font-bold text-white">{{ $image['title'] }}</p>
                  <!-- <a href="{{ asset('storage/' . $image['image']) }}"
                     data-gallery="portfolioGallery"
                     class="text-white text-2xl mt-2">
                     <i class="fa fa-eye"></i>
                  </a> -->
               </div>
         </div>
         @endif
         @endforeach
      </div>
   </div>
   @endforeach

   <div class="text-center mt-8">
      <a href="{{ route('gallery') }}"
         class="inline-block px-6 py-2 rounded-full border border-orange-500 text-white bg-gradient-to-r from-orange-600 to-orange-400 transition">
         Our Gallery
      </a>
   </div>
   </div>

   <script>
      document.addEventListener('DOMContentLoaded', () => {
         const items = document.querySelectorAll('.gallery-item');
         const buttons = document.querySelectorAll('.filter-button');

         if (buttons.length > 0) {
            const first = buttons[0];
            first.classList.add('bg-gradient-to-r', 'from-teal-400', 'to-green-400', 'text-white');
            document.querySelector(`.gallery-item[data-category="${first.dataset.filter}"]`).classList.remove('hidden');
         }

         buttons.forEach(btn => {
            btn.addEventListener('click', () => {
               items.forEach(i => i.classList.add('hidden'));
               buttons.forEach(b => b.classList.remove('bg-gradient-to-r', 'from-teal-400', 'to-green-400', 'text-white'));
               btn.classList.add('bg-gradient-to-r', 'from-teal-400', 'to-green-400', 'text-white');
               document.querySelector(`.gallery-item[data-category="${btn.dataset.filter}"]`).classList.remove('hidden');
            });
         });
      });
   </script>
</section>