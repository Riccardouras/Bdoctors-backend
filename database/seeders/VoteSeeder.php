<?php

namespace Database\Seeders;

use App\Models\Vote;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {  
       
        $data=[];
       for ($i=0; $i < 5; $i++) { 
            $data[]=[ 'name' => $i+1 . "stella", 'rating' => $i+1];
       };

        foreach ($data as $vote) {
            DB::table('votes')->insert($vote);
        }
    }
}
