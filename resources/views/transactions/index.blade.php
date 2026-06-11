<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Riwayat Transaksi</h2>
            <a href="{{ route('transactions.pos') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                Transaksi Baru
            </a>
        </div>
    </x-slot>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-4 border-b border-gray-100">
            <div class="flex flex-wrap gap-3">
                <div class="relative flex-1 max-w-sm">
                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input
                        type="text"
                        id="searchInput"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari invoice atau kasir..."
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm"
                    >
                </div>
                <form method="GET" class="flex flex-wrap gap-3">
                    <input
                        type="date"
                        name="start_date"
                        value="{{ request('start_date') }}"
                        class="border border-gray-300 rounded-lg text-sm px-3 py-2"
                    >

                    <input
                        type="date"
                        name="end_date"
                        value="{{ request('end_date') }}"
                        class="border border-gray-300 rounded-lg text-sm px-3 py-2"
                    >

                    
                </form>
               
            </div>
        </div>

        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                    <th class="px-6 py-3">ID Transaksi</th>
                    <th class="px-6 py-3">Tanggal</th>
                    <th class="px-6 py-3">Kasir</th>
                    <th class="px-6 py-3">Cabang</th>
                    <th class="px-6 py-3">Total</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </thead>
                <tbody id="transactionTable" class="divide-y divide-gray-100">

                    @forelse($transactions as $transaction)

                        <tr>

                            <td class="px-6 py-4">
                                {{ $transaction->invoice_number }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $transaction->created_at->format('d M Y H:i') }}
                            </td>

                            <td>
                                {{ $transaction->user->name ?? '-' }}
                            </td>

                            <td>
                                {{ $transaction->branch->name ?? '-' }}
                            </td>

                            <td class="px-6 py-4 font-semibold">
                                Rp {{ number_format($transaction->total, 0, ',', '.') }}
                            </td>

                            <td class="px-6 py-4">

                                <span class="text-green-600 font-semibold">
                                    {{ $transaction->status }}
                                </span>

                            </td>

                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('transactions.show', $transaction) }}"
                                   class="text-indigo-600 hover:text-indigo-800 font-medium">
                                    Detail
                                </a>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="7"
                                class="px-6 py-12 text-center text-gray-400">

                                Belum ada transaksi

                            </td>
                        </tr>

                    @endforelse

                </tbody>

        </table>

        <div class="px-6 py-3 border-t border-gray-100 text-sm text-gray-500">
            Total: {{ count($transactions) }} transaksi
        </div>
    </div>
</x-app-layout>
<script>
document.getElementById('searchInput').addEventListener('input', function() {

    let keyword = this.value.toLowerCase();

    let rows = document.querySelectorAll('#transactionTable tr');

    rows.forEach(function(row) {

        let text = row.innerText.toLowerCase();

        row.style.display =
            text.includes(keyword) ? '' : 'none';

    });

});
</script>