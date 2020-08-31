<?php

use Illuminate\Database\Seeder;

class OtherCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('Other_Chemistry')->insert(['test_category_id' => 1,'name' => 'Crp']);
      DB::table('Other_Chemistry')->insert(['test_category_id' => 1,'name' => 'High Sentine Crp']);
      DB::table('Other_Chemistry')->insert(['test_category_id' => 1,'name' => 'Homocystine']);
      DB::table('Other_Chemistry')->insert(['test_category_id' => 1,'name' => 'Serum Iron']);
      DB::table('Other_Chemistry')->insert(['test_category_id' => 1,'name' => 'T-iron Binding  Capacity']);
      DB::table('Other_Chemistry')->insert(['test_category_id' => 1,'name' => 'Ferritin']);
      DB::table('Other_Chemistry')->insert(['test_category_id' => 1,'name' => 'Urinary Metanephrines']);
      DB::table('Other_Chemistry')->insert(['test_category_id' => 1,'name' => 'Urinary Catechomalines']);
      DB::table('Other_Chemistry')->insert(['test_category_id' => 1,'name' => 'Vma']);
      DB::table('Other_Chemistry')->insert(['test_category_id' => 1,'name' => 'Bence Jones Proteins']);
      DB::table('Other_Chemistry')->insert(['test_category_id' => 1,'name' => 'Beta 2 Microglobulin']);
    }
}
