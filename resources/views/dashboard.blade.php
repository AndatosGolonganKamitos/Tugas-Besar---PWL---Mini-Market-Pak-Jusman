<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    {{-- TODO Backend: Ganti angka placeholder (Rp 0, 0) dengan data real dari controller --}}
    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-lg bg-emerald-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Penjualan Hari Ini</p>
                    <p class="text-2xl font-bold text-gray-900">Rp {{ $penjualanHariIni ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Transaksi</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalTransaksi ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-lg bg-amber-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Cabang</p>

                    <p class="text-2xl font-bold text-gray-900">
                        {{ $totalCabang ?? 0 }}
                    </p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-lg bg-rose-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Pengguna</p>

                    <p class="text-2xl font-bold text-gray-900">
                        {{ $totalUser ?? 0 }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- TODO Backend: Looping data transaksi terbaru dari $transaksiTerbaru --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Recent Transactions --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="px-5 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-gray-900">Transaksi Terbaru</h3>
            </div>
            <div class="p-5">
                @forelse($transaksiTerbaru ?? [] as $transaksi)
                {{-- TODO Backend: Tampilkan data transaksi: no invoice, total, status, waktu --}}
                <div class="flex items-center justify-between py-2 border-b border-gray-50 last:border-0">
                    <div>
                        <p class="text-sm font-medium text-gray-900">{{ $transaksi->invoice_number ?? '-' }}</p>
                        <p class="text-xs text-gray-400">{{ $transaksi->created_at ?? '' }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-semibold text-gray-900">Rp {{ number_format($transaksi->total ?? 0, 0, ',', '.') }}</p>
                    </div>
                </div>
                @empty
                <div class="text-center py-8 text-gray-400">
                    <svg class="w-12 h-12 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                    <p>Belum ada transaksi</p>
                </div>
                @endforelse
            </div>
        </div>

        {{-- TODO Backend: Looping data stok menipis dari $stokMenipis --}}
        {{-- Stock Alerts --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="px-5 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-gray-900">Peringatan Stok</h3>
            </div>
            <div class="p-5">
                @forelse($stokMenipis ?? [] as $item)
                {{-- TODO Backend: Tampilkan produk yg stoknya di bawah minimal --}}
                <div class="flex items-center justify-between py-2 border-b border-gray-50 last:border-0">
                    <div>
                        <p class="text-sm font-medium text-gray-900">{{ $item->product_name ?? '-' }}</p>
                        <p class="text-xs text-gray-400">Stok: {{ $item->stock ?? 0 }} (Min: {{ $item->min_stock ?? 0 }})</p>
                    </div>
                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-700">{{ $item->stock ?? 0 }} tersisa</span>
                </div>
                @empty
                <div class="text-center py-8 text-gray-400">
                    <svg class="w-12 h-12 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                    <p>Semua stok aman</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="mt-6 bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-5 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-900">Aksi Cepat</h3>
        </div>
        <div class="p-5 grid grid-cols-2 sm:grid-cols-4 gap-4">
            @if(auth()->user()->isOwner() || auth()->user()->isManager() || auth()->user()->isCashier())
            <a href="{{ route('transactions.pos') }}" class="flex flex-col items-center gap-2 p-4 rounded-lg bg-indigo-50 hover:bg-indigo-100 transition text-indigo-700">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                <span class="text-sm font-medium">Transaksi Baru</span>
            </a>
            @endif
            @if(auth()->user()->isOwner() || auth()->user()->isManager() || auth()->user()->isSupervisor())
            <a href="{{ route('master.products.create') }}" class="flex flex-col items-center gap-2 p-4 rounded-lg bg-emerald-50 hover:bg-emerald-100 transition text-emerald-700">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                <span class="text-sm font-medium">Tambah Produk</span>
            </a>
            @endif
            @if(auth()->user()->isOwner() || auth()->user()->isManager() || auth()->user()->isWarehouse())
            <a href="{{ route('inventory.stock-opname') }}" class="flex flex-col items-center gap-2 p-4 rounded-lg bg-amber-50 hover:bg-amber-100 transition text-amber-700">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                <span class="text-sm font-medium">Stok Opname</span>
            </a>
            @endif
            @if(auth()->user()->isOwner() || auth()->user()->isManager() || auth()->user()->isSupervisor())
            <a href="{{ route('reports.index') }}" class="flex flex-col items-center gap-2 p-4 rounded-lg bg-rose-50 hover:bg-rose-100 transition text-rose-700">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                <span class="text-sm font-medium">Lihat Laporan</span>
            </a>
            @endif
        </div>
    </div>
</x-app-layout>
