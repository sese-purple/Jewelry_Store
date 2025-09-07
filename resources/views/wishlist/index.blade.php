@extends('layout.main_page')

@section('title', 'My Wishlist - Elegant Jewelry & Co')

@section('content')
<div class="fade-in">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1><i class="fas fa-heart"></i> My Wishlist</h1>
        @if($wishlistItems->count() > 0)
            <form action="{{ route('wishlist.clear') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="btn btn-secondary" 
                        onclick="return confirm('Are you sure you want to clear your entire wishlist?')">
                    <i class="fas fa-trash"></i> Clear All
                </button>
            </form>
        @endif
    </div>

    @if($wishlistItems->count() > 0)
        <div class="product-grid">
            @foreach($wishlistItems as $wishlistItem)
                @php
                    $product = $wishlistItem->product;
                @endphp
                <div class="product-card">
                    @if($product->image)
                        <img src="{{ asset('images/products/' . $product->image) }}" 
                             alt="{{ $product->name }}" 
                             class="product-image">
                    @else
                        <div class="product-image" style="background: linear-gradient(135deg, var(--primary), var(--rose)); display: flex; align-items: center; justify-content: center; font-size: 3rem; color: var(--accent);">
                            <i class="fas fa-gem"></i>
                        </div>
                    @endif
                    
                    <div class="product-info">
                        @if($product->category)
                            <div class="product-category">{{ $product->category->name }}</div>
                        @endif
                        <h3 class="product-name">{{ $product->name }}</h3>
                        
                        @if($product->description)
                            <p class="product-description">{{ Str::limit($product->description, 80) }}</p>
                        @endif
                        
                        <div class="product-price">${{ number_format($product->price, 2) }}</div>
                        
                        <div class="product-meta">
                            <span>
                                @if($product->material)
                                    {{ $product->material }}
                                @endif
                            </span>
                            @if($product->is_featured)
                                <span class="badge badge-featured">Signature</span>
                            @endif
                        </div>
                        
                        <div class="product-actions" style="display: flex; gap: 0.5rem; margin-top: 1rem;">
                            <form action="{{ route('wishlist.remove', $product) }}" method="POST" style="margin: 0;">
                                @csrf
<button type="submit" class="btn btn-danger" 
                                        title="Remove from wishlist">
                                    <i class="fas fa-heart-broken"></i> Remove
                                </button>
                            </form>
                            
                            @if($product->isInStock())
                                <form action="{{ route('cart.add', $product) }}" method="POST" style="margin: 0;">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn btn-small" title="Add to cart">
                                        <i class="fas fa-shopping-bag"></i> Add to Cart
                                    </button>
                                </form>
                            @else
                                <span class="btn btn-small btn-disabled">Out of Stock</span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="card" style="text-align: center; padding: 3rem; background: linear-gradient(135deg, var(--tiffany-pale), var(--diamond-white));">
            <i class="fas fa-heart" style="font-size: 4rem; color: var(--tiffany-blue); margin-bottom: 1.5rem;"></i>
            <h3 style="color: var(--tiffany-blue); margin-bottom: 1rem;">Your wishlist is empty</h3>
            <p style="color: var(--warm-gray); margin-bottom: 2rem;">
                Start building your collection of exquisite jewelry. Browse our collections and add items you love to your wishlist.
            </p>
            <a href="{{ route('all_products') }}" class="btn">
                <i class="fas fa-gem"></i> Explore Collection
            </a>
        </div>
    @endif
</div>

<style>
.btn-danger {
    background: linear-gradient(135deg, #dc3545, #c82333);
    border: none;
    color: white;
}

.btn-danger:hover {
    background: linear-gradient(135deg, #c82333, #a71e2a);
    transform: translateY(-1px);
}

.btn-disabled {
    background: var(--warm-gray-light);
    color: var(--warm-gray);
    cursor: not-allowed;
    opacity: 0.7;
}
</style>
@endsection
