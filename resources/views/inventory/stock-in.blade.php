<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Barang Masuk
        </h2>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- FORM --}}
        <div class="bg-white rounded-xl shadow-sm border p-6">

            <h3 class="font-semibold text-lg mb-4">
                Tambah Barang Masuk
            </h3>

            @if(session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <form
                method="POST"
                action="{{ route('inventory.stock-in.store') }}"
                class="space-y-4">

                @csrf

                <div>
                    <label class="block text-sm mb-1">
                        Produk
                    </label>

                    <select
                        name="product_id"
                        class="w-full border rounded-lg px-3 py-2"
                        required>

                        <option value="">
                            Pilih Produk
                        </option>

                        @foreach($products as $product)

                            <option value="{{ $product->id }}">
                                {{ $product->name }}
                            </option>

                        @endforeach

                    </select>
                </div>

                <div>
                    <label class="block text-sm mb-1">
                        Supplier
                    </label>

                    <select
                        name="supplier_id"
                        class="w-full border rounded-lg px-3 py-2"
                        required>

                        <option value="">
                            Pilih Supplier
                        </option>

                        @foreach($suppliers as $supplier)

                            <option value="{{ $supplier->id }}">
                                {{ $supplier->name }}
                            </option>

                        @endforeach

                    </select>
                </div>

                @if(auth()->user()->role == 'owner')

                <div>
                    <label class="block text-sm mb-1">
                        Cabang
                    </label>

                    <select
                        name="branch_id"
                        class="w-full border rounded-lg px-3 py-2"
                        required>

                        <option value="">
                            Pilih Cabang
                        </option>

                        @foreach($branches as $branch)

                            <option value="{{ $branch->id }}">
                                {{ $branch->name }}
                            </option>

                        @endforeach

                    </select>
                </div>

                @else

                <div>
                    <label class="block text-sm mb-1">
                        Cabang
                    </label>

                    <input
                        type="text"
                        value="{{ auth()->user()->branch->name }}"
                        readonly
                        class="w-full border rounded-lg px-3 py-2 bg-gray-100">
                </div>

                @endif

                <div>
                    <label class="block text-sm mb-1">
                        Jumlah
                    </label>

                    <input
                        type="number"
                        name="qty"
                        min="1"
                        required
                        class="w-full border rounded-lg px-3 py-2">
                </div>

                <div>
                    <label class="block text-sm mb-1">
                        Keterangan
                    </label>

                    <textarea
                        name="note"
                        rows="3"
                        class="w-full border rounded-lg px-3 py-2"></textarea>
                </div>

                <button
                    type="submit"
                    class="w-full bg-indigo-600 text-white py-2 rounded-lg">

                    Simpan Barang Masuk

                </button>

            </form>

        </div>

        {{-- HISTORY --}}
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border overflow-hidden">

            <div class="p-4 border-b">
                <h3 class="font-semibold">
                    Riwayat Barang Masuk
                </h3>
            </div>

            <table class="w-full">

                <thead>

                    <tr class="bg-gray-50">

                        <th class="px-4 py-3 text-left">
                            Tanggal
                        </th>

                        <th class="px-4 py-3 text-left">
                            Produk
                        </th>

                        <th class="px-4 py-3 text-left">
                            Cabang
                        </th>

                        <th class="px-4 py-3 text-left">
                            Supplier
                        </th>

                        <th class="px-4 py-3 text-left">
                            Qty
                        </th>

                        <th class="px-4 py-3 text-left">
                            Petugas
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($history as $item)

                    <tr class="border-t">

                        <td class="px-4 py-3">
                            {{ $item->created_at->format('d/m/Y H:i') }}
                        </td>

                        <td class="px-4 py-3">
                            {{ $item->product->name }}
                        </td>

                        <td class="px-4 py-3">
                            {{ $item->branch->name }}
                        </td>

                        <td class="px-4 py-3">
                            {{ $item->supplier->name }}
                        </td>
                        <td class="px-4 py-3 font-semibold text-green-600">
                            +{{ $item->qty }}
                        </td>

                        <td class="px-4 py-3">
                            {{ $item->user->name }}
                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td
                            colspan="5"
                            class="text-center py-10 text-gray-400">

                            Belum ada data

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</x-app-layout>