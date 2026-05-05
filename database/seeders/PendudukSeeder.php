<?php
namespace App\Http\Controllers;
use Illuminate\Database\Seeder;

class PendudukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() 
    {
        $penduduk = [
            [
                'nik' => '1234567890123456',
                'name' => 'John Doe',
                'address' => 'Jl. Contoh Alamat No. 1',
            ]            
        ];

        // Baris untuk mengeksekusi data ke tabel
        DB::table('penduduks')->insert($penduduk);

    }
}