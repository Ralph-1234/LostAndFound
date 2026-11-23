@extends('layouts.main')

@section('content')
<div class="max-w-xl mx-auto space-y-8">
    <div class="bg-white p-6 rounded-xl shadow-sm border">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Profile Information</h2>

        <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
            @csrf
            @method('PATCH')

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Name</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                       class="w-full border rounded-lg px-3 py-2">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                       class="w-full border rounded-lg px-3 py-2">
            </div>

            <button type="submit" class="bg-gray-500 hover:bg-red-700 text-white font-semibold px-4 py-2 rounded-lg text-sm">
                Save Changes
            </button>
        </form>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-red-200">
        <h2 class="text-xl font-bold text-red-700 mb-2">Delete Account</h2>
        <p class="text-sm text-gray-600 mb-4">Enter your password to permanently delete your account and reported items.</p>

        <form method="POST" action="{{ route('profile.destroy') }}" class="space-y-4">
            @csrf
            @method('DELETE')

            <div>
                <input type="password" name="password" placeholder="Current Password" required
                       class="w-full border rounded-lg px-3 py-2">
            </div>

            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2 rounded-lg text-sm">
                Delete Account
            </button>
        </form>
    </div>
</div>
@endsection
