<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $usersNames = config('doctors');

        foreach ($usersNames as $userName) {

            $newUser = new User();
            $newUser->name = $userName['name'];
            $newUser->email = $userName['name'] . '@gmail.com';
            $newUser->password =  bcrypt('prova123');
            $newUser->save();
        }
    }
}
