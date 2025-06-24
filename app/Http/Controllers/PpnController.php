<?php

namespace App\Http\Controllers;

use App\Models\Calculation;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;


use Illuminate\Support\Facades\Cookie; 
use Illuminate\Support\Str;

class PPNController extends Controller
{
    public function showForm(Request $request)
    {
        $anonId = $request->cookie('anon_id');
        if (!$anonId) {
            $anonId = (string) \Illuminate\Support\Str::uuid();
            Cookie::queue('anon_id', $anonId, 60 * 24 * 30); // 30 hari
        }

        $history = \App\Models\Calculation::where('anon_id', $anonId)
            ->where('created_at', '>=', now()->subDays(3))
            ->where('data->type', 'ppn')
            ->orderBy('created_at', 'desc')
            ->get();

        $selected = null;
        if ($request->has('history_id')) {
            $selected = \App\Models\Calculation::where('anon_id', $anonId)
                ->where('id', $request->input('history_id'))
                ->first();
        }

        return view('penghasilan.ppn', compact('history', 'selected'));
    }

    public function hitung(Request $request)
    {
        $request->validate([
            'mekanisme' => 'required|in:standar,dpp_nilai_lain,besaran_tertentu',
            'nilai_transaksi' => 'required|numeric|min:0',
            'persentase_dpp' => 'nullable|numeric|min:0|max:100',
            'tarif_efektif' => 'nullable|numeric|min:0|max:100',
        ]);

        $mekanisme = $request->input('mekanisme');
        $nilai_transaksi = (float) $request->input('nilai_transaksi');
        $tarif_umum = 0.11;

        $dpp = 0;
        $ppn = 0;
        $total = 0;
        $keterangan_hasil = '';

        switch ($mekanisme) {
            case 'standar':
                $dpp = $nilai_transaksi;
                $ppn = $dpp * $tarif_umum;
                $total = $dpp + $ppn;
                $keterangan_hasil = "PPN = Tarif Umum (11%) × DPP";
                break;

            case 'dpp_nilai_lain':
                $persentase_dpp = (float) $request->input('persentase_dpp', 0);
                $dpp_efektif = $nilai_transaksi * ($persentase_dpp / 100);
                $ppn = $dpp_efektif * $tarif_umum;
                $dpp = $nilai_transaksi;
                $total = $dpp + $ppn;
                $keterangan_hasil = "PPN = Tarif Umum (11%) × (DPP Nilai Lain: " . $persentase_dpp . "% × Harga Jual)";
                break;

            case 'besaran_tertentu':
                $tarif_efektif = (float) $request->input('tarif_efektif', 0);
                $dpp = $nilai_transaksi;
                $ppn = $dpp * ($tarif_efektif / 100);
                $total = $dpp + $ppn;
                $keterangan_hasil = "PPN = Tarif Efektif (" . $tarif_efektif . "%) × Harga Jual";
                break;
        }

        // Tambahkan kode berikut untuk menyimpan ke database
        $anonId = $request->cookie('anon_id');
        if (!$anonId) {
            $anonId = (string) \Illuminate\Support\Str::uuid();
            Cookie::queue('anon_id', $anonId, 60 * 24 * 30); // 30 hari
        }

        \App\Models\Calculation::create([
            'anon_id' => $anonId,
            'data' => [
                'input' => $request->all(),
                'hasil' => [
                    'dpp' => $dpp,
                    'ppn' => $ppn,
                    'total' => $total,
                    'keterangan_hasil' => $keterangan_hasil,
                ],
                'type' => 'ppn',
            ],
            'created_at' => now(),
        ]);

        return back()
            ->with('hasil_ppn', [
                'dpp' => $dpp,
                'ppn' => $ppn,
                'total' => $total,
                'keterangan_hasil' => $keterangan_hasil,
            ])
            ->withInput($request->all());
    }

    // public function exportPdf(Request $request)
    // {
    //     // Ambil hasil dari session
    //     $hasil = session('hasil_ppn');

    //     // Jika ada id riwayat terpilih, ambil dari database
    //     if ($request->has('history_id')) {
    //         $anonId = $request->cookie('anon_id');
    //         $item = \App\Models\Calculation::where('id', $request->input('history_id'))
    //             ->where('anon_id', $anonId)
    //             ->where('data->type', 'ppn')
    //             ->first();
    //         if ($item) {
    //             $hasil = $item->data['hasil'] ?? null;
    //         }
    //     }

    //     $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('penghasilan.ppn_pdf', compact('hasil'));
    //     return $pdf->download('hasil_ppn.pdf');
    // }

    public function exportPdf(Request $request, $id = null)
    {
        $hasil = null;
        $anonId = $request->cookie('anon_id');

        // Jika ada id (riwayat), ambil dari database
        if ($id) {
            $item = \App\Models\Calculation::where('id', $id)
                ->where('anon_id', $anonId)
                ->where('data->type', 'ppn')
                ->first();
            if ($item) {
                $hasil = $item->data['hasil'] ?? null;
            }
        }

        // Jika tidak ada id, ambil dari session (hasil baru)
        if (!$hasil) {
            $hasil = session('hasil_ppn');
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('penghasilan.ppn_pdf', compact('hasil'));
        return $pdf->download('hasil_ppn.pdf');
    }

    public function showPpnForm(Request $request)
    {
        $anonId = $request->cookie('anon_id');
        if (!$anonId) {
            $anonId = (string) \Illuminate\Support\Str::uuid();
            Cookie::queue('anon_id', $anonId, 60 * 24 * 30); // 30 hari
            return redirect()->route('kalkulator.ppn');
        }

        $history = \App\Models\Calculation::where('anon_id', $anonId)
            ->where('created_at', '>=', now()->subDays(3))
            ->where('data->type', 'ppn')
            ->orderBy('created_at', 'desc')
            ->get();

        $selected = null;
        if ($request->has('history_id')) {
            $selected = \App\Models\Calculation::where('anon_id', $anonId)
                ->where('id', $request->input('history_id'))
                ->first();
        }

        // Ambil hasil dari riwayat terpilih atau dari session
        if ($selected) {
            $hasil = $selected->data['hasil'] ?? null;
        } elseif (session('hasil_ppn')) {
            $hasil = session('hasil_ppn');
        } else {
            $hasil = null;
        }

        return view('penghasilan.ppn', compact('history', 'selected', 'hasil'));
    }
    }
