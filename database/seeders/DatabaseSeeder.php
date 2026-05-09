<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * Urutan: Users → SPPG → Menu → Finance (Delivery + FinancialRecord)
     */
    public function run(): void
    {
        // ── 1. Users ───────────────────────────────────────────────────────────
        // Cek dulu agar tidak dobel jika sudah ada admin
        if (!DB::table('users')->where('email', 'admin@bgn.go.id')->exists()) {
            DB::table('users')->insert([
                'name'       => 'Admin BGN Pusat',
                'email'      => 'admin@bgn.go.id',
                'password'   => Hash::make('password'),
                'role'       => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Driver per wilayah
        $drivers = [
            ['name' => 'Driver Sumatera – Rian Permana',   'email' => 'driver.sumatra@bgn.go.id'],
            ['name' => 'Driver Jawa – Budi Santoso',        'email' => 'driver.java@bgn.go.id'],
            ['name' => 'Driver Kalimantan – Agus Wibowo',   'email' => 'driver.kalimantan@bgn.go.id'],
            ['name' => 'Driver Sulawesi – Hasrul Bakri',    'email' => 'driver.sulawesi@bgn.go.id'],
            ['name' => 'Driver Papua – Yohanis Merauke',    'email' => 'driver.papua@bgn.go.id'],
        ];
        foreach ($drivers as $d) {
            if (!DB::table('users')->where('email', $d['email'])->exists()) {
                DB::table('users')->insert(array_merge($d, [
                    'password'   => Hash::make('password'),
                    'role'       => 'driver',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]));
            }
        }

        // ── 2. SPPG Nasional (38 Provinsi) ───────────────────────────────────
        $this->call(SppgSeeder::class);

        // ── 3. Menu Gizi (per target group, hari ini & besok) ─────────────────
        $this->call(MenuSeeder::class);

        // ── 4. Finance + Deliveries ───────────────────────────────────────────
        $this->call(FinanceSeeder::class);

        $this->command->info('🎉 Seluruh data dummy nasional berhasil di-seed!');
    }
}
