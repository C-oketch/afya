<?php

use Illuminate\Database\Seeder;

class HaemotologyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('haematology')->insert(['test_category_id' => 3,'name' => 'FBC']);
      DB::table('haematology')->insert(['test_category_id' => 3,'name' => 'ESR']);
      DB::table('haematology')->insert(['test_category_id' => 3,'name' => 'HAEMOGLOBIN']);
      DB::table('haematology')->insert(['test_category_id' => 3,'name' => 'PERIPHERAL BLOOD FILM']);
      DB::table('haematology')->insert(['test_category_id' => 3,'name' => 'WBC + DIFF']);

      DB::table('haematology')->insert(['test_category_id' => 3,'name' => 'RETICULOCYTES']);
      DB::table('haematology')->insert(['test_category_id' => 3,'name' => 'COOMBS TEST D/1']);
      DB::table('haematology')->insert(['test_category_id' => 3,'name' => 'MALARIA']);
      DB::table('haematology')->insert(['test_category_id' => 3,'name' => 'MALARIA ANTIGEN']);
      DB::table('haematology')->insert(['test_category_id' => 3,'name' => 'HB ELECTROPHONES']);

      DB::table('haematology')->insert(['test_category_id' => 3,'name' => 'SICKLING']);
      DB::table('haematology')->insert(['test_category_id' => 3,'name' => 'FOLIC ACID']);
      DB::table('haematology')->insert(['test_category_id' => 3,'name' => 'VIT B12']);
      DB::table('haematology')->insert(['test_category_id' => 3,'name' => 'CD4']);
    
    }
}
