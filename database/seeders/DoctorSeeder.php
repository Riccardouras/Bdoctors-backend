<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\Specialty;
use App\Models\Vote;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $specialties_ids = Specialty::all()->pluck('id')->toArray();

        $doctorsArray = config('doctors');

        foreach($doctorsArray as $i => $doctor){
            $newDoctor = new Doctor();
            $newDoctor->address = $doctor['address'];
            $newDoctor->city = $doctor ['city'];
            $newDoctor->image = $doctor['image'];
            $newDoctor->curriculum = $doctor['curriculum'];
            $newDoctor->phone_number = $doctor['phone_number'];
            $newDoctor->service = 'Pulizia dei denti';
            $newDoctor->user_id = $i+1;
            $newDoctor->save();

            $numberOfSpecialties = rand(1, 2);
            $arraySpecialties = [];
            for ($c = 0; $c < $numberOfSpecialties; $c++) {
                $arraySpecialties[] = $faker->randomElement($specialties_ids);
            }
            $newDoctor->specialties()->sync($arraySpecialties);

            $votes = config('votes');

            $voteIdArray= [];
            foreach ($votes as $vote) {
                if ($vote['doctor_id']== $newDoctor->id)  {
                    $voteIdArray[]=$vote['vote_id'];
                }
                $newDoctor->votes()->sync($voteIdArray);
            }
        }
    }
}
