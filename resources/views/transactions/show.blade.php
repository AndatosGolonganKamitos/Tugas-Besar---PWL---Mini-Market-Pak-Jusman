
<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Transaksi
        </h2>
    </x-slot>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">

        <div class="mb-6">
            <p><strong>Invoice:</strong> {{ $transaction->invoice_number }}</p>
            <p><strong>Tanggal:</strong> {{ $transaction->created_at->format('d M Y H:i') }}</p>
            <p><strong>Status:</strong> {{ $transaction->status }}</p>
            <p><strong>Total:</strong>
                Rp {{ number_format($transaction->total, 0, ',', '.') }}
            </p>
        </div>

        <table class="w-full">

            <thead>
                <tr class="bg-gray-50 text-left text-sm text-gray-600">
                    <th class="px-4 py-3">Produk</th>
                    <th class="px-4 py-3">Qty</th>
                    <th class="px-4 py-3">Harga</th>
                    <th class="px-4 py-3">Subtotal</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">

                @foreach($transaction->items as $item)

                    <tr>

                        <td class="px-4 py-3">
                            {{ $item->product->name }}
                        </td>

                        <td class="px-4 py-3">
                            {{ $item->qty }}
                        </td>

                        <td class="px-4 py-3">
                            Rp {{ number_format($item->price, 0, ',', '.') }}
                        </td>

                        <td class="px-4 py-3 font-semibold">
                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>

    <a href="{{ route('transactions.receipt', $transaction) }}"
   target="_blank"
   class="px-4 py-2 bg-green-600 text-white rounded">

    Cetak Struk

</a>


    <style>
@media print {

    aside,
    nav,
    .no-print {
        display: none !important;
    }

    body {
        background: white !important;
    }

}
</style>


</x-app-layout>
