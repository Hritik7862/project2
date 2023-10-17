<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MembersTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 1000) as $index) {
            DB::table('members')->insert([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'age' => $faker->numberBetween(18, 60),
                'date_of_birth' => $faker->date,
            ]);
        }
    }
}
