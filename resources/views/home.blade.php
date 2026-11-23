@extends('layouts.main')

@section('content')
<!-- Hero Section -->
<div class="bg-white rounded-xl p-8 mb-8 text-center">
    <h1 class="text-3xl md:text-4xl font-bold text-blue-950 mb-3">University of Baguio Lost & Found Portal</h1>
    <p class="text-gray-600 max-w-2xl mx-auto mb-6">
        Lost something on campus or found an unattended item? Report it here to help reunite belongings with their rightful owners.
    </p>
    <div class="flex justify-center gap-4">
        <a href="{{ route('items.create') }}" class="bg-red-700 hover:bg-red-800 text-white px-6 py-3 rounded-lg font-semibold">
            Report Lost / Found Item
        </a>
        <a href="{{ route('items.found') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-3 rounded-lg font-semibold">
            Browse Found Items
        </a>
    </div>
</div>

<!-- Quick Stats -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
    <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-red-500">
        <div class="text-sm text-gray-500 uppercase">Active Lost Reports</div>
        <div class="text-3xl font-bold text-gray-900">{{ $stats['lost'] }}</div>
    </div>
    <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-emerald-500">
        <div class="text-sm text-gray-500 uppercase">Unclaimed Found Items</div>
        <div class="text-3xl font-bold text-gray-900">{{ $stats['found'] }}</div>
    </div>
    <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-blue-600">
        <div class="text-sm text-gray-500 uppercase">Items Returned</div>
        <div class="text-3xl font-bold text-gray-900">{{ $stats['resolved'] }}</div>
    </div>
</div>

<!-- Recent Found Items -->
<div class="mb-10">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold text-gray-800">Recently Found on Campus</h2>
        <a href="{{ route('items.found') }}" class="text-blue-700 hover:underline text-sm font-semibold">View All &rarr;</a>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @forelse($recentFound as $item)
            <div class="bg-white rounded-lg shadow-sm border overflow-hidden">
                @if($item->image_path)
                    <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->title }}" class="w-full h-40 object-cover">
                @else
                    <div class="w-full h-40 bg-gray-200 flex items-center justify-center text-gray-400 text-sm">No Image</div>
                @endif
                <div class="p-4">
                    <span class="text-xs bg-emerald-100 text-emerald-800 px-2 py-0.5 rounded font-semibold">{{ $item->category }}</span>
                    <h3 class="font-bold text-lg mt-1">{{ $item->title }}</h3>
                    <p class="text-sm text-gray-500">📍 {{ $item->location }}</p>
                    <p class="text-xs text-gray-400 mt-1">{{ $item->date_reported->format('M d, Y') }}</p>
                </div>
            </div>
        @empty
            <p class="text-gray-500 col-span-4">No found items reported yet.</p>
        @endforelse
    </div>
</div>

<!-- Recent Lost Items -->
<div>
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold text-gray-800">Recently Reported Lost</h2>
        <a href="{{ route('items.lost') }}" class="text-blue-700 hover:underline text-sm font-semibold">View All &rarr;</a>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @forelse($recentLost as $item)
            <div class="bg-white rounded-lg shadow-sm border overflow-hidden">
                @if($item->image_path)
                    <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->title }}" class="w-full h-40 object-cover">
                @else
                    <div class="w-full h-40 bg-gray-200 flex items-center justify-center text-gray-400 text-sm">No Image</div>
                @endif
                <div class="p-4">
                    <span class="text-xs bg-red-100 text-red-800 px-2 py-0.5 rounded font-semibold">{{ $item->category }}</span>
                    <h3 class="font-bold text-lg mt-1">{{ $item->title }}</h3>
                    <p class="text-sm text-gray-500">📍 {{ $item->location }}</p>
                    <p class="text-xs text-gray-400 mt-1">{{ $item->date_reported->format('M d, Y') }}</p>
                </div>
            </div>
        @empty
            <p class="text-gray-500 col-span-4">No lost items reported yet.</p>
        @endforelse
    </div>
</div>
@endsection
