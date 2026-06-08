```blade id="emp5"
<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            Laporan Karyawan
        </h2>
    </x-slot>

    <div class="bg-white p-6 rounded-xl border">

        <p class="text-lg font-semibold mb-4">
            Total Karyawan:
            {{ $totalKaryawan }}
        </p>

        <table class="w-full">

            <thead>
                <tr class="border-b">
                    <th class="text-left py-3">Nama</th>
                    <th class="text-left py-3">Email</th>
                </tr>
            </thead>

            <tbody>

                @foreach($employees as $employee)

                <tr class="border-b">

                    <td class="py-3">
                        {{ $employee->name }}
                    </td>

                    <td class="py-3">
                        {{ $employee->email }}
                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</x-app-layout>
```
