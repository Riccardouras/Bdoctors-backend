<?php

namespace Database\Seeders;

use App\Models\DoctorSponsor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DoctorSponsorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sponsorships = config('sponsorships');

        foreach ($sponsorships as $sponsor) {
            $newSponsorship = new DoctorSponsor();
            $newSponsorship->doctor_id = $sponsor['doctor_id'];
            $newSponsorship->sponsor_id = $sponsor['sponsor_id'];
            $newSponsorship->start_date = $sponsor['start_date'];
            $newSponsorship->end_date = $sponsor['end_date'];
            $newSponsorship->save();
        }
    }
}
