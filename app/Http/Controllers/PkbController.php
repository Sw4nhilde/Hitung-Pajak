<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PkbService;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Calculation;
;
use Illuminate\Support\Facades\Cookie; 
use Illuminate\Support\Str;

class PkbController extends Controller
{
    public function showForm(Request $request)
    {
        $anonId = $request->cookie('anon_id');
        $history = \App\Models\Calculation::where('anon_id', $anonId)
            ->where('created_at', '>=', now()->subDays(3))
            ->where('data->type', 'pkb') // atau 'ppn'
            ->orderBy('created_at', 'desc')
            ->get();

        $selected = null;
        if ($request->has('history_id')) {
            $selected = \App\Models\Calculation::where('anon_id', $anonId)
                ->where('id', $request->input('history_id'))
                ->first();
        }

        return view('penghasilan.pkb', compact('history', 'selected'));
    }

    public function hitung(Request $request)
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

        // Ambil anon_id dari cookie, jika tidak ada buat baru
        $anonId = $request->cookie('anon_id');
        if (!$anonId) {
            $anonId = (string) Str::uuid();
            Cookie::queue('anon_id', $anonId, 60 * 24 * 3); // 3 hari
        }

        // Simpan ke database
        \App\Models\Calculation::create([
            'anon_id' => $anonId,
            'data' => [
                'input' => $request->all(),
                'hasil' => $hasil,
                'type' => 'pkb', // atau 'ppn', 'pkb'
            ],
            'created_at' => now(),
        ]);

        return back()
            ->with('success', 'Perhitungan berhasil! Data tersimpan di riwayat.')
            ->with('hasil_pkb', $hasil)
            ->withInput($request->all());
    }

        public function exportPdf(Request $request, $id = null)
        {
            $hasil = null;
            $anonId = $request->cookie('anon_id');

            // Jika ada id (riwayat), ambil dari database
            if ($id) {
                $item = \App\Models\Calculation::where('id', $id)
                    ->where('anon_id', $anonId)
                    ->where('data->type', 'pkb')
                    ->first();
                if ($item) {
                    $hasil = $item->data['hasil'] ?? null;
                }
            }

            // Jika tidak ada id, ambil dari session (hasil baru)
            if (!$hasil) {
                $hasil = session('hasil_pkb');
            }

            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('penghasilan.pkb_pdf', compact('hasil'));
            return $pdf->download('hasil_pkb.pdf');
        }
}