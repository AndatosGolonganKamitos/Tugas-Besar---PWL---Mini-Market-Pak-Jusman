```blade id="branch1"
<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            Laporan Per Cabang
        </h2>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <div class="bg-white p-6 rounded-xl border">
            <p class="text-sm text-gray-500">
                Cabang Utama
            </p>

            <p class="text-2xl font-bold mt-2">
                Rp 12.500.000
            </p>
        </div>

        <div class="bg-white p-6 rounded-xl border">
            <p class="text-sm text-gray-500">
                Cabang Banjar
            </p>

            <p class="text-2xl font-bold mt-2">
                Rp 8.200.000
            </p>
        </div>

        <div class="bg-white p-6 rounded-xl border">
            <p class="text-sm text-gray-500">
                Cabang Ciamis
            </p>

            <p class="text-2xl font-bold mt-2">
                Rp 6.700.000
            </p>
        </div>

    </div>

</x-app-layout>
```
