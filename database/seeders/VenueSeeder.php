<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class VenueSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        for ($i = 0; $i < 10; $i++) {
            $bookedDates = [];
            $numDates = rand(2, 5); // Each venue has 2-5 booked dates
            for ($j = 0; $j < $numDates; $j++) {
                // Booked dates within next 2 months
                $bookedDates[] = $faker->dateTimeBetween('+1 week', '+2 months')->format('Y-m-d');
            }
            DB::table('venues')->insert([
                'name' => $faker->company . ' Hall',
                'size' => $faker->numberBetween(80, 400),
                'address' => $faker->address,
                'booked_dates' => json_encode($bookedDates),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
