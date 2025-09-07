@extends('layout.main_page')

@section('title', 'My Orders - Elegant Jewelry & Co')

@section('content')
<div class="fade-in">
    <h1><i class="fas fa-receipt"></i> My Orders</h1>

    @if($orders->count() > 0)
        <div class="orders-list">
            @foreach($orders as $order)
                <div class="order-card">
                    <div class="order-header">
                        <div class="order-info">
                            <h3>Order #{{ $order->order_number }}</h3>
                            <div class="order-meta">
                                <span class="order-date">
                                    <i class="fas fa-calendar"></i> 
                                    {{ $order->created_at->format('M d, Y') }}
                                </span>
                                <span class="order-status status-{{ strtolower($order->status) }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                                <span class="order-payment-status status-{{ strtolower($order->payment_status) }}">
                                    Payment: {{ ucfirst($order->payment_status) }}
                                </span>
                            </div>
                        </div>
                        <div class="order-total">
                            <strong>{{ $order->formatted_total }}</strong>
                        </div>
                    </div>

                    <div class="order-items">
                        @foreach($order->orderItems as $item)
                            <div class="order-item">
                                @if($item->product_image)
                                    <img src="{{ asset('images/products/' . $item->product_image) }}" 
                                         alt="{{ $item->product_name }}" 
                                         class="order-item-image">
                                @else
                                    <div class="order-item-image" style="background: linear-gradient(135deg, var(--primary), var(--rose)); display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: var(--accent);">
                                        <i class="fas fa-gem"></i>
                                    </div>
                                @endif
                                <div class="order-item-details">
                                    <h4>{{ $item->product_name }}</h4>
                                    @if($item->product_material)
                                        <p class="order-item-material">{{ $item->product_material }}</p>
                                    @endif
                                    <div class="order-item-quantity">
                                        Quantity: {{ $item->quantity }}
                                    </div>
                                    <div class="order-item-price">
                                        {{ $item->formatted_price }} each
                                    </div>
                                </div>
                                <div class="order-item-total">
                                    {{ $item->formatted_total }}
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="order-actions">
                        <a href="{{ route('orders.show', $order) }}" class="btn btn-small">
                            <i class="fas fa-eye"></i> View Details
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="pagination">
            {{ $orders->links() }}
        </div>
    @else
        <div class="card" style="text-align: center; padding: 3rem; background: linear-gradient(135deg, var(--tiffany-pale), var(--diamond-white));">
            <i class="fas fa-receipt" style="font-size: 4rem; color: var(--tiffany-blue); margin-bottom: 1.5rem;"></i>
            <h3 style="color: var(--tiffany-blue); margin-bottom: 1rem;">No Orders Yet</h3>
            <p style="color: var(--warm-gray); margin-bottom: 2rem;">
                You haven't placed any orders yet. Start shopping and discover our exquisite collection of jewelry.
            </p>
            <a href="{{ route('all_products') }}" class="btn">
                <i class="fas fa-gem"></i> Start Shopping
            </a>
        </div>
    @endif
</div>

<style>
.orders-list {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

.order-card {
    background: var(--white);
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    padding: 2rem;
    border: 1px solid var(--light-gray);
}

.order-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid var(--tiffany-pale);
}

.order-info h3 {
    color: var(--tiffany-blue);
    margin-bottom: 0.5rem;
}

.order-meta {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
    font-size: 0.9rem;
    color: var(--warm-gray);
}

.order-status, .order-payment-status {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
}

.status-pending {
    background: var(--soft-yellow);
    color: var(--dark-yellow);
}

.status-paid, status-processing {
    background: var(--soft-blue);
    color: var(--deep-blue);
}

.status-shipped {
    background: var(--soft-green);
    color: var(--deep-green);
}

.status-delivered {
    background: var(--success-light);
    color: var(--success);
}

.status-cancelled, .status-failed, .status-refunded {
    background: var(--soft-red);
    color: var(--error);
}

.order-total {
    font-size: 1.5rem;
    font-weight: bold;
    color: var(--tiffany-blue);
}

.order-items {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.order-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: var(--diamond-white);
    border-radius: var(--border-radius-small);
    border: 1px solid var(--light-gray);
}

.order-item-image {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: var(--border-radius-small);
}

.order-item-details {
    flex: 1;
}

.order-item-details h4 {
    margin-bottom: 0.25rem;
    color: var(--deep-blue);
}

.order-item-material {
    font-size: 0.9rem;
    color: var(--warm-gray);
    margin-bottom: 0.5rem;
}

.order-item-quantity, .order-item-price {
    font-size: 0.85rem;
    color: var(--warm-gray);
}

.order-item-total {
    font-weight: bold;
    color: var(--tiffany-blue);
}

.order-actions {
    display: flex;
    justify-content: flex-end;
}

.pagination {
    display: flex;
    justify-content: center;
    margin-top: 2rem;
}
</style>
@endsection
