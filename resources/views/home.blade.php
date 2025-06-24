{{-- <!-- filepath: resources/views/home.blade.php -->
@extends('layouts.app')

@section('title', 'Kalkulator Pajak')

@section('content')
    <h2>Selamat datang di Kalkulator Pajak!</h2>
    <p>Pilih jenis pajak di menu atas untuk memulai.</p>
@endsection --}}



@extends('layouts.app')

@section('title', 'Kalkulator Pajak Indonesia')

@section('content')
<div class="tax-calculator-page home-page">
    {{-- Latar Biru di Atas --}}
    <div class="home-hero-bg"></div>

    {{-- Header --}}
    <header class="tax-header">
        <img src="{{ asset('images/icon.png') }}" alt="Calculator Icon" class="header-icon">
        <h1>Kalkulator Pajak</h1>
    </header>

    {{-- Hero Section --}}
    <section class="home-hero">
        <div class="intro-text text-center">
            <h2>Solusi Cepat & Akurat untuk Perhitungan Pajak Anda</h2>
            <p class="fs-5">Hitung PPh 21, PPN, dan PKB dengan mudah. Dapatkan estimasi pajak tahunan Anda dalam hitungan detik berdasarkan peraturan terbaru.</p>
        </div>
        <div class="intro-illustration home-illustration">
            <img src="{{ asset('images/gambar.png') }}" alt="Ilustrasi Pajak">
        </div>
    </section>

    {{-- Calculator Selection Section --}}
    <section class="calculator-selection">
        <h3 class="section-title">Pilih Kalkulator yang Anda Butuhkan</h3>
        <div class="calculator-grid">
            
            {{-- Card PPh 21 --}}
            <a href="{{ route('kalkulator.pph') }}" class="calculator-card">
                <h3>Kalkulator PPh 21</h3>
                <p>Hitung estimasi pajak penghasilan tahunan Anda sebagai pegawai tetap. Dilengkapi panduan PTKP dan tarif progresif.</p>
                <span class="btn-link">Mulai Hitung &raquo;</span>
            </a>

            {{-- Card PPN --}}
            <a href="{{ route('kalkulator.ppn') }}" class="calculator-card">
                <h3>Kalkulator PPN</h3>
                <p>Hitung Pajak Pertambahan Nilai dengan berbagai skema, termasuk tarif umum dan besaran tertentu untuk usaha spesifik.</p>
                <span class="btn-link">Mulai Hitung &raquo;</span>
            </a>

            {{-- Card PKB --}}
            <a href="{{ route('kalkulator.pkb') }}" class="calculator-card">
                <h3>Kalkulator PKB</h3>
                <p>Hitung estimasi pajak kendaraan bermotor tahunan, lengkap dengan Opsen PKB dan SWDKLLJ sesuai peraturan daerah.</p>
                <span class="btn-link">Mulai Hitung &raquo;</span>
            </a>

        </div>
    </section>

    {{-- Footer --}}
    <footer class="site-footer">
        <div class="footer-content">
            <p>&copy; {{ date('Y') }} Kalkulator Pajak. Dibuat untuk kemudahan perhitungan pajak Anda.</p>
        </div>
    </footer>
</div>
@endsection