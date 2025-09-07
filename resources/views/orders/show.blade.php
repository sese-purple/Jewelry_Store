@extends('layout.main_page')

@section('title', 'Order #' . $order->order_number . ' - Elegant Jewelry & Co')

@section('content')
<div class="fade-in">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1><i class="fas fa-receipt"></i> Order #{{ $order->order_number }}</h1>
        <a href="{{ route('orders.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Orders
        </a>
    </div>

    <div class="order-details-grid">
        <!-- Order Summary -->
        <div class="order-summary-card">
            <h3><i class="fas fa-info-circle"></i> Order Summary</h3>
            <div class="order-summary-details">
                <div class="summary-row">
                    <span class="summary-label">Order Date:</span>
                    <span class="summary-value">{{ $order->created_at->format('F d, Y \a\t h:i A') }}</span>
                </div>
                <div class="summary-row">
                    <span class="summary-label">Order Status:</span>
                    <span class="summary-value status-{{ strtolower($order->status) }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
                <div class="summary-row">
                    <span class="summary-label">Payment Status:</span>
                    <span class="summary-value status-{{ strtolower($order->payment_status) }}">
                        {{ ucfirst($order->payment_status) }}
                    </span>
                </div>
                <div class="summary-row">
                    <span class="summary-label">Payment Method:</span>
                    <span class="summary-value">{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</span>
                </div>
                @if($order->payment_transaction_id)
                <div class="summary-row">
                    <span class="summary-label">Transaction ID:</span>
                    <span class="summary-value">{{ $order->payment_transaction_id }}</span>
                </div>
                @endif
                <div class="summary-row total-row">
                    <span class="summary-label">Total Amount:</span>
                    <span class="summary-value">{{ $order->formatted_total }}</span>
                </div>
            </div>
        </div>

        <!-- Shipping Information -->
        <div class="order-info-card">
            <h3><i class="fas fa-truck"></i> Shipping Information</h3>
            <div class="shipping-details">
                @php
                    $shipping = $order->shipping_address;
                @endphp
                <p><strong>{{ $shipping['name'] ?? '' }}</strong></p>
                <p>{{ $shipping['email'] ?? '' }}</p>
                <p>{{ $shipping['phone'] ?? '' }}</p>
                <p>{{ $shipping['address'] ?? '' }}</p>
                <p>
                    {{ $shipping['city'] ?? '' }}, 
                    {{ $shipping['state'] ?? '' }} 
                    {{ $shipping['postal_code'] ?? '' }}
                </p>
                <p>{{ $shipping['country'] ?? '' }}</p>
            </div>
        </div>
    </div>

    <!-- Order Items -->
    <div class="order-items-section">
        <h3><i class="fas fa-gem"></i> Order Items</h3>
        <div class="order-items-list">
            @foreach($order->orderItems as $item)
                <div class="order-item-detail">
                    @if($item->product_image)
                        <img src="{{ asset('images/products/' . $item->product_image) }}" 
                             alt="{{ $item->product_name }}" 
                             class="order-item-image">
                    @else
                        <div class="order-item-image" style="background: linear-gradient(135deg, var(--primary), var(--rose)); display: flex; align-items: center; justify-content: center; font-size: 2rem; color: var(--accent);">
                            <i class="fas fa-gem"></i>
                        </div>
                    @endif
                    
                    <div class="order-item-info">
                        <h4>{{ $item->product_name }}</h4>
                        @if($item->product_description)
                            <p class="item-description">{{ $item->product_description }}</p>
                        @endif
                        <div class="item-details">
                            @if($item->product_material)
                                <span class="item-detail">{{ $item->product_material }}</span>
                            @endif
                            @if($item->product_brand)
                                <span class="item-detail">{{ $item->product_brand }}</span>
                            @endif
                            @if($item->product_size)
                                <span class="item-detail">Size: {{ $item->product_size }}</span>
                            @endif
                            @if($item->product_weight)
                                <span class="item-detail">Weight: {{ $item->product_weight }}</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="order-item-pricing">
                        <div class="item-quantity">Quantity: {{ $item->quantity }}</div>
                        <div class="item-price">{{ $item->formatted_price }} each</div>
                        <div class="item-total">{{ $item->formatted_total }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Order Notes -->
    @if($order->notes)
    <div class="order-notes">
        <h3><i class="fas fa-sticky-note"></i> Order Notes</h3>
        <div class="notes-content">
            {{ $order->notes }}
        </div>
    </div>
    @endif
</div>

<style>
.order-details-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
    margin-bottom: 2rem;
}

.order-summary-card, .order-info-card {
    background: var(--white);
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    padding: 2rem;
    border: 1px solid var(--light-gray);
}

.order-summary-card h3, .order-info-card h3 {
    color: var(--tiffany-blue);
    margin-bottom: 1.5rem;
    border-bottom: 2px solid var(--tiffany-pale);
    padding-bottom: 0.5rem;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid var(--light-gray);
}

.summary-row:last-child {
    border-bottom: none;
}

.summary-row.total-row {
    border-top: 2px solid var(--tiffany-blue);
    font-weight: bold;
    font-size: 1.1rem;
}

.summary-label {
    color: var(--warm-gray);
    font-weight: 600;
}

.summary-value {
    color: var(--deep-blue);
    font-weight: 500;
}

.shipping-details p {
    margin-bottom: 0.5rem;
    color: var(--deep-blue);
}

.order-items-section {
    background: var(--white);
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    padding: 2rem;
    border: 1px solid var(--light-gray);
    margin-bottom: 2rem;
}

.order-items-section h3 {
    color: var(--tiffany-blue);
    margin-bottom: 1.5rem;
    border-bottom: 2px solid var(--tiffany-pale);
    padding-bottom: 0.5rem;
}

.order-items-list {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.order-item-detail {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    padding: 1.5rem;
    background: var(--diamond-white);
    border-radius: var(--border-radius);
    border: 1px solid var(--light-gray);
}

.order-item-image {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: var(--border-radius-small);
}

.order-item-info {
    flex: 1;
}

.order-item-info h4 {
    color: var(--deep-blue);
    margin-bottom: 0.5rem;
}

.item-description {
    color: var(--warm-gray);
    margin-bottom: 0.75rem;
    line-height: 1.5;
}

.item-details {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.item-detail {
    background: var(--light-gray);
    padding: 0.25rem 0.75rem;
    border-radius: 15px;
    font-size: 0.8rem;
    color: var(--warm-gray);
}

.order-item-pricing {
    text-align: right;
    min-width: 120px;
}

.item-quantity, .item-price {
    color: var(--warm-gray);
    font-size: 0.9rem;
    margin-bottom: 0.25rem;
}

.item-total {
    font-weight: bold;
    color: var(--tiffany-blue);
    font-size: 1.1rem;
}

.order-notes {
    background: var(--white);
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    padding: 2rem;
    border: 1px solid var(--light-gray);
}

.order-notes h3 {
    color: var(--tiffany-blue);
    margin-bottom: 1rem;
}

.notes-content {
    background: var(--diamond-white);
    padding: 1.5rem;
    border-radius: var(--border-radius-small);
    border: 1px solid var(--light-gray);
    line-height: 1.6;
    color: var(--deep-blue);
}

@media (max-width: 768px) {
    .order-details-grid {
        grid-template-columns: 1fr;
    }
    
    .order-item-detail {
        flex-direction: column;
        text-align: center;
    }
    
    .order-item-pricing {
        text-align: center;
    }
}
</style>
@endsection
