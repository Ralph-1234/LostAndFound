@extends('layouts.main')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Claim Request Management</h1>
        <p class="text-sm text-gray-600">Verify proof of ownership before approving handovers.</p>
    </div>
    <a href="{{ route('admin.dashboard') }}" class="text-sm text-blue-700 hover:underline font-semibold">&larr; Back to Dashboard</a>
</div>

<div class="bg-white rounded-lg shadow-sm border overflow-x-auto">
    <table class="w-full text-left border-collapse">
        <thead class="bg-gray-100 text-xs uppercase text-gray-600">
            <tr>
                <th class="p-4">Item</th>
                <th class="p-4">Claimant</th>
                <th class="p-4">Contact / Student ID</th>
                <th class="p-4">Proof Description</th>
                <th class="p-4">Status</th>
                <th class="p-4">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y text-sm">
            @forelse($claims as $claim)
                <tr>
                    <td class="p-4 font-semibold">{{ $claim->item->title }}</td>
                    <td class="p-4">{{ $claim->user->name }}<br><span class="text-xs text-gray-500">{{ $claim->user->email }}</span></td>
                    <td class="p-4">{{ $claim->contact_info }}</td>
                    <td class="p-4 max-w-xs">{{ $claim->proof_description }}</td>
                    <td class="p-4">
                        <span class="px-2.5 py-1 rounded-full text-xs font-bold uppercase
                            {{ $claim->status === 'approved' ? 'bg-green-100 text-green-800' : ($claim->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-amber-100 text-amber-800') }}">
                            {{ $claim->status }}
                        </span>
                    </td>
                    <td class="p-4">
                        @if($claim->status === 'pending')
                            <div class="flex gap-2">
                                <form method="POST" action="{{ route('admin.claims.update', $claim) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="approved">
                                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-3 py-1 rounded text-xs font-semibold">
                                        Approve
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.claims.update', $claim) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="rejected">
                                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs font-semibold">
                                        Reject
                                    </button>
                                </form>
                            </div>
                        @else
                            <span class="text-xs text-gray-400">Processed</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="p-6 text-center text-gray-500">No claim requests submitted yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $claims->links() }}
</div>
@endsection
