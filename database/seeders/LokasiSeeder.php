<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Lokasi;

class LokasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Lokasi::create(['nama' => 'Gudang Utama', 'lokasi' => 'Jakarta']);
        Lokasi::create(['nama' => 'Gudang Kedua', 'lokasi' => 'Surabaya']);
        Lokasi::create(['nama' => 'Gudang Ketiga', 'lokasi' => 'Bandung']);
    }
}
