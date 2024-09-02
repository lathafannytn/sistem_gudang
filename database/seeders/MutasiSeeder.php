<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Mutasi;

class MutasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Mutasi::create([
            'tanggal' => '2024-09-01',
            'jenis_mutasi' => 'Penambahan Stok',
            'jumlah' => 10,
            'barangs_id' => 1, // Laptop
            'users_id' => 1,
        ]);

        Mutasi::create([
            'tanggal' => '2024-09-02',
            'jenis_mutasi' => 'Pengurangan Stok',
            'jumlah' => 5,
            'barangs_id' => 2, // Meja Kantor
            'users_id' => 1,
        ]);

        Mutasi::create([
            'tanggal' => '2024-09-03',
            'jenis_mutasi' => 'Penambahan Stok',
            'jumlah' => 3,
            'barangs_id' => 3, // Kulkas
            'users_id' => 1,
        ]);
    }
}
