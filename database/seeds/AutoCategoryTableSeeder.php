<?php

use Illuminate\Database\Seeder;

class AutoCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('immunology_autoimmune')->insert(['test_category_id' => 4,'name' => 'ANA']);
      DB::table('immunology_autoimmune')->insert(['test_category_id' => 4,'name' => 'ENA SCREEN']);
      DB::table('immunology_autoimmune')->insert(['test_category_id' => 4,'name' => 'EBV']);
      DB::table('immunology_autoimmune')->insert(['test_category_id' => 4,'name' => 'CARDIOLIPIN AB']);
      DB::table('immunology_autoimmune')->insert(['test_category_id' => 4,'name' => 'RA FACTOR']);

    }
}
