<?php

use Illuminate\Database\Seeder;

class RenalCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('Renal_electrolytes_bone')->insert(['test_category_id' => 1,'name' => 'U/E/C']);
      DB::table('Renal_electrolytes_bone')->insert(['test_category_id' => 1,'name' => 'Potassium only']);
      DB::table('Renal_electrolytes_bone')->insert(['test_category_id' => 1,'name' => 'Estimated gfr']);
      DB::table('Renal_electrolytes_bone')->insert(['test_category_id' => 1,'name' => 'Bicarbonate']);
      DB::table('Renal_electrolytes_bone')->insert(['test_category_id' => 1,'name' => 'Creatinine Clearance']);
      DB::table('Renal_electrolytes_bone')->insert(['test_category_id' => 1,'name' => 'Uric Acid']);
      DB::table('Renal_electrolytes_bone')->insert(['test_category_id' => 1,'name' => 'Calcium']);
      DB::table('Renal_electrolytes_bone')->insert(['test_category_id' => 1,'name' => 'Phosphate']);
      DB::table('Renal_electrolytes_bone')->insert(['test_category_id' => 1,'name' => 'Alkaline Phosphate']);
      DB::table('Renal_electrolytes_bone')->insert(['test_category_id' => 1,'name' => 'Vitamin D']);
    }
}
