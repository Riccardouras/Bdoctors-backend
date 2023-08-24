<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SponsorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sponsorData = [
            ['name' => '24 hours', 'price' => 2.99, 'hours' => 24],
            ['name' => '72 hours', 'price' => 5.99, 'hours' => 72],
            ['name' => '144 hours', 'price' => 9.99, 'hours' => 144],
        ];

        foreach ($sponsorData as $data) {
            DB::table('sponsors')->insert($data);
        };  
    }

}
    
