@extends('layouts.web')


@section('webContent')

<div>
   @include('components.web.about-us.career-about')
   @include('components.web.about-us.career-about-cards')

   <div class="flex flex-col space-y-6 lg:flex-row lg:space-y-0 lg:gap-8 lg:items-start px-3 md:px-7 lg:px-12 my-10 md:my-12 lg:my-14">
      <div class="lg:w-2/3">
         @include('components.web.about-us.mission-purpose')
      </div>
      <div class="lg:w-1/3">
         @include('components.web.home.latest-news')
      </div>
   </div>



   @include('components.web.about-us.about-affiliation')
   @include('components.web.about-us.about-ceo')
</div>

@endsection