<?php

use Illuminate\Database\Seeder;

class DOBCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('Drug_Of_Abuse')->insert(['test_category_id' => 1,'name' => 'ACETEMINOPHEN/PARACETAMOL']);
      DB::table('Drug_Of_Abuse')->insert(['test_category_id' => 1,'name' => 'AMPHETAMINES']);
      DB::table('Drug_Of_Abuse')->insert(['test_category_id' => 1,'name' => 'CANNABINOIDS']);
      DB::table('Drug_Of_Abuse')->insert(['test_category_id' => 1,'name' => 'METAMPHETAMINES']);
      DB::table('Drug_Of_Abuse')->insert(['test_category_id' => 1,'name' => 'BARBITURATES']);
      DB::table('Drug_Of_Abuse')->insert(['test_category_id' => 1,'name' => 'BENZODIAPINES']);
      DB::table('Drug_Of_Abuse')->insert(['test_category_id' => 1,'name' => 'COCANE']);
      DB::table('Drug_Of_Abuse')->insert(['test_category_id' => 1,'name' => 'METHADONE']);
      DB::table('Drug_Of_Abuse')->insert(['test_category_id' => 1,'name' => 'OPIATES']);
        DB::table('Drug_Of_Abuse')->insert(['test_category_id' => 1,'name' => 'PHENCYCLIDINE']);
          DB::table('Drug_Of_Abuse')->insert(['test_category_id' => 1,'name' => 'TRICYCLIC ANTIDEPRESSANTS']);
    }
}
