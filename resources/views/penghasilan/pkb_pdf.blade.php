<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Surat Setoran Pajak (SSP) - PKB</title>
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
        <div class="ssp-subtitle">Pajak Kendaraan Bermotor (PKB)</div>
    </div>

    <div class="ssp-box">
        <div><span class="ssp-label">Nama Wajib Pajak</span>: ....................................................</div>
        <div><span class="ssp-label">Nomor Polisi</span>: ....................................................</div>
        <div><span class="ssp-label">Alamat</span>: ....................................................</div>
        <div><span class="ssp-label">Masa Pajak</span>: ....................................................</div>
        <div><span class="ssp-label">Tanggal Setor</span>: {{ date('d-m-Y') }}</div>
    </div>

    <h3 style="margin-bottom:8px;">Rincian Perhitungan PKB</h3>
    @if($hasil)
        <table>
            <tr>
                <th>Uraian</th>
                <th>Nilai</th>
            </tr>
            <tr>
                <td>PKB Pokok</td>
                <td>Rp {{ number_format($hasil['pkb_pokok'] ?? 0, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Opsen PKB (66%)</td>
                <td>Rp {{ number_format($hasil['opsen_pkb'] ?? 0, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>SWDKLLJ</td>
                <td>Rp {{ number_format($hasil['swdkllj'] ?? 0, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th class="ssp-total">TOTAL DISETOR</th>
                <th class="ssp-total">Rp {{ number_format($hasil['total_bayar'] ?? 0, 0, ',', '.') }}</th>
            </tr>
        </table>
    @else
        <p>Tidak ada data perhitungan.</p>
    @endif

    <div class="ssp-footer">
        <div>*) Bukti setor ini dicetak otomatis dari aplikasi, bukan bukti setor resmi SAMSAT.</div>
        <div>Silakan gunakan data ini untuk referensi pengisian SSP resmi.</div>
    </div>
</body>
</html>