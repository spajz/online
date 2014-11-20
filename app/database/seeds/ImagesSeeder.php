<?php

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImagesSeeder extends Seeder
{

    public function run()
    {
        $faker = Factory::create();
        $items = array();

        // Create 200 items
        for ($i = 0; $i < 80; $i++) {

            array_push($items, array(
                'alt' => $faker->sentence(rand(0, 5)),
                'image' => implode('_', $faker->words(rand(1, 3))). '.jpg',
                'model_id' => $faker->numberBetween(1, 10),
                'model_type' => $faker->randomElement(array('Catalog\Models\Catalog', 'Holiday\Models\Holiday')),
                'sort' => $faker->numberBetween(1, 4),
                'created_at' => $faker->dateTimeBetween($startDate = '-2 years', $endDate = '-10 days'),
                'updated_at' => $faker->dateTimeBetween($startDate = '-2 years', $endDate = '-10 days'),
            ));
        }

        // Delete all items
        DB::table('images')->truncate();

        DB::table('images')->insert($items);
    }

}