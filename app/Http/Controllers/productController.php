<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; // added semicolon

class ProductController extends Controller
{
    // This method will show products page
    public function index() {

    }

    // This method will show create product page
    public function create() {
        return view('products.create');
    }

    // This method will store a product in the database
    public function store(Request $request) {
        $rules = [
            'name' => 'required|min:5',
            'sku' => 'required|min:3',
            'price' => 'required|numeric',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('products.create')->withErrors($validator)->withInput();

           
        }
        // Add code to store the product in the database
        $product = new product();
        $product->name = $request->name;
        $product->sku = $request->sku;
        $product->price = $request->price;
        $product->save();
    }

    // This method will show edit product page
    public function edit() {

    }

    // This method will update a product
    public function update() {

    }

    // This method will delete a product
    public function destroy() {

    }
}