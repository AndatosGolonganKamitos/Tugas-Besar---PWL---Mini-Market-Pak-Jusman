<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($branch) ? 'Edit Cabang' : 'Tambah Cabang' }}
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <form action="{{ isset($branch) ? route('branches.update', $branch) : route('branches.store') }}" method="POST">
                @csrf
                @if(isset($branch)) @method('PUT') @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="code" value="Kode Cabang" />
                        <x-text-input id="code" name="code" type="text" class="mt-1 block w-full" :value="old('code', $branch->code ?? '')" required placeholder="CBG-001" />
                        <x-input-error :messages="$errors->get('code')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="name" value="Nama Cabang" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $branch->name ?? '')" required placeholder="Cabang Pusat" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="md:col-span-2">
                        <x-input-label for="address" value="Alamat" />
                        <textarea id="address" name="address" rows="3" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Jl. Merdeka No. 1, Jakarta">{{ old('address', $branch->address ?? '') }}</textarea>
                        <x-input-error :messages="$errors->get('address')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="phone" value="Telepon" />
                        <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $branch->phone ?? '')" placeholder="021-1234567" />
                        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="email" value="Email" />
                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $branch->email ?? '')" placeholder="cabang@minimarket.com" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="manager_name" value="Nama Manajer" />
                        <x-text-input id="manager_name" name="manager_name" type="text" class="mt-1 block w-full" :value="old('manager_name', $branch->manager_name ?? '')" placeholder="Budi Santoso" />
                        <x-input-error :messages="$errors->get('manager_name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="is_active" value="Status" />
                        <select id="is_active" name="is_active" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="1" {{ (old('is_active', $branch->is_active ?? true) == 1) ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ (old('is_active', $branch->is_active ?? true) == 0) ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>
                </div>

                <div class="mt-6 flex items-center gap-3">
                    <a href="{{ route('branches.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">Batal</a>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition">
                        {{ isset($branch) ? 'Simpan Perubahan' : 'Simpan' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
