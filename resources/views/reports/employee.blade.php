<x-app-layout>
    
    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            Laporan Karyawan
        </h2>
    </x-slot>
    
        <div class="grid grid-cols-4 gap-4 mb-6">
    
        <div class="bg-blue-50 p-4 rounded-lg">
            <p class="text-sm text-gray-500">Total Karyawan</p>
            <p class="text-2xl font-bold">{{ $totalKaryawan }}</p>
        </div>
    
        <div class="bg-green-50 p-4 rounded-lg">
            <p class="text-sm text-gray-500">Kasir</p>
            <p class="text-2xl font-bold">
                {{ $employees->where('role','cashier')->count() }}
            </p>
        </div>
    
        <div class="bg-yellow-50 p-4 rounded-lg">
            <p class="text-sm text-gray-500">Manager</p>
            <p class="text-2xl font-bold">
                {{ $employees->where('role','manager')->count() }}
            </p>
        </div>
    
        <div class="bg-purple-50 p-4 rounded-lg">
            <p class="text-sm text-gray-500">Supervisor</p>
            <p class="text-2xl font-bold">
                {{ $employees->where('role','supervisor')->count() }}
            </p>
        </div>
    
    </div>
    
    <table class="w-full">
        
    <thead>
        <tr class="border-b bg-gray-50">

            <th class="text-left py-3 px-2">Nama</th>
            <th class="text-left py-3 px-2">Email</th>
            <th class="text-left py-3 px-2">Role</th>
            <th class="text-left py-3 px-2">Cabang</th>
            <th class="text-left py-3 px-2">No HP</th>
            <th class="text-left py-3 px-2">Status</th>
            <th class="text-left py-3 px-2">Bergabung</th>

        </tr>
    </thead>

    <tbody>

        @foreach($employees as $employee)

        <tr class="border-b hover:bg-gray-50">

            <td class="py-3 px-2">
                {{ $employee->name }}
            </td>

            <td class="py-3 px-2">
                {{ $employee->email }}
            </td>

            <td class="py-3 px-2">
                {{ ucfirst($employee->role) }}
            </td>

            <td class="py-3 px-2">
                {{ $employee->branch->name ?? '-' }}
            </td>

            <td class="py-3 px-2">
                {{ $employee->phone ?? '-' }}
            </td>

            <td class="py-3 px-2">

                @if($employee->is_active)

                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">
                        Aktif
                    </span>

                @else

                    <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-700">
                        Nonaktif
                    </span>

                @endif

            </td>

            <td class="py-3 px-2">
                {{ $employee->created_at->format('d M Y') }}
            </td>

        </tr>

        @endforeach

    </tbody>

</table>


</x-app-layout>
