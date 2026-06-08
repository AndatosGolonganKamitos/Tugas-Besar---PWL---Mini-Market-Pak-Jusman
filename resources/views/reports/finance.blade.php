<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Laporan Keuangan
        </h2>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

        <div class="bg-white p-6 rounded-xl border">
            <p class="text-sm text-gray-500">
                Total Pendapatan
            </p>

            <p class="text-2xl font-bold text-green-600">
                Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
            </p>
        </div>

        <div class="bg-white p-6 rounded-xl border">
            <p class="text-sm text-gray-500">
                Jumlah Transaksi
            </p>

            <p class="text-2xl font-bold">
                {{ $jumlahTransaksi }}
            </p>
        </div>

        <div class="bg-white p-6 rounded-xl border">
            <p class="text-sm text-gray-500">
                Rata-rata Transaksi
            </p>

            <p class="text-2xl font-bold">
                Rp {{ number_format($rataRata, 0, ',', '.') }}
            </p>
        </div>

        <div class="bg-white p-6 rounded-xl border">
            <p class="text-sm text-gray-500">
                Estimasi Laba
            </p>

            <p class="text-2xl font-bold text-indigo-600">
                Rp {{ number_format($estimasiLaba, 0, ',', '.') }}
            </p>
        </div>

    </div>

</x-app-layout>
