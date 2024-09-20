<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function index() {
        $products = Product::orderBy('created_at', 'DESC')->get();
        return view('products.list', [
            'products' => $products
        ]);
    }

    public function create() {
        return view('products.create');
    }

    public function store(Request $request) {
        // Validation rules
        $rules = [
            'name' => 'required|min:5',
            'sku' => 'required|min:3',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validate image file
        ];

        // Validate input
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('products.create')
                ->withErrors($validator)
                ->withInput();
        }

        // Store product details
        $product = new Product();
        $product->name = $request->name;
        $product->sku = $request->sku;
        $product->price = $request->price;
        $product->description = $request->description;

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $ext = $image->getClientOriginalExtension();
            $imageName = time() . '.' . $ext;

            // Move the image to the 'uploads/products' directory
            $image->move(public_path('uploads/products'), $imageName);

            // Store the image name in the database
            $product->image = $imageName;
        }

        // Save product
        $product->save();

        return redirect()->route('products.index')
            ->with('success', 'Product added successfully.');
    }

    public function edit($id) {
        $product = Product::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, $id) {
        // Validation rules
        $rules = [
            'name' => 'required|min:5',
            'sku' => 'required|min:3',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validate image file
        ];

        // Validate input
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('products.edit', $id)
                ->withErrors($validator)
                ->withInput();
        }

        // Find and update the product
        $product = Product::findOrFail($id);
        $product->name = $request->name;
        $product->sku = $request->sku;
        $product->price = $request->price;
        $product->description = $request->description;

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($product->image && File::exists(public_path('uploads/products/'.$product->image))) {
                File::delete(public_path('uploads/products/'.$product->image));
            }

            $image = $request->file('image');
            $ext = $image->getClientOriginalExtension();
            $imageName = time() . '.' . $ext;

            // Move the new image to the 'uploads/products' directory
            $image->move(public_path('uploads/products'), $imageName);

            // Store the new image name in the database
            $product->image = $imageName;
        }

        // Save changes
        $product->save();

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy($id) {
        $product = Product::findOrFail($id);

        // Delete the image if it exists
        if ($product->image && File::exists(public_path('uploads/products/'.$product->image))) {
            File::delete(public_path('uploads/products/'.$product->image));
        }

        // Delete the product
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully.');
    }
}
