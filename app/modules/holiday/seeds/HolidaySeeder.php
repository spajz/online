<?php namespace Holiday\Seeds;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HolidaySeeder extends Seeder
{

    public function run()
    {
        $faker = Factory::create();
        $items = array();

        // Create 200 items
        for ($i = 0; $i < 200; $i++) {

            array_push($items, array(
                'description' => $faker->sentence(rand(10, 50)),

                'first_name' => $faker->firstName(),
                'last_name' => $faker->lastName(),
                'email' => $faker->email(),
                'email2' => $faker->email(),
                'text_position' => $faker->randomElement(array('left', 'right', 'top', 'bottom')),

                'text_color' => $faker->hexcolor(),
                'text_size' => $faker->randomElement(array(12, 12, 14, 16, 18, 20, 24)),
                'bg_color' => $faker->hexcolor(),
                'bg_transparency' => $faker->randomElement(array(0.5, 1, 1, 0.2, 0.6, 0.9, 0)),
                'angle' => $faker->randomElement(array(0, 0, 0, 10, 25, 30, 5)),

                'status' => $faker->randomElement(array(1, 1, 1, -1, -1, 0, 0)),
                'hash_delete' => $faker->sha1,
                'hash_activate' => $faker->sha1,

                'created_at' => $faker->dateTimeBetween($startDate = '-2 years', $endDate = '-10 days'),
                'updated_at' => $faker->dateTimeBetween($startDate = '-2 years', $endDate = '-10 days'),

            ));
        }

        // Delete all items
        DB::table('holiday')->truncate();

        DB::table('holiday')->insert($items);
    }

}