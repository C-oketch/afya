<?php

use Illuminate\Database\Seeder;

class InfectiveCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('immunology_infective')->insert(['test_category_id' => 2,'name' => 'HBsAg']);
      DB::table('immunology_infective')->insert(['test_category_id' => 2,'name' => 'HEP B Ab']);
      DB::table('immunology_infective')->insert(['test_category_id' => 2,'name' => 'HEP B CORE IgM']);
      DB::table('immunology_infective')->insert(['test_category_id' => 2,'name' => 'HEP BeAg']);
      DB::table('immunology_infective')->insert(['test_category_id' => 2,'name' => 'HEP BeAb']);

      DB::table('immunology_infective')->insert(['test_category_id' => 2,'name' => 'HCV']);
      DB::table('immunology_infective')->insert(['test_category_id' => 2,'name' => 'TOXOPLASMA IgM']);
      DB::table('immunology_infective')->insert(['test_category_id' => 2,'name' => 'TOXOPLASMA IgG']);
      DB::table('immunology_infective')->insert(['test_category_id' => 2,'name' => 'RUBELLA IgG']);
      DB::table('immunology_infective')->insert(['test_category_id' => 2,'name' => 'RUBELLA IgM']);

      DB::table('immunology_infective')->insert(['test_category_id' => 2,'name' => 'CYTOMEGAL IgG']);
      DB::table('immunology_infective')->insert(['test_category_id' => 2,'name' => 'CYTOMEGAL IgM']);
      DB::table('immunology_infective')->insert(['test_category_id' => 2,'name' => 'HERPES 1 IgG']);
      DB::table('immunology_infective')->insert(['test_category_id' => 2,'name' => 'HERPES 2 IgG']);
      DB::table('immunology_infective')->insert(['test_category_id' => 2,'name' => 'HERPES 2 IgM']);

      DB::table('immunology_infective')->insert(['test_category_id' => 2,'name' => 'HIV Ab 1+2']);
      DB::table('immunology_infective')->insert(['test_category_id' => 2,'name' => 'VDLRL']);
      DB::table('immunology_infective')->insert(['test_category_id' => 2,'name' => 'TPHA']);
      DB::table('immunology_infective')->insert(['test_category_id' => 2,'name' => 'BILHARZIA Ab']);
      DB::table('immunology_infective')->insert(['test_category_id' => 2,'name' => 'BRUCELLA Ab']);

      DB::table('immunology_infective')->insert(['test_category_id' => 2,'name' => 'LYME IgG/igM']);
      DB::table('immunology_infective')->insert(['test_category_id' => 2,'name' => 'IgE']);
      DB::table('immunology_infective')->insert(['test_category_id' => 2,'name' => 'PROCALCITONIN']);
      
    }
}
