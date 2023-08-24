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
        $usersNames = ['matteo', 'riccardo', 'gabriele', 'luca', 'francesco'];

        foreach ($usersNames as $userName) {

            $newUser = new User();
            $newUser->name = $userName;
            $newUser->email = $userName . '@gmail.com';
            $newUser->password =  bcrypt('prova123');
            $newUser->save();
        }
    }
}
