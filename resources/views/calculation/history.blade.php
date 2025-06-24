{{-- filepath: resources/views/calculation/history.blade.php --}}
@extends('layouts.app')

@section('title', 'Riwayat Perhitungan Pajak')

@section('content')
<h2>Riwayat Perhitungan Pajak (3 Hari Terakhir)</h2>
@if($calculations->isEmpty())
    <p>Tidak ada riwayat perhitungan.</p>
@else
    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Jenis Pajak</th>
                <th>Input</th>
                <th>Hasil</th>
            </tr>
        </thead>
        <tbody>
            @foreach($calculations as $calc)
                <tr>
                    <td>{{ $calc->created_at }}</td>
                    <td>{{ strtoupper($calc->data['type'] ?? '-') }}</td>
                    <td>
                        @foreach($calc->data['input'] as $k => $v)
                            <b>{{ $k }}:</b> {{ $v }}<br>
                        @endforeach
                    </td>
                    <td>
                        @foreach($calc->data['hasil'] as $k => $v)
                            <b>{{ $k }}:</b> {{ is_numeric($v) ? number_format($v,2) : $v }}<br>
                        @endforeach
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
@endsection