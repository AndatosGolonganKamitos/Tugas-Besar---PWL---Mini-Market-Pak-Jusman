<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Kategori</h2>
            <a href="{{ route('master.categories.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                Tambah Kategori
            </a>
        </div>
    </x-slot>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-4 border-b border-gray-100">
            <div class="flex gap-3">
                <div class="relative flex-1 max-w-sm">
                    <input
                        type="text"
                        id="searchInput"
                        placeholder="Cari kategori..."
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm">
                </div>
            </div>

            <table class="w-full">
            <thead>
                <tr class="bg-gray-50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                    <th class="px-6 py-3">Kode</th>
                    <th class="px-6 py-3">Nama Kategori</th>
                    <th class="px-6 py-3">Deskripsi</th>
                    <th class="px-6 py-3">Total Stok</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody id="categoryTable" class="divide-y divide-gray-100">

                @forelse($categories as $category)

                <tr>

                    <td class="px-6 py-4">
                        {{ $category->code }}
                    </td>

                    <td class="px-6 py-4">
                        {{ $category->name }}
                    </td>

                    <td class="px-6 py-4">
                        {{ $category->description }}
                    </td>

                    <td class="px-6 py-4">
                        {{
                            $category->products->sum(function ($product) {
                                return $product->stocks->sum('stock');
                            })
                        }}
                    </td>

                    <td class="px-6 py-4">

                        @if($category->is_active)

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

                            <a href="{{ route('master.categories.edit', $category) }}"
                            class="px-3 py-1 bg-yellow-500 text-white text-sm rounded hover:bg-yellow-600">
                                Edit
                            </a>

                            <form action="{{ route('master.categories.destroy', $category) }}"
                                method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="px-3 py-1 bg-red-500 text-white text-sm rounded hover:bg-red-600">

                                    Hapus

                                </button>

                            </form>

                        </div>

                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-400">

                        <svg class="w-12 h-12 mx-auto mb-3"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.5"
                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>

                        </svg>

                        <p>Belum ada kategori</p>

                    </td>
                </tr>

                @endforelse

            </tbody>

        <div class="px-6 py-3 border-t border-gray-100 text-sm text-gray-500">
             Total: {{ count($categories) }} kategori
        </div>
    </div>
</x-app-layout>
<script>

const searchInput = document.getElementById('searchInput');

searchInput.addEventListener('input', function() {

    const keyword = this.value.toLowerCase();

    const rows = document.querySelectorAll('#categoryTable tr');

    rows.forEach(row => {

        const text = row.innerText.toLowerCase();

        row.style.display =
            text.includes(keyword)
            ? ''
            : 'none';

    });

});

</script>