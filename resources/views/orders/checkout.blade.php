@extends('layout.main_page')

@section('title', 'Checkout - Elegant Jewelry & Co')

@section('content')
<div class="fade-in">
    <h1><i class="fas fa-shopping-bag"></i> Checkout</h1>

    <div class="checkout-grid">
        <!-- Order Summary -->
        <div class="checkout-summary">
            <h3><i class="fas fa-receipt"></i> Order Summary</h3>
            <div class="order-items">
                @foreach($cartItems as $item)
                    <div class="checkout-item">
                        @if($item->product->image)
                            <img src="{{ asset('images/products/' . $item->product->image) }}" 
                                 alt="{{ $item->product->name }}" 
                                 class="checkout-item-image">
                        @else
                            <div class="checkout-item-image" style="background: linear-gradient(135deg, var(--primary), var(--rose)); display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: var(--accent);">
                                <i class="fas fa-gem"></i>
                            </div>
                        @endif
                        
                        <div class="checkout-item-info">
                            <h4>{{ $item->product->name }}</h4>
                            @if($item->product->material)
                                <p class="item-material">{{ $item->product->material }}</p>
                            @endif
                            <div class="item-quantity">Quantity: {{ $item->quantity }}</div>
                        </div>
                        
                        <div class="checkout-item-price">
                            {{ $item->formatted_total }}
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="checkout-total">
                <div class="total-line">
                    <span>Subtotal:</span>
                    <span>${{ number_format($total, 2) }}</span>
                </div>
                <div class="total-line">
                    <span>Shipping:</span>
                    <span>Free</span>
                </div>
                <div class="total-line grand-total">
                    <span>Total:</span>
                    <span>${{ number_format($total, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Checkout Form -->
        <div class="checkout-form">
            <form action="{{ route('orders.store') }}" method="POST">
                @csrf
                
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <h3><i class="fas fa-user"></i> Shipping Information</h3>
                
                <div class="form-grid">
                    <div class="form-group">
                        <label for="shipping_name">
                            <i class="fas fa-user"></i> Full Name *
                        </label>
                        <input type="text" id="shipping_name" name="shipping_name" 
                               value="{{ old('shipping_name', auth()->user()->name) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="shipping_email">
                            <i class="fas fa-envelope"></i> Email Address *
                        </label>
                        <input type="email" id="shipping_email" name="shipping_email" 
                               value="{{ old('shipping_email', auth()->user()->email) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="shipping_phone">
                            <i class="fas fa-phone"></i> Phone Number *
                        </label>
                        <input type="tel" id="shipping_phone" name="shipping_phone" 
                               value="{{ old('shipping_phone') }}" required>
                    </div>

                    <div class="form-group full-width">
                        <label for="shipping_address">
                            <i class="fas fa-map-marker-alt"></i> Shipping Address *
                        </label>
                        <textarea id="shipping_address" name="shipping_address" rows="3" required>{{ old('shipping_address') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="shipping_city">
                            <i class="fas fa-city"></i> City *
                        </label>
                        <input type="text" id="shipping_city" name="shipping_city" 
                               value="{{ old('shipping_city') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="shipping_state">
                            <i class="fas fa-map"></i> State *
                        </label>
                        <input type="text" id="shipping_state" name="shipping_state" 
                               value="{{ old('shipping_state') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="shipping_postal_code">
                            <i class="fas fa-mail-bulk"></i> Postal Code *
                        </label>
                        <input type="text" id="shipping_postal_code" name="shipping_postal_code" 
                               value="{{ old('shipping_postal_code') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="shipping_country">
                            <i class="fas fa-globe"></i> Country *
                        </label>
                        <input type="text" id="shipping_country" name="shipping_country" 
                               value="{{ old('shipping_country') }}" required>
                    </div>
                </div>

                <h3><i class="fas fa-credit-card"></i> Payment Method</h3>
                
                <div class="payment-methods">
                    <div class="payment-option">
                        <input type="radio" id="payment_paypal" name="payment_method" value="paypal" 
                               {{ old('payment_method', 'paypal') == 'paypal' ? 'checked' : '' }}>
                        <label for="payment_paypal">
                            <i class="fab fa-paypal"></i> PayPal
                        </label>
                    </div>

                    <div class="payment-option">
                        <input type="radio" id="payment_stripe" name="payment_method" value="stripe" 
                               {{ old('payment_method') == 'stripe' ? 'checked' : '' }}>
                        <label for="payment_stripe">
                            <i class="fab fa-cc-stripe"></i> Stripe
                        </label>
                    </div>

                    <div class="payment-option">
                        <input type="radio" id="payment_cod" name="payment_method" value="cash_on_delivery" 
                               {{ old('payment_method') == 'cash_on_delivery' ? 'checked' : '' }}>
                        <label for="payment_cod">
                            <i class="fas fa-money-bill-wave"></i> Cash on Delivery
                        </label>
                    </div>
                </div>

                <div class="form-group full-width">
                    <label for="notes">
                        <i class="fas fa-sticky-note"></i> Order Notes (Optional)
                    </label>
                    <textarea id="notes" name="notes" rows="3" 
                              placeholder="Special instructions for your order...">{{ old('notes') }}</textarea>
                </div>

                <div class="checkout-actions">
                    <a href="{{ route('cart.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Cart
                    </a>
                    <button type="submit" class="btn">
                        <i class="fas fa-lock"></i> Place Order
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.alert {
    padding: 1rem;
    margin-bottom: 1.5rem;
    border-radius: var(--border-radius);
}

.alert-danger {
    background-color: #f8d7da;
    border: 1px solid #f5c6cb;
    color: #721c24;
}

.alert ul {
    margin: 0;
    padding-left: 1.5rem;
}

.checkout-grid {
    display: grid;
    grid-template-columns: 1fr 1.5fr;
    gap: 3rem;
}

.checkout-summary {
    background: var(--white);
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    padding: 2rem;
    border: 1px solid var(--light-gray);
    height: fit-content;
    position: sticky;
    top: 2rem;
}

.checkout-summary h3 {
    color: var(--tiffany-blue);
    margin-bottom: 1.5rem;
    border-bottom: 2px solid var(--tiffany-pale);
    padding-bottom: 0.5rem;
}

.checkout-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    margin-bottom: 1rem;
    background: var(--diamond-white);
    border-radius: var(--border-radius-small);
    border: 1px solid var(--light-gray);
}

.checkout-item-image {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: var(--border-radius-small);
}

.checkout-item-info {
    flex: 1;
}

.checkout-item-info h4 {
    margin-bottom: 0.25rem;
    color: var(--deep-blue);
}

.item-material {
    font-size: 0.9rem;
    color: var(--warm-gray);
    margin-bottom: 0.5rem;
}

.item-quantity {
    font-size: 0.85rem;
    color: var(--warm-gray);
}

.checkout-item-price {
    font-weight: bold;
    color: var(--tiffany-blue);
}

.checkout-total {
    margin-top: 2rem;
    padding-top: 1rem;
    border-top: 2px solid var(--tiffany-blue);
}

.total-line {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.5rem;
    color: var(--warm-gray);
}

.total-line.grand-total {
    font-weight: bold;
    font-size: 1.2rem;
    color: var(--tiffany-blue);
    margin-top: 1rem;
    padding-top: 1rem;
    border-top: 1px solid var(--light-gray);
}

.checkout-form {
    background: var(--white);
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    padding: 2rem;
    border: 1px solid var(--light-gray);
}

.checkout-form h3 {
    color: var(--tiffany-blue);
    margin-bottom: 1.5rem;
    border-bottom: 2px solid var(--tiffany-pale);
    padding-bottom: 0.5rem;
}

.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
    margin-bottom: 2rem;
}

.form-group.full-width {
    grid-column: 1 / -1;
}

.payment-methods {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    margin-bottom: 2rem;
}

.payment-option {
    display: flex;
    align-items: center;
    padding: 1rem;
    border: 2px solid var(--light-gray);
    border-radius: var(--border-radius-small);
    transition: var(--transition);
    cursor: pointer;
}

.payment-option:hover {
    border-color: var(--tiffany-blue);
}

.payment-option input[type="radio"] {
    margin-right: 1rem;
}

.payment-option label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin: 0;
    cursor: pointer;
    font-weight: 600;
    color: var(--deep-blue);
}

.checkout-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 2rem;
    padding-top: 2rem;
    border-top: 2px solid var(--tiffany-pale);
}

@media (max-width: 768px) {
    .checkout-grid {
        grid-template-columns: 1fr;
    }
    
    .form-grid {
        grid-template-columns: 1fr;
    }
    
    .checkout-actions {
        flex-direction: column;
        gap: 1rem;
    }
    
    .checkout-actions .btn {
        width: 100%;
        text-align: center;
    }
}
</style>
@endsection
