<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Doctor;
use App\Models\Review;
use Faker\Generator as Faker;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $doctor_ids = Doctor::all()->pluck('id')->toArray();    

        foreach($doctor_ids as $id){
            $numberOfReview = rand(1,5);

            for ($c = 0; $c < $numberOfReview; $c++) {
                $newReview = new Review();
                $newReview->name = $faker->name();
                $newReview->title = $faker->sentence();
                $newReview->comment = $faker->text();
                $newReview->date = $faker->dateTime();
                $newReview->doctor_id = $id;
                $newReview->save();
            }
        }

        
    }
}
