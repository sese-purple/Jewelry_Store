@extends('layout.main_page')

@section('title', 'Categories - Elegant Jewelry & Watches')

@section('content')
<div class="sparkle">
    <h1><i class="fas fa-tags"></i> Jewelry Categories</h1>
</div>

<div style="text-align: center; margin-bottom: 2rem;">
    <a href="{{ route('categories.create') }}" class="btn">
        <i class="fas fa-plus-circle"></i> Add New Category
    </a>
</div>

@if($categories->count() > 0)
    <div class="product-grid">
        @foreach($categories as $category)
            <div class="product-card">
                @if($category->image)
                    <img src="{{ asset('images/categories/' . $category->image) }}" 
                         alt="{{ $category->name }}" 
                         class="product-image">
                @else
                    <div class="product-image" style="background: linear-gradient(135deg, var(--primary-rose), var(--secondary-rose)); display: flex; align-items: center; justify-content: center; font-size: 3rem; color: var(--accent-gold);">
                        <i class="fas fa-gem"></i>
                    </div>
                @endif
                
                <div class="product-info">
                    <div class="product-category">Category</div>
                    <h3 class="product-name">{{ $category->name }}</h3>
                    
                    @if($category->description)
                        <p class="product-description">{{ Str::limit($category->description, 100) }}</p>
                    @endif
                    
                    <div class="product-meta">
                        <span>
                            <i class="fas fa-box"></i> 
                            {{ $category->products->count() }} Products
                        </span>
                        <span class="badge {{ $category->is_active ? 'badge-active' : 'badge-inactive' }}">
                            {{ $category->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                    
                    <div class="product-actions">
                        <a href="{{ route('products_by_category', $category->id) }}" class="btn btn-small">
                            <i class="fas fa-eye"></i> View Products
                        </a>
                        <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-small btn-secondary">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display: inline;" 
                              onsubmit="return confirm('Are you sure you want to delete this category?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-small" style="background: linear-gradient(135deg, #e74c3c, #c0392b);">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="card" style="text-align: center; padding: 3rem;">
        <i class="fas fa-tags" style="font-size: 4rem; color: var(--accent-gold); margin-bottom: 1rem;"></i>
        <h3>No Categories Yet</h3>
        <p style="color: var(--warm-gray); margin-bottom: 2rem;">Start by creating your first jewelry category.</p>
        <a href="{{ route('categories.create') }}" class="btn">
            <i class="fas fa-plus-circle"></i> Create First Category
        </a>
    </div>
@endif
@endsection