<?php

namespace Database\Seeders;

use App\Models\DoctorVote;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DoctorVoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $votesArray = config('votes');

        foreach($votesArray as $vote){

            $newVote = new DoctorVote();
            $newVote->date  = $vote['date'];
            $newVote->doctor_id  = $vote['doctor_id'];
            $newVote->vote_id  = $vote['vote_id'];
            $newVote->save();
        }
    }
}
