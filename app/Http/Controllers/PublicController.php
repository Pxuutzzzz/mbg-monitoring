<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index()
    {
        $deliveries = \App\Models\Delivery::with('sppg')->latest()->take(20)->get();
        $sppgs      = \App\Models\Sppg::all();
        $totalSppg  = $sppgs->count();
        $totalPortions = \App\Models\Delivery::sum('portions');
        $totalBudget   = \App\Models\FinancialRecord::sum('total');
        return view('dashboard', compact('deliveries', 'sppgs', 'totalSppg', 'totalPortions', 'totalBudget'));
    }
}
