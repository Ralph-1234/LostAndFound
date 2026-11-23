<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
     // 1. Home Page
    public function home()
    {
        $recentLost = Item::where('type', 'lost')->where('status', 'open')->latest()->take(4)->get();
        $recentFound = Item::where('type', 'found')->where('status', 'open')->latest()->take(4)->get();
        $stats = [
            'lost' => Item::where('type', 'lost')->where('status', 'open')->count(),
            'found' => Item::where('type', 'found')->where('status', 'open')->count(),
            'resolved' => Item::where('status', 'resolved')->count(),
        ];

        return view('home', compact('recentLost', 'recentFound', 'stats'));
    }

    // 3. Lost Items Page
    public function lost(Request $request)
    {
        // $query = Item::where('type', 'lost')->latest();

        // if ($request->filled('search')) {
        //     $query->where(function ($q) use ($request) {
        //         $q->where('title', 'like', "%{$request->search}%")
        //           ->orWhere('location', 'like', "%{$request->search}%")
        //           ->orWhere('description', 'like', "%{$request->search}%");
        //     });
        // }

        // if ($request->filled('category')) {
        //     $query->where('category', $request->category);
        // }

        // $items = $query->paginate(9);
        // return view('items.lost', compact('items'));
         $query = Item::where('type', 'lost')->latest();

        // Hide resolved items unless the user explicitly filters for them
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } else {
            $query->where('status', 'open');
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', "%{$request->search}%")
                  ->orWhere('location', 'like', "%{$request->search}%")
                  ->orWhere('description', 'like', "%{$request->search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $items = $query->paginate(9);
        return view('items.lost', compact('items'));
    }

    // 4. Found Items Page
    public function found(Request $request)
    {
        // $query = Item::where('type', 'found')->latest();

        // if ($request->filled('search')) {
        //     $query->where(function ($q) use ($request) {
        //         $q->where('title', 'like', "%{$request->search}%")
        //           ->orWhere('location', 'like', "%{$request->search}%")
        //           ->orWhere('description', 'like', "%{$request->search}%");
        //     });
        // }

        // if ($request->filled('category')) {
        //     $query->where('category', $request->category);
        // }

        // $items = $query->paginate(9);
        // return view('items.found', compact('items'));
         $query = Item::where('type', 'found')->latest();

        // Hide resolved items unless the user explicitly filters for them
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } else {
            $query->where('status', 'open');
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', "%{$request->search}%")
                  ->orWhere('location', 'like', "%{$request->search}%")
                  ->orWhere('description', 'like', "%{$request->search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $items = $query->paginate(9);
        return view('items.found', compact('items'));
    }

    // 5. Submit Item Report Form
    public function create()
    {
        return view('items.create');
    }

    // Store Item Report
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:lost,found',
            'category' => 'required|string|max:100',
            'location' => 'required|string|max:255',
            'date_reported' => 'required|date',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('items', 'public');
        }

        Item::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'type' => $validated['type'],
            'category' => $validated['category'],
            'location' => $validated['location'],
            'date_reported' => $validated['date_reported'],
            'description' => $validated['description'],
            'image_path' => $imagePath,
        ]);

        $route = $validated['type'] === 'lost' ? 'items.lost' : 'items.found';
        return redirect()->route($route)->with('success', 'Item report submitted successfully!');
    }

    public function updateStatus(Request $request, Item $item)
    {
        // Only allow the item's creator or an admin to change its status
        // if ($item->user_id !== Auth::id() && !Auth::user()?->is_admin) {
        //     abort(403, 'Unauthorized.');
        // }

        // $validated = $request->validate([
        //     'status' => 'required|in:open,claimed,resolved',
        // ]);

        // $item->update(['status' => $validated['status']]);

        // return back()->with('success', 'Item status updated to ' . ucfirst($validated['status']) . '!');

        // === another changes
        //     if ($item->user_id !== Auth::id() && !Auth::user()?->is_admin) {
        //     abort(403, 'Unauthorized.');
        // }

        // $validated = $request->validate([
        //     'status' => 'required|in:open,claimed,resolved',
        // ]);

        // $item->update(['status' => $validated['status']]);

        // if (in_array($validated['status'], ['resolved', 'claimed'])) {
        //     $item->claims()->where('status', 'pending')->update(['status' => 'approved']);
        // } elseif ($validated['status'] === 'open') {
        //     $item->claims()->where('status', 'approved')->update(['status' => 'pending']);
        // }

        // return back()->with('success', 'Item status updated to ' . ucfirst($validated['status']) . '!');


        $isAdmin = Auth::user()?->is_admin;
        $isOwnerOfLostItem = ($item->type === 'lost' && $item->user_id === Auth::id());

        if (!$isAdmin && !$isOwnerOfLostItem) {
            abort(403, 'Only an admin can resolve found items after verifying claims.');
        }

        $validated = $request->validate([
            'status' => 'required|in:open,claimed,resolved',
        ]);

        $item->update(['status' => $validated['status']]);

        if (in_array($validated['status'], ['resolved', 'claimed'])) {
            $item->claims()->where('status', 'pending')->update(['status' => 'approved']);
        } elseif ($validated['status'] === 'open') {
            $item->claims()->where('status', 'approved')->update(['status' => 'pending']);
        }

        return back()->with('success', 'Item status updated to ' . ucfirst($validated['status']) . '!');
    }
}
