<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Penghasilan;
use App\Http\Controllers\Controller;
use \App\Services\PkbService;
use \App\Services\PpnService;
use \App\Services\PphService;


class PenghasilanController extends Controller
{
        public function index(Request $request)
    {
        $anonId = $request->cookie('anon_id');
        $data = Penghasilan::where('user_id', $anonId)->get();
        return view('dashboard', compact('data'));
    }

    public function store(Request $request)
    {
        $anonId = $request->cookie('anon_id');
        $penghasilan = new Penghasilan();
        $penghasilan->user_id = $anonId;
        $penghasilan->nama = $request->nama;
        $penghasilan->gaji_bulanan = $request->gaji_bulanan;

        $tarif = 0.11;
        $dpp = $request->gaji_bulanan;

        if ($request->input('sudah_termasuk_ppn')) {
            $hasil = $dpp;
            $pajak = 0;
        } else {
            $hasil = $dpp * (1 + $tarif);
            $pajak = $hasil - $dpp;
        }

        $penghasilan->pajak = $pajak;
        $penghasilan->save();

        return redirect()->back()->with('success', 'Data berhasil disimpan!');
    }

    public function exportPDF(Request $request)
    {
        $anonId = $request->cookie('anon_id');
        $data = Penghasilan::where('user_id', $anonId)->get();
        $pdf = Pdf::loadView('penghasilan.pdf', compact('data'));
        return $pdf->download('data_pajak_saya.pdf');
    }

    public function showPph()
    {
        return view('penghasilan.pph');
    }


public function hitungPpn(Request $request)
{
    $request->validate([
        'mekanisme' => 'required|in:standar,dpp_nilai_lain,besaran_tertentu',
        'nilai_transaksi' => 'required|numeric|min:0',
        'persentase_dpp' => 'nullable|numeric|min:0|max:100',
        'tarif_efektif' => 'nullable|numeric|min:0|max:100',
    ]);

    $hasil = PpnService::hitungPpn(
        $request->input('mekanisme'),
        (float) $request->input('nilai_transaksi'),
        $request->input('persentase_dpp'),
        $request->input('tarif_efektif')
    );

    return back()
        ->with('hasil_ppn', $hasil)
        ->withInput($request->all());
}

    public function showPkb()
    {
        return view('penghasilan.pkb');
    }

public function hitungPkb(Request $request)
{
    $request->validate([
        'njkb' => 'required|numeric|min:0',
        'jenis_kendaraan' => 'required|string',
        'provinsi' => 'required|string',
        'kepemilikan' => 'required|integer|min:1',
    ]);

    $hasil = PkbService::hitungPkb(
        (float) $request->input('njkb'),
        $request->input('jenis_kendaraan'),
        $request->input('provinsi'),
        (int) $request->input('kepemilikan')
    );

    return back()
        ->with('hasil_pkb', $hasil)
        ->withInput($request->all());
}

}