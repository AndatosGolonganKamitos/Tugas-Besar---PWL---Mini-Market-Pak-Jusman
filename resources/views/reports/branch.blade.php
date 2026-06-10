<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            Laporan Per Cabang
        </h2>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        @foreach($branches as $branch)

            <div class="bg-white p-6 rounded-xl border">

                <p class="text-sm text-gray-500">
                    {{ $branch->name }}
                </p>

                <p class="text-2xl font-bold mt-2">
                    Rp {{ number_format($branch->transactions->sum('total'), 0, ',', '.') }}
                </p>

                <div class="mt-4 text-sm text-gray-500">

                    <p>
                        Karyawan:
                        {{ $branch->users->count() }}
                    </p>

                    <p>
                        Transaksi:
                        {{ $branch->transactions->count() }}
                    </p>

                </div>

            </div>

        @endforeach

    </div>

</x-app-layout>