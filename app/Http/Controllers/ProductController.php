<?php

namespace App\Http\Controllers;

use App\Models\Manufacturer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ProductController extends Controller
{
    public function index()
    {
        // Eager-load the 'manufacturer' relationship to prevent N+1 queries
        $products = Product::with('manufacturer')->paginate(10);
        $manufacturers=Manufacturer::all();

        return view('products.index', compact('products', 'manufacturers')); // Ensure this view file exists
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
