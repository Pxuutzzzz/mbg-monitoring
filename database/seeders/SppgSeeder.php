<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sppg;

class SppgSeeder extends Seeder
{
    /**
     * 38 SPPG Dapur Umum MBG – Mewakili seluruh provinsi di Indonesia
     * Koordinat (lat, lng) disertakan agar peta tetap akurat.
     */
    public function run(): void
    {
        // Disable foreign key checks (compatible MySQL & SQLite)
        $driver = \Illuminate\Support\Facades\DB::getDriverName();
        if ($driver === 'sqlite') {
            \Illuminate\Support\Facades\DB::statement('PRAGMA foreign_keys = OFF;');
        } else {
            \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }

        \App\Models\Nutrition::truncate();
        \App\Models\FinancialRecord::truncate();
        \App\Models\Delivery::truncate();
        Sppg::truncate();

        if ($driver === 'sqlite') {
            \Illuminate\Support\Facades\DB::statement('PRAGMA foreign_keys = ON;');
        } else {
            \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }

        $sppgs = [
            // ── SUMATERA ──────────────────────────────────────────────────────
            ['name' => 'SPPG Banda Aceh Utara',      'location' => 'Banda Aceh, Aceh',               'lat' =>  5.5501, 'lng' =>  95.3238],
            ['name' => 'SPPG Medan Helvetia',         'location' => 'Medan, Sumatera Utara',           'lat' =>  3.5952, 'lng' =>  98.6722],
            ['name' => 'SPPG Padang Barat',            'location' => 'Padang, Sumatera Barat',          'lat' => -0.9471, 'lng' => 100.4172],
            ['name' => 'SPPG Pekanbaru Tengah',        'location' => 'Pekanbaru, Riau',                 'lat' =>  0.5071, 'lng' => 101.4478],
            ['name' => 'SPPG Jambi Kota Baru',         'location' => 'Jambi, Jambi',                    'lat' => -1.6101, 'lng' => 103.6131],
            ['name' => 'SPPG Palembang Ilir Timur',    'location' => 'Palembang, Sumatera Selatan',     'lat' => -2.9761, 'lng' => 104.7754],
            ['name' => 'SPPG Bengkulu Selebar',        'location' => 'Bengkulu, Bengkulu',              'lat' => -3.7928, 'lng' => 102.2608],
            ['name' => 'SPPG Bandar Lampung Kedaton',  'location' => 'Bandar Lampung, Lampung',         'lat' => -5.4295, 'lng' => 105.2610],
            ['name' => 'SPPG Pangkalpinang Rangkui',   'location' => 'Pangkalpinang, Bangka Belitung',  'lat' => -2.1316, 'lng' => 106.1169],
            ['name' => 'SPPG Tanjungpinang Tanjung',   'location' => 'Tanjungpinang, Kepulauan Riau',   'lat' =>  0.9163, 'lng' => 104.4527],

            // ── JAWA ──────────────────────────────────────────────────────────
            ['name' => 'SPPG Jakarta Selatan Kebayoran','location' => 'Jakarta Selatan, DKI Jakarta',   'lat' => -6.2615, 'lng' => 106.7942],
            ['name' => 'SPPG Jakarta Utara Tanjung Priok','location' => 'Jakarta Utara, DKI Jakarta',   'lat' => -6.1167, 'lng' => 106.8829],
            ['name' => 'SPPG Bogor Tengah',             'location' => 'Bogor, Jawa Barat',              'lat' => -6.5971, 'lng' => 106.8060],
            ['name' => 'SPPG Bandung Cicendo',          'location' => 'Bandung, Jawa Barat',            'lat' => -6.9147, 'lng' => 107.6098],
            ['name' => 'SPPG Bekasi Mustikajaya',       'location' => 'Bekasi, Jawa Barat',             'lat' => -6.2349, 'lng' => 107.0022],
            ['name' => 'SPPG Serang Kasemen',           'location' => 'Serang, Banten',                 'lat' => -6.1194, 'lng' => 106.1502],
            ['name' => 'SPPG Semarang Barat',           'location' => 'Semarang, Jawa Tengah',          'lat' => -6.9667, 'lng' => 110.4167],
            ['name' => 'SPPG Solo Laweyan',             'location' => 'Surakarta, Jawa Tengah',         'lat' => -7.5657, 'lng' => 110.8266],
            ['name' => 'SPPG Yogyakarta Malioboro',     'location' => 'Yogyakarta, DI Yogyakarta',      'lat' => -7.7956, 'lng' => 110.3695],
            ['name' => 'SPPG Surabaya Gubeng',          'location' => 'Surabaya, Jawa Timur',           'lat' => -7.2575, 'lng' => 112.7521],
            ['name' => 'SPPG Malang Lowokwaru',         'location' => 'Malang, Jawa Timur',             'lat' => -7.9774, 'lng' => 112.6286],

            // ── BALI & NUSA TENGGARA ──────────────────────────────────────────
            ['name' => 'SPPG Denpasar Selatan',         'location' => 'Denpasar, Bali',                 'lat' => -8.6705, 'lng' => 115.2126],
            ['name' => 'SPPG Mataram Cakranegara',      'location' => 'Mataram, Nusa Tenggara Barat',   'lat' => -8.5833, 'lng' => 116.1167],
            ['name' => 'SPPG Kupang Oebobo',            'location' => 'Kupang, Nusa Tenggara Timur',    'lat' => -10.1771,'lng' => 123.6070],

            // ── KALIMANTAN ────────────────────────────────────────────────────
            ['name' => 'SPPG Pontianak Kota',           'location' => 'Pontianak, Kalimantan Barat',    'lat' => -0.0263, 'lng' => 109.3425],
            ['name' => 'SPPG Palangkaraya Jekan Raya',  'location' => 'Palangka Raya, Kalimantan Tengah','lat' => -2.2136, 'lng' => 113.9108],
            ['name' => 'SPPG Banjarmasin Utara',        'location' => 'Banjarmasin, Kalimantan Selatan', 'lat' => -3.3186, 'lng' => 114.5944],
            ['name' => 'SPPG Samarinda Ilir',           'location' => 'Samarinda, Kalimantan Timur',    'lat' => -0.4948, 'lng' => 117.1436],
            ['name' => 'SPPG Tanjung Selor Bulungan',   'location' => 'Tanjung Selor, Kalimantan Utara', 'lat' =>  2.8370, 'lng' => 117.3727],

            // ── SULAWESI ──────────────────────────────────────────────────────
            ['name' => 'SPPG Manado Wenang',            'location' => 'Manado, Sulawesi Utara',         'lat' =>  1.4748, 'lng' => 124.8421],
            ['name' => 'SPPG Palu Tatanga',             'location' => 'Palu, Sulawesi Tengah',          'lat' => -0.8917, 'lng' => 119.8707],
            ['name' => 'SPPG Makassar Tamalate',        'location' => 'Makassar, Sulawesi Selatan',     'lat' => -5.1477, 'lng' => 119.4327],
            ['name' => 'SPPG Kendari Mandonga',         'location' => 'Kendari, Sulawesi Tenggara',     'lat' => -3.9985, 'lng' => 122.5129],
            ['name' => 'SPPG Gorontalo Kota Tengah',    'location' => 'Gorontalo, Gorontalo',           'lat' =>  0.5412, 'lng' => 123.0595],
            ['name' => 'SPPG Mamuju Papalang',          'location' => 'Mamuju, Sulawesi Barat',         'lat' => -2.6753, 'lng' => 118.8887],

            // ── MALUKU & PAPUA ────────────────────────────────────────────────
            ['name' => 'SPPG Ambon Sirimau',            'location' => 'Ambon, Maluku',                  'lat' => -3.6954, 'lng' => 128.1814],
            ['name' => 'SPPG Sofifi Oba Utara',         'location' => 'Sofifi, Maluku Utara',           'lat' =>  0.7399, 'lng' => 127.5799],
            ['name' => 'SPPG Manokwari Timur',          'location' => 'Manokwari, Papua Barat',         'lat' => -0.8615, 'lng' => 134.0613],
            ['name' => 'SPPG Jayapura Abepura',         'location' => 'Jayapura, Papua',                'lat' => -2.5916, 'lng' => 140.6690],
        ];

        foreach ($sppgs as $data) {
            Sppg::create([
                'name'     => $data['name'],
                'location' => $data['location'],
                'lat'      => $data['lat'],
                'lng'      => $data['lng'],
            ]);
        }

        $this->command->info('✅ ' . count($sppgs) . ' SPPG berhasil dibuat dari seluruh Indonesia.');
    }
}
