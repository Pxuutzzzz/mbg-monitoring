<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FinancialRecord;
use App\Models\Delivery;
use App\Models\Sppg;
use App\Models\Menu;
use Carbon\Carbon;

class FinanceSeeder extends Seeder
{
    /*
     * BGN 2026 Juklak:
     * - Bahan baku: Rp 8.000 – Rp 10.000 / porsi
     * - Dana operasional: Rp 3.000 / porsi
     * - Total per porsi: Rp 11.000 – Rp 13.000
     *
     * Porsi Kecil (PAUD/TK, SD 1-3, Balita):
     *   Bahan baku: Rp 7.000 – Rp 8.500 (volume lebih kecil)
     * Porsi Besar (SD 4-6, SMP, SMA, Pesantren):
     *   Bahan baku: Rp 8.500 – Rp 10.000
     * Khusus (Ibu Hamil, Ibu Menyusui, Guru):
     *   Bahan baku: Rp 8.000 – Rp 9.500
     *
     * Max produksi per SPPG: 2.500 porsi/hari
     *   2.000 porsi anak sekolah (Porsi Besar ~70%, Porsi Kecil ~30%)
     *   500 porsi ibu & balita
     * Untuk simulasi "6-7 juta" → gunakan 550-650 total porsi (SPPG skala kecil-menengah)
     */

    private static array $PORSI_KECIL_TARGETS = ['PAUD/TK', 'SD Kelas 1-3', 'Balita'];
    private static array $PORSI_BESAR_TARGETS  = ['SD Kelas 4-6', 'SMP', 'SMA/SMK', 'Pesantren'];

    /**
     * Estimate realistic per-component unit price per portion size.
     * Returns ['besar' => price, 'kecil' => price]
     */
    private function estimateComponentPrice(string $componentName): array
    {
        $c = strtolower($componentName);

        // Protein hewani
        if (str_contains($c, 'daging') || str_contains($c, 'rendang') || str_contains($c, 'gulai'))
            return ['besar' => rand(3500, 4500), 'kecil' => rand(2200, 3000)];
        if (str_contains($c, 'ayam') || str_contains($c, 'sate') || str_contains($c, 'geprek') || str_contains($c, 'bakar'))
            return ['besar' => rand(2800, 3800), 'kecil' => rand(1800, 2600)];
        if (str_contains($c, 'ikan') || str_contains($c, 'tongkol') || str_contains($c, 'kembung') || str_contains($c, 'salmon') || str_contains($c, 'gurame') || str_contains($c, 'gabus'))
            return ['besar' => rand(2500, 3500), 'kecil' => rand(1600, 2400)];
        if (str_contains($c, 'telur') || str_contains($c, 'sosis'))
            return ['besar' => rand(1800, 2500), 'kecil' => rand(1200, 1800)];

        // Susu & minuman (tetap relatif sama untuk semua porsi)
        if (str_contains($c, 'susu') || str_contains($c, 'jus') || str_contains($c, 'kurma'))
            return ['besar' => rand(2000, 2800), 'kecil' => rand(1800, 2500)];

        // Makanan pokok — porsi besar lebih banyak nasi
        if (str_contains($c, 'nasi') || str_contains($c, 'bubur') || str_contains($c, 'kentang') || str_contains($c, 'ubi'))
            return ['besar' => rand(1500, 2200), 'kecil' => rand(900, 1500)];

        // Protein nabati (tahu/tempe)
        if (str_contains($c, 'tempe') || str_contains($c, 'tahu') || str_contains($c, 'kacang'))
            return ['besar' => rand(800, 1400), 'kecil' => rand(500, 900)];

        // Sayur & buah
        if (str_contains($c, 'sayur') || str_contains($c, 'tumis') || str_contains($c, 'bening') || str_contains($c, 'lodeh') || str_contains($c, 'sup') || str_contains($c, 'asem') || str_contains($c, 'sawi') || str_contains($c, 'kangkung') || str_contains($c, 'bayam') || str_contains($c, 'brokoli') || str_contains($c, 'wortel'))
            return ['besar' => rand(900, 1500), 'kecil' => rand(600, 1000)];
        if (str_contains($c, 'buah') || str_contains($c, 'pisang') || str_contains($c, 'melon') || str_contains($c, 'jeruk') || str_contains($c, 'apel') || str_contains($c, 'pepaya') || str_contains($c, 'semangka') || str_contains($c, 'jambu') || str_contains($c, 'naga'))
            return ['besar' => rand(800, 1300), 'kecil' => rand(600, 1000)];

        // Lalapan, bumbu, pelengkap
        return ['besar' => rand(300, 700), 'kecil' => rand(200, 500)];
    }

    public function run(): void
    {
        $driver = \Illuminate\Support\Facades\DB::getDriverName();
        if ($driver === 'sqlite') {
            \Illuminate\Support\Facades\DB::statement('PRAGMA foreign_keys = OFF;');
        } else {
            \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }

        \App\Models\Nutrition::truncate();
        FinancialRecord::truncate();
        Delivery::truncate();

        if ($driver === 'sqlite') {
            \Illuminate\Support\Facades\DB::statement('PRAGMA foreign_keys = ON;');
        } else {
            \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }

        $sppgs = Sppg::all();
        if ($sppgs->isEmpty()) return;

        $dates = [
            Carbon::today()->format('Y-m-d'),
            Carbon::yesterday()->format('Y-m-d'),
            Carbon::now()->subDays(2)->format('Y-m-d'),
        ];

        foreach ($sppgs as $sppg) {
            foreach ($dates as $date) {
                /*
                 * Per Juklak BGN 2026 (skala menengah SPPG):
                 *   Porsi Besar (SD 4-6, SMP, SMA, Pesantren): ~350-450 porsi
                 *   Porsi Kecil (PAUD/TK, SD 1-3, Balita, Ibu Hamil/Menyusui, Guru): ~150-200 porsi
                 *   Total: ~500-650 porsi → total anggaran ~6-8 juta
                 */
                $portionsBesar = rand(350, 450);
                $portionsKecil = rand(150, 200);
                $totalPortions = $portionsBesar + $portionsKecil;

                $delivery = Delivery::create([
                    'status'         => 'delivered',
                    'lat'            => -6.200000 + (rand(-300, 300) / 10000),
                    'lng'            => 106.816666 + (rand(-300, 300) / 10000),
                    'portions'       => $totalPortions,
                    'portions_besar' => $portionsBesar,
                    'portions_kecil' => $portionsKecil,
                    'sppg_id'        => $sppg->id,
                    'created_at'     => $date,
                ]);

                \App\Models\Nutrition::create([
                    'calories'    => rand(600, 700),  // rata-rata porsi besar
                    'protein_g'   => rand(22, 32),
                    'karbo_g'     => rand(80, 100),
                    'delivery_id' => $delivery->id,
                    'created_at'  => $date,
                ]);

                // Ambil menu real (prioritas SPPG ini, fallback random)
                $menu = Menu::where('sppg_id', $sppg->id)->where('serve_date', $date)->first()
                     ?? Menu::where('serve_date', $date)->inRandomOrder()->first();

                // Build component pricing breakdown
                $breakdown = [];
                $totalBesarUnit = 0;
                $totalKecilUnit = 0;

                if ($menu) {
                    $components = array_map('trim', explode('+', $menu->food_name));
                    foreach ($components as $component) {
                        $prices = $this->estimateComponentPrice($component);
                        $breakdown[$component] = $prices;
                        $totalBesarUnit += $prices['besar'];
                        $totalKecilUnit += $prices['kecil'];
                    }
                } else {
                    // Fallback (sesuai standar 4 komponen BGN)
                    $breakdown = [
                        'Makanan Pokok (Nasi/Karbohidrat)' => ['besar' => 2000, 'kecil' => 1200],
                        'Lauk Protein Hewani'               => ['besar' => 3500, 'kecil' => 2200],
                        'Lauk Protein Nabati (Tempe/Tahu)'  => ['besar' => 1000, 'kecil' => 700],
                        'Sayuran + Buah'                    => ['besar' => 1200, 'kecil' => 900],
                        'Susu UHT'                          => ['besar' => 2300, 'kecil' => 2000],
                    ];
                    foreach ($breakdown as $prices) {
                        $totalBesarUnit += $prices['besar'];
                        $totalKecilUnit += $prices['kecil'];
                    }
                }

                // Sesuai Juklak BGN: dana operasional Rp 3.000/porsi
                $operasionalBesarUnit = 3000;
                $operasionalKecilUnit = 3000;

                $bahanTotal = ($totalBesarUnit * $portionsBesar) + ($totalKecilUnit * $portionsKecil);
                $operasionalTotal = ($operasionalBesarUnit * $portionsBesar) + ($operasionalKecilUnit * $portionsKecil);
                $grandTotal = $bahanTotal + $operasionalTotal;

                FinancialRecord::create([
                    'date'           => $date,
                    'bahan_cost'     => $bahanTotal,
                    'transport_cost' => $operasionalTotal,  // kolom ini kita pakai untuk dana operasional
                    'total'          => $grandTotal,
                    'sppg_id'        => $sppg->id,
                    'breakdown'      => $breakdown,
                ]);
            }
        }
    }
}
