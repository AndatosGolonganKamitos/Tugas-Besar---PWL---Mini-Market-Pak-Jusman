<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between">

            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Laporan Stok Per Cabang
            </h2>

            <button
                onclick="window.print()"
                class="px-4 py-2 bg-indigo-600 text-white rounded-lg">

                Print

            </button>

        </div>
    </x-slot>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">

        <div class="px-6 py-4 border-b">

            <h3 class="font-semibold text-lg">
                Stok Produk Per Cabang
            </h3>

        </div>

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead>

                    <tr class="bg-gray-50">

                        <th class="px-6 py-3 text-left">
                            Produk
                        </th>

                        <th class="px-6 py-3 text-left">
                            Kategori
                        </th>

                        @foreach($branches as $branch)

                            <th class="px-6 py-3 text-center">
                                {{ $branch->name }}
                            </th>

                        @endforeach

                        <th class="px-6 py-3 text-center">
                            Total
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-gray-100">

                    @forelse($products as $product)

                        <tr>

                            <td class="px-6 py-4 font-medium">
                                {{ $product->name }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $product->category->name ?? '-' }}
                            </td>

                            @php
                                $totalStock = 0;
                            @endphp

                            @foreach($branches as $branch)

                                @php

                                    $stock = optional(
                                        $product->stocks
                                            ->where('branch_id', $branch->id)
                                            ->first()
                                    )->stock ?? 0;

                                    $totalStock += $stock;

                                @endphp

                                <td class="px-6 py-4 text-center">

                                    @if($stock == 0)

                                        <span class="text-red-600 font-semibold">
                                            0
                                        </span>

                                    @elseif($stock <= 20)

                                        <span class="text-yellow-600 font-semibold">
                                            {{ $stock }}
                                        </span>

                                    @else

                                        <span class="text-green-600 font-semibold">
                                            {{ $stock }}
                                        </span>

                                    @endif

                                </td>

                            @endforeach

                            <td class="px-6 py-4 text-center font-bold">

                                {{ $totalStock }}

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="{{ $branches->count() + 3 }}"
                                class="px-6 py-8 text-center text-gray-400">

                                Belum ada data stok

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</x-app-layout>