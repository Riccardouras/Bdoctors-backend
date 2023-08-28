<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpecialtySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $specialties = config('specialties');

        foreach ($specialties as $specialty) {
            DB::table('specialties')->insert([
                'name' => $specialty,
            ]);
        }
    }
}
