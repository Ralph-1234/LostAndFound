@extends('layouts.main')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Found Items Directory</h1>
        <p class="text-gray-600 text-sm">Spot your missing belonging? Submit a claim request with proof of ownership.</p>
    </div>

    <form method="GET" action="{{ route('items.found') }}" class="flex flex-wrap gap-2">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search title or location..."
               class="border rounded-lg px-3 py-2 text-sm">

        <select name="category" class="border rounded-lg px-3 py-2 text-sm">
            <option value="">All Categories</option>
            @foreach(['Electronics', 'ID/Cards', 'Books', 'Bags', 'Keys', 'Clothing', 'Other'] as $cat)
                <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
            @endforeach
        </select>

        <select name="status" class="border rounded-lg px-3 py-2 text-sm">
            <option value="open" {{ request('status', 'open') === 'open' ? 'selected' : '' }}>Open Items</option>
            <option value="resolved" {{ request('status') === 'resolved' ? 'selected' : '' }}>Resolved / Claimed</option>
        </select>

        <button type="submit" class="bg-blue-900 text-white px-4 py-2 rounded-lg text-sm font-semibold">Search</button>
    </form>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    @forelse($items as $item)
        <div class="bg-white rounded-lg shadow-sm border overflow-hidden flex flex-col justify-between">
            <div>
                @if($item->image_path)
                    <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->title }}" class="w-full h-48 object-cover">
                @else
                    <div class="w-full h-48 bg-gray-100 flex items-center justify-center text-gray-400">No Photo Provided</div>
                @endif
                <div class="p-5">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-xs bg-emerald-100 text-emerald-800 px-2.5 py-0.5 rounded-full font-semibold">{{ $item->category }}</span>
                        <span class="text-xs uppercase font-bold {{ $item->status === 'resolved' ? 'text-gray-500' : 'text-emerald-600' }}">
                            {{ $item->status }}
                        </span>
                    </div>
                    <h2 class="text-lg font-bold text-gray-900">{{ $item->title }}</h2>
                    <p class="text-sm text-gray-600 mt-1">{{ $item->description }}</p>
                    <div class="mt-4 text-xs text-gray-500 space-y-1">
                        <p><strong>Found At:</strong> {{ $item->location }}</p>
                        <p><strong>Date Found:</strong> {{ \Carbon\Carbon::parse($item->date_reported)->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>

            <div class="p-4 bg-gray-50 border-t">
                @if($item->status === 'open')
                    @auth
                        @if(auth()->id() !== $item->user_id)
                            <button type="button"
                                    onclick="document.getElementById('claim-form-{{ $item->id }}').classList.toggle('hidden')"
                                    class="w-full bg-blue-900 hover:bg-blue-800 text-white py-2 rounded text-sm font-semibold">
                                Claim This Item
                            </button>

                            <form id="claim-form-{{ $item->id }}" method="POST" action="{{ route('claims.store', $item) }}" class="hidden mt-3 space-y-3 border-t pt-3">
                                @csrf
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700">Proof of Ownership</label>
                                    <textarea name="proof_description" rows="2" required placeholder="Describe unique marks, wallpaper, serial number, or contents..."
                                              class="w-full border rounded p-2 text-xs mt-1"></textarea>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700">Student ID / Contact Number</label>
                                    <input type="text" name="contact_info" required placeholder="e.g., 2026-10492 / 0917-000-0000"
                                           class="w-full border rounded p-2 text-xs mt-1">
                                </div>
                                <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white py-1.5 rounded text-xs font-semibold">
                                    Submit Claim Request
                                </button>
                            </form>
                        @else
                            <span class="block text-center text-xs text-gray-500">You reported this item. Waiting for owner claims.</span>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="block text-center text-sm text-blue-700 font-semibold hover:underline">
                            Login to Claim Item
                        </a>
                    @endauth
                @else
                    <span class="block text-center text-xs font-semibold text-gray-500">Item Already Claimed</span>
                @endif

                @auth
                    @if(auth()->user()->is_admin)
                        <form method="POST" action="{{ route('items.status', $item) }}" class="mt-3 pt-3 border-t">
                            @csrf
                            @method('PATCH')

                            @if($item->status === 'open')
                                <input type="hidden" name="status" value="resolved">
                                <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white py-1.5 px-3 rounded text-xs font-semibold">
                                    Admin: Mark as Resolved
                                </button>
                            @else
                                <input type="hidden" name="status" value="open">
                                <button type="submit" class="w-full bg-amber-500 hover:bg-amber-600 text-blue-950 py-1.5 px-3 rounded text-xs font-semibold">
                                    Admin: Reopen Item
                                </button>
                            @endif
                        </form>
                    @endif
                @endauth
            </div>
        </div>
    @empty
        <div class="col-span-3 text-center py-12 bg-white rounded-lg border">
            <p class="text-gray-500">No found items matched your search.</p>
        </div>
    @endforelse
</div>

<div class="mt-6">
    {{ $items->withQueryString()->links() }}
</div>
@endsection
