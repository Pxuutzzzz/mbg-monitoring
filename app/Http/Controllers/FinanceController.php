<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FinanceController extends Controller
{
    public function index(Request $request)
    {
        $sppgId = $request->query('sppg_id');
        $allSppgs = \App\Models\Sppg::orderBy('name', 'asc')->get();

        $selectedSppg = null;
        $totalBudget = 0;
        $totalPortions = 0;
        $costPerPortion = 0;
        
        if ($sppgId) {
            $selectedSppg = \App\Models\Sppg::find($sppgId);
            
            // Get records specifically for this SPPG
            $records = \App\Models\FinancialRecord::with('sppg')
                        ->where('sppg_id', $sppgId)
                        ->orderBy('date', 'desc')
                        ->get();
            
            // Calculate Total Budget spent by this SPPG
            $totalBudget = $records->sum('total');

            // Calculate Total Portions delivered by this SPPG
            $totalPortions = \App\Models\Delivery::where('sppg_id', $sppgId)->sum('portions');

            // Unit Cost
            if ($totalPortions > 0) {
                $costPerPortion = $totalBudget / $totalPortions;
            }
        } else {
            // National View
            $records = \App\Models\FinancialRecord::with('sppg')->orderBy('date', 'desc')->get();
        }

        return view('finance.index', compact(
            'records', 'allSppgs', 'sppgId', 'selectedSppg', 
            'totalBudget', 'totalPortions', 'costPerPortion'
        ));
    }

    public function exportPdf()
    {
        $records = \App\Models\FinancialRecord::with('sppg')->orderBy('date', 'desc')->get();
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('finance.pdf', compact('records'));
        return $pdf->download('Rekapitulasi_Keuangan_MBG.pdf');
    }

    public function uploadInvoice(Request $request)
    {
        $request->validate([
            'invoice' => 'required|mimes:pdf,jpg,jpeg,png|max:5120',
            'portions' => 'required|integer|min:1',
        ]);

        if ($request->hasFile('invoice')) {
            $path = $request->file('invoice')->store('invoices', 'public');
            // Normally we would save $path to DB here
        }

        return redirect()->back()->with('success', 'Dokumen SPPG berhasil diotorisasi dan diunggah.');
    }
}
