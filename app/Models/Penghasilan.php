<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Penghasilan extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'gaji_bulanan', 'pajak', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function hitungPajak()
    {
        $penghasilan_tahunan = $this->gaji_bulanan * 12;
        if ($penghasilan_tahunan <= 54000000) {
            return 0;
        }
        return ($penghasilan_tahunan - 54000000) * 0.05;
    }
}
