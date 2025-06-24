<?php

namespace App\Services;

class PkbService
{
    public static function hitungPkb($njkb, $jenis_kendaraan, $provinsi, $kepemilikan)
    {
        $koefisien = 1.000;
        $swdkllj = 0;
        switch ($jenis_kendaraan) {
            case 'motor_dibawah_250cc':
                $koefisien = 1.000;
                $swdkllj = 35000;
                break;
            case 'motor_diatas_250cc':
                $koefisien = 1.000;
                $swdkllj = 83000;
                break;
            case 'sedan_jeep_minibus':
                $koefisien = 1.025;
                $swdkllj = 143000;
                break;
            case 'bus_non_umum':
                $koefisien = 1.100;
                $swdkllj = 153000;
                break;
            case 'truk_ringan':
                $koefisien = 1.300;
                $swdkllj = 163000;
                break;
        }

        $tarif_pajak = 0;
        switch ($provinsi) {
            case 'dki_jakarta':
                $tarif_progresif = [1 => 0.02, 2 => 0.025, 3 => 0.03, 4 => 0.035];
                $tarif_pajak = $tarif_progresif[$kepemilikan] ?? 0.04;
                break;
            case 'jawa_barat':
            case 'jawa_tengah':
            case 'jawa_timur':
            case 'banten':
                $tarif_progresif = [1 => 0.0175, 2 => 0.02, 3 => 0.0225, 4 => 0.0250];
                $tarif_pajak = $tarif_progresif[$kepemilikan] ?? 0.0275;
                break;
            default:
                $tarif_progresif = [1 => 0.0175, 2 => 0.02, 3 => 0.0225, 4 => 0.0250];
                $tarif_pajak = $tarif_progresif[$kepemilikan] ?? 0.0275;
                break;
        }

        $pkb_pokok = $njkb * $koefisien * $tarif_pajak;
        $opsen_pkb = $pkb_pokok * 0.66;
        $total_bayar = $pkb_pokok + $opsen_pkb + $swdkllj;

        return [
            'njkb' => $njkb,
            'pkb_pokok' => $pkb_pokok,
            'opsen_pkb' => $opsen_pkb,
            'swdkllj' => $swdkllj,
            'total_bayar' => $total_bayar,
            'koefisien' => $koefisien,
            'tarif_pajak' => $tarif_pajak,
        ];
    }
}