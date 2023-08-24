<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\Message;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $doctors = Doctor::all();

        for ($i = 0; $i < 10; $i++) {
            $newMessage = new Message();
            $newMessage->text = $faker->text(50);
            $newMessage->full_name = $faker->name();
            $newMessage->mail = $faker->email();
            $newMessage->date = $faker->dateTime();
            $newMessage->doctor_id = rand(1, count($doctors));
        }
        
    }
}
