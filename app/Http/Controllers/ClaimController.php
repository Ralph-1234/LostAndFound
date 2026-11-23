<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClaimController extends Controller
{
    public function store(Request $request, Item $item)
    {
        $validated = $request->validate([
            'proof_description' => 'required|string|min:10',
            'contact_info' => 'required|string|max:255',
        ]);

        Claim::create([
            'item_id' => $item->id,
            'user_id' => Auth::id(),
            'proof_description' => $validated['proof_description'],
            'contact_info' => $validated['contact_info'],
        ]);

        return back()->with('success', 'Your claim request has been submitted for admin verification.');
    }

    public function myClaims()
    {
        $claims = Claim::with('item')->where('user_id', Auth::id())->latest()->get();
        return view('claims.index', compact('claims'));
    }
}
