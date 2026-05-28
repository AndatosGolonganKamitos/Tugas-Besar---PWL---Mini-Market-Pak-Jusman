<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Supplier</h2>
            <a href="{{ route('master.suppliers.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                Tambah Supplier
            </a>
        </div>
    </x-slot>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-4 border-b border-gray-100">
            <div class="flex gap-3">
                <div class="relative flex-1 max-w-sm">
                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" placeholder="Cari supplier..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
            </div>
        </div>

        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                    <th class="px-6 py-3">Kode</th>
                    <th class="px-6 py-3">Nama Supplier</th>
                    <th class="px-6 py-3">Kontak</th>
                    <th class="px-6 py-3">Telepon</th>
                    <th class="px-6 py-3">Alamat</th>
                    <th class="px-6 py-3">Email</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">

                @forelse($suppliers as $supplier)

                <tr>

                    <td class="px-6 py-4">
                        {{ $supplier->code }}
                    </td>

                    <td class="px-6 py-4">
                        {{ $supplier->name }}
                    </td>

                    <td class="px-6 py-4">
                        {{ $supplier->contact_person ?? '-' }}
                    </td>
                        
                    <td class="px-6 py-4">
                        {{ $supplier->phone }}
                    </td>

                    <td class="px-6 py-4">
                        {{ $supplier->address ?? '-' }}
                    </td>

                    <td class="px-6 py-4">
                        {{ $supplier->email }}
                    </td>

                    <td class="px-6 py-4">
                        @if($supplier->is_active)

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

                            <a href="{{ route('master.suppliers.edit', $supplier) }}"
                                class="px-3 py-1 bg-yellow-500 text-white text-sm rounded hover:bg-yellow-600">

                                Edit

                            </a>

                            <form action="{{ route('master.suppliers.destroy', $supplier) }}"
                                method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus supplier ini?')">

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
                    <td colspan="6" class="px-6 py-12 text-center text-gray-400">

                        <svg class="w-12 h-12 mx-auto mb-3"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.5"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>

                        </svg>

                        <p>Belum ada supplier</p>

                    </td>
                </tr>

                @endforelse

            </tbody>
        </table>

        <div class="px-6 py-3 border-t border-gray-100 text-sm text-gray-500">
            Total: {{ count($suppliers) }} supplier
        </div>
    </div>
</x-app-layout>
