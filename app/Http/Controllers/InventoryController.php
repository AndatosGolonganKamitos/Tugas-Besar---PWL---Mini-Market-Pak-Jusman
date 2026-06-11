<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Branch;
use App\Models\ProductStock;
use App\Models\StockIn;
use App\Models\StockOpname;
use App\Models\Supplier;

class InventoryController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $query = ProductStock::with([
            'product.category',
            'branch'
        ]);

        if ($user->role != 'owner') {

            $query->where(
                'branch_id',
                $user->branch_id
            );
        }

        $stocks = $query->get();

        $totalStok = $stocks->sum('stock');

        $stokMenipis = $stocks->filter(function ($item) {

            return $item->stock <= $item->product->min_stock
                && $item->stock > 0;

        })->count();

        $stokHabis = $stocks->where('stock', 0)->count();

        $nilaiInventaris = $stocks->sum(function ($item) {

            return $item->stock
                * $item->product->purchase_price;

        });

        return view('inventory.index', compact(
            'stocks',
            'totalStok',
            'stokMenipis',
            'stokHabis',
            'nilaiInventaris'
        ));
    }

    public function stockOpname()
    {
        $user = auth()->user();

$histories = StockOpname::with([
    'productStock.product',
    'productStock.branch',
    'user'
]);

if ($user->role != 'owner') {

    $histories->whereHas(
        'productStock',
        function ($q) use ($user) {

            $q->where(
                'branch_id',
                $user->branch_id
            );
        }
    );
}

$histories = $histories
    ->latest()
    ->take(10)
    ->get();

        $query = ProductStock::with([
            'product',
            'branch'
        ]);

        if ($user->role != 'owner') {

            $query->where(
                'branch_id',
                $user->branch_id
            );
        }

        $stocks = $query->get();

        $branches = Branch::all();

        return view(
            'inventory.stock-opname',
            compact(
                'stocks',
                'branches',
                'histories'
            )
        );
    }

   public function saveOpname(Request $request)
{
    foreach ($request->stocks as $id => $physicalStock) {

        $stock = ProductStock::find($id);

        if (!$stock) {
            continue;
        }

        if ($stock->stock != $physicalStock) {

            $reason =
                $request->reasons[$id] ?? null;

            if (!$reason) {

                return back()->with(
                    'error',
                    'Alasan perubahan stok wajib diisi'
                );
            }

            StockOpname::create([

                'product_stock_id' => $stock->id,
                'stock_system'     => $stock->stock,
                'stock_fisik'      => $physicalStock,
                'selisih'          => $physicalStock - $stock->stock,
                'reason'           => $reason,
                'user_id'          => auth()->id()

            ]);

            $stock->update([
                'stock' => $physicalStock
            ]);
        }
    }

    return redirect()
        ->route('inventory.stock-opname')
        ->with(
            'success',
            'Stok opname berhasil disimpan'
        );
}

    public function stockIn()
    {
        $user = auth()->user();

        $products = Product::orderBy('name')->get();

        $suppliers = Supplier::orderBy('name')->get();

        $branches = [];

        if ($user->role == 'owner') {

            $branches = Branch::orderBy('name')->get();
        }

        $historyQuery = StockIn::with([
            'product',
            'branch',
            'supplier',
            'user'
        ]);

        if ($user->role != 'owner') {

            $historyQuery->where(
                'branch_id',
                $user->branch_id
            );
        }

        $history = $historyQuery
            ->latest()
            ->take(20)
            ->get();

        return view(
            'inventory.stock-in',
            compact(
                'products',
                'branches',
                'suppliers',
                'history'
            )
        );
    }

    public function storeStockIn(Request $request)
    {
        $user = auth()->user();

        $rules = [
            'product_id' => 'required',
            'supplier_id' => 'required',
            'qty' => 'required|integer|min:1',
            'note' => 'nullable'
        ];

        if ($user->role == 'owner') {

            $rules['branch_id'] = 'required';
        }

        $request->validate($rules);

        $branchId = $user->role == 'owner'
            ? $request->branch_id
            : $user->branch_id;

        $stock = ProductStock::where(
            'product_id',
            $request->product_id
        )
        ->where(
            'branch_id',
            $branchId
        )
        ->first();

        if (!$stock) {

            $stock = ProductStock::create([
                'product_id' => $request->product_id,
                'branch_id' => $branchId,
                'stock' => 0
            ]);
        }

        $stock->increment(
            'stock',
            $request->qty
        );

        StockIn::create([
            'product_id' => $request->product_id,
            'branch_id' => $branchId,
            'supplier_id' => $request->supplier_id,
            'user_id' => auth()->id(),
            'qty' => $request->qty,
            'note' => $request->note
        ]);

        return redirect()
            ->route('inventory.stock-in')
            ->with(
                'success',
                'Barang masuk berhasil disimpan'
            );
    }
}