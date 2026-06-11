<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;
use App\Models\User;

class BranchController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role == 'owner') {

            $branches = Branch::with([
                'users',
                'transactions'
            ])->get();

        } else {

            $branches = Branch::with([
                'users',
                'transactions'
            ])
            ->where('id', $user->branch_id)
            ->get();

        }

        return view('branches.index', compact('branches'));
    }

    public function create()
        {
            $users = User::whereIn('role', [
                'manager',
                'supervisor'
            ])->get();

            return view(
                'branches.form',
                compact('users')
            );
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
        if (auth()->user()->role != 'owner') {
            abort(403);
        }

        $users = User::where('role', 'manager')->get();

        return view(
            'branches.form',
            compact(
                'branch',
                'users'
            )
        );
    }

    public function update(Request $request, Branch $branch)
    {
        if (auth()->user()->role != 'owner') {
            abort(403);
        }

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
        if (auth()->user()->role != 'owner') {
            abort(403);
        }

        $branch->delete();

        return redirect()
            ->route('branches.index')
            ->with('success', 'Cabang berhasil dihapus');
    }

    public function show(Branch $branch)
    {
        $user = auth()->user();

        // selain owner hanya boleh lihat cabangnya sendiri
        if ($user->role != 'owner' && $user->branch_id != $branch->id) {

            abort(403, 'Akses ditolak');

        }

        $branch->load([
            'users',
            'transactions.user'
        ]);

        $todayTransactions = $branch->transactions()
            ->whereDate('created_at', today())
            ->get();

        $manager = $branch->users()
            ->where('role', 'manager')
            ->first();

        return view('branches.show', [
            'branch' => $branch,
            'manager' => $manager,
            'totalKaryawan' => $branch->users->count(),
            'transaksiHariIni' => $todayTransactions->count(),
            'pendapatanHariIni' => $todayTransactions->sum('total'),
        ]);
    }

       
}
