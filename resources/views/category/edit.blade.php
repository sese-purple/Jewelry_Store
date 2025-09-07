@extends('layout.main_page')

@section('title', 'Edit Category - Elegant Jewelry & Watches')

@section('content')
<div class="sparkle">
    <h1><i class="fas fa-edit"></i> Edit Category: {{ $category->name }}</h1>
</div>

<div class="card">
    <form action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="name">
                <i class="fas fa-tag"></i> Category Name *
            </label>
            <input type="text" 
                   id="name" 
                   name="name" 
                   value="{{ old('name', $category->name) }}" 
                   placeholder="e.g., Rings, Necklaces, Watches"
                   required>
        </div>
        
        <div class="form-group">
            <label for="description">
                <i class="fas fa-align-left"></i> Description
            </label>
            <textarea id="description" 
                      name="description" 
                      placeholder="Describe this category and what products it includes...">{{ old('description', $category->description) }}</textarea>
        </div>
        
        <div class="form-group">
            <label for="image">
                <i class="fas fa-image"></i> Category Image
            </label>
            
            @if($category->image)
                <div style="margin-bottom: 1rem;">
                    <img src="{{ asset('images/categories/' . $category->image) }}" 
                         alt="{{ $category->name }}" 
                         style="max-width: 200px; height: auto; border-radius: var(--border-radius-small); box-shadow: 0 4px 15px var(--shadow);">
                    <p style="color: var(--warm-gray); font-size: 0.85rem; margin-top: 0.5rem;">
                        Current image: {{ $category->image }}
                    </p>
                </div>
            @endif
            
            <input type="file" 
                   id="image" 
                   name="image" 
                   accept="image/*">
            <small style="color: var(--warm-gray); font-size: 0.85rem;">
                Upload a new image to replace the current one (JPEG, PNG, GIF - Max 2MB)
            </small>
        </div>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            <div class="form-group">
                <label for="sort_order">
                    <i class="fas fa-sort-numeric-up"></i> Sort Order
                </label>
                <input type="number" 
                       id="sort_order" 
                       name="sort_order" 
                       value="{{ old('sort_order', $category->sort_order) }}" 
                       min="0"
                       placeholder="0">
                <small style="color: var(--warm-gray); font-size: 0.85rem;">
                    Lower numbers appear first
                </small>
            </div>
            
            <div class="form-group">
                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" 
                           name="is_active" 
                           value="1" 
                           {{ old('is_active', $category->is_active) ? 'checked' : '' }}
                           style="width: auto;">
                    <i class="fas fa-toggle-on"></i> Active Category
                </label>
                <small style="color: var(--warm-gray); font-size: 0.85rem;">
                    Only active categories are shown to customers
                </small>
            </div>
        </div>
        
        <div style="display: flex; gap: 1rem; margin-top: 2rem;">
            <button type="submit" class="btn" style="flex: 1;">
                <i class="fas fa-save"></i> Update Category
            </button>
            <a href="{{ route('categories.index') }}" class="btn btn-secondary" style="flex: 1; text-align: center;">
                <i class="fas fa-arrow-left"></i> Back to Categories
            </a>
        </div>
    </form>
</div>

<div class="card" style="background: var(--soft-pink); border: 2px dashed var(--deep-rose);">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-info-circle"></i> Category Statistics
        </h3>
    </div>
    <div class="jewelry-details">
        <div class="jewelry-detail">
            <div class="jewelry-detail-label">Products</div>
            <div class="jewelry-detail-value">{{ $category->products->count() }}</div>
        </div>
        <div class="jewelry-detail">
            <div class="jewelry-detail-label">Status</div>
            <div class="jewelry-detail-value">{{ $category->is_active ? 'Active' : 'Inactive' }}</div>
        </div>
        <div class="jewelry-detail">
            <div class="jewelry-detail-label">Created</div>
            <div class="jewelry-detail-value">{{ $category->created_at->format('M d, Y') }}</div>
        </div>
        <div class="jewelry-detail">
            <div class="jewelry-detail-label">Updated</div>
            <div class="jewelry-detail-value">{{ $category->updated_at->format('M d, Y') }}</div>
        </div>
    </div>
</div>
@endsection