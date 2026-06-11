<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Branch;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SalesExport;
use App\Models\Product;


class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with('branch')
        ->latest();

        $user = auth()->user();

        if ($user->role != 'owner') {

            $query->where(
                'branch_id',
                $user->branch_id
            );

        }
        
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
                    
                    })->map(function ($items) 
                    {
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
        $user = auth()->user();

        $query = Transaction::query();

        if ($user->role != 'owner') {

            $query->where(
                'branch_id',
                $user->branch_id
            );

        }

        $transactions = $query->get();

        $totalPendapatan = $transactions->sum('total');

        $jumlahTransaksi = $transactions->count();

        $rataRata = $jumlahTransaksi > 0
            ? $totalPendapatan / $jumlahTransaksi
            : 0;

        $estimasiLaba = $totalPendapatan * 0.2;

        return view(
            'reports.finance',
            compact(
                'totalPendapatan',
                'jumlahTransaksi',
                'rataRata',
                'estimasiLaba'
            )
        );
    }
                    
                    
   public function employee()
    {
        $user = auth()->user();

        $query = User::query();

        if ($user->role != 'owner') {

            $query->where(
                'branch_id',
                $user->branch_id
            );

        }

        $employees = $query->latest()->get();

        $totalKaryawan = $employees->count();

        return view(
            'reports.employee',
            compact(
                'employees',
                'totalKaryawan'
            )
        );
    }
                                                            
   
        public function stock()
            {
                $products = Product::with([
                    'category',
                    'stocks'
                ])->get();

                $branches = Branch::all();

                return view(
                    'reports.stock',
                    compact(
                        'products',
                        'branches'
                    )
                );
            }
     public function branch()
        {
            $user = auth()->user();

            $query = Branch::with([
                'users',
                'transactions'
            ]);

            if ($user->role != 'owner') {

                $query->where(
                    'id',
                    $user->branch_id
                );

            }

            $branches = $query->get();

            return view(
                'reports.branch',
                compact('branches')
            );
        }
                        
            public function exportSales()
            {
                return Excel::download(
                    new SalesExport,
                    'laporan-penjualan.xlsx'
                    );
            }
}  