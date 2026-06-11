<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Produk</h2>
            <a href="{{ route('master.products.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                Tambah Produk
            </a>
        </div>
    </x-slot>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-4 border-b border-gray-100">
            <div class="flex gap-3">

                <input
                    type="text"
                    id="searchInput"
                    name="search"
                    placeholder="Cari produk..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg"
                >
                
            </div>
        </div>

        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                    <th class="px-6 py-3">Kode</th>
                    <th class="px-6 py-3">Nama Produk</th>
                    <th class="px-6 py-3">Kategori</th>
                    <th class="px-6 py-3">Harga Beli</th>
                    <th class="px-6 py-3">Harga Jual</th>
                    <th class="px-6 py-3">Stok</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                    @forelse($products as $product)
                    <tr>
                        <td class="px-6 py-4">
                            {{ $product->code }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $product->name }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $product->category->name ?? '-' }}
                        </td>

                        <td class="px-6 py-4">
                            Rp {{ number_format($product->purchase_price, 0, ',', '.') }}
                        </td>

                        <td class="px-6 py-4">
                            Rp {{ number_format($product->selling_price, 0, ',', '.') }}
                        </td>

                        <td class="px-6 py-4">

                       @php
                            $user = auth()->user();
                            if ($user->role == 'owner') {
                                $stock = $product->stocks->sum('stock');
                            } else {
                                $stock = $product->stocks
                                    ->where(
                                        'branch_id',
                                        $user->branch_id
                                    )->sum('stock');
                            }

                    @endphp

                        @if($stock == 0)

                            <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-700 font-semibold">
                                Habis
                            </span>

                        @elseif($stock <= 20)

                            <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700 font-semibold">
                                Menipis ({{ $stock }})
                            </span>

                        @else

                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700 font-semibold">
                                {{ $stock }}
                            </span>

                        @endif
                    </td>
                        <td class="px-6 py-4">
                            @if($product->is_active)
                                <span class="text-green-600 font-semibold">
                                    Aktif
                                </span>
                            @else
                                <span class="text-red-600 font-semibold">
                                    Nonaktif
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('master.products.edit', $product) }}"
                                    class="px-3 py-1 bg-yellow-500 text-white text-sm rounded hover:bg-yellow-600">
                                    Edit
                                </a>
                                <form action="{{ route('master.products.destroy', $product) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-3 py-1 bg-red-500 text-white text-sm rounded hover:bg-red-600">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8"
                            class="px-6 py-12 text-center text-gray-400">
                            Belum ada produk
                        </td>
                    </tr>
                    @endforelse
                </tbody>
        </table>
        <div class="px-6 py-3 border-t border-gray-100 text-sm text-gray-500">
            Total: {{ count($products) }} produk
        </div>
    </div>
</x-app-layout>


<script>
document.getElementById('searchInput').addEventListener('keyup', function () {

    let keyword = this.value.toLowerCase();

    let rows = document.querySelectorAll('tbody tr');

    rows.forEach(function(row) {

        let text = row.innerText.toLowerCase();

        if (text.includes(keyword)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }

    });

});

const categoryFilter = document.getElementById('categoryFilter');

categoryFilter.addEventListener('change', filterProducts);

searchInput.addEventListener('input', filterProducts);

function filterProducts() {

    const keyword = searchInput.value.toLowerCase();
    const category = categoryFilter.value;

    const rows = document.querySelectorAll('#productTable tr');

    rows.forEach(row => {

        const text = row.innerText.toLowerCase();

        const rowCategory =
            row.children[2]?.innerText.trim();

        const matchSearch =
            text.includes(keyword);

        const matchCategory =
            category === '' ||
            rowCategory === category;

        row.style.display =
            matchSearch && matchCategory
            ? ''
            : 'none';

    });
}
</script>

