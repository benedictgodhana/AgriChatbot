<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {

        // Fetch products from the database
        $products = Product::paginate(10); // Uncomment this line if you have a Product model
        return view('products.index',compact('products')); // Ensure this view file exists
    }

    public function create()
    {
        return view('products.create'); // Ensure this view file exists
    }

    public function store(Request $request)
    {
        // Validate and store the product
        // Redirect or return a response
    }

    public function edit($id)
    {
        return view('products.edit', compact('id')); // Ensure this view file exists
    }

    public function update(Request $request, $id)
    {
        // Validate and update the product
        // Redirect or return a response
    }

    public function destroy($id)
    {
        // Delete the product
        // Redirect or return a response
    }
}
