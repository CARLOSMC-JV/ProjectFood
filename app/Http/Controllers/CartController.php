<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::find($request->product_id);
        $cart = session()->get('cart', []);
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $request->quantity;
        } else {
            $cart[$product->id] = [
                "id" => $product->id,
                "name" => $product->name,
                "quantity" => $request->quantity,
                "price" => $product->price,
                "image" => $product->image
            ];
        }

        session()->put('cart', $cart);

        return back()->with('success', 'Product added to cart');
    }

    public function viewCart()
    {
        $cart = session()->get('cart', []);
        return Inertia::render('ProductCategory/Index', [
            'cart' => $cart,
            // Asegúrate de pasar también otros props necesarios
            'products' => Product::all(),
            'category' => 'some_category',
            'class_category' => 'some_class_category',
        ]);
    }

    public function removeFromCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$request->product_id])) {
            unset($cart[$request->product_id]);
            session()->put('cart', $cart);
        }

        return response()->json(['message' => 'Product removed from cart', 'cart' => $cart], 200);
    }

    public function clearCart()
    {
        session()->forget('cart');
        return response()->json(['message' => 'Cart cleared'], 200);
    }
}