<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $categories = Category::with('products.stocks')
    ->latest()
    ->get();

    return view('master.categories.index', compact('categories'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'code' => 'required|unique:categories',
        'name' => 'required',
        'description' => 'nullable',
        'is_active' => 'required',
    ]);

    Category::create([
            'code' => $request->code,
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $request->is_active,
    ]);

    return redirect()->back()->with('success', 'Kategori berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('master.categories.form', compact('category'));
        }
        
        /**
         * Update the specified resource in storage.
        */
        public function update(Request $request, Category $category)
        {
            //
            }
            
            /**
             * Remove the specified resource from storage.
            */
            public function destroy(Category $category)
                {
                    $category->delete();

                    return redirect()
                        ->route('master.categories.index')
                        ->with('success', 'Kategori berhasil dihapus');
                }
}
