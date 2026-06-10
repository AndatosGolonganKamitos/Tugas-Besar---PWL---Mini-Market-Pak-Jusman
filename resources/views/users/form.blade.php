<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($user) ? 'Edit Pengguna' : 'Tambah Pengguna' }}
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <form action="{{ isset($user) ? route('users.update', $user) : route('users.store') }}" method="POST">
                @csrf
                @if(isset($user)) @method('PUT') @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="name" value="Nama Lengkap" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name ?? '')" required placeholder="Budi Santoso" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="email" value="Email" />
                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email ?? '')" required placeholder="budi@example.com" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div>

                        <x-input-label for="password" value="Password" />

                        <input
                            id="password"
                            name="password"
                            type="password"
                            class="mt-1 block w-full border border-gray-300 rounded-lg px-4 py-2"
                            {{ isset($user) ? '' : 'required' }}
                        >

                        <x-input-error :messages="$errors->get('password')" class="mt-2" />

                        <p class="text-xs text-gray-400 mt-1">

                            Kosongkan jika tidak ingin mengubah password

                        </p>

                    </div>


                    <div>

                        <x-input-label
                            for="password_confirmation"
                            value="Konfirmasi Password" />

                        <input
                            id="password_confirmation"
                            name="password_confirmation"
                            type="password"
                            class="mt-1 block w-full border border-gray-300 rounded-lg px-4 py-2"
                        >

                        <x-input-error
                            :messages="$errors->get('password_confirmation')"
                            class="mt-2" />

                    </div>

                    <div>
                            <x-input-label for="phone" value="Nomor Telepon" />

                            <x-text-input
                                id="phone"
                                name="phone"
                                type="text"
                                class="mt-1 block w-full"
                                :value="old('phone', $user->phone ?? '')"
                                placeholder="081234567890"
                            />

                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>


                    <div>
                        <x-input-label for="role" value="Role" />
                        <select id="role" name="role" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            <option value="">Pilih Role</option>
                            <option value="owner" {{ (old('role', $user->role ?? '') == 'owner') ? 'selected' : '' }}>Owner</option>
                            <option value="manager" {{ (old('role', $user->role ?? '') == 'manager') ? 'selected' : '' }}>Manajer Toko</option>
                            <option value="supervisor" {{ (old('role', $user->role ?? '') == 'supervisor') ? 'selected' : '' }}>Supervisor</option>
                            <option value="cashier" {{ (old('role', $user->role ?? '') == 'cashier') ? 'selected' : '' }}>Kasir</option>
                            <option value="warehouse" {{ (old('role', $user->role ?? '') == 'warehouse') ? 'selected' : '' }}>Pegawai Gudang</option>
                        </select>
                        <x-input-error :messages="$errors->get('role')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="branch_id" value="Cabang" />
                    <select
                        name="branch_id"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2">

                        <option value="">
                            Pilih Cabang
                        </option>

                        @foreach($branches as $branch)

                            <option
                                value="{{ $branch->id }}"
                                {{ old('branch_id', $user->branch_id ?? '') == $branch->id ? 'selected' : '' }}>

                                {{ $branch->name }}

                            </option>

                        @endforeach

                    </select>

                        <x-input-error :messages="$errors->get('branch_id')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="is_active" value="Status" />
                        <select id="is_active" name="is_active" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="1" {{ (old('is_active', $user->is_active ?? true) == 1) ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ (old('is_active', $user->is_active ?? true) == 0) ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>
                </div>

                <div class="mt-6 flex items-center gap-3">
                    <a href="{{ route('users.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">Batal</a>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition">
                        {{ isset($user) ? 'Simpan Perubahan' : 'Simpan' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
