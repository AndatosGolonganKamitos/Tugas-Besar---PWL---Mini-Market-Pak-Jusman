<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $branch->name ?? 'Cabang Pusat' }}</h2>
                <p class="text-sm text-gray-500 mt-1">{{ $branch->code ?? 'CBG-001' }} &middot; {{ $branch->address ?? 'Jl. Merdeka No. 1, Jakarta' }}</p>
            </div>
            <a href="{{ route('branches.edit', $branch ?? 1) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Edit
            </a>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                <h3 class="font-semibold text-gray-900 mb-4">Ringkasan</h3>
                <div class="grid grid-cols-3 gap-4">
                    <div class="p-3 bg-gray-50 rounded-lg text-center">
                        <p class="text-2xl font-bold text-gray-900">
                            {{ $totalKaryawan }}
                        </p>
                        <p class="text-xs text-gray-500">Karyawan</p>
                    </div>
                    <div class="p-3 bg-gray-50 rounded-lg text-center">
                        <p class="text-2xl font-bold text-gray-900">
                            {{ $transaksiHariIni }}
                        </p>
                        <p class="text-xs text-gray-500">Transaksi Hari Ini</p>
                    </div>
                    <div class="p-3 bg-gray-50 rounded-lg text-center">
                        <p class="text-2xl font-bold text-gray-900">
                            Rp {{ number_format($pendapatanHariIni) }}
                        </p>
                        <p class="text-xs text-gray-500">Pendapatan Hari Ini</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                <h3 class="font-semibold text-gray-900 mb-4">Transaksi Terbaru</h3>
                @forelse($branch->transactions->take(5) as $transaction)

                    <div class="flex justify-between py-3 border-b">

                        <div>
                            <p class="font-medium">
                                {{ $transaction->invoice_number }}
                            </p>

                            <p class="text-xs text-gray-500">
                                {{ $transaction->created_at->format('d M Y H:i') }}
                            </p>
                        </div>

                        <div class="text-right">

                            <p class="font-semibold">
                                Rp {{ number_format($transaction->total,0,',','.') }}
                            </p>

                            <p class="text-xs text-gray-500">
                                {{ $transaction->user->name ?? '-' }}
                            </p>

                        </div>

                    </div>

                    @empty

                    <p class="text-center text-gray-400">
                        Belum ada transaksi
                    </p>

                    @endforelse
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                <h3 class="font-semibold text-gray-900 mb-4">Informasi</h3>
                <dl class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Manajer</dt>
                        <dd class="font-medium text-gray-900">{{ $manager->name  ?? '—' }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Telepon</dt>
                        <dd class="font-medium text-gray-900">{{ $manager->phone ?? '—' }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Email</dt>
                        <dd class="font-medium text-gray-900">{{ $manager->email ?? '—' }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Status</dt>
                        <dd><span class="px-2 py-0.5 text-xs font-medium bg-green-100 text-green-700 rounded-full">Aktif</span></dd>
                    </div>
                </dl>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                <h3 class="font-semibold text-gray-900 mb-4">Karyawan</h3>
                @forelse($branch->users as $user)

                    <div class="flex justify-between py-2 border-b">
                        <div>
                            <p class="font-medium">
                                {{ $user->name }}
                            </p>

                            <p class="text-xs text-gray-500">
                                {{ ucfirst($user->role) }}
                            </p>
                        </div>

                        <span class="text-sm text-gray-500">
                            {{ $user->email }}
                        </span>
                    </div>

                    @empty

                    <p class="text-center text-gray-400">
                        Belum ada karyawan
                    </p>

                    @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
