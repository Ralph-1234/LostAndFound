@extends('layouts.main')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow-sm border">
    <h1 class="text-2xl font-bold text-gray-900 mb-2">Submit Item Report</h1>
    <p class="text-sm text-gray-600 mb-6">Provide accurate details to help match lost and found items quickly.</p>

    <form method="POST" action="{{ route('items.store') }}" enctype="multipart/form-data" class="space-y-5">
        @csrf

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Report Type</label>
            <select name="type" required class="w-full border rounded-lg px-3 py-2">
                <option value="lost">I Lost an Item</option>
                <option value="found">I Found an Item</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Item Name / Title</label>
            <input type="text" name="title" required placeholder="e.g., Blue Hydro Flask, Scientific Calculator"
                   class="w-full border rounded-lg px-3 py-2">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Category</label>
                <select name="category" required class="w-full border rounded-lg px-3 py-2">
                    @foreach(['Electronics', 'ID/Cards', 'Books', 'Bags', 'Keys', 'Clothing', 'Other'] as $cat)
                        <option value="{{ $cat }}">{{ $cat }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Date Lost / Found</label>
                <input type="date" name="date_reported" value="{{ date('Y-m-d') }}" required
                       class="w-full border rounded-lg px-3 py-2">
            </div>
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Campus Location</label>
            <input type="text" name="location" required placeholder="e.g., Main Library 2nd Floor, Canteen, Gym"
                   class="w-full border rounded-lg px-3 py-2">
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Description</label>
            <textarea name="description" rows="4" required placeholder="Color, brand, distinguishing features..."
                      class="w-full border rounded-lg px-3 py-2"></textarea>
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Photo (Optional)</label>
            <input type="file" name="image" accept="image/*" class="block w-full text-sm text-gray-600 border border-gray-300 rounded-lg cursor-pointer bg-gray-50
                    file:mr-4 file:py-2 file:px-4 file:rounded-l-lg file:border-0
                    file:text-sm file:font-semibold file:bg-gray-600 file:text-white
                     hover:file:bg-red-400">
             <p class="mt-1 text-xs text-gray-500">PNG, JPG, or WEBP (Max 2MB)</p>
        </div>

        <button type="submit" class="w-full bg-gray-600 hover:bg-red-400 text-white font-semibold py-3 rounded-lg">
            Submit Report
        </button>
    </form>
</div>
@endsection
