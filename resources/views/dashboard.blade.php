<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kalkulator Pajak') }}
        </h2>
    </x-slot>

    <div class="py-6 px-4">
        @if($data->count() > 0)
            <a href="{{ route('penghasilan.exportPDF') }}" target="_blank">
                <button class="bg-blue-500 text-white px-4 py-2 rounded mt-2">Download PDF</button>
            </a>
        @endif

        @if(session('success'))
            <p class="text-green-600">{{ session('success') }}</p>
        @endif

        <form action="/simpan" method="POST" class="mb-4">
            @csrf
            <div>
                Nama: <input type="text" name="nama" required>
            </div>
            <div>
                Gaji Bulanan: <input type="number" name="gaji_bulanan" required>
            </div>
            <button type="submit">Hitung Pajak</button>
        </form>

        <table border="1" class="mt-4">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Gaji Bulanan</th>
                    <th>Pajak Tahunan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $item)
                <tr>
                    <td>{{ $item->nama }}</td>
                    <td>Rp {{ number_format($item->gaji_bulanan, 2) }}</td>
                    <td>Rp {{ number_format($item->pajak, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>