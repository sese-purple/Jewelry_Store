@extends('layout.main_page')

@section('title', 'Shopping Cart - Elegant Jewelry & Co')

@section('content')
<div class="fade-in">
    <h1><i class="fas fa-shopping-bag"></i> Shopping Cart</h1>
</div>

@if($cartItems->count() > 0)
    <div class="cart-container fade-in">
        <div class="cart-items">
            @foreach($cartItems as $item)
                <div class="cart-item">
                    <div class="cart-item-image">
                        @if($item->product->image)
                            <img src="{{ asset('images/products/' . $item->product->image) }}" 
                                 alt="{{ $item->product->name }}">
                        @else
                            <div class="placeholder-image">
                                <i class="fas fa-gem"></i>
                            </div>
                        @endif
                    </div>
                    
                    <div class="cart-item-details">
                        <h3>{{ $item->product->name }}</h3>
                        @if($item->product->category)
                            <p class="item-category">{{ $item->product->category->name }}</p>
                        @endif
                        
                        @if($item->product->material || $item->product->brand)
                            <div class="item-specs">
                                @if($item->product->material)
                                    <span><strong>Material:</strong> {{ $item->product->material }}</span>
                                @endif
                                @if($item->product->brand)
                                    <span><strong>Brand:</strong> {{ $item->product->brand }}</span>
                                @endif
                            </div>
                        @endif
                        
                        <div class="item-price">${{ number_format($item->price, 2) }}</div>
                    </div>
                    
                    <div class="cart-item-quantity">
                        <form method="POST" action="{{ route('cart.update', $item) }}" class="quantity-form" id="quantityForm{{ $item->id }}">
                            @csrf
                            @method('PATCH')
                            <div class="quantity-controls">
                                <button type="button" class="qty-btn" onclick="decreaseQuantity({{ $item->id }})">-</button>
                                <input type="number" 
                                       name="quantity" 
                                       value="{{ $item->quantity }}" 
                                       min="1" 
                                       max="{{ $item->product->quantity }}"
                                       class="qty-input"
                                       onchange="updateQuantity({{ $item->id }})"
                                       id="quantityInput{{ $item->id }}">
                                <button type="button" class="qty-btn" onclick="increaseQuantity({{ $item->id }})">+</button>
                            </div>
                        </form>
                        
                        <form method="POST" action="{{ route('cart.remove', $item) }}" style="margin-top: 0.5rem;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-small btn-danger" 
                                    onclick="return confirm('Remove this item from cart?')">
                                <i class="fas fa-trash"></i> Remove
                            </button>
                        </form>
                    </div>
                    
                    <div class="cart-item-total">
                        <strong>${{ number_format($item->total, 2) }}</strong>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="cart-summary">
            <div class="summary-card">
                <h3>Order Summary</h3>
                
                <div class="summary-line">
                    <span>Subtotal ({{ $cartItems->sum('quantity') }} items)</span>
                    <span>${{ number_format($total, 2) }}</span>
                </div>
                
                <div class="summary-line">
                    <span>Shipping</span>
                    <span>Free</span>
                </div>
                
                <div class="summary-line total-line">
                    <span><strong>Total</strong></span>
                    <span><strong>${{ number_format($total, 2) }}</strong></span>
                </div>
                
                <div class="cart-actions">
                    <a href="{{ route('orders.checkout') }}" class="btn btn-large">
                        <i class="fas fa-credit-card"></i> Proceed to Checkout
                    </a>
                    
                    <a href="{{ route('all_products') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Continue Shopping
                    </a>
                    
                    <form method="POST" action="{{ route('cart.clear') }}" style="margin-top: 1rem;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-small btn-danger" 
                                onclick="return confirm('Clear entire cart?')" 
                                style="width: 100%;">
                            <i class="fas fa-trash"></i> Clear Cart
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="card fade-in" style="text-align: center; padding: 3rem;">
        <i class="fas fa-shopping-bag" style="font-size: 4rem; color: var(--tiffany-blue); margin-bottom: 1rem;"></i>
        <h3>Your Cart is Empty</h3>
        <p style="color: var(--warm-gray); margin-bottom: 2rem;">
            Discover our exquisite jewelry collection and add some beautiful pieces to your cart.
        </p>
        <a href="{{ route('all_products') }}" class="btn">
            <i class="fas fa-gem"></i> Explore Jewelry
        </a>
    </div>
@endif

<style>
.cart-container {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 3rem;
    margin-top: 2rem;
}

.cart-item {
    display: grid;
    grid-template-columns: 120px 1fr auto auto;
    gap: 1.5rem;
    padding: 2rem;
    background: var(--white);
    border: 1px solid var(--light-gray);
    margin-bottom: 1rem;
    align-items: center;
}

.cart-item-image img {
    width: 100%;
    height: 100px;
    object-fit: cover;
    border-radius: var(--radius);
}

.placeholder-image {
    width: 100%;
    height: 100px;
    background: linear-gradient(135deg, var(--tiffany-blue), var(--tiffany-dark));
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--white);
    font-size: 2rem;
    border-radius: var(--radius);
}

.cart-item-details h3 {
    margin-bottom: 0.5rem;
    color: var(--charcoal);
}

.item-category {
    color: var(--tiffany-blue);
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 0.5rem;
}

.item-specs {
    font-size: 0.85rem;
    color: var(--warm-gray);
    margin-bottom: 0.5rem;
}

.item-specs span {
    display: block;
    margin-bottom: 0.25rem;
}

.item-price {
    font-size: 1.2rem;
    font-weight: 600;
    color: var(--luxury-gold);
}

.quantity-controls {
    display: flex;
    align-items: center;
    margin-bottom: 0.5rem;
}

.qty-btn {
    background: var(--tiffany-blue);
    color: var(--white);
    border: none;
    width: 30px;
    height: 30px;
    cursor: pointer;
    font-weight: bold;
}

.qty-input {
    width: 60px;
    text-align: center;
    border: 1px solid var(--light-gray);
    height: 30px;
    margin: 0;
}

.update-btn {
    background: var(--tiffany-blue);
    color: var(--white);
}

.cart-item-total {
    font-size: 1.3rem;
    font-weight: 600;
    color: var(--charcoal);
}

.summary-card {
    background: var(--white);
    padding: 2rem;
    border: 1px solid var(--light-gray);
    position: sticky;
    top: 2rem;
}

.summary-line {
    display: flex;
    justify-content: space-between;
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
}

.total-line {
    border-top: 2px solid var(--tiffany-blue);
    padding-top: 1rem;
    font-size: 1.2rem;
}

.cart-actions {
    margin-top: 2rem;
}

.cart-actions .btn {
    width: 100%;
    margin-bottom: 1rem;
}

.btn-large {
    padding: 1.2rem 2rem;
    font-size: 1.1rem;
}

@media (max-width: 768px) {
    .cart-container {
        grid-template-columns: 1fr;
    }
    
    .cart-item {
        grid-template-columns: 1fr;
        text-align: center;
    }
}
</style>

<script>
function increaseQuantity(itemId) {
    const input = document.getElementById('quantityInput' + itemId);
    const max = parseInt(input.getAttribute('max'));
    const current = parseInt(input.value);
    if (current < max) {
        input.value = current + 1;
        updateQuantity(itemId);
    }
}

function decreaseQuantity(itemId) {
    const input = document.getElementById('quantityInput' + itemId);
    const current = parseInt(input.value);
    if (current > 1) {
        input.value = current - 1;
        updateQuantity(itemId);
    }
}

function updateQuantity(itemId) {
    const form = document.getElementById('quantityForm' + itemId);
    form.submit();
}
</script>
@endsection