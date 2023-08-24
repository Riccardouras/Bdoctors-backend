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
        $specialties = Specialty::all();
        $specialties_ids = Specialty::all()->pluck('id')->toArray();
        for ($i = 1; $i <= 5; $i++) {
            $newDoctor = new Doctor();
            $newDoctor->address = $faker->address();
            $newDoctor->city = $faker->city();
            $newDoctor->img_path = 'https://i0.wp.com/albertaps.ca/wp-content/uploads/2016/03/doctor-placeholder.jpg?ssl=1';
            $newDoctor->cv_path = 'https://img.freepik.com/free-vector/minimalist-cv-template_23-2148916066.jpg?w=996&t=st=1692808441~exp=1692809041~hmac=e53f33f074516204fb82b1f68525e7ff8b127515ec37e473d500fdb933040686';
            $newDoctor->phone_number = $faker->phoneNumber();
            $newDoctor->service = 'Pulizia dei denti';
            $newDoctor->user_id = $i;
            $newDoctor->save();

            $myNumber = rand(1, 2);
            $arraySpecialties = [];
            for ($c = 0; $c < $myNumber; $c++) {
                $arraySpecialties[] = $specialties->random()->id;
            }
            $newDoctor->specialties()->sync($arraySpecialties);
        }
    }
}
