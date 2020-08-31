<?php

use Illuminate\Database\Seeder;

class MicrobiologyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('microbiology')->insert(['test_category_id' => 6,'name' => 'FBC']);
      DB::table('microbiology')->insert(['test_category_id' => 6,'name' => 'ESR']);
      DB::table('microbiology')->insert(['test_category_id' => 6,'name' => 'HAEMOGLOBIN']);
      DB::table('microbiology')->insert(['test_category_id' => 6,'name' => 'PERIPHERAL BLOOD FILM']);
      DB::table('microbiology')->insert(['test_category_id' => 6,'name' => 'WBC + DIFF']);

      DB::table('microbiology')->insert(['test_category_id' => 6,'name' => 'RETICULOCYTES']);
      DB::table('microbiology')->insert(['test_category_id' => 6,'name' => 'COOMBS TEST D/1']);
      DB::table('microbiology')->insert(['test_category_id' => 6,'name' => 'MALARIA']);
      DB::table('microbiology')->insert(['test_category_id' => 6,'name' => 'MALARIA ANTIGEN']);
      DB::table('microbiology')->insert(['test_category_id' => 6,'name' => 'HB ELECTROPHONES']);

      DB::table('microbiology')->insert(['test_category_id' => 6,'name' => 'SICKLING']);
      DB::table('microbiology')->insert(['test_category_id' => 6,'name' => 'FOLIC ACID']);
      DB::table('microbiology')->insert(['test_category_id' => 6,'name' => 'VIT B12']);
      DB::table('microbiology')->insert(['test_category_id' => 6,'name' => 'CD4']);

    }
}
