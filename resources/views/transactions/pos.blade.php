<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">POS / Penjualan</h2>
    </x-slot>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        {{-- Products Panel --}}
        <div class="xl:col-span-2 space-y-4">
            {{-- Search & Category Filter --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                <div class="flex gap-3">
                    <div class="relative flex-1">
                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input type="text" x-data x-ref="searchInput"
                               x-on:input.debounce="console.log($event.target.value)"
                               placeholder="Cari produk (nama / barcode)..." autofocus
                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>
                <div class="flex gap-2 mt-3 overflow-x-auto pb-1">
                    <button class="px-3 py-1.5 text-xs font-medium rounded-full bg-indigo-100 text-indigo-700 whitespace-nowrap">Semua</button>
                    <button class="px-3 py-1.5 text-xs font-medium rounded-full bg-gray-100 text-gray-600 hover:bg-gray-200 whitespace-nowrap">Makanan</button>
                    <button class="px-3 py-1.5 text-xs font-medium rounded-full bg-gray-100 text-gray-600 hover:bg-gray-200 whitespace-nowrap">Minuman</button>
                    <button class="px-3 py-1.5 text-xs font-medium rounded-full bg-gray-100 text-gray-600 hover:bg-gray-200 whitespace-nowrap">Rokok</button>
                    <button class="px-3 py-1.5 text-xs font-medium rounded-full bg-gray-100 text-gray-600 hover:bg-gray-200 whitespace-nowrap">Sembako</button>
                    <button class="px-3 py-1.5 text-xs font-medium rounded-full bg-gray-100 text-gray-600 hover:bg-gray-200 whitespace-nowrap">Alat Tulis</button>
                </div>
            </div>

            {{-- TODO Backend: Ganti dengan loop data produk $products — @foreach($products as $product) --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">

    @forelse($products as $product)

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-3 hover:border-indigo-300 hover:shadow cursor-pointer transition">

        <div class="aspect-square bg-gray-100 rounded-lg mb-2 flex items-center justify-center text-gray-400">

            <svg class="w-8 h-8"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24">

                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="1.5"
                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>

            </svg>

        </div>

        <p class="text-sm font-medium text-gray-900 truncate">
            {{ $product->name }}
        </p>

        <p class="text-xs text-gray-400">
            Stok: {{ $product->stock }}
        </p>

        <p class="text-sm font-bold text-indigo-600 mt-1">
            Rp {{ number_format($product->selling_price, 0, ',', '.') }}
        </p>

    </div>

    @empty

    <div class="col-span-full text-center py-10 text-gray-400">

        Tidak ada produk

    </div>

    @endforelse

</div>
        {{-- Cart Panel --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 flex flex-col" style="max-height: calc(100vh - 12rem);">
            <div class="p-4 border-b border-gray-100">
                <h3 class="font-semibold text-gray-900">Keranjang</h3>
            </div>

            {{-- TODO Backend: Loop item keranjang dari session/state, ganti "Keranjang kosong" jika ada item --}}
            <div class="flex-1 overflow-y-auto p-4 space-y-3">
                <div class="text-center py-8 text-gray-400">
                    <svg class="w-12 h-12 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                    <p>Keranjang kosong</p>
                    <p class="text-xs mt-1">Pilih produk untuk memulai transaksi</p>
                </div>
            </div>

            {{-- TODO Backend: Hitung subtotal, diskon, total dari item keranjang --}}
            <div class="border-t border-gray-100 p-4 space-y-3">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Subtotal</span>
                    <span class="font-medium text-gray-900">Rp 0</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Diskon</span>
                    <span class="font-medium text-green-600">Rp 0</span>
                </div>
                <div class="flex justify-between text-lg font-bold border-t border-gray-100 pt-3">
                    <span>Total</span>
                    <span class="text-indigo-600">Rp 0</span>
                </div>

                {{-- TODO Backend: Enable tombol saat keranjang tidak kosong, tambah @click untuk submit --}}
                <div class="grid grid-cols-2 gap-2 pt-2">
                    <button class="px-4 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition disabled:opacity-50" disabled>
                        Batal
                    </button>
                    <button class="px-4 py-2.5 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition disabled:opacity-50" disabled>
                        Bayar
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
