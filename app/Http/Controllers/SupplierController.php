<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers = Supplier::latest()->get();

        return view('master.suppliers.index', compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
        {
            $request->validate([
                'code' => 'required|unique:suppliers',
                'name' => 'required',
                'contact_person' => 'nullable|string',
                'phone' => 'nullable',
                'email' => 'nullable|email',
                'address' => 'nullable',
                'is_active' => 'required',
            ]);

            Supplier::create([
                'code' => $request->code,
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'address' => $request->address,
                'is_active' => $request->is_active,
            ]);

            return redirect()
                ->route('master.suppliers.index')
                ->with('success', 'Supplier berhasil ditambahkan');
        }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        return view('master.suppliers.form', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier)
        {
            $request->validate([
                'code' => 'required|unique:suppliers,code,' . $supplier->id,
                'name' => 'required',
                'contact_person' => 'nullable|string',
            ]);

            $supplier->update($request->all());

            return redirect()
                ->route('master.suppliers.index')
                ->with('success', 'Supplier berhasil diupdate');
        }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
        {
            $supplier->delete();

            return redirect()
                ->route('master.suppliers.index')
                ->with('success', 'Supplier berhasil dihapus');
        }

        
}
