<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Surat Setoran Pajak (SSP) - PPh 21</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 13px; }
        .ssp-header { text-align: center; margin-bottom: 20px; }
        .ssp-title { font-size: 18px; font-weight: bold; }
        .ssp-subtitle { font-size: 14px; }
        .ssp-box { border: 1px solid #333; padding: 12px; margin-bottom: 18px; }
        .ssp-label { width: 180px; display: inline-block; font-weight: bold; }
        table { border-collapse: collapse; width: 100%; margin-bottom: 18px; }
        th, td { border: 1px solid #333; padding: 8px; }
        th { background: #f2f2f2; }
        .ssp-total { font-size: 16px; font-weight: bold; color: #d32f2f; }
        .ssp-footer { margin-top: 30px; font-size: 12px; }
    </style>
</head>
<body>
    <div class="ssp-header">
        <div class="ssp-title">SURAT SETORAN PAJAK (SSP)</div>
        <div class="ssp-subtitle">PPh 21 Pegawai Tetap</div>
    </div>

    <div class="ssp-box">
        <div><span class="ssp-label">Nama Wajib Pajak</span>: ....................................................</div>
        <div><span class="ssp-label">NPWP</span>: ....................................................</div>
        <div><span class="ssp-label">Alamat</span>: ....................................................</div>
        <div><span class="ssp-label">Masa Pajak</span>: ....................................................</div>
        <div><span class="ssp-label">Tanggal Setor</span>: {{ date('d-m-Y') }}</div>
    </div>

    <h3 style="margin-bottom:8px;">Rincian Perhitungan PPh 21</h3>
    @if($hasil)
        <table>
            <tr>
                <th>Uraian</th>
                <th>Nilai</th>
            </tr>
            <tr>
                <td>Penghasilan Neto Setahun</td>
                <td>Rp {{ number_format($hasil['neto_setahun'] ?? 0, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>PTKP</td>
                <td>Rp {{ number_format($hasil['total_ptkp'] ?? 0, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>PKP</td>
                <td>Rp {{ number_format($hasil['pkp'] ?? 0, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>PPh 21 Terutang (Tahunan)</td>
                <td>Rp {{ number_format($hasil['pajak_setahun'] ?? 0, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th class="ssp-total">TOTAL DISETOR</th>
                <th class="ssp-total">Rp {{ number_format($hasil['pajak_setahun'] ?? 0, 0, ',', '.') }}</th>
            </tr>
        </table>
    @else
        <p>Tidak ada hasil perhitungan pajak.</p>
    @endif

    <div class="ssp-footer">
        <div>*) Bukti setor ini dicetak otomatis dari aplikasi, bukan bukti setor resmi DJP.</div>
        <div>Silakan gunakan data ini untuk referensi pengisian SSP resmi.</div>
    </div>
</body>
</html>