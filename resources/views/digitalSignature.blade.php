@extends('layouts.adminmaster')

@section('content')
<div class="min-h-screen bg-gray-100 flex items-center justify-center p-4">
  <form action="/confirm" method="POST" class="bg-white p-10 rounded-lg shadow-lg max-w-xl w-full">
    @csrf
    <h1 class="text-2xl font-bold text-center mb-4">Employment Agreement (GIL)</h1>
    <p class="mb-4 text-justify text-gray-600">
      Please fill in your details and sign below to confirm your acceptance of the employment terms.
    </p>
    <!-- Display Success Message -->
    @if (session('success'))
    <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
      {{ session('success') }}
    </div>
    @endif
    
    <!-- Display Error Messages -->
    @if ($errors->any())
    <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
      <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif
    
    <div class="mb-4">
      <label for="name" class="block text-lg text-gray-700 font-medium mb-1">Full Name</label>
      <input type="text" id="name" name="name"
      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
      placeholder="Enter your full name" required />
    </div>
    
    <div class="mb-4">
      <label for="email" class="block text-lg text-gray-700 font-medium mb-1">Email Address</label>
      <input type="email" id="email" name="email"
      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
      placeholder="Enter your email" required />
    </div>
    
    <div class="mb-4">
      <label for="itemname" class="block text-lg text-gray-700 font-medium mb-1">Related Item</label>
      <input type="text" id="itemname" name="itemname"
      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
      placeholder="Enter Name of Inventory" required />
    </div>
    
    <div class="mb-4">
      <label for="description" class="block text-lg text-gray-700 font-medium mb-1">Description</label>
      <textarea id="description" name="description" rows="3"
      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
      placeholder="Add any additional notes or description..." required></textarea>
    </div>
    
    <!-- Signature Pad -->
    <div class="mb-6">
      <label class="block text-lg text-gray-700 font-medium mb-2">Signature</label>
      <x-creagia-signature-pad name='sign' />
    </div>
    
    <!-- Submit Button -->
    <div class="text-center">
      <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-8 rounded-lg transition duration-200 ease-in-out transform hover:scale-105">
        Submit Agreement
      </button>
    </div>
  </form>
</div>

<!-- Sign-pad js -->
<script src="{{ asset('vendor/sign-pad/sign-pad.min.js') }}"></script>
@endsection