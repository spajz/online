<?php namespace Product\Seeds;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttributesSeeder extends Seeder
{

    public function run()
    {
        $faker = Factory::create();
        $items = array();
        $table = 'attributes';

        // Create 200 items
        for ($i = 0; $i < 200; $i++) {

            array_push($items, array(
                'product_id' => $faker->numberBetween(1, 100),
                'type' => $faker->randomElement(array('color')),
                'value' => $faker->randomElement(array('2817919', '13926399' , '11007', '16777045')),
                'status' => $faker->randomElement(array(0)),
                'created_at' => $faker->dateTimeBetween($startDate = '-2 years', $endDate = '-10 days'),
                'updated_at' => $faker->dateTimeBetween($startDate = '-2 years', $endDate = '-10 days'),
            ));
        }

        // Delete all items
        DB::table($table)->truncate();

        DB::table($table)->insert($items);
    }

}