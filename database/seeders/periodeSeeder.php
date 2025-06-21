<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\periode;

class periodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       periode::factory()->count(5)->create();
    }
}
