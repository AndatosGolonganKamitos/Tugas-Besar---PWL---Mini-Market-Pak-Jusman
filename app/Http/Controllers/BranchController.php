<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index()
    {
        $branches = Branch::latest()->get();

        return view('branches.index', compact('branches'));
    }

    public function create()
    {
        return view('branches.form');
    }

    public function store(Request $request)
    {
        $request->validate([

            'code' => 'required|unique:branches,code',
            'name' => 'required',

        ]);

        Branch::create($request->all());

        return redirect()
            ->route('branches.index')
            ->with('success', 'Cabang berhasil ditambahkan');
    }

    public function edit(Branch $branch)
    {
        return view('branches.form', compact('branch'));
    }

    public function update(Request $request, Branch $branch)
    {
        $request->validate([

            'code' => 'required|unique:branches,code,' . $branch->id,
            'name' => 'required',

        ]);

        $branch->update($request->all());

        return redirect()
            ->route('branches.index')
            ->with('success', 'Cabang berhasil diupdate');
    }

    public function destroy(Branch $branch)
    {
        $branch->delete();

        return redirect()
            ->route('branches.index')
            ->with('success', 'Cabang berhasil dihapus');
    }
}
