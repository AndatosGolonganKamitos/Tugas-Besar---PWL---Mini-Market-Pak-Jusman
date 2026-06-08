<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Laporan Penjualan</h2>
            <div class="flex gap-2">
                <button class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">Export Excel</button>
                <button
                    onclick="window.print()"
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                    Print
                </button>

            </div>
        </div>
    </x-slot>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-4 border-b border-gray-100">
            <div class="flex flex-wrap gap-3 items-center">
                <input type="date" class="border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
                <span class="text-gray-400">—</span>
                <input type="date" class="border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
                <select class="border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Semua Cabang</option>
                </select>
                <button class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition">Filter</button>
            </div>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                <div class="p-4 bg-gray-50 rounded-lg text-center">
                    <p class="text-sm text-gray-500">Total Penjualan</p>
                    Rp {{ number_format($totalPenjualan, 0, ',', '.') }}
                </div>
                <div class="p-4 bg-gray-50 rounded-lg text-center">
                    <p class="text-sm text-gray-500">Total Transaksi</p>
                    {{ $jumlahTransaksi }}
                </div>
                <div class="p-4 bg-gray-50 rounded-lg text-center">
                    <p class="text-sm text-gray-500">Rata-rata Transaksi</p>
                    Rp{{ number_format($jumlahTransaksi > 0? $totalPenjualan / $jumlahTransaksi: 0,0,',','.') }}
                </div>
            </div>

            <div class="border border-gray-200 rounded-lg p-8 text-center text-gray-400">
                <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    <div class="bg-white border border-gray-200 rounded-lg p-6">

                        <canvas id="salesChart"></canvas>

                    </div>

                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

                    <script>

                    const ctx = document.getElementById('salesChart');

                    new Chart(ctx, {

                        type: 'bar',

                        data: {

                            labels: {!! json_encode($salesChart->keys()) !!},

                            datasets: [{ label: 'Penjualan', data: {!! json_encode($salesChart->values()) !!}, }]

                        }

                    });

                    </script>

                <p class="text-xs mt-1">Pilih periode untuk melihat data</p>
            </div>
        </div>

        <div class="border-t border-gray-100">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        <th class="px-6 py-3">Tanggal</th>
                        <th class="px-6 py-3">Cabang</th>
                        <th class="px-6 py-3">Jumlah Transaksi</th>
                        <th class="px-6 py-3">Total Penjualan</th>
                        <th class="px-6 py-3">Rata-rata</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($transactions as $transaction)

                    <tr>

                        <td class="px-6 py-4">
                            {{ $transaction->created_at->format('d M Y') }}
                        </td>

                        <td class="px-6 py-4">
                            Utama
                        </td>

                        <td class="px-6 py-4">
                            1
                        </td>

                        <td class="px-6 py-4 font-semibold">
                            Rp {{ number_format($transaction->total, 0, ',', '.') }}
                        </td>

                        <td class="px-6 py-4">
                            Rp {{ number_format($transaction->total, 0, ',', '.') }}
                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="5"
                            class="px-6 py-8 text-center text-gray-400">

                            Belum ada data

                        </td>

                    </tr>

                    @endforelse


                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
