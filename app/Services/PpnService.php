<?php

namespace App\Services;

class PpnService
{
    public static function hitungPpn($mekanisme, $nilai_transaksi, $persentase_dpp = null, $tarif_efektif = null)
    {
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
                $persentase_dpp = (float) $persentase_dpp;
                $dpp_efektif = $nilai_transaksi * ($persentase_dpp / 100);
                $ppn = $dpp_efektif * $tarif_umum;
                $dpp = $nilai_transaksi;
                $total = $dpp + $ppn;
                $keterangan_hasil = "PPN = Tarif Umum (11%) × (DPP Nilai Lain: " . $persentase_dpp . "% × Harga Jual)";
                break;

            case 'besaran_tertentu':
                $tarif_efektif = (float) $tarif_efektif;
                $dpp = $nilai_transaksi;
                $ppn = $dpp * ($tarif_efektif / 100);
                $total = $dpp + $ppn;
                $keterangan_hasil = "PPN = Tarif Efektif (" . $tarif_efektif . "%) × Harga Jual";
                break;
        }

        return [
            'dpp' => $dpp,
            'ppn' => $ppn,
            'total' => $total,
            'keterangan_hasil' => $keterangan_hasil,
        ];
    }
}