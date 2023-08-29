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
    public function run()
    {
        $messagesArray = config('messages');

        foreach ($messagesArray as $message) {

            $newMessage = new Message();
            $newMessage->text = $message['text'];
            $newMessage->full_name = $message['full_name'];
            $newMessage->mail = $message['mail'];
            $newMessage->date = $message['date'];
            $newMessage->doctor_id = $message['doctor_id'];
            $newMessage->save();
        }
    }
}
