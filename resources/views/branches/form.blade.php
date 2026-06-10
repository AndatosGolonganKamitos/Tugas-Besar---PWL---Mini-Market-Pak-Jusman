<x-app-layout>

    <x-slot name="header">

        <h2 class="font-semibold text-xl text-gray-800 leading-tight">

            {{ isset($branch) ? 'Edit Cabang' : 'Tambah Cabang' }}

        </h2>

    </x-slot>

    <div class="max-w-4xl mx-auto">

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">

            <form
                action="{{ isset($branch)
                    ? route('branches.update', $branch->id)
                    : route('branches.store') }}"
                method="POST">

                @csrf

                @if(isset($branch))
                    @method('PUT')
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div>

                        <label class="block text-sm font-medium text-gray-700 mb-1">

                            Kode Cabang

                        </label>

                        <input
                            type="text"
                            name="code"
                            value="{{ old('code', $branch->code ?? '') }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2">

                    </div>

                    <div>

                        <label class="block text-sm font-medium text-gray-700 mb-1">

                            Nama Cabang

                        </label>

                        <input
                            type="text"
                            name="name"
                            value="{{ old('name', $branch->name ?? '') }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2">

                    </div>

                    <div>

                        <label class="block text-sm font-medium text-gray-700 mb-1">

                            Telepon

                        </label>

                        <input
                            type="text"
                            name="phone"
                            value="{{ old('phone', $branch->phone ?? '') }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2">

                    </div>

                    <div>

                        <label class="block text-sm font-medium text-gray-700 mb-1">

                            Email

                        </label>

                        <input
                            type="email"
                            name="email"
                            value="{{ old('email', $branch->email ?? '') }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2">

                    </div>

                    <div class="md:col-span-2">

                        <label class="block text-sm font-medium text-gray-700 mb-1">

                            Alamat

                        </label>

                        <textarea
                            name="address"
                            rows="3"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2">{{ old('address', $branch->address ?? '') }}</textarea>

                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">
                            Manager Cabang
                        </label>

                        <select
                            name="manager_name"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2">

                            <option value="">
                                Pilih Manager
                            </option>

                            @foreach($users as $user)

                                @if(in_array($user->role, ['manager', 'supervisor']))

                                    <option
                                        value="{{ $user->name }}"
                                        {{ old('manager_name', $branch->manager_name ?? '') == $user->name ? 'selected' : '' }}>

                                        {{ $user->name }} ({{ ucfirst($user->role) }})

                                    </option>

                                @endif

                            @endforeach

                        </select>
                    </div>

                    <div>

                        <label class="block text-sm font-medium text-gray-700 mb-1">

                            Status

                        </label>

                        <select
                            name="is_active"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2">

                            <option value="1"
                                {{ old('is_active', $branch->is_active ?? 1) == 1 ? 'selected' : '' }}>

                                Aktif

                            </option>

                            <option value="0"
                                {{ old('is_active', $branch->is_active ?? 1) == 0 ? 'selected' : '' }}>

                                Nonaktif

                            </option>

                        </select>

                    </div>

                </div>

                <div class="mt-6 flex gap-3">

                    <a href="{{ route('branches.index') }}"
                        class="px-4 py-2 border border-gray-300 rounded-lg">

                        Batal

                    </a>

                    <button
                        type="submit"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">

                        Simpan

                    </button>

                </div>

            </form>

        </div>

    </div>

</x-app-layout>
