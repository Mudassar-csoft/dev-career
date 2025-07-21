@extends('layouts.web')
@section('webContent')
<div class="max-w-4xl mx-auto my-10 bg-white shadow-md rounded p-6">
   <h1 class="text-3xl text-orange-600 font-bold text-center">Verifications</h1>
   <p class="text-center text-gray-600 mt-2">
      Verify your Certificate by entering the provided Verification ID.
   </p>

   <!-- Tabs -->
   <div class="flex justify-center mt-6 ">
      <button
         class="px-4 py-2 text-orange-600 border-b-2 border-orange-600 font-bold"
         disabled>
         Certificate
      </button>
      <button
         class="px-4 py-2 text-gray-400 cursor-not-allowed"
         disabled>
         Internship Letter
      </button>
      <button
         class="px-4 py-2 text-gray-400 cursor-not-allowed"
         disabled>
         Experience Letter
      </button>
   </div>

   <!-- Input -->
   <div class="mt-8 flex justify-center">
      <input
         type="text"
         id="roll_number"
         placeholder="Verification ID"
         class="w-1/2 px-3 py-2 border rounded focus:outline-none">
   </div>

   <!-- Button -->
   <div class="mt-4 flex justify-center">
      <button
         id="submit_Button"
         class="px-4 py-2 bg-orange-500 text-white rounded hover:bg-orange-600">
         Verify Now
      </button>
   </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('js/verify.js') }}"></script>
@endpush