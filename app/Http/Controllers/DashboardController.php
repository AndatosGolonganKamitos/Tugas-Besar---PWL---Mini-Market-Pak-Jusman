<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Branch;
use App\Models\ProductStock;

class DashboardController extends Controller
{
    public function index()
    {
    $user = auth()->user();

    $transactionQuery = Transaction::query();
    $stockQuery = ProductStock::with('product');
    $userQuery = User::query();

    if ($user->role != 'owner') {

        $transactionQuery->where(
            'branch_id',
            $user->branch_id
        );

        $stockQuery->where(
            'branch_id',
            $user->branch_id
        );

        $userQuery->where(
            'branch_id',
            $user->branch_id
        );
    }

        $todaySales = (clone $transactionQuery)
            ->whereDate('created_at', today())
            ->sum('total');

        $totalTransactions = (clone $transactionQuery)
            ->count();

        $latestTransactions = (clone $transactionQuery)
            ->latest()
            ->take(5)
            ->get();

        $lowStocks = $stockQuery
        ->get()
        ->filter(function ($stock) {
            return $stock->stock <= $stock->product->min_stock;
        });

        $totalUsers = $userQuery->count();

        $totalBranches = Branch::count();

        return view('dashboard', [
        'penjualanHariIni' => $todaySales,
        'totalTransaksi' => $totalTransactions,
        'transaksiTerbaru' => $latestTransactions,
        'stokMenipis' => $lowStocks,
        'totalUser' => $totalUsers,
        'totalCabang' => $totalBranches,
        ]);
    }
}
     