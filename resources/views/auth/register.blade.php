@extends('layouts.main')

@section('content')
<div class="max-w-md mx-auto bg-white p-8 rounded-xl shadow-sm border">
    <h1 class="text-2xl font-bold text-gray-900 mb-6 text-center">Create an Account</h1>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Full Name</label>
            <input type="text" name="name" value="{{ old('name') }}" required autofocus
                   class="w-full border rounded-lg px-3 py-2">
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required
                   class="w-full border rounded-lg px-3 py-2">
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
            <input type="password" name="password" required
                   class="w-full border rounded-lg px-3 py-2">
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Confirm Password</label>
            <input type="password" name="password_confirmation" required
                   class="w-full border rounded-lg px-3 py-2">
        </div>

        <button type="submit" class="w-full bg-gray-500 hover:bg-red-800 text-white font-semibold py-2.5 rounded-lg">
            Register
        </button>
    </form>

    <p class="text-center text-sm text-gray-600 mt-4">
        Already registered? <a href="{{ route('login') }}" class="text-red-700 font-semibold hover:underline">Login</a>
    </p>
</div>
@endsection
