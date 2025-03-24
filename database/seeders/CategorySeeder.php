<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product_categories')->insert([
            ['category_name' => 'Electronics', 'is_active' => 1],
            ['category_name' => 'Clothing', 'is_active' => 1],
            ['category_name' => 'Home Appliances', 'is_active' => 1]
        ]);
    }
}
