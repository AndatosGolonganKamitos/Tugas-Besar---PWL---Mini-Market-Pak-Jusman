<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">POS / Penjualan</h2>
    </x-slot>
<div
    x-data="{
        cart: [],
        search: '',
        selectedCategory: 'Semua',


        addToCart(product) {

            let existing = this.cart.find(
                item => item.id === product.id
            );

            if(existing) {

                existing.qty++;

            } else {

                this.cart.push({
                    ...product,
                    qty: 1
                });

            }
        },

        removeCart(id) {

            this.cart = this.cart.filter(
                item => item.id !== id
            );

        },

        increaseQty(id) {

            let item = this.cart.find(
                i => i.id === id
            );

            if(item) {
                item.qty++;
            }
        },

        decreaseQty(id) {

            let item = this.cart.find(
                i => i.id === id
            );

            if(item && item.qty > 1) {
                item.qty--;
            }
        },

        get subtotal() {

            return this.cart.reduce((total, item) => {

                return total + (
                    item.price * item.qty
                );

            }, 0);
        }
    }"

    class="grid grid-cols-1 xl:grid-cols-3 gap-6"
        {{-- Products Panel --}}
        <div class="xl:col-span-2 space-y-4">
            {{-- Search & Category Filter --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                <div class="flex gap-3">
                    <div class="relative flex-1">
                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input   type="text"
                                id="searchProduct"
                                x-model="search"
                                x-on:input.debounce="console.log($event.target.value)"
                                placeholder="Cari produk..."
                                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                </div>
                <div class="flex gap-2 mt-3 overflow-x-auto pb-1">
                    <button
                        @click="selectedCategory = 'Semua'"
                        class="px-3 py-1.5 text-xs font-medium rounded-full bg-indigo-100 text-indigo-700 whitespace-nowrap">
                        Semua
                    </button>
                    <button
                        @click="selectedCategory = 'Makanan'"
                        class="px-3 py-1.5 text-xs font-medium rounded-full bg-gray-100 text-gray-600 hover:bg-gray-200 whitespace-nowrap">

                        Makanan

                    </button>

                    <button
                        @click="selectedCategory = 'Minuman'"
                        class="px-3 py-1.5 text-xs font-medium rounded-full bg-gray-100 text-gray-600 hover:bg-gray-200 whitespace-nowrap">

                        Minuman

                    </button>

                    <button
                        @click="selectedCategory = 'Rokok'"
                        class="px-3 py-1.5 text-xs font-medium rounded-full bg-gray-100 text-gray-600 hover:bg-gray-200 whitespace-nowrap">
                        Rokok
                    </button>
                    <button
                        @click="selectedCategory = 'Sembako'"
                        class="px-3 py-1.5 text-xs font-medium rounded-full bg-gray-100 text-gray-600 hover:bg-gray-200 whitespace-nowrap">
                        Sembako
                    </button>
                    <button
                        @click="selectedCategory = 'Alat Tulis'"
                        class="px-3 py-1.5 text-xs font-medium rounded-full bg-gray-100 text-gray-600 hover:bg-gray-200 whitespace-nowrap">
                        Alat Tulis
                    </button>
                </div>
            </div>

            {{-- TODO Backend: Ganti dengan loop data produk $products — @foreach($products as $product) --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">
@forelse($products as $product)
                @php

                if(auth()->user()->role === 'owner') {

                    $stockCabang = $product->stocks->sum('stock');

                } else {

                    $stockCabang = optional(
                        $product->stocks
                            ->where('branch_id', auth()->user()->branch_id)
                            ->first()
                    )->stock ?? 0;

                }

                @endphp

<div
x-show="
'{{ strtolower($product->name) }}'
.includes(search.toLowerCase())

&&

(
    selectedCategory === 'Semua'

    ||

    selectedCategory === '{{ $product->category->name ?? '' }}'
)
"

>

    <div
        @click='

        let cartItem = cart.find(i => i.id === {{ $product->id }});

        let qtyInCart = cartItem ? cartItem.qty : 0;

        if (qtyInCart < {{ $stockCabang }}) {

            addToCart({
                id: {{ $product->id }},
                name: "{{ $product->name }}",
                price: {{ $product->selling_price }}
            });

        }

        '



        class="bg-white rounded-xl shadow-sm border border-gray-200 p-3 transition

        {{ $stockCabang  <= 0
            ? 'opacity-50 cursor-not-allowed'
            : 'hover:border-indigo-300 hover:shadow cursor-pointer' }}"

    >

        <div class="aspect-square bg-gray-100 rounded-lg mb-2 overflow-hidden">

            @if($product->image)

                <img
                    src="{{ asset('storage/' . $product->image) }}"
                    class="w-full h-full object-cover"
                >

            @else

                <div class="w-full h-full flex items-center justify-center text-gray-400">

                    <svg class="w-8 h-8"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.5"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>

                    </svg>

                </div>

            @endif

        </div>

        <p class="text-sm font-medium text-gray-900 truncate">
            {{ $product->name }}
        </p>

        <p class="text-xs mt-1
            {{ $stockCabang < 5
                ? 'text-red-500 font-semibold'
                : 'text-gray-400' }}">

            Stok: {{ $stockCabang }}

            @if($stockCabang < 5)

                ⚠ Hampir habis

            @endif

        </p>


        <p class="text-sm font-bold text-indigo-600 mt-1">
            Rp {{ number_format($product->selling_price, 0, ',', '.') }}
        </p>

    </div>

</div>

@empty

<div class="col-span-full text-center py-10 text-gray-400">
    Tidak ada produk
</div>
@endforelse
            </div>
        {{-- Cart Panel --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 flex flex-col" style="max-height: calc(100vh - 12rem);">
            <div class="p-4 border-b border-gray-100">
                <h3 class="font-semibold text-gray-900">Keranjang</h3>
            </div>

            {{-- TODO Backend: Loop item keranjang dari session/state, ganti "Keranjang kosong" jika ada item --}}
            <div class="flex-1 overflow-y-auto p-4 space-y-3">
                <template x-if="cart.length === 0">

                    <div class="text-center py-8 text-gray-400">

                        <svg class="w-12 h-12 mx-auto mb-3"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.5"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/>

                        </svg>
                        <p>Keranjang kosong</p>
                        <p class="text-xs mt-1">
                            Pilih produk untuk memulai transaksi
                        </p>
                    </div>

                </template>
                <template x-for="item in cart" :key="item.id">

                    <div class="border rounded-lg p-3">

                        <div class="flex justify-between items-start gap-2">
                            <div>
                                <p class="font-medium text-sm"
                                    x-text="item.name"></p>
                                <p class="text-xs text-gray-400 mt-1">
                                    Qty:
                                    <div class="flex items-center gap-2 mt-1">
                                    <button
                                        @click.stop="decreaseQty(item.id)"
                                        class="px-2 py-0.5 bg-gray-200 rounded text-xs"
                                    >
                                        -
                                    </button>

                                    <span class="text-xs text-gray-500"
                                        x-text="item.qty">
                                    </span>

                                    <button
                                        @click.stop="increaseQty(item.id)"
                                        class="px-2 py-0.5 bg-indigo-500 text-white rounded text-xs"
                                    >
                                        +
                                    </button>
                                </div>
                                </p>
                            </div>
                            <div class="text-right">

                                <p class="font-semibold text-indigo-600">

                                    Rp
                                    <span x-text="(item.price * item.qty).toLocaleString('id-ID')"></span>

                                </p>

                                <button
                                    @click.stop="removeCart(item.id)"

                                    class="text-xs text-red-500 hover:text-red-700 mt-1"
                                >
                                    Hapus
                                </button>

                            </div>

                        </div>

                    </div>

                </template>
            </div>

            {{-- TODO Backend: Hitung subtotal, diskon, total dari item keranjang --}}
            <div class="border-t border-gray-100 p-4 space-y-3">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Subtotal</span>

                    <span>

                        Rp
                        <span x-text="subtotal.toLocaleString('id-ID')"></span>

                    </span>

                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Diskon</span>
                    Rp 0
                </div>
                <div class="flex justify-between text-lg font-bold border-t border-gray-100 pt-3">

                    <span>Total</span>

                    <span>

                        Rp
                        <span x-text="subtotal.toLocaleString('id-ID')"></span>

                    </span>

                </div>

                {{-- TODO Backend: Enable tombol saat keranjang tidak kosong, tambah @click untuk submit --}}
                <div class="grid grid-cols-2 gap-2 pt-2">
                  <button
                        @click="cart = []"

                        :disabled="cart.length === 0"

                        class="px-4 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition disabled:opacity-50"
                    >
                        Batal
                    </button>
                    <button
                        :disabled="cart.length === 0"

                                                @click="

                        fetch('{{ route('transactions.checkout') }}', {

                            method: 'POST',

                            headers: {

                                'Content-Type': 'application/json',

                                'X-CSRF-TOKEN': '{{ csrf_token() }}'

                            },

                            body: JSON.stringify({

                                cart: cart

                            })

                        })

                        .then(res => res.json())

                        .then(data => {

                            if(data.success) {

                                alert('Pembayaran berhasil 😄');

                                location.reload();

                            }

                        })
                        "

                        class="px-4 py-2.5 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition disabled:opacity-50"
                    >
                        Bayar
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
