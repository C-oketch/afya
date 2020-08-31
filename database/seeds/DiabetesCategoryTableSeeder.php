<?php

use Illuminate\Database\Seeder;

class DiabetesCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('Diabetes')->insert(['test_category_id' => 1,'name' => 'Random Glucose']);
      DB::table('Diabetes')->insert(['test_category_id' => 1,'name' => 'Fasting Glucose']);
      DB::table('Diabetes')->insert(['test_category_id' => 1,'name' => '2 Hours P.P']);
      DB::table('Diabetes')->insert(['test_category_id' => 1,'name' => 'G.T.T']);
      DB::table('Diabetes')->insert(['test_category_id' => 1,'name' => 'HbA1c']);
      DB::table('Diabetes')->insert(['test_category_id' => 1,'name' => 'Micro Albumin Random']);

    }
}
