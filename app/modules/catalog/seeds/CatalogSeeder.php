<?php namespace Catalog\Seeds;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatalogSeeder extends Seeder
{

    public function run()
    {
        $faker = Factory::create();
        $items = array();

        // Create 200 items
        for ($i = 0; $i < 200; $i++) {

            array_push($items, array(
                'title' => $faker->sentence(rand(0, 7)),
                'description' => $faker->sentence(rand(0, 50)),
                //'image' => implode('_', $faker->words(rand(1, 3))). '.jpg',
                'price' => $faker->optional($weight = 0.9, $default = 0)->randomFloat(2, $min = 100, 99999),
                'area' => $faker->numberBetween(10, 9999),
                'region' => $faker->numberBetween(1, 8),
                'type' => $faker->numberBetween(1, 3),
                'status' => $faker->randomElement(array(1, 1, 1, 1, 1, 0, 0)),
                'hash_delete' => $faker->sha1,
                'created_at' => $faker->dateTimeBetween($startDate = '-2 years', $endDate = '-10 days'),
                'updated_at' => $faker->dateTimeBetween($startDate = '-2 years', $endDate = '-10 days'),
            ));
        }

        // Delete all items
        DB::table('catalog')->truncate();

        DB::table('catalog')->insert($items);
    }

}