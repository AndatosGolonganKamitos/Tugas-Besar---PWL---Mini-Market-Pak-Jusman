<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Pengguna</h2>
            <a href="{{ route('users.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                Tambah Pengguna
            </a>
        </div>
    </x-slot>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-4 border-b border-gray-100">
            <div class="flex gap-3">
                <div class="relative flex-1 max-w-sm">
                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input
                        type="text"
                        id="searchUser"
                        placeholder="Cari pengguna..."
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <select
    id="roleFilter"
    class="border border-gray-300 rounded-lg text-sm px-3 py-2">
                    <option value="">Semua Role</option>
                    <option value="owner">Owner</option>
                    <option value="manager">Manajer Toko</option>
                    <option value="supervisor">Supervisor</option>
                    <option value="cashier">Kasir</option>
                    <option value="warehouse">Pegawai Gudang</option>
                </select>
            </div>
        </div>

        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                    <th class="px-6 py-3">Nama</th>
                    <th class="px-6 py-3">Email</th>
                    <th class="px-6 py-3">Telepon</th>
                    <th class="px-6 py-3">Role</th>
                    <th class="px-6 py-3">Cabang</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody id="userTable" class="divide-y divide-gray-100">

                @forelse($users as $user)

                <tr>

                    <td class="px-6 py-4">
                        {{ $user->name }}
                    </td>

                    <td class="px-6 py-4">
                        {{ $user->email }}
                    </td>

                    <td class="px-6 py-4">
                        {{ $user->phone ?? '—' }}
                    </td>

                    <td class="px-6 py-4">

                        <span class="px-2 py-1 text-xs rounded-full bg-indigo-100 text-indigo-700">

                            {{ ucfirst($user->role) }}

                        </span>

                    </td>

                    <td class="px-6 py-4">
                        {{ $user->branch->name ?? '-' }}
                    </td>

                    <td class="px-6 py-4">

                        <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">

                            Aktif

                        </span>

                    </td>

                    <td class="px-6 py-4 text-right">

                        <div class="flex justify-end gap-3">

                            <a href="{{ route('users.edit', $user->id) }}"
                                class="text-indigo-600 hover:text-indigo-800">

                                Edit

                            </a>

                            <form
                                action="{{ route('users.destroy', $user->id) }}"
                                method="POST">

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    onclick="return confirm('Hapus user ini?')"
                                    class="text-red-500 hover:text-red-700">

                                    Hapus

                                </button>

                            </form>

                        </div>

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="6"
                        class="px-6 py-10 text-center text-gray-400">

                        Belum ada pengguna

                    </td>

                </tr>

                @endforelse

            </tbody>


        {{-- TODO Backend: Ganti 0 dengan count($users) --}}
        <div class="px-6 py-3 border-t border-gray-100 text-sm text-gray-500">
            Total: {{ $users->count() }} pengguna
        </div>
    </div>
</x-app-layout>
<script>

const searchUser = document.getElementById('searchUser');
const roleFilter = document.getElementById('roleFilter');

searchUser.addEventListener('input', filterUsers);
roleFilter.addEventListener('change', filterUsers);

function filterUsers() {

    const keyword = searchUser.value.toLowerCase();
    const role = roleFilter.value.toLowerCase();

    const rows = document.querySelectorAll('#userTable tr');

    rows.forEach(row => {

        const text = row.innerText.toLowerCase();

        const roleCell =
            row.children[2]?.innerText.toLowerCase().trim();

        const matchSearch =
            text.includes(keyword);

        const matchRole =
            role === '' ||
            roleCell.includes(role);

        row.style.display =
            matchSearch && matchRole
            ? ''
            : 'none';

    });
}

</script>