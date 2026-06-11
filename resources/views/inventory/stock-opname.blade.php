    <x-app-layout>
        <x-slot name="header">
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Stok Opname</h2>
                <div class="flex gap-2">
                    <button type="submit" form="opname-form"
                        class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition">
                        Simpan Opname
                    </button>
                </div>
            </div>
        </x-slot>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            {{-- Form Side --}}
            <div class="lg:col-span-3 space-y-4">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                    <div class="flex flex-wrap gap-3">
                        <div class="relative flex-1 max-w-sm">
                            <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <input type="text" id="search-product" placeholder="Scan barcode atau cari produk..." 
                                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        @if(auth()->user()->role == 'owner')

                            <select
                                id="branch-filter"
                                class="border border-gray-300 rounded-lg text-sm px-3 py-2">

                                <option value="">
                                    Semua Cabang
                                </option>

                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}">
                                        {{ $branch->name }}
                                    </option>
                                @endforeach

                            </select>

                            @endif
                        <select id="category-filter" class="border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Semua Kategori</option>
                            @foreach($categories ?? [] as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <form id="opname-form"
        method="POST"
        action="{{ route('inventory.stock-opname.save') }}">

        @csrf

        <table class="w-full">

            <thead>
                <tr class="bg-gray-50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">

                    <th class="px-6 py-3">Produk</th>
                    <th class="px-6 py-3">Stok Sistem</th>
                    <th class="px-6 py-3">Stok Fisik</th>
                    <th class="px-6 py-3">Selisih</th>
                    <th class="px-6 py-3">Keterangan</th>

                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">

                @forelse($stocks as $stock)

                <tr>

                    <td class="px-6 py-3">
                        <div class="font-medium">
                            {{ $stock->product->name }}
                        </div>

                        <div class="text-xs text-gray-500">
                            SKU : {{ $stock->product->sku ?? '-' }}
                        </div>
                    </td>

                    <td class="px-6 py-3 system-stock">
                        {{ $stock->stock }}
                    </td>

                    <td class="px-6 py-3">

                        <input
                            type="number"
                            name="stocks[{{ $stock->id }}]"
                            value="{{ $stock->stock }}"
                            min="0"
                            class="physical-stock border rounded px-3 py-2 w-28">

                    </td>

                    <td class="px-6 py-3 difference font-semibold text-gray-700">
                        0
                    </td>

                    <td class="px-6 py-3">

                        <select
                            name="reasons[{{ $stock->id }}]"
                            class="reason-select border rounded px-3 py-2 hidden">

                            <option value="">
                                Pilih Alasan
                            </option>

                            <option value="Hilang">
                                Hilang
                            </option>

                            <option value="Rusak">
                                Rusak
                            </option>

                            <option value="Kadaluarsa">
                                Kadaluarsa
                            </option>

                            <option value="Salah Input">
                                Salah Input
                            </option>

                            <option value="Lainnya">
                                Lainnya
                            </option>

                        </select>

                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="5"
                        class="text-center py-10 text-gray-400">

                        Belum ada data stok

                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

    </form>
                </div>
            </div>

            {{-- Summary --}}
            <div class="space-y-4">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5"><div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                    <h3 class="font-semibold text-gray-900 mb-3">
                        Ringkasan
                    </h3>

                    <div class="space-y-3 text-sm">

                        <div class="flex justify-between">
                            <span class="text-gray-500">
                                Produk Dicek
                            </span>

                            <span
                                id="produkDicek"
                                class="font-medium">

                                {{ $stocks->count() }}

                            </span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-500">
                                Selisih (+)
                            </span>

                            <span
                                id="selisihPlus"
                                class="font-medium text-green-600">

                                0

                            </span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-500">
                                Selisih (-)
                            </span>

                            <span
                                id="selisihMinus"
                                class="font-medium text-red-600">

                                0

                            </span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-500">
                                Total Selisih
                            </span>

                            <span
                                id="totalSelisih"
                                class="font-semibold">

                                0 pcs

                            </span>
                        </div>

                        <div class="flex justify-between border-t border-gray-100 pt-3">
                            <span class="text-gray-500">
                                Cabang
                            </span>

                            <span
                                class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">

                                {{ auth()->user()->branch->name ?? 'Semua Cabang' }}

                            </span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-500">
                                Petugas
                            </span>

                            <span class="font-medium">
                                {{ Auth::user()->name }}
                            </span>
                        </div>

                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                    <h3 class="font-semibold text-gray-900 mb-3">Riwayat Opname</h3>
                    <div class="space-y-3 max-h-96 overflow-y-auto">
                        @forelse($histories as $history)
                        
                        <div class="text-xs text-gray-500">
                            {{ $history->productStock->branch->name }}
                        </div>
                        <div class="border-b py-2 text-sm">

                            <div class="font-medium">
                                {{ $history->productStock->product->name }}
                            </div>

                            <div class="text-xs text-gray-500">
                                {{ $history->productStock->branch->name }}
                            </div>

                            <div class="text-gray-500">
                                Stok:
                                {{ $history->stock_system }}
                                →
                                {{ $history->stock_fisik }}

                                <span class="text-red-600">
                                    ({{ $history->selisih }})
                                </span>
                            </div>

                            @if($history->reason)
                            <div class="text-xs mt-1">
                                📌 {{ $history->reason }}
                            </div>
                            @endif

                            <div class="text-xs text-gray-400">
                                {{ $history->user->name }}
                                •
                                {{ $history->created_at->format('d/m/Y H:i') }}
                            </div>

                        </div>

                        @empty

                        <div class="text-center py-4 text-gray-400 text-sm">
                            Belum ada riwayat
                        </div>

                        @endforelse
                    </div>
                </div>
            </div>
        </div>

    <script>
    function updateSummary() {
        let plus = 0;
        let minus = 0;
        let total = 0;

        document.querySelectorAll('tbody tr').forEach(row => {
            const systemStock = row.querySelector('.system-stock');
            const physicalStock = row.querySelector('.physical-stock');
            const difference = row.querySelector('.difference');
            const reasonSelect = row.querySelector('.reason-select');

            if (systemStock && physicalStock && difference) {
                const system = parseInt(systemStock.innerText) || 0;
                const physical = parseInt(physicalStock.value) || 0;
                const diff = physical - system;

                difference.innerText = diff;
                total += diff;

                // Update warna selisih dan tampilkan dropdown reason jika ada selisih
                if (diff > 0) {
                    plus++;
                    difference.className = 'px-6 py-3 difference font-semibold text-green-600';
                    if (reasonSelect) {
                        reasonSelect.classList.remove('hidden'); // Tampilkan dropdown
                    }
                }
                else if (diff < 0) {
                    minus++;
                    difference.className = 'px-6 py-3 difference font-semibold text-red-600';
                    if (reasonSelect) {
                        reasonSelect.classList.remove('hidden'); // Tampilkan dropdown
                    }
                }
                else {
                    difference.className = 'px-6 py-3 difference font-semibold text-gray-700';
                    if (reasonSelect) {
                        reasonSelect.classList.add('hidden'); // Sembunyikan dropdown
                        reasonSelect.value = ''; // Reset pilihan
                    }
                }
            }
        });

        document.getElementById('selisihPlus').innerText = plus + ' produk';
        document.getElementById('selisihMinus').innerText = minus + ' produk';
        document.getElementById('totalSelisih').innerText = total + ' pcs';
    }

    document.querySelectorAll('.physical-stock').forEach(input => {
        input.addEventListener('input', updateSummary);
    });

    updateSummary();
</script>
    </x-app-layout>