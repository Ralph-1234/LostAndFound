@extends('layouts.main')

@section('content')
<div class="max-w-md mx-auto bg-white p-8 rounded-xl shadow-sm border">
    <h1 class="text-2xl font-bold text-gray-900 mb-6 text-center">Login to UB Lost & Found</h1>

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus
                   class="w-full border rounded-lg px-3 py-2">
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
            <input type="password" name="password" required
                   class="w-full border rounded-lg px-3 py-2">
        </div>

        <div class="flex items-center">
            <input type="checkbox" name="remember" id="remember" class="rounded border-gray-300">
            <label for="remember" class="ml-2 text-sm text-gray-600">Remember me</label>
        </div>

        <button type="submit" class="w-full bg-gray-500 hover:bg-red-800 text-white font-semibold py-2.5 rounded-lg">
            Login
        </button>
    </form>

    <p class="text-center text-sm text-gray-600 mt-4">
        Don't have an account? <a href="{{ route('register') }}" class="text-red-700 font-semibold hover:underline">Register</a>
    </p>
</div>
@endsection
