<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // 6. Admin Dashboard
    public function dashboard()
    {
        $stats = [
            'total_items' => Item::count(),
            'open_lost' => Item::where('type', 'lost')->where('status', 'open')->count(),
            'open_found' => Item::where('type', 'found')->where('status', 'open')->count(),
            'pending_claims' => Claim::where('status', 'pending')->count(),
            'resolved_items' => Item::where('status', 'resolved')->count(),
            'users' => User::count(),
        ];

        $items = Item::with('user')->latest()->paginate(10);

        return view('admin.dashboard', compact('stats', 'items'));
    }

    // 7. Claim Request Management
    public function claims()
    {
        $claims = Claim::with(['item', 'user'])->latest()->paginate(15);
        return view('admin.claims', compact('claims'));
    }

    public function updateClaim(Request $request, Claim $claim)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        $claim->update(['status' => $request->status]);

        if ($request->status === 'approved') {
            $claim->item->update(['status' => 'resolved']);
            // Reject other pending claims for the same item
            Claim::where('item_id', $claim->item_id)
                ->where('id', '!=', $claim->id)
                ->where('status', 'pending')
                ->update(['status' => 'rejected']);
        }

        return back()->with('success', "Claim marked as {$request->status}.");
    }

    public function destroyItem(Item $item)
    {
        $item->delete();
        return back()->with('success', 'Item removed.');
    }
}
