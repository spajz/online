<?php namespace Product\Seeds;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Str;

class ProductsSeeder extends Seeder
{

    public function run()
    {
        $faker = Factory::create();
        $items = array();
        $table = 'products';

        // Create 200 items
        for ($i = 0; $i < 200; $i++) {

            $title = $faker->sentence(rand(0, 7));

            array_push($items, array(
                'title' => $title,
                'slug' => Str::slug($title),
                'url' => $faker->url(),
                'description' => $faker->sentence(rand(0, 50)),
                'category_id' => $faker->numberBetween(10, 30),
                'status' => $faker->randomElement(array(1, 1, 1, 1, 1, 0, 0)),
                'created_at' => $faker->dateTimeBetween($startDate = '-2 years', $endDate = '-10 days'),
                'updated_at' => $faker->dateTimeBetween($startDate = '-2 years', $endDate = '-10 days'),
            ));
        }

        // Delete all items
        DB::table($table)->truncate();

        DB::table($table)->insert($items);
    }

}