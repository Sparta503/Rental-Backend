<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::with('user')->where('is_available', true)->get();
        return response()->json($items);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price_per_day' => 'required|numeric|min:0',
            'category' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'is_available' => 'sometimes|boolean'
        ]);

        $item = Item::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'description' => $validated['description'],
            'price_per_day' => $validated['price_per_day'],
            'category' => $validated['category'],
            'location' => $validated['location'],
            'is_available' => $validated['is_available'] ?? true
        ]);

        return response()->json($item, 201);
    }

    public function update(Request $request, $id)
    {
        $item = Item::findOrFail($id);
        
        // Check if user owns the item or is admin
        if ($item->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'price_per_day' => 'sometimes|numeric|min:0',
            'category' => 'sometimes|string|max:255',
            'location' => 'sometimes|string|max:255',
            'is_available' => 'sometimes|boolean'
        ]);

        $item->update($validated);

        return response()->json($item);
    }

    public function destroy($id)
    {
        $item = Item::findOrFail($id);
        
        // Check if user owns the item or is admin
        if ($item->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $item->delete();

        return response()->json(null, 204);
    }

    public function show($id)
    {
        $item = Item::with('user')->findOrFail($id);
        return response()->json($item);
    }
}
