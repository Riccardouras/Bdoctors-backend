<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\Specialty;
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

        $doctorsData = config('doctors');

        for ($i = 1; $i <= count($doctorsData); $i++) {
            $doctorData = $doctorsData[$i];

            $newDoctor = new Doctor();
            $newDoctor->address = $doctorData['address'];
            $newDoctor->city = $doctorData ['city'];
            $newDoctor->image = $doctorData['image'];
            $newDoctor->curriculum = $doctorData['curriculum'];
            $newDoctor->phone_number = $doctorData['phone_number'];
            $newDoctor->service = 'Pulizia dei denti';
            $newDoctor->user_id = $i;
            $newDoctor->save();

            $myNumber = rand(1, 2);
            $arraySpecialties = [];
            for ($c = 0; $c < $myNumber; $c++) {
                $arraySpecialties[] = $faker->randomElement($specialties_ids);
            }
            $newDoctor->specialties()->sync($arraySpecialties);
        }
    }
}
