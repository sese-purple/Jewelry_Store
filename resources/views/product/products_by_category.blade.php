@extends('layout.main_page')

@section('title', $category->name . ' - Elegant Jewelry & Watches')

@section('content')
<div class="fade-in">
    <h1><i class="fas fa-gem"></i> {{ $category->name }}</h1>
    @if($category->description)
        <p style="text-align: center; color: var(--gray); font-size: 1.1rem; margin-bottom: 2rem;">
            {{ $category->description }}
        </p>
    @endif
</div>

<!-- Category Navigation -->
<div class="fade-in">
    @if(isset($categories) && $categories->count() > 0)
        <div class="category-filters">
            <a href="{{ route('all_products') }}" class="category-filter">
                <i class="fas fa-th"></i> All Products
            </a>
            @foreach($categories as $cat)
                <a href="{{ route('products_by_category', $cat->id) }}" 
                   class="category-filter {{ $cat->id == $category->id ? 'active' : '' }}">
                    <i class="fas fa-gem"></i> {{ $cat->name }}
                </a>
            @endforeach
        </div>
    @endif
</div>

@if($products->count() > 0)
    <div class="product-grid fade-in">
        @foreach ($products as $product)
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
                    <div class="product-category">{{ $category->name }}</div>
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
                    
                    @auth
                        <div class="product-actions">
                            <a href="{{ route('edit_product', $product->id) }}" class="btn btn-small">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a href="{{ route('delete_product', $product->id) }}" 
                               class="btn btn-small btn-danger"
                               onclick="return confirm('Are you sure you want to delete this product?')">
                                <i class="fas fa-trash"></i> Delete
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        @endforeach
    </div>
    
    <div style="text-align: center; margin-top: 3rem;">
        @auth
            <a href="{{ route('product_form') }}" class="btn">
                <i class="fas fa-plus-circle"></i> Add Product to {{ $category->name }}
            </a>
        @endauth
    </div>
@else
    <div class="card fade-in" style="text-align: center; padding: 3rem;">
        <i class="fas fa-gem" style="font-size: 4rem; color: var(--accent); margin-bottom: 1rem;"></i>
        <h3>No {{ $category->name }} Yet</h3>
        <p style="color: var(--gray); margin-bottom: 2rem;">
            This category is waiting for its first beautiful piece. Start adding {{ strtolower($category->name) }} to your collection.
        </p>
        @auth
            <a href="{{ route('product_form') }}" class="btn">
                <i class="fas fa-plus-circle"></i> Add First {{ rtrim($category->name, 's') }}
            </a>
        @endauth
    </div>
@endif

<!-- Category Stats -->
<div class="stats fade-in">
    <div class="stat-card">
        <div class="stat-number">{{ $products->count() }}</div>
        <div class="stat-label">{{ $category->name }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-number">${{ number_format($products->avg('price') ?? 0, 0) }}</div>
        <div class="stat-label">Avg Price</div>
    </div>
    <div class="stat-card">
        <div class="stat-number">{{ $products->sum('quantity') }}</div>
        <div class="stat-label">Total Stock</div>
    </div>
    <div class="stat-card">
        <div class="stat-number">{{ $products->where('is_featured', true)->count() }}</div>
        <div class="stat-label">Featured</div>
    </div>
</div>
@endsection