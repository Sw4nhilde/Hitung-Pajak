<!DOCTYPE html>
<html>
<head>
    <title>Data Pajak</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 8px; }
    </style>
</head>
<body>
    <h1>Data Pajak Tahunan</h1>
    <table>
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
</body>
</html>
