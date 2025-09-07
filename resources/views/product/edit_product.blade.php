@extends('layout.main_page')

@section('title', 'Edit Product - ' . $product->name)

@section('content')
<div class="fade-in">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1><i class="fas fa-edit"></i> Edit Product</h1>
        <a href="{{ route('all_products') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Products
        </a>
    </div>

    <div class="edit-product-container">
        <!-- Product Preview Section -->
        <div class="product-preview-section">
            <div class="current-product-preview">
                <h3><i class="fas fa-eye"></i> Current Product</h3>
                <div class="product-preview-card">
                    <div class="preview-image">
                        @if($product->image)
                            <img src="{{ asset('images/products/' . $product->image) }}" 
                                 alt="{{ $product->name }}" 
                                 id="currentProductImage">
                        @else
                            <div class="no-image-placeholder" id="currentProductImage">
                                <i class="fas fa-gem"></i>
                                <span>No Image</span>
                            </div>
                        @endif
                    </div>
                    <div class="preview-info">
                        <h4 id="previewName">{{ $product->name }}</h4>
                        <p class="preview-category" id="previewCategory">
                            {{ $product->category ? $product->category->name : 'No Category' }}
                        </p>
                        <div class="preview-price" id="previewPrice">
                            ${{ number_format($product->price, 2) }}
                        </div>
                        <div class="preview-stock" id="previewStock">
                            Stock: {{ $product->quantity }} items
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Form Section -->
        <div class="edit-form-section">
            <h3><i class="fas fa-edit"></i> Edit Details</h3>
            
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul style="margin: 0; padding-left: 1.5rem;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="post" action="{{ route('update_product', $product->id) }}" enctype="multipart/form-data" class="edit-product-form">
                @csrf
                
                <!-- Basic Information -->
                <div class="form-section">
                    <h4><i class="fas fa-info-circle"></i> Basic Information</h4>
                    
                    <div class="form-group">
                        <label for="name"><i class="fas fa-tag"></i> Product Name</label>
                        <input type="text" 
                               name="name" 
                               id="name"
                               value="{{ old('name', $product->name) }}" 
                               class="form-control" 
                               required
                               onkeyup="updatePreview()">
                    </div>

                    <div class="form-group">
                        <label for="category_id"><i class="fas fa-list"></i> Category</label>
                        <select name="category_id" id="category_id" class="form-control" required onchange="updatePreview()">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" 
                                        data-name="{{ $category->name }}"
                                        {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="price"><i class="fas fa-dollar-sign"></i> Price</label>
                            <input type="number" 
                                   name="price" 
                                   id="price"
                                   value="{{ old('price', $product->price) }}" 
                                   class="form-control" 
                                   step="0.01" 
                                   min="0"
                                   required
                                   onkeyup="updatePreview()">
                        </div>

                        <div class="form-group">
                            <label for="quantity"><i class="fas fa-boxes"></i> Stock Quantity</label>
                            <input type="number" 
                                   name="quantity" 
                                   id="quantity"
                                   value="{{ old('quantity', $product->quantity) }}" 
                                   class="form-control" 
                                   min="0"
                                   required
                                   onkeyup="updatePreview()">
                        </div>
                    </div>
                </div>

                <!-- Product Details -->
                <div class="form-section">
                    <h4><i class="fas fa-gem"></i> Product Details</h4>
                    
                    <div class="form-group">
                        <label for="description"><i class="fas fa-align-left"></i> Description</label>
                        <textarea name="description" 
                                  id="description" 
                                  class="form-control" 
                                  rows="4"
                                  placeholder="Describe this beautiful piece...">{{ old('description', $product->description) }}</textarea>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="material"><i class="fas fa-ring"></i> Material</label>
                            <input type="text" 
                                   name="material" 
                                   id="material"
                                   value="{{ old('material', $product->material) }}" 
                                   class="form-control"
                                   placeholder="e.g., 18K Gold, Sterling Silver">
                        </div>

                        <div class="form-group">
                            <label for="brand"><i class="fas fa-crown"></i> Brand</label>
                            <input type="text" 
                                   name="brand" 
                                   id="brand"
                                   value="{{ old('brand', $product->brand) }}" 
                                   class="form-control"
                                   placeholder="e.g., Tiffany & Co">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="size"><i class="fas fa-ruler"></i> Size</label>
                            <input type="text" 
                                   name="size" 
                                   id="size"
                                   value="{{ old('size', $product->size) }}" 
                                   class="form-control"
                                   placeholder="e.g., 7, Medium, 16 inches">
                        </div>

                        <div class="form-group">
                            <label for="weight"><i class="fas fa-weight"></i> Weight</label>
                            <input type="text" 
                                   name="weight" 
                                   id="weight"
                                   value="{{ old('weight', $product->weight) }}" 
                                   class="form-control"
                                   placeholder="e.g., 2.5g, 0.5 oz">
                        </div>
                    </div>
                </div>

                <!-- Image Upload -->
                <div class="form-section">
                    <h4><i class="fas fa-camera"></i> Product Image</h4>
                    
                    <div class="image-upload-section">
                        <div class="current-image-info">
                            @if($product->image)
                                <p><i class="fas fa-check-circle" style="color: var(--success);"></i> Current image: <strong>{{ $product->image }}</strong></p>
                            @else
                                <p><i class="fas fa-exclamation-triangle" style="color: var(--warning);"></i> No image currently uploaded</p>
                            @endif
                        </div>
                        
                        <div class="form-group">
                            <label for="image"><i class="fas fa-upload"></i> Upload New Image (Optional)</label>
                            <input type="file" 
                                   name="image" 
                                   id="image"
                                   class="form-control" 
                                   accept="image/*"
                                   onchange="previewNewImage(this)">
                            <small class="form-text">Leave empty to keep current image. Accepted formats: JPG, PNG, GIF (Max: 2MB)</small>
                        </div>

                        <div id="newImagePreview" class="new-image-preview" style="display: none;">
                            <p><strong>New image preview:</strong></p>
                            <img id="newImagePreviewImg" src="" alt="New image preview">
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Product
                    </button>
                    <a href="{{ route('all_products') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.edit-product-container {
    display: grid;
    grid-template-columns: 1fr 2fr;
    gap: 3rem;
    margin-top: 2rem;
}

.product-preview-section {
    position: sticky;
    top: 2rem;
    height: fit-content;
}

.current-product-preview h3 {
    color: var(--tiffany-blue);
    margin-bottom: 1.5rem;
    border-bottom: 2px solid var(--tiffany-pale);
    padding-bottom: 0.5rem;
}

.product-preview-card {
    background: var(--white);
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    padding: 2rem;
    border: 1px solid var(--light-gray);
    text-align: center;
}

.preview-image {
    margin-bottom: 1.5rem;
}

.preview-image img {
    width: 100%;
    max-width: 250px;
    height: 250px;
    object-fit: cover;
    border-radius: var(--border-radius);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.no-image-placeholder {
    width: 100%;
    max-width: 250px;
    height: 250px;
    background: linear-gradient(135deg, var(--primary), var(--rose));
    border-radius: var(--border-radius);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: var(--accent);
    font-size: 3rem;
    margin: 0 auto;
}

.no-image-placeholder span {
    font-size: 1rem;
    margin-top: 0.5rem;
}

.preview-info h4 {
    color: var(--deep-blue);
    margin-bottom: 0.5rem;
    font-size: 1.3rem;
}

.preview-category {
    color: var(--warm-gray);
    font-size: 0.9rem;
    margin-bottom: 1rem;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.preview-price {
    font-size: 1.5rem;
    font-weight: bold;
    color: var(--tiffany-blue);
    margin-bottom: 0.5rem;
}

.preview-stock {
    color: var(--warm-gray);
    font-size: 0.9rem;
}

.edit-form-section {
    background: var(--white);
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    padding: 2.5rem;
    border: 1px solid var(--light-gray);
}

.edit-form-section h3 {
    color: var(--tiffany-blue);
    margin-bottom: 2rem;
    border-bottom: 2px solid var(--tiffany-pale);
    padding-bottom: 0.5rem;
}

.form-section {
    margin-bottom: 2.5rem;
    padding-bottom: 2rem;
    border-bottom: 1px solid var(--light-gray);
}

.form-section:last-of-type {
    border-bottom: none;
    margin-bottom: 2rem;
}

.form-section h4 {
    color: var(--deep-blue);
    margin-bottom: 1.5rem;
    font-size: 1.1rem;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    color: var(--deep-blue);
    font-weight: 600;
}

.form-group label i {
    color: var(--tiffany-blue);
    margin-right: 0.5rem;
    width: 16px;
}

.image-upload-section {
    background: var(--diamond-white);
    padding: 1.5rem;
    border-radius: var(--border-radius);
    border: 1px solid var(--light-gray);
}

.current-image-info {
    margin-bottom: 1rem;
    padding: 1rem;
    background: var(--white);
    border-radius: var(--border-radius-small);
    border-left: 4px solid var(--tiffany-blue);
}

.new-image-preview {
    margin-top: 1rem;
    padding: 1rem;
    background: var(--white);
    border-radius: var(--border-radius-small);
    border: 2px dashed var(--tiffany-blue);
}

.new-image-preview img {
    max-width: 200px;
    height: 150px;
    object-fit: cover;
    border-radius: var(--border-radius-small);
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.form-actions {
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
    padding-top: 2rem;
    border-top: 2px solid var(--tiffany-pale);
}

.alert {
    padding: 1rem 1.5rem;
    border-radius: var(--border-radius);
    margin-bottom: 2rem;
    border-left: 4px solid var(--danger);
    background: #ffeaea;
    color: var(--danger);
}

@media (max-width: 1024px) {
    .edit-product-container {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    
    .product-preview-section {
        position: static;
    }
    
    .form-row {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
}

@media (max-width: 768px) {
    .edit-form-section {
        padding: 1.5rem;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    .form-actions .btn {
        width: 100%;
        text-align: center;
    }
}
</style>

<script>
function updatePreview() {
    // Update product name
    const nameInput = document.getElementById('name');
    const previewName = document.getElementById('previewName');
    if (nameInput && previewName) {
        previewName.textContent = nameInput.value || 'Product Name';
    }
    
    // Update category
    const categorySelect = document.getElementById('category_id');
    const previewCategory = document.getElementById('previewCategory');
    if (categorySelect && previewCategory) {
        const selectedOption = categorySelect.options[categorySelect.selectedIndex];
        previewCategory.textContent = selectedOption.text || 'No Category';
    }
    
    // Update price
    const priceInput = document.getElementById('price');
    const previewPrice = document.getElementById('previewPrice');
    if (priceInput && previewPrice) {
        const price = parseFloat(priceInput.value) || 0;
        previewPrice.textContent = '$' + price.toFixed(2);
    }
    
    // Update stock
    const quantityInput = document.getElementById('quantity');
    const previewStock = document.getElementById('previewStock');
    if (quantityInput && previewStock) {
        const quantity = parseInt(quantityInput.value) || 0;
        previewStock.textContent = 'Stock: ' + quantity + ' items';
    }
}

function previewNewImage(input) {
    const preview = document.getElementById('newImagePreview');
    const previewImg = document.getElementById('newImagePreviewImg');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.style.display = 'block';
        }
        
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.style.display = 'none';
    }
}

// Initialize preview on page load
document.addEventListener('DOMContentLoaded', function() {
    updatePreview();
});
</script>
@endsection
