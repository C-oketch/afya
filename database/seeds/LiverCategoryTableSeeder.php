<?php

use Illuminate\Database\Seeder;

class LiverCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('Liver_Protien_Pancreas')->insert(['test_category_id' => 1,'name' => 'Lfts']);
      DB::table('Liver_Protien_Pancreas')->insert(['test_category_id' => 1,'name' => 'Paedriatic Bilirubin']);
      DB::table('Liver_Protien_Pancreas')->insert(['test_category_id' => 1,'name' => 'Total Protien']);
      DB::table('Liver_Protien_Pancreas')->insert(['test_category_id' => 1,'name' => 'Globulins']);
      DB::table('Liver_Protien_Pancreas')->insert(['test_category_id' => 1,'name' => 'Proteins Electrophones']);
      DB::table('Liver_Protien_Pancreas')->insert(['test_category_id' => 1,'name' => 'Amylase']);
      DB::table('Liver_Protien_Pancreas')->insert(['test_category_id' => 1,'name' => 'Lipase']);
      DB::table('Liver_Protien_Pancreas')->insert(['test_category_id' => 1,'name' => 'Albumin']);

    }
}
