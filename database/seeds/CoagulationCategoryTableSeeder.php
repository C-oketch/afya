<?php

use Illuminate\Database\Seeder;

class CoagulationCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('coagulation')->insert(['test_category_id' => 5,'name' => 'INR']);
      DB::table('coagulation')->insert(['test_category_id' => 5,'name' => 'PT']);
      DB::table('coagulation')->insert(['test_category_id' => 5,'name' => 'APTT']);
      DB::table('coagulation')->insert(['test_category_id' => 5,'name' => 'BLEEDING TIME']);
      DB::table('coagulation')->insert(['test_category_id' => 5,'name' => 'D-DIMER']);
    }
}
