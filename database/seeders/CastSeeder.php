<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Cast;
use Faker\Factory as Faker;

class CastSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $faker = Faker::create('id_ID');
        for($i = 1; $i <= 50; $i++){
            // insert data ke table cast menggunakan Faker
            \DB::table('casts')->insert([
                'name' => $faker->name(),
                'age' => $faker->numberBetween(7,80),
                'bio' => $faker->company(),
            ]);
        }

    }
}
