<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $user = auth()->user();

    $query = Product::with([
        'category',
        'stocks'
    ]);

    if ($user->role != 'owner') {

        $query->whereHas('stocks', function ($q) use ($user) {

            $q->where(
                'branch_id',
                $user->branch_id
            );

        });

    }

    $products = $query->get();

    $categories = Category::all();

    return view(
        'master.products.index',
        compact(
            'products',
            'categories'
        )
    );
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();

        $suppliers = Supplier::all();

        return view(
            'master.products.form',
            compact('categories', 'suppliers')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:products',
            'name' => 'required',
            'category_id' => 'required',
            'purchase_price' => 'required|numeric',
            'selling_price' => 'required|numeric',
            'stock' => 'required|numeric',
            'barcode' => 'nullable',
            'supplier_id' => 'nullable',
            'min_stock' => 'required|numeric',
            'unit' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_active' => 'required',
        ]);


    $image = null;

    if ($request->hasFile('image')) {

        $image = $request->file('image')
            ->store('products', 'public');
    }

        Product::create([
            'code' => $request->code,
            'name' => $request->name,
            'category_id' => $request->category_id,
            'purchase_price' => $request->purchase_price,
            'selling_price' => $request->selling_price,
            'stock' => $request->stock,
            'is_active' => $request->is_active,
            'barcode' => $request->barcode,
            'supplier_id' => $request->supplier_id,
            'min_stock' => $request->min_stock,
            'unit' => $request->unit,
            'image' => $image,
        ]);

        return redirect()
            ->route('master.products.index')
            ->with('success', 'Produk berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();

        $suppliers = Supplier::all();

        return view(
            'master.products.form',
            compact('product', 'categories', 'suppliers')
        );
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, Product $product)
    {
        $request->validate([
            'code' => 'required|unique:products,code,' . $product->id,
            'name' => 'required',
            'category_id' => 'required',
            'purchase_price' => 'required|numeric',
            'selling_price' => 'required|numeric',
            'stock' => 'required|numeric',
            'barcode' => 'nullable',
            'supplier_id' => 'nullable',
            'min_stock' => 'required|numeric',
            'unit' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_active' => 'required',
        ]);

        $data = [
            'code' => $request->code,
            'name' => $request->name,
            'category_id' => $request->category_id,
            'purchase_price' => $request->purchase_price,
            'selling_price' => $request->selling_price,
            'stock' => $request->stock,
            'is_active' => $request->is_active,
            'barcode' => $request->barcode,
            'supplier_id' => $request->supplier_id,
            'min_stock' => $request->min_stock,
            'unit' => $request->unit,
        ];

        if ($request->hasFile('image')) {

            $data['image'] = $request->file('image')
                ->store('products', 'public');
        }

        $product->update($data);

        return redirect()
            ->route('master.products.index')
            ->with('success', 'Produk berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()
            ->route('master.products.index')
            ->with('success', 'Produk berhasil dihapus');
    }
}
