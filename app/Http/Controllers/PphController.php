<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie; 
use Illuminate\Support\Str;

use App\Services\PphService;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Calculation;



class PphController extends Controller
{
    public function showForm(Request $request)
    {
        $anonId = $request->cookie('anon_id');
        $history = Calculation::where('anon_id', $anonId)
            ->where('created_at', '>=', now()->subDays(3))
            ->where('data->type', 'pph')
            ->orderBy('created_at', 'desc')
            ->get();

        // Jika ada request history_id, ambil data terpilih
        $selected = null;
        if ($request->has('history_id')) {
            $selected = Calculation::where('anon_id', $anonId)
                ->where('id', $request->input('history_id'))
                ->first();
        }

        return view('penghasilan.pph', [
            'history' => $history,
            'selected' => $selected,
        ]);
    }

    public function hitung(Request $request)
    {
        $request->validate([
            'pendapatan' => 'required|numeric|min:0',
            'tunjangan' => 'required|numeric|min:0',
            'iuran_pensiun' => 'required|numeric|min:0',
            'status' => 'required|string',
            'tanggungan' => 'required|integer|min:0|max:3',
        ]);

        $hasil = PphService::hitungPph(
            $request->input('pendapatan'),
            $request->input('tunjangan'),
            $request->input('iuran_pensiun'),
            $request->input('status'),
            $request->input('tanggungan')
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
                'type' => 'pph', // atau 'ppn', 'pkb'
            ],
            'created_at' => now(),
        ]);

        return back()
            ->with('success', 'Perhitungan berhasil! Data tersimpan di riwayat.')
            ->with('hasil_pph', $hasil)
            ->withInput($request->all());
            }

    public function exportPdf(Request $request, $id = null)
    {
        $hasil = null;
        $input = null;
        $anonId = $request->cookie('anon_id');

        // Jika ada id (riwayat), ambil dari database
        if ($id) {
            $item = \App\Models\Calculation::where('id', $id)
                ->where('anon_id', $anonId)
                ->where('data->type', 'pph')
                ->first();
            if ($item) {
                $hasil = $item->data['hasil'] ?? null;
                $input = $item->data['input'] ?? null;
            }
        }

        // Jika tidak ada id, ambil dari session (hasil baru)
        if (!$hasil) {
            $hasil = session('hasil_pph');
            $input = session()->getOldInput();
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('penghasilan.pph_pdf', compact('hasil', 'input'));
        return $pdf->download('hasil_pph.pdf');
    }
}