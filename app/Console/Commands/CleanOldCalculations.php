<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Calculation;
use Carbon\Carbon;

class CleanOldCalculations extends Command
{
    protected $signature = 'calculations:clean-old';
    protected $description = 'Hapus data calculation yang lebih dari 3 hari';

    public function handle()
    {
        $deleted = Calculation::where('created_at', '<', Carbon::now()->subDays(3))->delete();
        $this->info("Berhasil menghapus $deleted data calculation lama.");
    }
}