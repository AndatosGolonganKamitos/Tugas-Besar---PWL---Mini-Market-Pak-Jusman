<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Branch;


class DashboardController extends Controller
{
public function index()
{
    $penjualanHariIni = Transaction::whereDate(
        'created_at',
        today()
    )->sum('total');    

    $totalTransaksi = Transaction::count();

    $totalProduk = Product::count();

    $totalPelanggan = 0;

    $totalUser = User::count();

    $totalCabang = Branch::count();

    $transaksiTerbaru = Transaction::latest()
        ->take(5)
        ->get();

    $stokMenipis = Product::whereColumn(
        'stock',
        '<=',
        'min_stock'
    )->get();

    return view('dashboard', compact(
    'penjualanHariIni',
    'totalTransaksi',
    'totalProduk',
    'totalUser',
    'totalCabang',
    'transaksiTerbaru',
    'stokMenipis'
));
}

}