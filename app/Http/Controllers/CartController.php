<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Auth::user()->cartItems()->with('product')->get();
        $total = $cartItems->sum('total');
        
        return view('cart.index', compact('cartItems', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $product->quantity
        ]);

        $cartItem = Cart::where('user_id', Auth::id())
                       ->where('product_id', $product->id)
                       ->first();

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $request->quantity;
            
            if ($newQuantity > $product->quantity) {
                return back()->with('error', 'Not enough stock available. Only ' . $product->quantity . ' items in stock.');
            }
            
            $cartItem->update([
                'quantity' => $newQuantity,
                'price' => $product->price
            ]);
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'price' => $product->price
            ]);
        }

        return back()->with('success', $product->name . ' added to cart successfully!');
    }

    public function update(Request $request, Cart $cart)
    {
        $this->authorize('update', $cart);
        
        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $cart->product->quantity
        ]);

        $cart->update([
            'quantity' => $request->quantity,
            'price' => $cart->product->price
        ]);

        return back()->with('success', 'Cart updated successfully!');
    }

    public function remove(Cart $cart)
    {
        $this->authorize('delete', $cart);
        
        $cart->delete();

        return back()->with('success', 'Item removed from cart successfully!');
    }

    public function clear()
    {
        Auth::user()->cartItems()->delete();

        return back()->with('success', 'Cart cleared successfully!');
    }

    public function count()
    {
        return response()->json([
            'count' => Auth::user()->cart_count ?? 0
        ]);
    }
}