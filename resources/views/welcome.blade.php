@extends('layout.main_page')

@section('title', 'Elegant Jewelry & Co - Luxury Since Forever')

@section('content')
<div class="hero fade-in">
    <h1><i class="fas fa-gem"></i> Elegant Jewelry & Co</h1>
    <p> Discover our legendary heritage of exceptional craftsmanship and timeless style with jewelry that captures the beauty of love, friendship and the world around us.</p>
    <div style="display: flex; gap: 2rem; justify-content: center; flex-wrap: wrap; margin-top: 2rem;">
        <a href="{{ route('all_products') }}" class="btn">
            Explore Collection
        </a>
        @guest
            <a href="{{ route('login') }}" class="btn btn-secondary">
                Sign In
            </a>
        @endguest
    </div>
</div>

@php
    $categories = \App\Models\Category::active()->ordered()->take(6)->get();
    $featuredProducts = \App\Models\Product::with('category')->featured()->active()->take(6)->get();
    $totalProducts = \App\Models\Product::active()->count();
    $totalCategories = \App\Models\Category::active()->count();
@endphp

<!-- Luxury Divider -->
<div class="luxury-divider">
    <i class="fas fa-gem"></i>
</div>

<!-- Categories Section -->
@if($categories->count() > 0)
<div class="fade-in">
    <h2>Jewelry Collections</h2>
    
    <div class="category-filters">
        @foreach($categories as $category)
            <a href="{{ route('products_by_category', $category->id) }}" class="category-filter">
                {{ $category->name }}
            </a>
        @endforeach
    </div>
</div>
@endif

<!-- Featured Products -->
@if($featuredProducts->count() > 0)
<div class="fade-in">
    <h2>Signature Collection</h2>
    
    <div class="product-grid">
        @foreach($featuredProducts as $product)
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
                        <span class="badge badge-featured">Signature</span>
                    </div>
                    
                    @auth
                        <div class="product-actions">
                            <a href="{{ route('edit_product', $product->id) }}" class="btn btn-small">
                                Edit Product
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        @endforeach
    </div>
    
    <div style="text-align: center; margin-top: 3rem;">
        <a href="{{ route('all_products') }}" class="btn">
            View All Jewelry
        </a>
    </div>
</div>
@endif

<!-- Luxury Divider -->
<div class="luxury-divider">
    <i class="fas fa-diamond"></i>
</div>

<!-- Stats Section -->
<div class="stats fade-in">
    <div class="stat-card">
        <div class="stat-number">{{ $totalProducts }}</div>
        <div class="stat-label">Exquisite Pieces</div>
    </div>
    <div class="stat-card">
        <div class="stat-number">{{ $totalCategories }}</div>
        <div class="stat-label">Collections</div>
    </div>
   
    <div class="stat-card">
        <div class="stat-number">∞</div>
        <div class="stat-label">Craftsmanship</div>
    </div>
</div>

<!-- Call to Action -->
@guest
<div class="card fade-in" style="text-align: center; background: linear-gradient(135deg, var(--tiffany-pale), var(--diamond-white)); border-top: 4px solid var(--luxury-gold);">
    <h3 style="color: var(--tiffany-blue); margin-bottom: 1.5rem; font-family: var(--font-heading); font-size: 2rem;">
        The Elegant Jewelry & Co
    </h3>
    <p style="color: var(--warm-gray); margin-bottom: 2.5rem; font-size: 1.1rem; line-height: 1.8;">
        Join our exclusive world of luxury jewelry. Create an account to access our full collection and experience personalized service that has defined luxury for generations.
    </p>
    <div style="display: flex; gap: 2rem; justify-content: center; flex-wrap: wrap;">
        <a href="{{ route('registration_form') }}" class="btn">
            Create Account
        </a>
        <a href="{{ route('login') }}" class="btn btn-secondary">
            Sign In
        </a>
    </div>
</div>
@endguest
@endsection