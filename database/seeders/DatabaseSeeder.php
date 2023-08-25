<?php

namespace Database\Seeders;

use App\Models\Message;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            SpecialtySeeder::class,
            DoctorSeeder::class,
            VoteSeeder::class,
            SponsorSeeder::class,
<<<<<<< HEAD
            DoctorSeeder::class,
=======
>>>>>>> main
            ReviewSeeder::class,
            MessageSeeder::class

        ]);
    }
}
