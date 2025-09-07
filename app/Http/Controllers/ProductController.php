<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
  public function product_form()
  {
        $categories = Category::active()->ordered()->get();
        return view('product.product_form', compact('categories'));
   }

    public function store_product(Request $request)
    {
      $validated_data = $request->validate([
        'name' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'quantity' => 'required|integer|min:0',
        'category_id' => 'required|exists:categories,id',
        'description' => 'nullable|string',
        'material' => 'nullable|string|max:255',
        'brand' => 'nullable|string|max:255',
        'size' => 'nullable|string|max:255',
        'color' => 'nullable|string|max:255',
        'weight' => 'nullable|string|max:255',
        'gender' => 'nullable|in:Men,Women,Unisex',
        'sku' => 'nullable|string|max:255|unique:products,sku',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
      ]);

      if($request->hasFile('image')){
        $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
        $request->file('image')->move(
          public_path('images/products'),
          $imageName
        );
        $validated_data['image'] = $imageName;
      }
      if(Product::create($validated_data))
        {
      return redirect()->back()->with('message','Product Saved');

        };
      return redirect()->back()->with('message','saved');

  }

  public function all_products()
  {
    $all_products = Product::with('category')->active()->get();
    $categories = Category::active()->ordered()->get();
    return view('product.all_products', ['products'=>$all_products, 'categories'=>$categories]);
  }

 public function delete_product($product_id)
  {
    $product = Product::where('id',$product_id)->first();
    $product->delete();
    return redirect()->back()->with('message','Product Deleted');
  }

public function edit_product($id)
  {
    $prod = Product::where('id',$id)->first();
    $categories = Category::active()->ordered()->get();
    return view('product.edit_product',['product'=>$prod, 'categories'=>$categories]);
  }

  public function update_product(Request $request, $id)
  {
    $validated_data = $request->validate([
        'name' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'quantity' => 'required|integer|min:0',
        'category_id' => 'required|exists:categories,id',
        'description' => 'nullable|string',
        'material' => 'nullable|string|max:255',
        'brand' => 'nullable|string|max:255',
        'size' => 'nullable|string|max:255',
        'color' => 'nullable|string|max:255',
        'weight' => 'nullable|string|max:255',
        'gender' => 'nullable|in:Men,Women,Unisex',
        'sku' => 'nullable|string|max:255|unique:products,sku,' . $id,
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
      ]);

      $product = Product::where('id',$id)->first();
      
      // Only update image if a new one is provided
      if($request->hasFile('image')){
        $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
        $request->file('image')->move(
          public_path('images/products'),
          $imageName
        );
        $validated_data['image'] = $imageName;
      } else {
        // Keep the existing image if no new image is uploaded
        unset($validated_data['image']);
      }
      
      $product->update($validated_data);   
      return redirect()->back()->with('message','Product Updated');

  }

public function sell_product(Request $request, $id)
  {
    $validated_data = $request->validate([
        'sold_quantity'=>'required',

      ]);

      $product=Product::where('id',$id)->first();
      $remaining_quantity=$product->quantity - $validated_data['sold_quantity'];
      $product->quantity=$remaining_quantity;
      $product->save();

      return redirect()->back()->with('message','thank-you!');

      
  }

public function purchase_product(Request $request, $id)
  {
    $validated_data = $request->validate([
        'purchased_quantity'=>'required',

      ]);

      $product=Product::where('id',$id)->first();
      $new_quantity=$product->quantity + $validated_data['purchased_quantity'];
      $product->quantity=$new_quantity;
      $product->save();

      return redirect()->back()->with('message','Quantity Increased');

      
  }

  public function products_by_category($category_id)
  {
    $category = Category::findOrFail($category_id);
    $products = Product::with('category')->byCategory($category_id)->active()->get();
    $categories = Category::active()->ordered()->get();
    return view('product.products_by_category', compact('products', 'category', 'categories'));
  }

}
