@extends('layouts.main')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Admin Dashboard</h1>
    <a href="{{ route('admin.claims') }}" class="bg-amber-500 hover:bg-amber-600 text-blue-950 font-semibold px-4 py-2 rounded-lg text-sm">
        Manage Claim Requests ({{ $stats['pending_claims'] }} Pending)
    </a>
</div>

<!-- Admin Metrics -->
<div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">
    <div class="bg-white p-4 rounded-lg border shadow-sm">
        <div class="text-xs text-gray-500 uppercase">Total Reports</div>
        <div class="text-2xl font-bold">{{ $stats['total_items'] }}</div>
    </div>
    <div class="bg-white p-4 rounded-lg border shadow-sm">
        <div class="text-xs text-gray-500 uppercase">Open Lost</div>
        <div class="text-2xl font-bold text-red-600">{{ $stats['open_lost'] }}</div>
    </div>
    <div class="bg-white p-4 rounded-lg border shadow-sm">
        <div class="text-xs text-gray-500 uppercase">Open Found</div>
        <div class="text-2xl font-bold text-emerald-600">{{ $stats['open_found'] }}</div>
    </div>
    <div class="bg-white p-4 rounded-lg border shadow-sm">
        <div class="text-xs text-gray-500 uppercase">Pending Claims</div>
        <div class="text-2xl font-bold text-amber-600">{{ $stats['pending_claims'] }}</div>
    </div>
    <div class="bg-white p-4 rounded-lg border shadow-sm">
        <div class="text-xs text-gray-500 uppercase">Resolved</div>
        <div class="text-2xl font-bold text-blue-600">{{ $stats['resolved_items'] }}</div>
    </div>
</div>

<!-- All Reported Items Table -->
<div class="bg-white rounded-lg shadow-sm border overflow-x-auto">
    <div class="p-4 border-b font-bold text-gray-800">All Reported Items</div>
    <table class="w-full text-left border-collapse">
        <thead class="bg-gray-100 text-xs uppercase text-gray-600">
            <tr>
                <th class="p-4">Item</th>
                <th class="p-4">Type</th>
                <th class="p-4">Category</th>
                <th class="p-4">Location</th>
                <th class="p-4">Reported By</th>
                <th class="p-4">Status</th>
                <th class="p-4">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y text-sm">
            @foreach($items as $item)
                <tr>
                    <td class="p-4 font-semibold">{{ $item->title }}</td>
                    <td class="p-4 uppercase text-xs font-bold {{ $item->type === 'lost' ? 'text-red-600' : 'text-emerald-600' }}">
                        {{ $item->type }}
                    </td>
                    <td class="p-4">{{ $item->category }}</td>
                    <td class="p-4">{{ $item->location }}</td>
                    <td class="p-4">{{ $item->user->name }}</td>
                    <td class="p-4 uppercase text-xs font-semibold">{{ $item->status }}</td>
                    <td class="p-4 flex items-center gap-3">
                        <!-- Toggle Status (Open <-> Resolved) -->
                        <form method="POST" action="{{ route('items.status', $item) }}">
                            @csrf
                            @method('PATCH')

                            @if($item->status === 'open')
                                <input type="hidden" name="status" value="resolved">
                                <button type="submit" class="text-emerald-600 hover:underline text-xs font-semibold">
                                    Mark Resolved
                                </button>
                            @else
                                <input type="hidden" name="status" value="open">
                                <button type="submit" class="text-amber-600 hover:underline text-xs font-semibold">
                                    Reopen (Unclaim)
                                </button>
                            @endif
                        </form>

                        <span class="text-gray-300">|</span>

                        <!-- Delete Item -->
                        <form method="POST" action="{{ route('admin.items.destroy', $item) }}" onsubmit="return confirm('Delete this item?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline text-xs font-semibold">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $items->links() }}
</div>
@endsection
