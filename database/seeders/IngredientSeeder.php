<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ingredients')->insert([
            [
                'product_id' => 1,
                'title' => 'Beef',
                'consumption' => 150,
                'consumption_unit' => 'g',
                'stock' => 20,
                'available_stock' => 20,
                'stock_unit' => 'kg',
                'stock_notification' => 0,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'product_id' => 1,
                'title' => 'Cheese',
                'consumption' => 30,
                'consumption_unit' => 'g',
                'stock' => 5,
                'available_stock' => 5,
                'stock_unit' => 'kg',
                'stock_notification' => 0,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'product_id' => 1,
                'title' => 'Onion',
                'consumption' => 20,
                'consumption_unit' => 'g',
                'stock' => 1,
                'available_stock' => 1,
                'stock_unit' => 'kg',
                'stock_notification' => 0,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ]);
    }
}
