<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($product) ? 'Edit Produk' : 'Tambah Produk' }}
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <form action="{{ isset($product)
                ? route('master.products.update', $product)
                : route('master.products.store') }}"
                method="POST">

                @csrf

                @if(isset($product))
                    @method('PUT')
                @endif
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="code" value="Kode Produk" />
                        <x-text-input id="code" name="code" type="text" class="mt-1 block w-full" :value="old('code', $product->code ?? '')" required placeholder="BRG-001" />
                        <x-input-error :messages="$errors->get('code')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="barcode" value="Barcode" />
                        <x-text-input id="barcode" name="barcode" type="text" class="mt-1 block w-full" :value="old('barcode', $product->barcode ?? '')" placeholder="8991234567890" />
                        <x-input-error :messages="$errors->get('barcode')" class="mt-2" />
                    </div>

                    <div class="md:col-span-2">
                        <x-input-label for="name" value="Nama Produk" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $product->name ?? '')" required placeholder="Chitato Sapi Panggang 68g" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="category_id" value="Kategori" />
                        <select id="category_id" name="category_id" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="supplier_id" value="Supplier" />
                        <select id="supplier_id" name="supplier_id" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Pilih Supplier</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}"
                                    {{ old('supplier_id', $product->supplier_id ?? '') == $supplier->id ? 'selected' : '' }}>
                                    {{ $supplier->name }}
                                </option>
                            @endforeach
                        </select>

                        <x-input-error :messages="$errors->get('supplier_id')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="purchase_price" value="Harga Beli (Rp)" />
                        <x-text-input id="purchase_price" name="purchase_price" type="number" class="mt-1 block w-full" :value="old('purchase_price', $product->purchase_price ?? '')" required min="0" />
                        <x-input-error :messages="$errors->get('purchase_price')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="selling_price" value="Harga Jual (Rp)" />
                        <x-text-input id="selling_price" name="selling_price" type="number" class="mt-1 block w-full" :value="old('selling_price', $product->selling_price ?? '')" required min="0" />
                        <x-input-error :messages="$errors->get('selling_price')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="stock" value="Stok Awal" />
                        <x-text-input id="stock" name="stock" type="number" class="mt-1 block w-full" :value="old('stock', $product->stock ?? '0')" required min="0" />
                        <x-input-error :messages="$errors->get('stock')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="min_stock" value="Stok Minimal" />
                        <x-text-input id="min_stock" name="min_stock" type="number" class="mt-1 block w-full" :value="old('min_stock', $product->min_stock ?? '5')" required min="0" />
                        <x-input-error :messages="$errors->get('min_stock')" class="mt-2" />
                    </div>

                    <div class="md:col-span-2">
                        <x-input-label for="unit" value="Satuan" />
                        <select id="unit" name="unit" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="pcs" {{ (old('unit', $product->unit ?? '') == 'pcs') ? 'selected' : '' }}>Pcs</option>
                            <option value="pack" {{ (old('unit', $product->unit ?? '') == 'pack') ? 'selected' : '' }}>Pack</option>
                            <option value="kg" {{ (old('unit', $product->unit ?? '') == 'kg') ? 'selected' : '' }}>Kg</option>
                            <option value="liter" {{ (old('unit', $product->unit ?? '') == 'liter') ? 'selected' : '' }}>Liter</option>
                            <option value="box" {{ (old('unit', $product->unit ?? '') == 'box') ? 'selected' : '' }}>Box</option>
                        </select>
                        <x-input-error :messages="$errors->get('unit')" class="mt-2" />
                    </div>
                </div>
            <div class="md:col-span-2">
                <x-input-label for="is_active" value="Status" />
                <select id="is_active"
                    name="is_active"
                    class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="1"
                        {{ (old('is_active', $product->is_active ?? true) == 1) ? 'selected' : '' }}>
                        Aktif
                    </option>
                    <option value="0"
                        {{ (old('is_active', $product->is_active ?? true) == 0) ? 'selected' : '' }}>
                        Nonaktif
                    </option>
                </select>
            </div>

                <div class="mt-6 flex items-center gap-3">
                    <a href="{{ route('master.products.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">Batal</a>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition">
                        {{ isset($product) ? 'Simpan Perubahan' : 'Simpan' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
