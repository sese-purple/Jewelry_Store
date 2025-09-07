<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlistItems = Auth::user()->wishlistItems()->with('product')->latest()->get();
        
        return view('wishlist.index', compact('wishlistItems'));
    }

    public function add(Product $product)
    {
        $exists = Wishlist::where('user_id', Auth::id())
                         ->where('product_id', $product->id)
                         ->exists();

        if ($exists) {
            return back()->with('info', $product->name . ' is already in your wishlist.');
        }

        Wishlist::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id
        ]);

        return back()->with('success', $product->name . ' added to wishlist!');
    }

    public function remove(Product $product)
    {
        Wishlist::where('user_id', Auth::id())
               ->where('product_id', $product->id)
               ->delete();

        return back()->with('success', $product->name . ' removed from wishlist!');
    }

    public function toggle(Product $product)
    {
        $wishlistItem = Wishlist::where('user_id', Auth::id())
                               ->where('product_id', $product->id)
                               ->first();

        if ($wishlistItem) {
            $wishlistItem->delete();
            return response()->json([
                'status' => 'removed',
                'message' => 'Removed from wishlist'
            ]);
        } else {
            Wishlist::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id
            ]);
            return response()->json([
                'status' => 'added',
                'message' => 'Added to wishlist'
            ]);
        }
    }

    public function clear()
    {
        Auth::user()->wishlistItems()->delete();

        return back()->with('success', 'Wishlist cleared successfully!');
    }
}