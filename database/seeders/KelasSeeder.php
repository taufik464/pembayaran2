<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;



class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kelas')->insert([
            [
                'nama' => 'X MIIA 1',
                'tingkatan' => 'X MIIA',
                'status' => 'aktif',
            ],
            [
                'nama' => 'X MIIA 2',
                'tingkatan' => 'X MIIA',
                'status' => 'aktif',
            ],
            [
                'nama' => 'X IIS',
                'tingkatan' => 'X IIS',
                'status' => 'aktif',
            ],
            [
                'nama' => 'XI MIIA 1',
                'tingkatan' => 'XI MIIA',
                'status' => 'aktif',
            ],
            [
                'nama' => 'XI MIIA 2',
                'tingkatan' => 'XI MIIA',
                'status' => 'aktif',
            ],
            [
                'nama' => 'XII MIIA 1',
                'tingkatan' => 'XII MIIA',
                'status' => 'aktif',
            ],
            [
                'nama' => 'XII IIS',
                'tingkatan' => 'XII IIS',
                'status' => 'aktif',
            ],
            [
                'nama' => 'MIIA21',
                'tingkatan' => '2021',
                'status' => 'lulus',
            ],
        ]);
    }
}
