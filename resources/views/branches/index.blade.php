<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Manajemen Cabang
            </h2>
            @if(auth()->user()->role === 'owner')
                <a href="{{ route('branches.create') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Tambah Cabang
                </a>
            @endif
        </div>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($branches as $branch)
            <div onclick="window.location='{{ route('branches.show', $branch) }}'"
                class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 hover:shadow-md hover:scale-[1.01] transition cursor-pointer">
                
                <div class="flex items-center justify-between mb-4">
                    <div class="w-10 h-10 rounded-lg bg-indigo-100 flex items-center justify-center">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <span class="px-2 py-1 text-xs font-medium rounded-full
                        {{ $branch->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ $branch->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </div>

                <h3 class="font-semibold text-gray-900">
                    {{ $branch->name }}
                </h3>

                <p class="text-sm text-gray-500 mt-1">
                    {{ $branch->address }}
                </p>

                <div class="mt-4 pt-4 border-t border-gray-100 grid grid-cols-3 gap-2 text-center text-xs">
                    <div>
                        <span class="block text-lg font-bold text-gray-900">
                            {{ $branch->users_count ?? $branch->users->count() }}
                        </span>
                        Karyawan
                    </div>
                    <div>
                        <span class="block text-lg font-bold text-gray-900">
                            {{ $branch->transactions_count ?? $branch->transactions->count() }}
                        </span>
                        Transaksi
                    </div>
                    <div>
                        <span class="block text-lg font-bold text-gray-900">
                            Rp {{ number_format($branch->transactions_sum_total ?? $branch->transactions->sum('total')) }}
                        </span>
                        Pendapatan
                    </div>
                </div>

                {{-- Tombol Edit & Hapus - HANYA TAMPIL UNTUK OWNER --}}
                @if(auth()->user()->role === 'owner')
                    <div class="mt-4 flex gap-4 text-sm" onclick="event.stopPropagation()">
                        <a href="{{ route('branches.edit', $branch->id) }}"
                            class="text-indigo-600 hover:text-indigo-800">
                            Edit
                        </a>
                        <form action="{{ route('branches.destroy', $branch->id) }}"
                            method="POST"
                            onsubmit="return confirm('Hapus cabang {{ $branch->name }}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700">
                                Hapus
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        @empty
            <div class="col-span-full text-center py-10 text-gray-400">
                Belum ada cabang
            </div>
        @endforelse

        {{-- Tombol Tambah Cabang Baru - HANYA TAMPIL UNTUK OWNER --}}
        @if(auth()->user()->role === 'owner')
            <a href="{{ route('branches.create') }}"
                class="bg-white rounded-xl shadow-sm border-2 border-dashed border-gray-300 p-5 flex flex-col items-center justify-center text-gray-400 hover:text-indigo-500 hover:border-indigo-400 transition min-h-[200px]">
                <svg class="w-10 h-10 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                <span class="text-sm font-medium">
                    Tambah Cabang Baru
                </span>
            </a>
        @endif
    </div>
</x-app-layout>