@extends('layouts.app')

@section('title', 'Kalkulator PPN')

@section('content')
<div class="tax-calculator-page ppn-page">
    {{-- Bagian Header, Intro, dan Tabs --}}
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
        <a href="{{ route('kalkulator.pph') }}" class="tab-item">PPh</a>
        <a href="{{ route('kalkulator.ppn') }}" class="tab-item active">PPN</a>
        <a href="{{ route('kalkulator.pkb') }}" class="tab-item">PKB</a>
    </div>

    {{-- Kontainer Utama Kalkulator --}}
    <div class="calculator-container">
        <h3 class="calculator-title">PPN</h3>
        <p class="calculator-subtitle">Kalkulator Pajak Pertambahan Nilai (PPN) dengan berbagai skema pengenaan.</p>

        <div class="calculator-body">
            {{-- Kolom Panduan (Kiri) --}}
            <div class="guide-column">
                <h4 class="guide-title">Memahami Mekanisme PPN</h4>
                <ul class="guide-list">
                    <li><strong>1. Perhitungan Standar (Tarif Umum)</strong> Ini adalah cara hitung paling umum. PPN dihitung sebesar 11% dari Harga Jual/Nilai Penggantian.</li>
                    <li><strong>2. DPP Nilai Lain</strong> Untuk transaksi khusus, DPP-nya bukan harga jual, melainkan persentase tertentu dari harga jual. PPN kemudian dihitung 11% dari DPP "Nilai Lain" tersebut.</li>
                    <li><strong>3. Besaran Tertentu (Tarif Efektif)</strong> Untuk kemudahan, beberapa usaha bisa langsung mengalikan Harga Jual dengan tarif efektif yang lebih rendah (misal 1,1%).</li>
                    <li><strong>4. PPN Dibebaskan / Tidak Dipungut</strong> Barang dan jasa vital seperti kebutuhan pokok, jasa kesehatan, dan pendidikan tidak dikenai PPN.</li>
                    {{-- Dropdown Riwayat dipindahkan ke sini --}}
                    @if(isset($history) && $history->count() > 0)
                        <div class="mb-3">
                            <form method="GET" action="{{ route('kalkulator.ppn') }}">
                                <label for="history_id"><strong>Riwayat Perhitungan (3 Hari Terakhir):</strong></label>
                                <select name="history_id" id="history_id" class="form-select" onchange="this.form.submit()">
                                    <option value="">-- Pilih Riwayat --</option>
                                    @foreach($history as $item)
                                        <option value="{{ $item->id }}" {{ (isset($selected) && $selected && $selected->id == $item->id) ? 'selected' : '' }}>
                                            {{ $item->created_at->format('d-m-Y H:i') }} | Nilai Transaksi: {{ number_format($item->data['input']['nilai_transaksi'] ?? 0) }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </div>
                    @endif
                </ul>
            </div>

            {{-- Kolom Form (Kanan) --}}
            <div class="form-column">
                <div class="form-column">
                <form method="POST" action="{{ route('ppn.hitung') }}">
                    @csrf
                    <div class="form-group">
                        <label for="mekanisme">
                            Pilih Mekanisme Perhitungan PPN <span class="required">*</span>
                            <i class="info-icon" data-bs-toggle="tooltip" title="Pilihan ini akan mengubah input yang dibutuhkan dan cara perhitungan.">?</i>
                        </label>
                        <select id="mekanisme" name="mekanisme" class="form-select" required>
                            <option value="standar" {{ old('mekanisme', 'standar') == 'standar' ? 'selected' : '' }}>1. Perhitungan Standar (Tarif Umum 11%)</option>
                            <option value="dpp_nilai_lain" {{ old('mekanisme') == 'dpp_nilai_lain' ? 'selected' : '' }}>2. Perhitungan dengan DPP Nilai Lain</option>
                            <option value="besaran_tertentu" {{ old('mekanisme') == 'besaran_tertentu' ? 'selected' : '' }}>3. Perhitungan dengan Besaran Tertentu</option>
                        </select>
                    </div>

                    {{-- KUMPULAN INPUT YANG DINAMIS --}}
                    <div id="input-standar">
                        <div class="form-group">
                            <label for="nilai_transaksi_standar">Nilai Transaksi / DPP <span class="required">*</span></label>
                            <input type="number" name="nilai_transaksi" class="form-control" placeholder="Contoh: 10000000" value="{{ old('nilai_transaksi') }}">
                        </div>
                    </div>

                    <div id="input-dpp-nilai-lain" class="d-none">
                        <div class="form-group">
                            <label for="nilai_transaksi_dpp">Harga Jual / Nilai Penggantian <span class="required">*</span></label>
                            <input type="number" name="nilai_transaksi" class="form-control" placeholder="Contoh: 200000000" value="{{ old('nilai_transaksi') }}">
                        </div>
                        <div class="form-group">
                            <label for="persentase_dpp">Persentase DPP Nilai Lain (%) <span class="required">*</span></label>
                            <input type="number" name="persentase_dpp" class="form-control" placeholder="Contoh: 10 (untuk 10%)" value="{{ old('persentase_dpp') }}">
                        </div>
                    </div>

                    <div id="input-besaran-tertentu" class="d-none">
                        <div class="form-group">
                            <label for="nilai_transaksi_besaran">Harga Jual / Nilai Penggantian <span class="required">*</span></label>
                            <input type="number" name="nilai_transaksi" class="form-control" placeholder="Contoh: 50000000" value="{{ old('nilai_transaksi') }}">
                        </div>
                        <div class="form-group">
                            <label for="tarif_efektif">Tarif Efektif (%) <span class="required">*</span></label>
                            <input type="number" name="tarif_efektif" class="form-control" placeholder="Contoh: 1.1 (untuk 1,1%)" value="{{ old('tarif_efektif') }}" step="0.1">
                        </div>
                    </div>
                    {{-- AKHIR KUMPULAN INPUT --}}

                    <button type="submit" class="btn-hitung mt-4">Hitung PPN</button>

                    {{-- Rincian Hasil Perhitungan --}}
                    @php
                        $hasil = null;
                        if(isset($selected) && $selected) {
                            $hasil = $selected->data['hasil'] ?? null;
                        } elseif(session('hasil_ppn')) {
                            $hasil = session('hasil_ppn');
                        }
                    @endphp
                    {{-- Jika ada hasil perhitungan --}}
                    @if($hasil)
                        <div class="result-breakdown mt-4">
                            <h5 class="guide-title">Rincian Perhitungan Anda</h5>
                            <div class="form-group readonly">
                                <label>Dasar Pengenaan Pajak (DPP)</label>
                                <input type="text" class="form-control" value="Rp {{ number_format($hasil['dpp'], 2, ',', '.') }}" readonly>
                                <small class="formula-text">Nilai yang dijadikan dasar perhitungan pajak.</small>
                            </div>
                            <div class="form-group readonly">
                                <label>PPN Terutang</label>
                                <input type="text" class="form-control" value="Rp {{ number_format($hasil['ppn'], 2, ',', '.') }}" readonly>
                                <small class="formula-text">{{ $hasil['keterangan_hasil'] }}</small>
                            </div>
                            <div class="form-group readonly result-total">
                                <label>Total yang Harus Dibayar</label>
                                <input type="text" class="form-control" value="Rp {{ number_format($hasil['total'], 2, ',', '.') }}" readonly>
                                <small class="formula-text">DPP + PPN</small>
                            </div>
                            @if(isset($selected) && $selected)
                                <a href="{{ route('ppn.exportPDF', $selected->id) }}" target="_blank" class="btn btn-success mt-3">Download PDF</a>
                            @else
                                <a href="{{ route('ppn.exportPDF') }}" target="_blank" class="btn btn-success mt-3">Download PDF</a>
                            @endif
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Script untuk form dinamis --}}
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mekanismeSelect = document.getElementById('mekanisme');
        const inputDivs = {
            standar: document.getElementById('input-standar'),
            dpp_nilai_lain: document.getElementById('input-dpp-nilai-lain'),
            besaran_tertentu: document.getElementById('input-besaran-tertentu')
        };

        function toggleInputs() {
            const selected = mekanismeSelect.value;
            for (const key in inputDivs) {
                inputDivs[key].classList.add('d-none');
                inputDivs[key].querySelectorAll('input').forEach(i => i.disabled = true);
            }
            if (inputDivs[selected]) {
                inputDivs[selected].classList.remove('d-none');
                inputDivs[selected].querySelectorAll('input').forEach(i => i.disabled = false);
            }
        }

        toggleInputs();
        mekanismeSelect.addEventListener('change', toggleInputs);
    });

    

</script>
@endpush
@endsection
