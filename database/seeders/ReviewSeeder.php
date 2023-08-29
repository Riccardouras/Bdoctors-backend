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

        $reviewArray = config('reviews');

        foreach($reviewArray as $review){

                $newReview = new Review();
                $newReview->name = $review['name'];
                $newReview->title = $review['title'];
                $newReview->comment = $review['content'];
                $newReview->date = $review['date'];
                $newReview->doctor_id = $review['doctor_id'];
                $newReview->save();
        }

        
    }
}
