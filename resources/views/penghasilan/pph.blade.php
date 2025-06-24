@extends('layouts.app')

@section('title', 'Kalkulator PPh 21')

@section('content')
<div class="tax-calculator-page pph-page">
    <header class="tax-header">
        <img src="{{ asset('images/icon.png') }}" alt="Calculator Icon" class="header-icon">
        <h1>Kalkulator Pajak</h1>
    </header>

    <section class="tax-intro">
        <div class="intro-illustration">
            <img src="{{ asset('images/gambar.png') }}" alt="Ilustrasi Pajak">
        </div>
        <div class="intro-text">
            <h2>Yuk, Hitung Pajak Tanpa Ribet!</h2>
            <p>Di aplikasi ini, kamu bisa hitung 3 jenis pajak utama secara otomatis dan akurat. Cukup isi data, langsung keluar hasilnya. Gampang banget, kan?</p>
            <p class="highlight">Hitung pajaknya di sini, lapornya tetap di DJP!</p>
        </div>
    </section>

    <div class="tax-tabs">
        <a href="{{ route('kalkulator.pph') }}" class="tab-item active">PPh</a>
        <a href="{{ route('kalkulator.ppn') }}" class="tab-item">PPN</a>
        <a href="{{ route('kalkulator.pkb') }}" class="tab-item">PKB</a>
    </div>

    <div class="calculator-container">
        <h3 class="calculator-title">PPh 21</h3>
        <p class="calculator-subtitle">Kalkulator PPh 21 untuk Pegawai Tetap dengan Gaji Bulanan.</p>

        <div class="calculator-body">
            <div class="guide-column">
                <h4 class="guide-title">Panduan Pengisian Form</h4>
                <ul class="guide-list">
                    <li><strong>Pendapatan Pokok:</strong> Masukkan gaji bulanan Anda sebelum potongan apapun.</li>
                    <li><strong>Tunjangan Lainnya:</strong> Total semua tunjangan rutin (makan, transport, dll). Isi 0 jika tidak ada.</li>
                    <li><strong>Iuran Pensiun/JHT:</strong> Total iuran yang Anda bayarkan sendiri setiap bulan. Isi 0 jika tidak ada.</li>
                    <li><strong>Status & Tanggungan:</strong> Pilih status perkawinan dan jumlah tanggungan (anak/orang tua) yang sah secara aturan pajak.</li>
                </ul>

                <h4 class="guide-title mt-4">Memahami PPh 21</h4>
                <ul class="guide-list">
                    <li>
                        <strong>Penghasilan Kena Pajak (PKP)</strong>
                        Dasar perhitungan pajak, dihitung dari `Penghasilan Neto Setahun` dikurangi `PTKP`.
                    </li>
                    <li>
                        <strong>PTKP (Penghasilan Tidak Kena Pajak)</strong>
                        Batas penghasilan yang bebas pajak, tergantung status dan tanggungan Anda.
                        <a href="https://pajak.go.id/id/penghasilan-tidak-kena-pajak" target="_blank" rel="noopener noreferrer" class="details-link">
                            Lihat Aturan Resmi PTKP &raquo;
                        </a>
                    </li>
                    <li>
                        <strong>Tarif Progresif</strong>
                        Pajak dihitung secara berlapis: 5%, 15%, 25%, 30%, dan 35%.
                        <a href="https://www.talenta.co/blog/tarif-ptkp-cara-perhitungan-pajak-penghasilan-progresif-pph-pasal-21" target="_blank" rel="noopener noreferrer" class="details-link">
                            Lihat Penjelasan Tarif Progresif &raquo;
                        </a>
                    </li>

                    {{-- Tempatkan dropdown riwayat di bawah Tarif Progresif --}}
                    @if(isset($history) && $history->count() > 0)
                    <li>
                        <form method="GET" action="{{ route('kalkulator.pph') }}" class="history-select-form mt-3">
                            <label for="history_id" class="form-label">Riwayat Perhitungan (3 Hari Terakhir):</label>
                            <select name="history_id" id="history_id" onchange="this.form.submit()" class="form-control" style="max-width: 300px;">
                                <option value="">-- Pilih Riwayat --</option>
                                @foreach($history as $item)
                                    <option value="{{ $item->id }}" {{ (isset($selected) && $selected->id == $item->id) ? 'selected' : '' }}>
                                        {{ $item->created_at->format('d-m-Y H:i') }} | Pendapatan: Rp{{ number_format($item->data['input']['pendapatan'] ?? 0, 0, ',', '.') }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </li>
                    @endif
                </ul>
            </div>

            <div class="form-column">
                <form method="POST" action="{{ route('pph.hitung') }}">
                    @csrf
                    <div class="form-group">
                        <label for="pendapatan">Pendapatan Pokok (per Bulan) <span class="required">*</span></label>
                        <input type="number" id="pendapatan" name="pendapatan" class="form-control" placeholder="Contoh: 8000000" value="{{ old('pendapatan') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="tunjangan">Tunjangan Lainnya (per Bulan) <span class="required">*</span></label>
                        <input type="number" id="tunjangan" name="tunjangan" class="form-control" placeholder="Contoh: 1500000" value="{{ old('tunjangan') ?? 0 }}" required>
                    </div>
                    <div class="form-group">
                        <label for="iuran_pensiun">Iuran Pensiun/JHT (per Bulan)</label>
                        <input type="number" id="iuran_pensiun" name="iuran_pensiun" class="form-control" placeholder="Contoh: 100000" value="{{ old('iuran_pensiun') ?? 0 }}">
                    </div>
                    <div class="form-group">
                        <label for="status">Status Perkawinan <span class="required">*</span></label>
                        <select id="status" name="status" class="form-control" required>
                            <option value="lajang" {{ old('status') == 'lajang' ? 'selected' : '' }}>Tidak Kawin</option>
                            <option value="menikah" {{ old('status') == 'menikah' ? 'selected' : '' }}>Kawin</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tanggungan">Jumlah Tanggungan <span class="required">*</span></label>
                        <select id="tanggungan" name="tanggungan" class="form-control" required>
                            <option value="0" {{ old('tanggungan') == '0' ? 'selected' : '' }}>0</option>
                            <option value="1" {{ old('tanggungan') == '1' ? 'selected' : '' }}>1</option>
                            <option value="2" {{ old('tanggungan') == '2' ? 'selected' : '' }}>2</option>
                            <option value="3" {{ old('tanggungan') == '3' ? 'selected' : '' }}>3</option>
                        </select>
                    </div>

                    <button type="submit" class="btn-hitung mt-4">Hitung PPh 21</button>

                    {{-- Hasil Perhitungan --}}
                    @if(session('hasil_pph') || isset($selected))
                        @php
                            if(isset($selected)) {
                                $hasil = $selected->data['hasil'] ?? [];
                                $bruto = $selected->data['bruto_setahun'] ?? ($hasil['bruto_setahun'] ?? 0);
                                $pengurang = $selected->data['total_pengurang_setahun'] ?? ($hasil['total_pengurang_setahun'] ?? 0);
                                $ptkp = $selected->data['total_ptkp'] ?? ($hasil['total_ptkp'] ?? 0);
                            } else {
                                $hasil = session('hasil_pph');
                                $bruto = $hasil['bruto_setahun'] ?? 0;
                                $pengurang = $hasil['total_pengurang_setahun'] ?? 0;
                                $ptkp = $hasil['total_ptkp'] ?? 0;
                            }
                            $neto = $hasil['neto_setahun'] ?? 0;
                            $pkp = $hasil['pkp'] ?? 0;
                            $pajak = $hasil['pajak_setahun'] ?? 0;
                        @endphp

                        <div class="result-breakdown mt-4">
                            <h5 class="guide-title">Rincian Perhitungan {{ isset($selected) ? 'Riwayat' : 'Anda' }}</h5>
                            <div class="form-group readonly">
                                <label>Penghasilan Neto (setahun)</label>
                                <input type="text" class="form-control" value="Rp {{ number_format($neto, 0, ',', '.') }}" readonly>
                                <small class="formula-text">Bruto Setahun ({{ number_format($bruto, 0, ',', '.') }}) - Pengurang ({{ number_format($pengurang, 0, ',', '.') }})</small>
                            </div>
                            <div class="form-group readonly">
                                <label>PTKP (Penghasilan Tidak Kena Pajak)</label>
                                <input type="text" class="form-control" value="Rp {{ number_format($ptkp, 0, ',', '.') }}" readonly>
                            </div>
                            <div class="form-group readonly">
                                <label>PKP (Penghasilan Kena Pajak)</label>
                                <input type="text" class="form-control" value="Rp {{ number_format($pkp, 0, ',', '.') }}" readonly>
                            </div>
                            <div class="form-group readonly result-total">
                                <label>PPh 21 Terutang (Tahunan)</label>
                                <input type="text" class="form-control" value="Rp {{ number_format($pajak, 0, ',', '.') }}" readonly>
                            </div>
                            @if(isset($selected) && $selected)
                                <a href="{{ route('pph.exportPDF', $selected->id) }}" target="_blank">
                                    <button type="button" class="btn btn-success mt-3">Download PDF</button>
                                </a>
                            @elseif(session('hasil_pph'))
                                <a href="{{ route('pph.exportPDF') }}" target="_blank">
                                    <button type="button" class="btn btn-success mt-3">Download PDF</button>
                                </a>
                            @endif
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
