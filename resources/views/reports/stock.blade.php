```blade
<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Laporan Stok
            </h2>

            <div class="flex gap-2">
                <button class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg">
                    Export Excel
                </button>

                <button onclick="window.print()"
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg">
                    Print
                </button>
            </div>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- STOK MASUK --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">

            <div class="px-5 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-gray-900">
                    Stok Masuk
                </h3>
            </div>

            <div class="p-4 border-b border-gray-100">

                <form method="GET"
                    action="{{ route('reports.stock') }}"
                    class="flex flex-wrap gap-3">

                    <input
                        type="date"
                        name="start_date"
                        value="{{ request('start_date') }}"
                        class="border border-gray-300 rounded-lg text-sm px-3 py-2">

                    <span class="text-gray-400">—</span>

                    <input
                        type="date"
                        name="end_date"
                        value="{{ request('end_date') }}"
                        class="border border-gray-300 rounded-lg text-sm px-3 py-2">

                    <button
                        type="submit"
                        class="px-3 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg">

                        Filter

                    </button>

                </form>

            </div>

            <table class="w-full">

                <thead>
                    <tr class="bg-gray-50 text-left text-xs font-semibold text-gray-500 uppercase">
                        <th class="px-5 py-3">Tanggal</th>
                        <th class="px-5 py-3">Produk</th>
                        <th class="px-5 py-3">Jumlah</th>
                        <th class="px-5 py-3">Supplier</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td colspan="4"
                            class="px-5 py-8 text-center text-gray-400">

                            Belum ada data

                        </td>
                    </tr>
                </tbody>

            </table>

        </div>

        {{-- STOK KELUAR --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">

            <div class="px-5 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-gray-900">
                    Stok Keluar
                </h3>
            </div>

            <div class="p-4 border-b border-gray-100">

                <form method="GET"
                    action="{{ route('reports.stock') }}"
                    class="flex flex-wrap gap-3">

                    <input
                        type="date"
                        name="start_date"
                        value="{{ request('start_date') }}"
                        class="border border-gray-300 rounded-lg text-sm px-3 py-2">

                    <span class="text-gray-400">—</span>

                    <input
                        type="date"
                        name="end_date"
                        value="{{ request('end_date') }}"
                        class="border border-gray-300 rounded-lg text-sm px-3 py-2">

                    <button
                        type="submit"
                        class="px-3 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg">

                        Filter

                    </button>

                </form>

            </div>

            <table class="w-full">

                <thead>
                    <tr class="bg-gray-50 text-left text-xs font-semibold text-gray-500 uppercase">
                        <th class="px-5 py-3">Tanggal</th>
                        <th class="px-5 py-3">Produk</th>
                        <th class="px-5 py-3">Jumlah</th>
                        <th class="px-5 py-3">Keterangan</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">

                    @forelse($transactions as $transaction)

                        @foreach($transaction->items as $item)

                        <tr>

                            <td class="px-5 py-3">
                                {{ $transaction->created_at->format('d M Y') }}
                            </td>

                            <td class="px-5 py-3">
                                {{ $item->product->name }}
                            </td>

                            <td class="px-5 py-3">
                                {{ $item->qty }}
                            </td>

                            <td class="px-5 py-3">
                                Penjualan
                            </td>

                        </tr>

                        @endforeach

                    @empty

                        <tr>
                            <td colspan="4"
                                class="px-5 py-8 text-center text-gray-400">

                                Belum ada data

                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</x-app-layout>
```
