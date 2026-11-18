<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Profile;
use Faker\Factory as Faker;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $faker = Faker::create('id_ID');
        for($loop = 1; $loop <= 10; $loop++)
        {
            Profile::create([
                "alamat"    => $faker->address(),
                "umur"    => $faker->numberBetween(1,50),
                "bio"      => $faker->jobTitle(),
            ]);
        }
    }
}
