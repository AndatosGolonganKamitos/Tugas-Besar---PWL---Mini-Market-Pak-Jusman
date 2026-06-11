<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Inventaris</h2>
            <div class="flex gap-2">
                <a href="{{ route('inventory.stock-opname') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-amber-600 text-white text-sm font-medium rounded-lg hover:bg-amber-700 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                    Stok Opname
                </a>
            </div>
        </div>
    </x-slot>
    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <p class="text-sm text-gray-500">Total Stok</p>
            <p class="text-2xl font-bold text-gray-900">{{ $totalStok ?? 0 }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <p class="text-sm text-gray-500">Stok Menipis</p>
            <p class="text-2xl font-bold text-amber-600">{{ $stokMenipis ?? 0 }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <p class="text-sm text-gray-500">Stok Habis</p>
            <p class="text-2xl font-bold text-red-600">{{ $stokHabis ?? 0 }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <p class="text-sm text-gray-500">Nilai Inventaris</p>
            <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($nilaiInventaris ?? 0, 0, ',', '.') }}</p>
        </div>
    </div>

    {{-- TODO Backend: Loop $inventoryItems — @forelse($inventoryItems as $item) --}}
    {{-- Inventory Table --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-4 border-b border-gray-100">
            <div class="flex flex-wrap gap-3">
                <div class="relative flex-1 max-w-sm">
                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" placeholder="Cari produk..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <select class="border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Semua Kategori</option>
                </select>
                <select class="border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Semua Cabang</option>
                </select>
            </div>
        </div>

        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                    <th class="px-6 py-3">Kode</th>
                    <th class="px-6 py-3">Nama Produk</th>
                    <th class="px-6 py-3">Kategori</th>
                    <th class="px-6 py-3">Cabang</th>
                    <th class="px-6 py-3">Stok</th>
                    <th class="px-6 py-3">Stok Minimal</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">

                @forelse($stocks as $stock)

                <tr>

                    <td class="px-6 py-4">
                        {{ $stock->product->code }}
                    </td>

                    <td class="px-6 py-4">
                        {{ $stock->product->name }}
                    </td>

                    <td class="px-6 py-4">
                        {{ $stock->product->category->name ?? '-' }}
                    </td>

                    <td class="px-6 py-4">
                        {{ $stock->branch->name ?? '-' }}
                    </td>

                    <td class="px-6 py-4">
                        {{ $stock->stock }}
                    </td>

                    <td class="px-6 py-4">
                        {{ $stock->product->min_stock }}
                    </td>

                    <td class="px-6 py-4">

                        @if($stock->stock == 0)

                        <span class="text-red-600 font-semibold">
                            Habis
                        </span>

                    @elseif($stock->stock <= $stock->product->min_stock)

                        <span class="text-amber-600 font-semibold">
                            Menipis
                        </span>

                    @else

                        <span class="text-green-600 font-semibold">
                            Aman
                        </span>

                    @endif

                    </td>

                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('inventory.stock-opname') }}"
                            class="px-3 py-1 bg-indigo-600 text-white text-sm rounded hover:bg-indigo-700">
                            Update Stok
                        </a>
                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="8"
                        class="px-6 py-12 text-center text-gray-400">

                        Belum ada data inventaris

                    </td>

                </tr>

                @endforelse

            </tbody>

        <div class="px-6 py-3 border-t border-gray-100 text-sm text-gray-500">
            Total: {{ count($stocks) }} produk
        </div>
    </div>
</x-app-layout>
