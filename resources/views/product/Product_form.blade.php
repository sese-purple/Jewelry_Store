@extends('layout.main_page')

@section('title', 'Add New Product - Elegant Jewelry & Watches')

@section('content')
<div class="sparkle">
    <h1><i class="fas fa-plus-circle"></i> Add New Jewelry Product</h1>
</div>

<div class="card">
    <form method="POST" action="{{ route('reister') }}" enctype="multipart/form-data">
        @csrf
        
        <!-- Basic Information -->
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-info-circle"></i> Basic Information
            </h3>
        </div>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 2rem;">
            <div class="form-group">
                <label for="name">
                    <i class="fas fa-tag"></i> Product Name *
                </label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="{{ old('name') }}" 
                       placeholder="e.g., Diamond Engagement Ring"
                       required>
            </div>
            
            <div class="form-group">
                <label for="category_id">
                    <i class="fas fa-list"></i> Category *
                </label>
                <select id="category_id" name="category_id" required>
                    <option value="">Select a category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <div class="form-group">
            <label for="description">
                <i class="fas fa-align-left"></i> Description
            </label>
            <textarea id="description" 
                      name="description" 
                      placeholder="Describe this beautiful piece of jewelry...">{{ old('description') }}</textarea>
        </div>
        
        <!-- Pricing & Inventory -->
        <div class="card-header" style="margin-top: 2rem;">
            <h3 class="card-title">
                <i class="fas fa-dollar-sign"></i> Pricing & Inventory
            </h3>
        </div>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem; margin-bottom: 2rem;">
            <div class="form-group">
                <label for="price">
                    <i class="fas fa-dollar-sign"></i> Price *
                </label>
                <input type="number" 
                       id="price" 
                       name="price" 
                       value="{{ old('price') }}" 
                       step="0.01" 
                       min="0"
                       placeholder="0.00"
                       required>
            </div>
            
            <div class="form-group">
                <label for="quantity">
                    <i class="fas fa-boxes"></i> Stock Quantity *
                </label>
                <input type="number" 
                       id="quantity" 
                       name="quantity" 
                       value="{{ old('quantity') }}" 
                       min="0"
                       placeholder="0"
                       required>
            </div>
            
            <div class="form-group">
                <label for="sku">
                    <i class="fas fa-barcode"></i> SKU
                </label>
                <input type="text" 
                       id="sku" 
                       name="sku" 
                       value="{{ old('sku') }}" 
                       placeholder="e.g., JWL-001">
            </div>
        </div>
        
        <!-- Jewelry Details -->
        <div class="card-header" style="margin-top: 2rem;">
            <h3 class="card-title">
                <i class="fas fa-gem"></i> Jewelry Details
            </h3>
        </div>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 2rem;">
            <div class="form-group">
                <label for="material">
                    <i class="fas fa-medal"></i> Material
                </label>
                <select id="material" name="material">
                    <option value="">Select material</option>
                    <option value="Gold" {{ old('material') == 'Gold' ? 'selected' : '' }}>Gold</option>
                    <option value="Silver" {{ old('material') == 'Silver' ? 'selected' : '' }}>Silver</option>
                    <option value="Platinum" {{ old('material') == 'Platinum' ? 'selected' : '' }}>Platinum</option>
                    <option value="Rose Gold" {{ old('material') == 'Rose Gold' ? 'selected' : '' }}>Rose Gold</option>
                    <option value="White Gold" {{ old('material') == 'White Gold' ? 'selected' : '' }}>White Gold</option>
                    <option value="Stainless Steel" {{ old('material') == 'Stainless Steel' ? 'selected' : '' }}>Stainless Steel</option>
                    <option value="Titanium" {{ old('material') == 'Titanium' ? 'selected' : '' }}>Titanium</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="brand">
                    <i class="fas fa-crown"></i> Brand
                </label>
                <input type="text" 
                       id="brand" 
                       name="brand" 
                       value="{{ old('brand') }}" 
                       placeholder="e.g., Tiffany & Co, Cartier">
            </div>
        </div>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem; margin-bottom: 2rem;">
            <div class="form-group">
                <label for="size">
                    <i class="fas fa-ruler"></i> Size
                </label>
                <input type="text" 
                       id="size" 
                       name="size" 
                       value="{{ old('size') }}" 
                       placeholder="e.g., 7, Medium, 42mm">
            </div>
            
            <div class="form-group">
                <label for="color">
                    <i class="fas fa-palette"></i> Color
                </label>
                <input type="text" 
                       id="color" 
                       name="color" 
                       value="{{ old('color') }}" 
                       placeholder="e.g., Rose Gold, Silver">
            </div>
            
            <div class="form-group">
                <label for="weight">
                    <i class="fas fa-weight"></i> Weight
                </label>
                <input type="text" 
                       id="weight" 
                       name="weight" 
                       value="{{ old('weight') }}" 
                       placeholder="e.g., 2.5g, 15 carats">
            </div>
        </div>
        
        <div class="form-group">
            <label for="gender">
                <i class="fas fa-venus-mars"></i> Gender
            </label>
            <select id="gender" name="gender">
                <option value="">Select gender</option>
                <option value="Women" {{ old('gender') == 'Women' ? 'selected' : '' }}>Women</option>
                <option value="Men" {{ old('gender') == 'Men' ? 'selected' : '' }}>Men</option>
                <option value="Unisex" {{ old('gender') == 'Unisex' ? 'selected' : '' }}>Unisex</option>
            </select>
        </div>
        
        <!-- Product Image -->
        <div class="card-header" style="margin-top: 2rem;">
            <h3 class="card-title">
                <i class="fas fa-image"></i> Product Image
            </h3>
        </div>
        
        <div class="form-group">
            <label for="image">
                <i class="fas fa-camera"></i> Product Image
            </label>
            <input type="file" 
                   id="image" 
                   name="image" 
                   accept="image/*">
            <small style="color: var(--warm-gray); font-size: 0.85rem;">
                Upload a high-quality image of your jewelry (JPEG, PNG, GIF - Max 2MB)
            </small>
        </div>
        
        <!-- Product Settings -->
        <div class="card-header" style="margin-top: 2rem;">
            <h3 class="card-title">
                <i class="fas fa-cog"></i> Product Settings
            </h3>
        </div>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem;">
            <div class="form-group">
                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                    <input type="hidden" name="is_featured" value="0">
                    <input type="checkbox" 
                           name="is_featured" 
                           value="1" 
                           {{ old('is_featured') ? 'checked' : '' }}
                           style="width: auto;">
                    <i class="fas fa-star"></i> Featured Product
                </label>
                <small style="color: var(--warm-gray); font-size: 0.85rem;">
                    Featured products are highlighted on the homepage
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
                    <i class="fas fa-toggle-on"></i> Active Product
                </label>
                <small style="color: var(--warm-gray); font-size: 0.85rem;">
                    Only active products are shown to customers
                </small>
            </div>
        </div>
        
        <div style="display: flex; gap: 1rem; margin-top: 2rem;">
            <button type="submit" class="btn" style="flex: 1;">
                <i class="fas fa-save"></i> Create Product
            </button>
            <a href="{{ route('all_products') }}" class="btn btn-secondary" style="flex: 1; text-align: center;">
                <i class="fas fa-arrow-left"></i> Back to Products
            </a>
        </div>
    </form>
</div>
@endsection
