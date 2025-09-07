@extends('layout.main_page')

@section('title', 'Order Confirmation - Elegant Jewelry & Co')

@section('content')
<div class="fade-in" style="text-align: center; max-width: 600px; margin: 0 auto;">
    <div class="success-icon">
        <i class="fas fa-check-circle"></i>
    </div>
    
    <h1 style="color: var(--success); margin-bottom: 1.5rem;">
        Order Confirmed!
    </h1>
    
    <div class="success-card">
        <div class="confirmation-details">
            <div class="confirmation-item">
                <i class="fas fa-receipt"></i>
                <div>
                    <span class="label">Order Number:</span>
                    <span class="value">{{ $order->order_number }}</span>
                </div>
            </div>
            
            <div class="confirmation-item">
                <i class="fas fa-calendar"></i>
                <div>
                    <span class="label">Order Date:</span>
                    <span class="value">{{ $order->created_at->format('F d, Y \a\t h:i A') }}</span>
                </div>
            </div>
            
            <div class="confirmation-item">
                <i class="fas fa-dollar-sign"></i>
                <div>
                    <span class="label">Total Amount:</span>
                    <span class="value">{{ $order->formatted_total }}</span>
                </div>
            </div>
            
            <div class="confirmation-item">
                <i class="fas fa-truck"></i>
                <div>
                    <span class="label">Shipping To:</span>
                    <span class="value">
                        @php
                            $shipping = $order->shipping_address;
                        @endphp
                        {{ $shipping['city'] ?? '' }}, {{ $shipping['state'] ?? '' }}
                    </span>
                </div>
            </div>
        </div>
        
        <div class="success-message">
            <p style="color: var(--warm-gray); line-height: 1.6; margin-bottom: 2rem;">
                Thank you for your order! Your exquisite jewelry pieces are being carefully prepared for shipment. 
                You will receive a confirmation email shortly with tracking information.
            </p>
            
            <div class="next-steps">
                <h3 style="color: var(--tiffany-blue); margin-bottom: 1rem;">
                    <i class="fas fa-gift"></i> What's Next?
                </h3>
                <ul style="text-align: left; color: var(--warm-gray); line-height: 1.8;">
                    <li>You will receive an order confirmation email within 24 hours</li>
                    <li>Your items will be carefully packaged and shipped within 2-3 business days</li>
                    <li>Tracking information will be sent to your email once shipped</li>
                    <li>Expected delivery: 5-7 business days</li>
                </ul>
            </div>
        </div>
        
        <div class="success-actions">
            <a href="{{ route('orders.show', $order) }}" class="btn">
                <i class="fas fa-eye"></i> View Order Details
            </a>
            <a href="{{ route('orders.index') }}" class="btn btn-secondary">
                <i class="fas fa-list"></i> View All Orders
            </a>
            <a href="{{ route('all_products') }}" class="btn btn-outline">
                <i class="fas fa-gem"></i> Continue Shopping
            </a>
        </div>
        
        <div class="customer-support" style="margin-top: 3rem; padding-top: 2rem; border-top: 1px solid var(--light-gray);">
            <h4 style="color: var(--tiffany-blue); margin-bottom: 1rem;">
                <i class="fas fa-headset"></i> Need Help?
            </h4>
            <p style="color: var(--warm-gray); margin-bottom: 1rem;">
                Our customer service team is here to assist you with any questions about your order.
            </p>
            <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                <a href="{{ route('contact') }}" class="btn btn-small">
                    <i class="fas fa-envelope"></i> Contact Us
                </a>
                <a href="tel:+1-800-JEWELRY" class="btn btn-small">
                    <i class="fas fa-phone"></i> Call Us
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.success-icon {
    font-size: 6rem;
    color: var(--success);
    margin-bottom: 2rem;
    animation: bounce 2s infinite;
}

@keyframes bounce {
    0%, 20%, 50%, 80%, 100% {
        transform: translateY(0);
    }
    40% {
        transform: translateY(-30px);
    }
    60% {
        transform: translateY(-15px);
    }
}

.success-card {
    background: var(--white);
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    padding: 3rem;
    border: 1px solid var(--light-gray);
    margin-bottom: 2rem;
}

.confirmation-details {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
    margin-bottom: 2rem;
    padding-bottom: 2rem;
    border-bottom: 2px solid var(--tiffany-pale);
}

.confirmation-item {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.confirmation-item i {
    font-size: 1.5rem;
    color: var(--tiffany-blue);
    width: 40px;
    text-align: center;
}

.confirmation-item .label {
    display: block;
    font-size: 0.9rem;
    color: var(--warm-gray);
    margin-bottom: 0.25rem;
}

.confirmation-item .value {
    display: block;
    font-weight: 600;
    color: var(--deep-blue);
    font-size: 1.1rem;
}

.success-message {
    margin-bottom: 2rem;
}

.next-steps {
    background: var(--diamond-white);
    padding: 1.5rem;
    border-radius: var(--border-radius);
    border: 1px solid var(--light-gray);
}

.next-steps ul {
    margin: 0;
    padding-left: 1.5rem;
}

.next-steps li {
    margin-bottom: 0.5rem;
}

.success-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
    margin-bottom: 2rem;
}

.btn-outline {
    background: transparent;
    border: 2px solid var(--tiffany-blue);
    color: var(--tiffany-blue);
}

.btn-outline:hover {
    background: var(--tiffany-blue);
    color: var(--white);
}

.customer-support {
    text-align: center;
}

@media (max-width: 768px) {
    .success-card {
        padding: 2rem;
    }
    
    .success-actions {
        flex-direction: column;
    }
    
    .success-actions .btn {
        width: 100%;
        text-align: center;
    }
    
    .confirmation-item {
        flex-direction: column;
        text-align: center;
        gap: 0.5rem;
    }
    
    .confirmation-item i {
        width: auto;
    }
}
</style>
@endsection
