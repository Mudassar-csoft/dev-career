@extends('layouts.web')


@section('webContent')

<div>

   @include('components.web.sharedworkspace.workspace-hero')
   @include('components.web.sharedworkspace.workspace-categories')
   @include('components.web.sharedworkspace.workspace-job-source')
   @include('components.web.sharedworkspace.workspace-resume')
   @include('components.web.sharedworkspace.workspace-find-job')
   

</div>

@endsection