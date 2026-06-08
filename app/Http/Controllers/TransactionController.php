<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function pos()
    {
        $products = Product::where('is_active', 1)
            ->latest()
            ->get();

        return view('transactions.pos', compact('products'));
    }

    public function index(Request $request)
    {
        $query = Transaction::latest();

        if ($request->start_date) {

            $query->whereDate(
                'created_at',
                '>=',
                $request->start_date
            );
        }

        if ($request->end_date) {

            $query->whereDate(
                'created_at',
                '<=',
                $request->end_date
            );
        }

        $transactions = $query->get();

        return view(
            'transactions.index',
            compact('transactions')
        );
    }



    public function checkout(Request $request)
        {
            DB::beginTransaction();

            try {

                    $cart = $request->cart;

                    $subtotal = collect($cart)->sum(function ($item) {

                    return $item['price'] * $item['qty'];

                    });

                    $transaction = Transaction::create([

                        'invoice_number' => 'INV-' . time(),

                        'user_id' => auth()->id(),

                        'branch_id' => auth()->user()?->branch_id,

                        'subtotal' => $subtotal,

                        'discount' => 0,

                        'total' => $subtotal,

                        'status' => 'completed',

                    ]);


                    foreach ($cart as $item) {

                    $product = Product::find($item['id']);

                    if ($product->stock < $item['qty']) {

                        DB::rollback();

                        return response()->json([
                            'success' => false,
                            'message' => 'Stok tidak cukup'
                        ], 400);
                    }

                    TransactionItem::create([

                        'transaction_id' => $transaction->id,

                        'product_id' => $item['id'],

                        'qty' => $item['qty'],

                        'price' => $item['price'],

                        'subtotal' => $item['price'] * $item['qty'],

                    ]);

                    $product->decrement('stock', $item['qty']);
                    }

                     DB::commit();

                    return response()->json([
                    'success' => true
                ]);

            } catch (\Exception $e) {

                DB::rollback();

                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 500);

            }
        }



    public function show(Transaction $transaction)
    {
        $transaction->load('items.product');

        return view(
            'transactions.show',
            compact('transaction')
        );
    }



}