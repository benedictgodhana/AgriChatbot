<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $productId = $request->input('product_id');
        $product = Product::find($productId);

        if ($product) {
            $cart = session()->get('cart', []);
            if (isset($cart[$productId])) {
                $cart[$productId]['quantity']++;
            } else {
                $cart[$productId] = [
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => 1,
                    'image' => $product->image,
                ];
            }
            session()->put('cart', $cart);

            // Update cart count
            $cartCount = array_sum(array_column($cart, 'quantity'));
            session()->put('cart_count', $cartCount);

            return response()->json([
                'message' => 'Product added to cart!',
                'cartCount' => $cartCount
            ]);
        }

        return response()->json(['message' => 'Product not found.'], 404);
    }

    public function index()
    {
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }

    public function checkout()
    {
        // Handle checkout (e.g., order creation, payment processing)
        return view('checkout.index');
    }
}
