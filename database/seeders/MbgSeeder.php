<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MbgSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Users
        \App\Models\User::create([
            'name' => 'Admin MBG',
            'email' => 'admin@bgn.go.id',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        \App\Models\User::create([
            'name' => 'Driver Yogyakarta',
            'email' => 'driver@bgn.go.id',
            'password' => bcrypt('password'),
            'role' => 'driver',
        ]);

        // SPPGs
        $sppg = \App\Models\Sppg::create([
            'name' => 'Satuan Pelayanan Malioboro',
            'location' => 'Yogyakarta',
        ]);

        // Deliveries
        $delivery = \App\Models\Delivery::create([
            'status' => 'transit',
            'lat' => -7.7956,
            'lng' => 110.3695,
            'portions' => 500,
            'sppg_id' => $sppg->id,
        ]);

        // Financial
        \App\Models\FinancialRecord::create([
            'date' => now(),
            'bahan_cost' => 500 * 10000,
            'transport_cost' => 500 * 2000,
            'total' => 500 * 15000,
            'sppg_id' => $sppg->id,
        ]);

        // Nutrition
        \App\Models\Nutrition::create([
            'calories' => 500,
            'protein_g' => 12,
            'karbo_g' => 100,
            'delivery_id' => $delivery->id,
        ]);
    }
}
