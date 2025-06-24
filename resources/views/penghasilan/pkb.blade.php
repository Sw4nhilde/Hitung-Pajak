    @extends('layouts.app')

    @section('title', 'Kalkulator PKB')

    @section('content')
    <div class="tax-calculator-page pkb-page">
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
            <a href="{{ route('kalkulator.ppn') }}" class="tab-item">PPN</a>
            <a href="{{ route('kalkulator.pkb') }}" class="tab-item active">PKB</a>
        </div>

        {{-- Kontainer Utama Kalkulator --}}
        <div class="calculator-container">
            <h3 class="calculator-title">PKB</h3>
            <p class="calculator-subtitle">Kalkulator Pajak Kendaraan Bermotor (PKB) Tahunan, Opsen PKB, dan SWDKLLJ.</p>

            <div class="calculator-body">

                {{-- Kolom Panduan (Kiri) --}}
                <div class="guide-column">
                    <h4 class="guide-title">Panduan Pengisian Form</h4>
                    <ul class="guide-list">
                        <li><strong>NJKB:</strong> Masukkan Nilai Jual Kendaraan Bermotor yang tertera pada lembar STNK Anda.</li>
                        <li><strong>Jenis Kendaraan:</strong> Pilih kategori yang paling sesuai. Pilihan ini akan menentukan Koefisien dan SWDKLLJ otomatis.</li>
                        <li><strong>Provinsi:</strong> Pilih provinsi tempat kendaraan terdaftar untuk menentukan tarif pajak yang akurat.</li>
                        <li><strong>Kepemilikan ke-:</strong> Pilih ini kendaraan keberapa yang Anda miliki atas nama dan alamat yang sama untuk menentukan tarif pajak progresif.</li>
                    </ul>

                    {{-- INFORMASI DETAIL ANGKA PERHITUNGAN --}}
                    <h4 class="guide-title mt-4">Dasar Angka Perhitungan</h4>
                    <div class="alert alert-light small p-3">
                        <strong>Tarif Pajak Progresif (Contoh):</strong>
                        <ul>
                            <li><b>DKI Jakarta:</b> 2% (pertama), 2.5% (kedua), 3% (ketiga), dst.</li>
                            <li><b>Jawa Barat:</b> 1.75% (pertama), 2% (kedua), 2.25% (ketiga), dst.</li>
                        </ul>
                        <strong>Koefisien Bobot Otomatis:</strong>
                        <ul>
                            <li>Motor: <b>1.000</b></li>
                            <li>Sedan/Minibus/Jeep: <b>1.025</b> - <b>1.050</b></li>
                            <li>Bus/Truk: <b>1.100</b> - <b>1.300</b></li>
                        </ul>
                        <strong>Biaya SWDKLLJ Otomatis:</strong>
                        <ul>
                            <li>Motor s.d 250cc: <b>Rp 35.000</b></li>
                            <li>Motor > 250cc: <b>Rp 83.000</b></li>
                            <li>Mobil Penumpang: <b>Rp 143.000</b></li>
                            <li>Bus/Truk: <b>Rp 153.000</b> - <b>Rp 163.000</b></li>
                        </ul>
                    </div>

                    <div class="alert alert-warning mt-3" role="alert" style="font-size: 13px;">
                        <strong>Disclaimer:</strong> Kalkulator ini hanya bersifat estimasi. Perhitungan dapat berbeda sesuai kebijakan pemerintah daerah setempat.
                    </div>

                    {{-- ⬇️ Form Riwayat Ditaruh di Bawah Panduan --}}
                    @if(isset($history) && $history->count() > 0)
                    <div class="mt-4">
                        <form method="GET" action="{{ route('kalkulator.pkb') }}" class="history-select-form">
                            <label for="history_id" class="form-label"><strong>Riwayat Perhitungan (3 Hari Terakhir):</strong></label>
                            <select name="history_id" id="history_id" onchange="this.form.submit()" class="form-control" style="max-width: 100%;">
                                <option value="">-- Pilih Riwayat --</option>
                                @foreach($history as $item)
                                    <option value="{{ $item->id }}" {{ (isset($selected) && $selected->id == $item->id) ? 'selected' : '' }}>
                                        {{ $item->created_at->format('d-m-Y H:i') }} | Nilai: Rp{{ number_format($item->data['input']['njkb'] ?? 0, 0, ',', '.') }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                    @endif
                </div>


                
                {{-- Kolom Form (Kanan) --}}
                <div class="form-column">
                    <form method="POST" action="{{ route('pkb.hitung') }}">
                        @csrf
                        <div class="form-group">
                            <label for="njkb">NJKB (Nilai Jual Kendaraan Bermotor) <span class="required">*</span></label>
                            <input type="number" id="njkb" name="njkb" class="form-control" placeholder="Contoh: 150000000" value="{{ old('njkb') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="jenis_kendaraan">Jenis Kendaraan <span class="required">*</span></label>
                            <select id="jenis_kendaraan" name="jenis_kendaraan" class="form-select" required>
                                <option value="motor_dibawah_250cc" {{ old('jenis_kendaraan') == 'motor_dibawah_250cc' ? 'selected' : '' }}>Sepeda Motor s.d. 250cc</option>
                                <option value="motor_diatas_250cc" {{ old('jenis_kendaraan') == 'motor_diatas_250cc' ? 'selected' : '' }}>Sepeda Motor di atas 250cc</option>
                                <option value="sedan_jeep_minibus" {{ old('jenis_kendaraan', 'sedan_jeep_minibus') == 'sedan_jeep_minibus' ? 'selected' : '' }}>Mobil Penumpang (Sedan, Jeep, Minibus)</option>
                                <option value="bus_non_umum" {{ old('jenis_kendaraan') == 'bus_non_umum' ? 'selected' : '' }}>Bus (Bukan Angkutan Umum)</option>
                                <option value="truk_ringan" {{ old('jenis_kendaraan') == 'truk_ringan' ? 'selected' : '' }}>Truk Ringan / Pick Up</option>
                            </select>
                        </div>

                        {{-- DROPDOWN PROVINSI LENGKAP --}}
                        <div class="form-group">
                            <label for="provinsi">Provinsi Terdaftar <span class="required">*</span></label>
                            <select id="provinsi" name="provinsi" class="form-select" required>
                                <option value="aceh" {{ old('provinsi') == 'aceh' ? 'selected' : '' }}>Aceh</option>
                                <option value="sumatera_utara" {{ old('provinsi') == 'sumatera_utara' ? 'selected' : '' }}>Sumatera Utara</option>
                                <option value="sumatera_selatan" {{ old('provinsi') == 'sumatera_selatan' ? 'selected' : '' }}>Sumatera Selatan</option>
                                <option value="sumatera_barat" {{ old('provinsi') == 'sumatera_barat' ? 'selected' : '' }}>Sumatera Barat</option>
                                <option value="bengkulu" {{ old('provinsi') == 'bengkulu' ? 'selected' : '' }}>Bengkulu</option>
                                <option value="riau" {{ old('provinsi') == 'riau' ? 'selected' : '' }}>Riau</option>
                                <option value="kepulauan_riau" {{ old('provinsi') == 'kepulauan_riau' ? 'selected' : '' }}>Kepulauan Riau</option>
                                <option value="jambi" {{ old('provinsi') == 'jambi' ? 'selected' : '' }}>Jambi</option>
                                <option value="lampung" {{ old('provinsi') == 'lampung' ? 'selected' : '' }}>Lampung</option>
                                <option value="bangka_belitung" {{ old('provinsi') == 'bangka_belitung' ? 'selected' : '' }}>Bangka Belitung</option>
                                <option value="kalimantan_barat" {{ old('provinsi') == 'kalimantan_barat' ? 'selected' : '' }}>Kalimantan Barat</option>
                                <option value="kalimantan_timur" {{ old('provinsi') == 'kalimantan_timur' ? 'selected' : '' }}>Kalimantan Timur</option>
                                <option value="kalimantan_selatan" {{ old('provinsi') == 'kalimantan_selatan' ? 'selected' : '' }}>Kalimantan Selatan</option>
                                <option value="kalimantan_tengah" {{ old('provinsi') == 'kalimantan_tengah' ? 'selected' : '' }}>Kalimantan Tengah</option>
                                <option value="kalimantan_utara" {{ old('provinsi') == 'kalimantan_utara' ? 'selected' : '' }}>Kalimantan Utara</option>
                                <option value="banten" {{ old('provinsi') == 'banten' ? 'selected' : '' }}>Banten</option>
                                <option value="dki_jakarta" {{ old('provinsi', 'dki_jakarta') == 'dki_jakarta' ? 'selected' : '' }}>DKI Jakarta</option>
                                <option value="jawa_barat" {{ old('provinsi') == 'jawa_barat' ? 'selected' : '' }}>Jawa Barat</option>
                                <option value="jawa_tengah" {{ old('provinsi') == 'jawa_tengah' ? 'selected' : '' }}>Jawa Tengah</option>
                                <option value="di_yogyakarta" {{ old('provinsi') == 'di_yogyakarta' ? 'selected' : '' }}>DI Yogyakarta</option>
                                <option value="jawa_timur" {{ old('provinsi') == 'jawa_timur' ? 'selected' : '' }}>Jawa Timur</option>
                                <option value="bali" {{ old('provinsi') == 'bali' ? 'selected' : '' }}>Bali</option>
                                <option value="nusa_tenggara_timur" {{ old('provinsi') == 'nusa_tenggara_timur' ? 'selected' : '' }}>Nusa Tenggara Timur</option>
                                <option value="nusa_tenggara_barat" {{ old('provinsi') == 'nusa_tenggara_barat' ? 'selected' : '' }}>Nusa Tenggara Barat</option>
                                <option value="gorontalo" {{ old('provinsi') == 'gorontalo' ? 'selected' : '' }}>Gorontalo</option>
                                <option value="sulawesi_barat" {{ old('provinsi') == 'sulawesi_barat' ? 'selected' : '' }}>Sulawesi Barat</option>
                                <option value="sulawesi_tengah" {{ old('provinsi') == 'sulawesi_tengah' ? 'selected' : '' }}>Sulawesi Tengah</option>
                                <option value="sulawesi_utara" {{ old('provinsi') == 'sulawesi_utara' ? 'selected' : '' }}>Sulawesi Utara</option>
                                <option value="sulawesi_tenggara" {{ old('provinsi') == 'sulawesi_tenggara' ? 'selected' : '' }}>Sulawesi Tenggara</option>
                                <option value="sulawesi_selatan" {{ old('provinsi') == 'sulawesi_selatan' ? 'selected' : '' }}>Sulawesi Selatan</option>
                                <option value="maluku_utara" {{ old('provinsi') == 'maluku_utara' ? 'selected' : '' }}>Maluku Utara</option>
                                <option value="maluku" {{ old('provinsi') == 'maluku' ? 'selected' : '' }}>Maluku</option>
                                <option value="papua_barat" {{ old('provinsi') == 'papua_barat' ? 'selected' : '' }}>Papua Barat</option>
                                <option value="papua" {{ old('provinsi') == 'papua' ? 'selected' : '' }}>Papua</option>
                                <option value="papua_selatan" {{ old('provinsi') == 'papua_selatan' ? 'selected' : '' }}>Papua Selatan</option>
                                <option value="papua_tengah" {{ old('provinsi') == 'papua_tengah' ? 'selected' : '' }}>Papua Tengah</option>
                                <option value="papua_pegunungan" {{ old('provinsi') == 'papua_pegunungan' ? 'selected' : '' }}>Papua Pegunungan</option>
                                <option value="papua_barat_daya" {{ old('provinsi') == 'papua_barat_daya' ? 'selected' : '' }}>Papua Barat Daya</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="kepemilikan">Kepemilikan Kendaraan ke- <span class="required">*</span></label>
                            <select id="kepemilikan" name="kepemilikan" class="form-select" required>
                                <option value="1" {{ old('kepemilikan', '1') == '1' ? 'selected' : '' }}>1 (Pertama)</option>
                                <option value="2" {{ old('kepemilikan') == '2' ? 'selected' : '' }}>2 (Kedua)</option>
                                <option value="3" {{ old('kepemilikan') == '3' ? 'selected' : '' }}>3 (Ketiga)</option>
                                <option value="4" {{ old('kepemilikan') == '4' ? 'selected' : '' }}>4 (Keempat)</option>
                                <option value="5" {{ old('kepemilikan') == '5' ? 'selected' : '' }}>5 atau lebih</option>
                            </select>
                        </div>

                        <button type="submit" class="btn-hitung mt-4">Hitung PKB</button>
                        
                        {{-- Rincian Hasil Perhitungan --}}
                        @php
                            $hasil = null;
                            if(isset($selected) && $selected) {
                                $hasil = $selected->data['hasil'];
                            } elseif(session('hasil_pkb')) {
                                $hasil = session('hasil_pkb');
                            }
                        @endphp
                       @if($hasil)
                        <div class="result-breakdown mt-4">
                            <h5 class="guide-title">Rincian Pembayaran Tahunan Anda</h5>
                            <div class="form-group readonly">
                                <label>PKB Pokok</label>
                                <input type="text" class="form-control" value="Rp {{ number_format($hasil['pkb_pokok'], 0, ',', '.') }}" readonly>
                                <small class="formula-text">NJKB ({{ number_format($hasil['njkb']) }}) × Koefisien ({{ $hasil['koefisien'] }}) × Tarif ({{ $hasil['tarif_pajak'] * 100 }}%)</small>
                            </div>

                            <div class="form-group readonly">
                                <label>Opsen PKB (66%)</label>
                                <input type="text" class="form-control" value="Rp {{ number_format($hasil['opsen_pkb'], 0, ',', '.') }}" readonly>
                                <small class="formula-text">PKB Pokok ({{ number_format($hasil['pkb_pokok']) }}) × 66%</small>
                            </div>

                            <div class="form-group readonly">
                                <label>SWDKLLJ</label>
                                <input type="text" class="form-control" value="Rp {{ number_format($hasil['swdkllj'], 0, ',', '.') }}" readonly>
                                <small class="formula-text">Sumbangan Wajib Jasa Raharja (otomatis berdasarkan jenis kendaraan).</small>
                            </div>

                            <div class="form-group readonly result-total">
                                <label>Total Bayar (PKB + Opsen PKB + SWDKLLJ)</label>
                                <input type="text" class="form-control" value="Rp {{ number_format($hasil['total_bayar'], 0, ',', '.') }}" readonly>
                                <small class="formula-text">Ini adalah total estimasi yang Anda bayar untuk perpanjangan STNK tahunan.</small>
                            </div>
                            @if(isset($selected) && $selected)
                                <a href="{{ route('pkb.exportPDF', $selected->id) }}" target="_blank">
                                    <button type="button" class="btn btn-success mt-3">Download PDF</button>
                                </a>
                            @elseif($hasil)
                                <a href="{{ route('pkb.exportPDF') }}" target="_blank">
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