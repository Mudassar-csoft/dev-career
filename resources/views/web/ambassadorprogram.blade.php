@extends('layouts.web')


@section('webContent')

    @include('components.web.ambassador.ambassador-hero')
    @include('components.web.ambassador.ambassador-job-resource')
    @include('components.web.ambassador.ambassador-perk')
    @include('components.web.ambassador.ambassador-form')
    @include('components.web.home.intro-video')

@endsection