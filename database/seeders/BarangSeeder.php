<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Barang;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Barang::create([
            'kode' => 'BRG001',
            'nama' => 'Laptop',
            'stok' => 50,
            'deskripsi' => 'Laptop dengan spesifikasi tinggi',
            'kategori_id' => 1, 
            'lokasi_id' => 1,
        ]);

        Barang::create([
            'kode' => 'BRG002',
            'nama' => 'Meja Kantor',
            'stok' => 20,
            'deskripsi' => 'Meja kantor ukuran standar',
            'kategori_id' => 3, 
            'lokasi_id' => 2, 
        ]);

        Barang::create([
            'kode' => 'BRG003',
            'nama' => 'Kulkas',
            'stok' => 15,
            'deskripsi' => 'Kulkas dengan teknologi inverter',
            'kategori_id' => 2,
            'lokasi_id' => 3,
        ]);
    }
}
