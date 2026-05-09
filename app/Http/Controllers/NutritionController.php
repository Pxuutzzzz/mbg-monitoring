<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NutritionController extends Controller
{
    public function index(Request $request)
    {
        // Kategori penerima manfaat sesuai Juklak MBG BGN 2026
        // Porsi Kecil (~400-500 Kkal): PAUD/TK, SD Kelas 1-3, Balita
        // Porsi Besar (~600-700 Kkal): SD Kelas 4-6, SMP, SMA/SMK, Pesantren
        // Penerima khusus: Ibu Hamil, Ibu Menyusui, Guru/Pendidik
        $activeTab = $request->query('tab', 'SD Kelas 4-6');
        $validTabs = [
            // Porsi Kecil
            'PAUD/TK',
            'SD Kelas 1-3',
            'Balita',
            // Porsi Besar
            'SD Kelas 4-6',
            'SMP',
            'SMA/SMK',
            // Pesantren (dengan sub-jenjang formal)
            'Pesantren - RA/TK',
            'Pesantren - MI Kelas 1-3',
            'Pesantren - MI Kelas 4-6',
            'Pesantren - MTs',
            'Pesantren - MA/MAK',
            'Pesantren - Santri',
            // Khusus
            'Ibu Hamil',
            'Ibu Menyusui',
            'Guru/Pendidik',
        ];
        if (!in_array($activeTab, $validTabs)) {
            $activeTab = 'SD Kelas 4-6';
        }

        $sppgId = $request->query('sppg_id');
        $today = date('Y-m-d');
        $tomorrow = \Carbon\Carbon::tomorrow()->format('Y-m-d');

        // Fetch all SPPGs for the dropdown
        $allSppgs = \App\Models\Sppg::orderBy('name', 'asc')->get();

        $menuToday = null;
        $menuTomorrow = null;
        $recapMenus = null;
        $selectedSppg = null;

        if ($sppgId) {
            // Skenario A: Mitra Dipilih
            $selectedSppg = \App\Models\Sppg::find($sppgId);
            $menuToday = \App\Models\Menu::with('sppg')
                            ->where('sppg_id', $sppgId)
                            ->where('target_group', $activeTab)
                            ->where('serve_date', $today)
                            ->first();
                            
            $menuTomorrow = \App\Models\Menu::with('sppg')
                                ->where('sppg_id', $sppgId)
                                ->where('target_group', $activeTab)
                                ->where('serve_date', $tomorrow)
                                ->first();
        } else {
            // Skenario B: Rekapitulasi Nasional (Ambil semua menu hari ini/besok untuk tab tersebut)
            $recapMenus = \App\Models\Menu::with('sppg')
                            ->where('target_group', $activeTab)
                            ->whereIn('serve_date', [$today, $tomorrow])
                            ->orderBy('serve_date', 'asc')
                            ->get();
        }

        // Also fetch historical audit data for the bottom table (if needed)
        $nutritions = \App\Models\Nutrition::with('delivery.sppg')->orderBy('created_at', 'desc')->take(10)->get();
        
        return view('nutrition.index', compact('activeTab', 'validTabs', 'menuToday', 'menuTomorrow', 'recapMenus', 'allSppgs', 'sppgId', 'selectedSppg', 'nutritions'));
    }

    public function exportPdf()
    {
        $nutritions = \App\Models\Nutrition::with('delivery.sppg')->orderBy('created_at', 'desc')->get();
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('nutrition.pdf', compact('nutritions'));
        return $pdf->download('Audit_Nutrisi_MBG.pdf');
    }
}
