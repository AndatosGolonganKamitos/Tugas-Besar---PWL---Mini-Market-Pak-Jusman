<?php

namespace App\Http\Controllers;

use App\Models\Product;

class TransactionController extends Controller
{
    public function pos()
    {
        $products = Product::where('is_active', 1)
            ->latest()
            ->get();

        return view('transactions.pos', compact('products'));
    }
}