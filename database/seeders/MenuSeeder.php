<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;
use App\Models\Sppg;
use Carbon\Carbon;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        Menu::truncate();

        $sppgs = Sppg::take(5)->pluck('id')->toArray();
        if (empty($sppgs)) {
            $sppgs = [null];
        }

        $today    = Carbon::today()->format('Y-m-d');
        $tomorrow = Carbon::tomorrow()->format('Y-m-d');

        /*
         * Juklak MBG BGN 2026
         * Porsi Kecil (~400-500 Kkal): PAUD/TK | SD Kelas 1-3 | Balita
         * Porsi Besar (~600-700 Kkal): SD Kelas 4-6 | SMP | SMA/SMK | Pesantren
         * Khusus (setara Porsi Kecil-Sedang): Ibu Hamil | Ibu Menyusui | Guru/Pendidik
         *
         * Siklus menu 20 hari: telur/ayam 8x, tahu/tempe 10x.
         * Komposisi wajib: Makanan pokok + Lauk hewani/nabati + Sayur + Buah + Susu
         */
        $menuData = [
            // ─── PAUD/TK ── Porsi Kecil ~400-500 Kkal ────────────────────────────
            ['target' => 'PAUD/TK', 'date' => $today,
             'food'   => 'Bubur Nasi Ayam Cincang + Sup Wortel Bening + Puree Pepaya',
             'cal' => 420, 'pro' => 14.0, 'kar' => 52.0, 'fat' => 10.5],
            ['target' => 'PAUD/TK', 'date' => $tomorrow,
             'food'   => 'Nasi Tim + Telur Kukus + Tumis Bayam + Pisang Cavendish',
             'cal' => 450, 'pro' => 15.5, 'kar' => 55.0, 'fat' => 11.0],

            // ─── SD Kelas 1-3 ── Porsi Kecil ~400-500 Kkal ───────────────────────
            ['target' => 'SD Kelas 1-3', 'date' => $today,
             'food'   => 'Nasi Putih + Telur Dadar Gulung + Oseng Tempe Kecap + Pepaya + Susu UHT',
             'cal' => 490, 'pro' => 18.0, 'kar' => 60.0, 'fat' => 14.0],
            ['target' => 'SD Kelas 1-3', 'date' => $tomorrow,
             'food'   => 'Nasi Putih + Ayam Kecap Manis + Sayur Bening Bayam Jagung + Jeruk + Susu UHT',
             'cal' => 500, 'pro' => 20.0, 'kar' => 62.0, 'fat' => 13.5],

            // ─── Balita ── Porsi Kecil ~400-500 Kkal ─────────────────────────────
            ['target' => 'Balita', 'date' => $today,
             'food'   => 'Bubur Kacang Hijau Santan + Puree Hati Ayam + Finger Food Brokoli Kukus',
             'cal' => 380, 'pro' => 13.0, 'kar' => 48.0, 'fat' => 12.0],
            ['target' => 'Balita', 'date' => $tomorrow,
             'food'   => 'Nasi Lembek + Ikan Gabus Panggang + Pure Wortel Kentang + Buah Melon',
             'cal' => 400, 'pro' => 16.0, 'kar' => 50.0, 'fat' => 10.0],

            // ─── SD Kelas 4-6 ── Porsi Besar ~600-700 Kkal ───────────────────────
            ['target' => 'SD Kelas 4-6', 'date' => $today,
             'food'   => 'Nasi Putih + Telur Dadar Gulung Sosis + Tumis Kacang Panjang + Semangka + Susu UHT',
             'cal' => 630, 'pro' => 22.0, 'kar' => 78.0, 'fat' => 20.0],
            ['target' => 'SD Kelas 4-6', 'date' => $tomorrow,
             'food'   => 'Nasi Kuning + Ayam Goreng Lengkuas + Orek Tempe + Buah Pisang + Susu UHT',
             'cal' => 660, 'pro' => 25.0, 'kar' => 82.0, 'fat' => 22.5],

            // ─── SMP ── Porsi Besar ~600-700 Kkal ────────────────────────────────
            ['target' => 'SMP', 'date' => $today,
             'food'   => 'Nasi Putih + Ikan Tongkol Balado + Tahu Goreng + Sayur Lodeh + Semangka + Susu UHT',
             'cal' => 680, 'pro' => 28.0, 'kar' => 85.0, 'fat' => 22.0],
            ['target' => 'SMP', 'date' => $tomorrow,
             'food'   => 'Nasi Merah + Sate Ayam Bumbu Kacang + Tempe Mendoan + Tumis Buncis + Melon + Susu UHT',
             'cal' => 700, 'pro' => 30.0, 'kar' => 88.0, 'fat' => 24.0],

            // ─── SMA/SMK ── Porsi Besar ~650-750 Kkal ────────────────────────────
            ['target' => 'SMA/SMK', 'date' => $today,
             'food'   => 'Nasi Putih + Rendang Daging Sapi + Tahu Bacem + Daun Singkong Rebus + Jeruk + Susu UHT',
             'cal' => 750, 'pro' => 32.0, 'kar' => 92.0, 'fat' => 28.0],
            ['target' => 'SMA/SMK', 'date' => $tomorrow,
             'food'   => 'Nasi Goreng Spesial + Telur Ceplok + Ayam Suwir Bumbu Kuning + Acar + Buah Naga + Susu UHT',
             'cal' => 720, 'pro' => 30.0, 'kar' => 95.0, 'fat' => 25.0],

            // ─── PESANTREN SUB-JENJANG ────────────────────────────────────────────
            // RA/TK — Porsi Kecil ~400-450 Kkal
            ['target' => 'Pesantren - RA/TK', 'date' => $today,
             'food'   => 'Bubur Ayam Kampung + Telur Puyuh Rebus + Tumis Sayur Bayam + Buah Pisang + Susu UHT',
             'cal' => 430, 'pro' => 15.0, 'kar' => 54.0, 'fat' => 11.0],
            ['target' => 'Pesantren - RA/TK', 'date' => $tomorrow,
             'food'   => 'Nasi Tim Ikan + Puree Wortel Kentang + Sari Buah Jeruk + Susu UHT',
             'cal' => 440, 'pro' => 16.0, 'kar' => 55.0, 'fat' => 10.5],

            // MI Kelas 1-3 — Porsi Kecil ~480-510 Kkal
            ['target' => 'Pesantren - MI Kelas 1-3', 'date' => $today,
             'food'   => 'Nasi Putih + Telur Dadar Orak-Arik + Oseng Tempe Kecap + Pepaya + Susu UHT',
             'cal' => 490, 'pro' => 18.0, 'kar' => 60.0, 'fat' => 14.0],
            ['target' => 'Pesantren - MI Kelas 1-3', 'date' => $tomorrow,
             'food'   => 'Nasi Putih + Ayam Suwir Bumbu Kuning + Sayur Bening Bayam + Pisang Raja + Susu UHT',
             'cal' => 505, 'pro' => 20.0, 'kar' => 62.0, 'fat' => 13.5],

            // MI Kelas 4-6 — Porsi Besar ~620-650 Kkal
            ['target' => 'Pesantren - MI Kelas 4-6', 'date' => $today,
             'food'   => 'Nasi Putih + Ayam Goreng Bumbu Rempah + Orek Tempe Manis + Sup Sayuran + Melon + Susu UHT',
             'cal' => 635, 'pro' => 24.0, 'kar' => 80.0, 'fat' => 20.0],
            ['target' => 'Pesantren - MI Kelas 4-6', 'date' => $tomorrow,
             'food'   => 'Nasi Kuning Gurih + Telur Balado + Tahu Goreng + Tumis Kangkung + Jeruk + Susu UHT',
             'cal' => 650, 'pro' => 23.0, 'kar' => 82.0, 'fat' => 21.0],

            // MTs — Porsi Besar ~680-710 Kkal (setara SMP)
            ['target' => 'Pesantren - MTs', 'date' => $today,
             'food'   => 'Nasi Putih + Ikan Nila Goreng Kunyit + Tahu Bacem + Sayur Asem Jakarta + Semangka + Susu UHT',
             'cal' => 690, 'pro' => 28.0, 'kar' => 86.0, 'fat' => 22.0],
            ['target' => 'Pesantren - MTs', 'date' => $tomorrow,
             'food'   => 'Nasi Merah + Sate Ayam Bumbu Kacang + Tempe Mendoan + Tumis Wortel Buncis + Melon + Susu UHT',
             'cal' => 705, 'pro' => 30.0, 'kar' => 88.0, 'fat' => 24.0],

            // MA/MAK — Porsi Besar ~730-760 Kkal (setara SMA)
            ['target' => 'Pesantren - MA/MAK', 'date' => $today,
             'food'   => 'Nasi Putih + Rendang Ayam Padang + Tahu Goreng + Tumis Kangkung Bawang Putih + Jeruk + Susu UHT',
             'cal' => 745, 'pro' => 32.0, 'kar' => 93.0, 'fat' => 27.0],
            ['target' => 'Pesantren - MA/MAK', 'date' => $tomorrow,
             'food'   => 'Nasi Goreng Telur Ceplok + Ayam Panggang Kecap + Tumis Brokoli + Buah Naga + Susu UHT',
             'cal' => 730, 'pro' => 31.0, 'kar' => 90.0, 'fat' => 25.0],

            // Santri Boarding Umum — Porsi Besar ~770-800 Kkal (aktif fisik tinggi)
            ['target' => 'Pesantren - Santri', 'date' => $today,
             'food'   => 'Nasi Liwet + Ayam Bakar Kecap + Tempe Orek Cabai + Lalapan + Susu Kurma',
             'cal' => 780, 'pro' => 35.0, 'kar' => 98.0, 'fat' => 30.0],
            ['target' => 'Pesantren - Santri', 'date' => $tomorrow,
             'food'   => 'Nasi Putih + Gulai Cincang Sapi + Tahu Goreng Bumbu Tomat + Tumis Kangkung + Apel + Susu UHT',
             'cal' => 800, 'pro' => 37.0, 'kar' => 100.0, 'fat' => 32.0],

            // ─── Ibu Hamil ── Porsi Khusus tinggi Fe & Asam Folat ────────────────
            ['target' => 'Ibu Hamil', 'date' => $today,
             'food'   => 'Nasi Putih + Sayur Bayam Bening Kunci (tinggi Fe) + Telur Rebus + Ikan Salmon Panggang + Susu Kehamilan',
             'cal' => 650, 'pro' => 28.5, 'kar' => 78.0, 'fat' => 20.0],
            ['target' => 'Ibu Hamil', 'date' => $tomorrow,
             'food'   => 'Nasi Merah + Pepes Ikan Kembung + Tumis Brokoli Wortel + Kacang Rebus + Jus Jambu Biji',
             'cal' => 680, 'pro' => 30.0, 'kar' => 80.0, 'fat' => 18.0],

            // ─── Ibu Menyusui ── Porsi Khusus tinggi Kalsium ────────────────────
            ['target' => 'Ibu Menyusui', 'date' => $today,
             'food'   => 'Nasi Putih + Sup Ayam Kacang Merah + Daun Katuk Tumis + Tempe Goreng + Susu Full Cream',
             'cal' => 700, 'pro' => 32.0, 'kar' => 85.0, 'fat' => 22.0],
            ['target' => 'Ibu Menyusui', 'date' => $tomorrow,
             'food'   => 'Nasi Putih + Ikan Gurame Bakar + Sayur Asem Kacang + Tahu Bumbu Kuning + Pepaya + Susu UHT',
             'cal' => 720, 'pro' => 33.0, 'kar' => 88.0, 'fat' => 20.0],

            // ─── Guru/Pendidik ── Porsi setara SD Kelas 4-6 ─────────────────────
            ['target' => 'Guru/Pendidik', 'date' => $today,
             'food'   => 'Nasi Putih + Ayam Geprek Sambal Hijau + Tahu Goreng + Lalapan Timun Kemangi + Buah Jeruk',
             'cal' => 640, 'pro' => 26.0, 'kar' => 80.0, 'fat' => 22.0],
            ['target' => 'Guru/Pendidik', 'date' => $tomorrow,
             'food'   => 'Nasi Putih + Semur Daging Tahu + Tumis Sawi Putih + Kerupuk + Pisang Raja',
             'cal' => 620, 'pro' => 24.0, 'kar' => 78.0, 'fat' => 20.0],
        ];

        foreach ($menuData as $data) {
            Menu::create([
                'sppg_id'      => $sppgs[array_rand($sppgs)],
                'target_group' => $data['target'],
                'serve_date'   => $data['date'],
                'food_name'    => $data['food'],
                'calories'     => $data['cal'],
                'protein_g'    => $data['pro'],
                'karbo_g'      => $data['kar'],
                'fat_g'        => $data['fat'],
            ]);
        }
    }
}
