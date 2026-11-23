@extends('layouts.main')

@section('content')
<h1 class="text-2xl font-bold text-gray-900 mb-6">My Claim Requests</h1>

<div class="bg-white rounded-lg shadow-sm border overflow-x-auto">
    <table class="w-full text-left border-collapse">
        <thead class="bg-gray-100 text-xs uppercase text-gray-600">
            <tr>
                <th class="p-4">Item</th>
                <th class="p-4">Proof Submitted</th>
                <th class="p-4">Contact Info</th>
                <th class="p-4">Status</th>
                <th class="p-4">Date</th>
            </tr>
        </thead>
        <tbody class="divide-y text-sm">
            @forelse($claims as $claim)
                <tr>
                    <td class="p-4 font-semibold">{{ $claim->item->title }}</td>
                    <td class="p-4 text-gray-600">{{ $claim->proof_description }}</td>
                    <td class="p-4">{{ $claim->contact_info }}</td>
                    <td class="p-4">
                        <span class="px-2.5 py-1 rounded-full text-xs font-bold uppercase
                            {{ $claim->status === 'approved' ? 'bg-green-100 text-green-800' : ($claim->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-amber-100 text-amber-800') }}">
                            {{ $claim->status }}
                        </span>
                    </td>
                    <td class="p-4 text-gray-500">{{ $claim->created_at->format('M d, Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="p-6 text-center text-gray-500">You haven't submitted any claims yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
