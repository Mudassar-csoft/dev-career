{{--webLayout--}}
@extends('layouts.web')

@section('webContent')

<div>

    @include('components.web.home.counseling-form')
    
    <section class="homepage-maaiin-define-ha grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-7 lg:gap-4 md:gap-4 px-3 space-y-3 sm:space-y-0  md:px-10 lg:px-11 mt-[760px] sm:mt-[300px] md:mt-[370px] lg:mt-[180px]">
        @include('components.web.home.latest-news')
        @include('components.web.home.events')
        @include('components.web.home.why-choose-us')
    </section>

    @include('components.web.home.ceo-quote')

    @include('components.web.home.featured-courses')

    @include('components.web.home.intro-video')

    @include('components.web.home.affiliation')

    @include('components.web.home.blogs-articles', [
    'blog' => $blog ?? []
    ])

    @include('components.web.home.partner')
    
    @include('components.web.home.gallery', [
    'galleryTags' => $galleryTags ?? []
    ])

</div>

@endsection