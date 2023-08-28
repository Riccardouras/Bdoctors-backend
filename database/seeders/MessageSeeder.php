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
        $doctor_ids = Doctor::all()->pluck('id')->toArray();

        foreach($doctor_ids as $id){
            $numberOfMessage = rand(1,5);

            for ($c = 0; $c < $numberOfMessage; $c++) {
                $newMessage = new Message();
                $newMessage->text = $faker->text(50);
                $newMessage->full_name = $faker->name();
                $newMessage->mail = $faker->email();
                $newMessage->date = $faker->dateTime();
                $newMessage->doctor_id = $id;
                $newMessage->save();
            }
        }
        
    }
}
