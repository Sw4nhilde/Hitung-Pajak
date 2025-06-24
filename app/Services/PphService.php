<?php

namespace App\Services;

class PphService
{
    public static function hitungPph($pendapatan, $tunjangan, $iuran_pensiun, $status, $tanggungan)
    {
        // 1. Penghasilan Bruto
        $pendapatan_sebulan = (float) $pendapatan;
        $tunjangan_sebulan = (float) $tunjangan;
        $bruto_sebulan = $pendapatan_sebulan + $tunjangan_sebulan;
        $bruto_setahun = $bruto_sebulan * 12;

        // 2. Pengurang
        $biaya_jabatan_setahun = min($bruto_setahun * 0.05, 6000000);
        $iuran_pensiun_setahun = (float) $iuran_pensiun * 12;
        $total_pengurang_setahun = $biaya_jabatan_setahun + $iuran_pensiun_setahun;

        // 3. Neto
        $neto_setahun = $bruto_setahun - $total_pengurang_setahun;

        // 4. PTKP
        $ptkp_pribadi = 54000000;
        $ptkp_kawin = ($status == 'menikah') ? 4500000 : 0;
        $ptkp_tanggungan = (int) $tanggungan * 4500000;
        $total_ptkp = $ptkp_pribadi + $ptkp_kawin + $ptkp_tanggungan;

        // 5. PKP
        $pkp = max(0, $neto_setahun - $total_ptkp);
        $pkp = floor($pkp / 1000) * 1000;

        // 6. Pajak Terutang
        $pajak_setahun = 0;
        if ($pkp > 0) {
            if ($pkp <= 60000000) {
                $pajak_setahun = $pkp * 0.05;
            } elseif ($pkp <= 250000000) {
                $pajak_setahun = (60000000 * 0.05) + (($pkp - 60000000) * 0.15);
            } elseif ($pkp <= 500000000) {
                $pajak_setahun = (60000000 * 0.05) + (190000000 * 0.15) + (($pkp - 250000000) * 0.25);
            } elseif ($pkp <= 5000000000) {
                $pajak_setahun = (60000000 * 0.05) + (190000000 * 0.15) + (250000000 * 0.25) + (($pkp - 500000000) * 0.30);
            } else {
                $pajak_setahun = (60000000 * 0.05) + (190000000 * 0.15) + (250000000 * 0.25) + (4500000000 * 0.30) + (($pkp - 5000000000) * 0.35);
            }
        }

        return [
            'bruto_setahun' => $bruto_setahun,
            'total_pengurang_setahun' => $total_pengurang_setahun,
            'neto_setahun' => $neto_setahun,
            'total_ptkp' => $total_ptkp,
            'pkp' => $pkp,
            'pajak_setahun' => $pajak_setahun,
        ];
    }
}