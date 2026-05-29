<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class InventoryController extends Controller
{
    public function index()
{   
    $products = Product::with('category')->latest()->get();

    $totalStok = $products->sum('stock');

    $stokMenipis = $products
        ->where('stock', '<=', 'min_stock')
        ->count();

    $stokHabis = $products
        ->where('stock', 0)
        ->count();

    $nilaiInventaris = $products->sum(function ($product) {

        return $product->purchase_price * $product->stock;

    });

    return view('inventory.index', compact(
        'products',
        'totalStok',
        'stokMenipis',
        'stokHabis',
        'nilaiInventaris'
    ));
}
}