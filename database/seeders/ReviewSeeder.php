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
        $doctors = Doctor::all();

        foreach ($doctors as $doctor) {
            for ($i = 0; $i < 10; $i++) {
                $newReview = new Review();
                $newReview->name = $faker->name();
                $newReview->title = $faker->sentence();
                $newReview->comment = $faker->text();
                $newReview->date = $faker->dateTime();
                $doctor->reviews()->save($newReview);
            }
        }
       
    }
}
