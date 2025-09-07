<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Auth::user()->orders()->with('orderItems')->latest()->paginate(10);
        
        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $this->authorize('view', $order);
        
        $order->load('orderItems');
        
        return view('orders.show', compact('order'));
    }

    public function checkout()
    {
        $cartItems = Auth::user()->cartItems()->with('product')->get();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        // Check stock availability
        foreach ($cartItems as $item) {
            if ($item->quantity > $item->product->quantity) {
                return redirect()->route('cart.index')->with('error', 
                    $item->product->name . ' has insufficient stock. Only ' . $item->product->quantity . ' available.');
            }
        }

        $total = $cartItems->sum('total');
        
        return view('orders.checkout', compact('cartItems', 'total'));
    }

    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'shipping_name' => 'required|string|max:255',
            'shipping_email' => 'required|email|max:255',
            'shipping_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string',
            'shipping_city' => 'required|string|max:100',
            'shipping_state' => 'required|string|max:100',
            'shipping_postal_code' => 'required|string|max:20',
            'shipping_country' => 'required|string|max:100',
            'payment_method' => 'required|in:paypal,stripe,cash_on_delivery',
            'notes' => 'nullable|string|max:1000'
        ]);

        $cartItems = Auth::user()->cartItems()->with('product')->get();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('message', 'Your cart is empty!');
        }

        try {
            DB::transaction(function () use ($request, $cartItems) {
                // Prepare shipping address
                $shippingAddress = [
                    'name' => $request->shipping_name,
                    'email' => $request->shipping_email,
                    'phone' => $request->shipping_phone,
                    'address' => $request->shipping_address,
                    'city' => $request->shipping_city,
                    'state' => $request->shipping_state,
                    'postal_code' => $request->shipping_postal_code,
                    'country' => $request->shipping_country
                ];

                // Create order
                $order = Order::create([
                    'order_number' => Order::generateOrderNumber(),
                    'user_id' => Auth::id(),
                    'status' => 'pending',
                    'total_amount' => $cartItems->sum('total'),
                    'payment_method' => $request->payment_method,
                    'payment_status' => $request->payment_method === 'cash_on_delivery' ? 'pending' : 'pending',
                    'shipping_address' => $shippingAddress,
                    'billing_address' => $shippingAddress, // Using same address for billing
                    'notes' => $request->notes
                ]);

                // Create order items and update product quantities
                foreach ($cartItems as $cartItem) {
                    $product = $cartItem->product;
                    
                    // Check stock again
                    if ($cartItem->quantity > $product->quantity) {
                        throw new \Exception($product->name . ' has insufficient stock.');
                    }

                    // Create order item
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => $cartItem->quantity,
                        'price' => $cartItem->price,
                        'total' => $cartItem->total,
                        'product_name' => $product->name,
                        'product_description' => $product->description,
                        'product_image' => $product->image,
                        'product_material' => $product->material,
                        'product_brand' => $product->brand,
                        'product_size' => $product->size,
                        'product_weight' => $product->weight
                    ]);

                    // Update product quantity
                    $product->decrement('quantity', $cartItem->quantity);
                }

                // Clear cart
                Auth::user()->cartItems()->delete();

                // Handle payment processing
                if ($request->payment_method === 'paypal') {
                    $this->processPayPalPayment($order);
                } elseif ($request->payment_method === 'stripe') {
                    $this->processStripePayment($order);
                }
            });

            // Get the latest order to pass to success view
            $order = Auth::user()->orders()->latest()->first();
            
            return redirect()->route('orders.success', ['order' => $order])
                ->with('message', 'Order placed successfully!');

        } catch (\Exception $e) {
            return redirect()->route('cart.index')->with('message', 'Error: ' . $e->getMessage());
        }
    }

    public function success(Order $order)
    {
        $this->authorize('view', $order);
        
        return view('orders.success', compact('order'));
    }

    private function processPayPalPayment($order)
    {
        // Simulate PayPal payment processing
        // In a real application, you would integrate with PayPal API
        $order->update([
            'payment_status' => 'paid',
            'payment_transaction_id' => 'PP_' . uniqid()
        ]);
        
        return true;
    }

    private function processStripePayment($order)
    {
        // Simulate Stripe payment processing
        // In a real application, you would integrate with Stripe API
        $order->update([
            'payment_status' => 'paid',
            'payment_transaction_id' => 'ST_' . uniqid()
        ]);
        
        return true;
    }
}