<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;

class SalesExport implements FromCollection
{
    public function collection()
    {
        return Transaction::with([
            'user',
            'branch'
        ])->get()->map(function ($t) {

            return [

                'Invoice' => $t->invoice_number,

                'Tanggal' => $t->created_at->format('d-m-Y H:i'),

                'Kasir' => $t->user->name ?? '-',

                'Cabang' => $t->branch->name ?? '-',

                'Total' => $t->total,

                'Status' => ucfirst($t->status),

            ];

        });
    }
}