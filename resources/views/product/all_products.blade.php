@extends('layout.main_page')

@section('title', 'Jewelry Collection - Elegant Jewelry & Co')

@section('content')
<div class="fade-in">
    <h1><i class="fas fa-gem"></i> Jewelry Collection</h1>
</div>


    
    @if(isset($categories) && $categories->count() > 0)
        <div class="category-filters">
            <a href="{{ route('all_products') }}" class="category-filter {{ !request('category') ? 'active' : '' }}">
                All Jewelry
            </a>
            @foreach($categories as $category)
                <a href="{{ route('products_by_category', $category->id) }}" class="category-filter">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>
    @endif
</div>

@if($products->count() > 0)
    <div class="product-grid fade-in">
        @foreach ($products as $product)
            <div class="product-card" data-name="{{ strtolower($product->name) }}" data-material="{{ strtolower($product->material ?? '') }}" data-brand="{{ strtolower($product->brand ?? '') }}">
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
                        <p class="product-description">{{ Str::limit($product->description, 100) }}</p>
                    @endif
                    
                    <div class="product-price">${{ number_format($product->price, 2) }}</div>
                    
                    <!-- Jewelry Details -->
                    @if($product->material || $product->brand || $product->size || $product->weight)
                        <div class="jewelry-details">
                            @if($product->material)
                                <div class="jewelry-detail">
                                    <div class="jewelry-detail-label">Material</div>
                                    <div class="jewelry-detail-value">{{ $product->material }}</div>
                                </div>
                            @endif
                            @if($product->brand)
                                <div class="jewelry-detail">
                                    <div class="jewelry-detail-label">Brand</div>
                                    <div class="jewelry-detail-value">{{ $product->brand }}</div>
                                </div>
                            @endif
                            @if($product->size)
                                <div class="jewelry-detail">
                                    <div class="jewelry-detail-label">Size</div>
                                    <div class="jewelry-detail-value">{{ $product->size }}</div>
                                </div>
                            @endif
                            @if($product->weight)
                                <div class="jewelry-detail">
                                    <div class="jewelry-detail-label">Weight</div>
                                    <div class="jewelry-detail-value">{{ $product->weight }}</div>
                                </div>
                            @endif
                        </div>
                    @endif
                    
                    <div class="product-meta">
                        <span>
                            <i class="fas fa-boxes"></i> Stock: {{ $product->quantity }}
                        </span>
                        <div>
                            @if($product->is_featured)
                                <span class="badge badge-featured">Featured</span>
                            @endif
                            @if($product->quantity <= 5 && $product->quantity > 0)
                                <span class="badge" style="background: #f39c12; color: white;">Low Stock</span>
                            @elseif($product->quantity == 0)
                                <span class="badge badge-inactive">Out of Stock</span>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Customer Actions -->
                    @auth
                        <div class="product-actions" style="margin-bottom: 1rem;">
                            @if($product->quantity > 0)
                                <form method="POST" action="{{ route('cart.add', $product) }}" style="display: inline-block;">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn btn-small" style="background: var(--tiffany-blue);">
                                        <i class="fas fa-shopping-bag"></i> Add to Cart
                                    </button>
                                </form>
                            @else
                                <button class="btn btn-small" disabled style="background: var(--warm-gray);">
                                    <i class="fas fa-times"></i> Out of Stock
                                </button>
                            @endif
                            
                            <button type="button" class="btn btn-small btn-secondary wishlist-btn" 
                                    data-wishlist-toggle 
                                    data-product-id="{{ $product->id }}">
                                <i class="fas fa-heart"></i> Wishlist
                            </button>
                        </div>
                        
                        <!-- Admin Actions (moved to bottom) -->
                        <div class="admin-actions" style="padding-top: 1rem; border-top: 1px solid var(--light-gray); font-size: 0.8rem;">
                            <a href="{{ route('edit_product', $product->id) }}" style="color: var(--tiffany-blue); text-decoration: none; margin-right: 1rem;">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a href="{{ route('delete_product', $product->id) }}" 
                               style="color: var(--error); text-decoration: none;"
                               onclick="return confirm('Are you sure you want to delete this product?')">
                                <i class="fas fa-trash"></i> Delete
                            </a>
                        </div>
                    @else
                        <!-- Guest Actions -->
                        <div class="product-actions">
                            <a href="{{ route('login') }}" class="btn btn-small">
                                <i class="fas fa-sign-in-alt"></i> Sign In to Purchase
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        @endforeach
    </div>
    
    <!-- Admin buttons removed for cleaner customer experience -->
@else
    <div class="card fade-in" style="text-align: center; padding: 3rem;">
        <i class="fas fa-gem" style="font-size: 4rem; color: var(--tiffany-blue); margin-bottom: 1rem;"></i>
        <h3>Collection Coming Soon</h3>
        <p style="color: var(--warm-gray); margin-bottom: 2rem;">Our exquisite jewelry collection is being carefully curated. Please check back soon for our latest pieces.</p>
    </div>
@endif

<script>
// Simple search functionality
document.getElementById('productSearch').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const productCards = document.querySelectorAll('.product-card');
    
    productCards.forEach(card => {
        const name = card.dataset.name;
        const material = card.dataset.material;
        const brand = card.dataset.brand;
        
        if (name.includes(searchTerm) || material.includes(searchTerm) || brand.includes(searchTerm)) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
});
</script>
@endsection