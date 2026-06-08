<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\User;


class ReportController extends Controller
{
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

        $totalPenjualan = $transactions->sum('total');

        $jumlahTransaksi = $transactions->count();

        $salesChart = $transactions
            ->groupBy(function ($item) {

                return $item->created_at->format('d M');

            })
            ->map(function ($items) {

                return $items->sum('total');

            });

        return view('reports.sales', compact(
            'transactions',
            'totalPenjualan',
            'jumlahTransaksi',
            'salesChart'
        ));
    }

                        
    public function finance()
    {
        $transactions = Transaction::all();
        
        $totalPendapatan = $transactions->sum('total');
        
        $jumlahTransaksi = $transactions->count();
        
        $rataRata = $jumlahTransaksi > 0
        ? $totalPendapatan / $jumlahTransaksi
        : 0;
        
        $estimasiLaba = $totalPendapatan * 0.2;
        
        return view('reports.finance', compact(
            'totalPendapatan',
            'jumlahTransaksi',
            'rataRata',
            'estimasiLaba',
            ));

            $salesChart = $transactions
            ->groupBy(function ($item) {
            
                return $item->created_at->format('d M');
            
            })
            ->map(function ($items) {
            
                return $items->sum('total');
            
            });
        }
                                
                                
        public function employee()
        {
            $employees = User::latest()->get();

            $totalKaryawan = $employees->count();

            return view('reports.employee', compact(
                'employees',
                'totalKaryawan'
            ));
        }

    public function stock(Request $request)
    {
        $query = Transaction::with('items.product')
            ->latest();

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

        return view('reports.stock', compact(
            'transactions'
        ));
    }




}
