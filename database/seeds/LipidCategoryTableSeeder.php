<?php

use Illuminate\Database\Seeder;

class LipidCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('Lipid_Cardiac_Risk')->insert(['test_category_id' => 1,'name' => 'Lipid Profile']);
      DB::table('Lipid_Cardiac_Risk')->insert(['test_category_id' => 1,'name' => 'Apolipoprotein A']);
      DB::table('Lipid_Cardiac_Risk')->insert(['test_category_id' => 1,'name' => 'Apolipoprotein B']);
      DB::table('Lipid_Cardiac_Risk')->insert(['test_category_id' => 1,'name' => 'Cardiac Enzymes']);
      DB::table('Lipid_Cardiac_Risk')->insert(['test_category_id' => 1,'name' => 'Ck-MB']);
      DB::table('Lipid_Cardiac_Risk')->insert(['test_category_id' => 1,'name' => 'Troponin 1']);
      DB::table('Lipid_Cardiac_Risk')->insert(['test_category_id' => 1,'name' => 'Cardiac Triage Screen']);
    }
}
