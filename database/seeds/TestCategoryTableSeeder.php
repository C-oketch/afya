<?php

use Illuminate\Database\Seeder;

class TestCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('test_category')->insert(['test_type_id' => 2,'category_name' => 'Biochemistry']);
      DB::table('test_category')->insert(['test_type_id' => 2,'category_name' => 'Immunology/Infective']);
      DB::table('test_category')->insert(['test_type_id' => 2,'category_name' => 'Haematology']);
      DB::table('test_category')->insert(['test_type_id' => 2,'category_name' => 'Immunology/Auto-Immune']);
      DB::table('test_category')->insert(['test_type_id' => 2,'category_name' => 'Coagulation']);
      DB::table('test_category')->insert(['test_type_id' => 2,'category_name' => 'Microbiology']);
    }
}
