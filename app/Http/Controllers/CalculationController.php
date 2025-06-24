<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Calculation;

class CalculationController extends Controller
{
    public function index(Request $request)
    {
        $anonId = $request->cookie('anon_id');
        $calculations = Calculation::where('anon_id', $anonId)
            ->where('created_at', '>=', now()->subDays(3))
            ->orderBy('created_at', 'desc')
            ->get();

        return view('calculation.history', compact('calculations'));
    }
}