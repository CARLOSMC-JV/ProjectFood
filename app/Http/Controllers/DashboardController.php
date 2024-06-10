<?php

namespace App\Http\Controllers;
use App\Models\Product; 
use Inertia\Inertia;
use App\Models\Category; 

class DashboardController extends Controller
{
    public function index()
    {
        $latestProducts = Product::with(['subcategory.category', 'images'])->latest()->take(15)->get();
        $categories = Category::all(); 
        $cart = session()->get('cart', []);

        if (is_object($cart)) {
            $cart = (array) $cart;
        }

        return Inertia::render('Dashboard', [
            'latestProducts' => $latestProducts,
            'categories' => $categories,
            'cart' => array_values($cart)
        ]);
    }
}