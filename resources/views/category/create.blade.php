@extends('layout.main_page')

@section('title', 'Create Category - Elegant Jewelry & Watches')

@section('content')
<div class="sparkle">
    <h1><i class="fas fa-plus-circle"></i> Create New Category</h1>
</div>

<div class="card">
    <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="form-group">
            <label for="name">
                <i class="fas fa-tag"></i> Category Name *
            </label>
            <input type="text" 
                   id="name" 
                   name="name" 
                   value="{{ old('name') }}" 
                   placeholder="e.g., Rings, Necklaces, Watches"
                   required>
        </div>
        
        <div class="form-group">
            <label for="description">
                <i class="fas fa-align-left"></i> Description
            </label>
            <textarea id="description" 
                      name="description" 
                      placeholder="Describe this category and what products it includes...">{{ old('description') }}</textarea>
        </div>
        
        <div class="form-group">
            <label for="image">
                <i class="fas fa-image"></i> Category Image
            </label>
            <input type="file" 
                   id="image" 
                   name="image" 
                   accept="image/*">
            <small style="color: var(--warm-gray); font-size: 0.85rem;">
                Upload a beautiful image that represents this category (JPEG, PNG, GIF - Max 2MB)
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
                       value="{{ old('sort_order', 0) }}" 
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
                           {{ old('is_active', 1) ? 'checked' : '' }}
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
                <i class="fas fa-save"></i> Create Category
            </button>
            <a href="{{ route('categories.index') }}" class="btn btn-secondary" style="flex: 1; text-align: center;">
                <i class="fas fa-arrow-left"></i> Back to Categories
            </a>
        </div>
    </form>
</div>

<div class="card" style="background: var(--soft-pink); border: 2px dashed var(--accent-gold);">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-lightbulb"></i> Category Tips
        </h3>
    </div>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem;">
        <div>
            <h4 style="color: var(--accent-gold); margin-bottom: 0.5rem;">
                <i class="fas fa-gem"></i> Popular Categories
            </h4>
            <ul style="color: var(--warm-gray); line-height: 1.8;">
                <li>Rings (Engagement, Wedding, Fashion)</li>
                <li>Necklaces & Pendants</li>
                <li>Earrings (Studs, Hoops, Drops)</li>
                <li>Bracelets & Bangles</li>
            </ul>
        </div>
        <div>
            <h4 style="color: var(--accent-gold); margin-bottom: 0.5rem;">
                <i class="fas fa-clock"></i> Watch Categories
            </h4>
            <ul style="color: var(--warm-gray); line-height: 1.8;">
                <li>Luxury Watches</li>
                <li>Fashion Watches</li>
                <li>Sports Watches</li>
                <li>Smart Watches</li>
            </ul>
        </div>
    </div>
</div>
@endsection