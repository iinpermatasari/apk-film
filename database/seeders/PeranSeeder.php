<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Peran;
use Faker\Factory as Faker;

class PeranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $faker = Faker::create('id_ID');
        for($loop = 1; $loop <= 300; $loop++)
        {
            Peran::create([
                "film_id"    => $faker->numberBetween(1,128),
                "cast_id"    => $faker->numberBetween(1,50),
                "actor"      => $faker->jobTitle(),
            ]);
        }
    }
}
